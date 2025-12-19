<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Message;

class ChatController extends Controller
{
    /**
     * Menampilkan daftar semua percakapan untuk pakar (Kotak Masuk).
     */

    public function fetchNotifications()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0, 'notifications' => []]);
        }

        $user = Auth::user();

        try {
            // 1. Ambil Percakapan yang memiliki pesan belum dibaca
            // Kita ambil ID percakapan user ini
            $conversationIds = $user->conversations()->pluck('conversations.id');

            // 2. Ambil pesan terakhir yang belum dibaca dari setiap percakapan (group by conversation)
            // Ini query yang agak kompleks untuk mendapatkan detail per pengirim
            $unreadMessages = Message::whereIn('conversation_id', $conversationIds)
                ->where('sender_id', '!=', $user->id)
                ->whereNull('read_at')
                ->with(['sender', 'conversation'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->unique('conversation_id'); // Hanya ambil 1 pesan terbaru per orang

            // 3. Hitung total semua pesan belum dibaca (bukan per orang, tapi total pesan)
            $totalCount = Message::whereIn('conversation_id', $conversationIds)
                ->where('sender_id', '!=', $user->id)
                ->whereNull('read_at')
                ->count();

            // 4. Format data sesuai permintaan JavaScript Anda
            $notifications = $unreadMessages->map(function ($msg) {
                return [
                    'sender_name' => $msg->sender->name,
                    'message_preview' => Str::limit($msg->message, 30), // Potong pesan panjang
                    'time' => $msg->created_at->diffForHumans(), // Cth: "5 menit yang lalu"
                    'url' => route('chat.show', $msg->conversation_id)
                ];
            });

            // 5. Kirim JSON
            return response()->json([
                'count' => $totalCount,
                'notifications' => $notifications
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['count' => 0, 'notifications' => []]);
        }
    }
    public function indexForPakar(Request $request) // Tambahkan Request $request
    {
        $penyuluh = Auth::user();
        $search = $request->input('search'); // 1. Ambil input pencarian

        // Query Dasar: Ambil percakapan di mana pakar ini terlibat
        $conversations = Conversation::whereHas('participants', function ($query) use ($penyuluh) {
            $query->where('user_id', $penyuluh->id);
        })
            // 2. LOGIKA PENCARIAN (Filter berdasarkan nama Petani)
            ->when($search, function ($query) use ($search, $penyuluh) {
                // Cari percakapan dimana partisipannya memiliki nama sesuai pencarian
                $query->whereHas('participants', function ($q) use ($search, $penyuluh) {
                    $q->where('users.id', '!=', $penyuluh->id) // Pastikan bukan mencari diri sendiri
                        ->where('name', 'like', "%{$search}%");  // LANGSUNG cari kolom 'name'
                });
            })
            ->with(['participants' => function ($query) use ($penyuluh) {
                $query->where('user_id', '!=', $penyuluh->id);
            }, 'messages'])
            ->latest('updated_at')
            ->get();

        // 3. Hitung Notifikasi (Logic sebelumnya)
        $myConversationIds = Conversation::whereHas('participants', function ($q) use ($penyuluh) {
            $q->where('user_id', $penyuluh->id);
        })->pluck('id');

        $unread_count = Message::whereIn('conversation_id', $myConversationIds)
            ->where('sender_id', '!=', $penyuluh->id)
            ->whereNull('read_at')
            ->count();

        // Kirim data ke View (tambahkan $search agar input tidak hilang setelah submit)
        return view('pakar.konsultasi', compact('conversations', 'unread_count', 'search'));
    }

    /**
     * DIUBAH: Menampilkan halaman "Pilih Pakar" untuk Petani.
     * Ini adalah pengganti method startOrShowConversation() yang lama.
     */
    public function startOrShowConversation()
    {
        // 1. Dapatkan semua pengguna dengan peran 'pakar'
        $penyuluh = User::whereHas('roles', function ($q) {
            $q->where('name', 'penyuluh');
        })->get();

        // 2. Dapatkan petani yang sedang login
        $petani = auth()->user();

        // 3. Cari obrolan yang sudah ada untuk petani ini
        $existingConversations = Conversation::whereHas('participants', function ($q) use ($petani) {
            $q->where('user_id', $petani->id);
        })->with('participants')->get();

        // 4. Buat peta [pakar_id => conversation_id] untuk menandai obrolan yang sudah ada
        $penyuluhConvMap = [];
        foreach ($existingConversations as $conv) {
            // Cari partisipan lain (yaitu Pakar)
            $penyuluhParticipant = $conv->participants->firstWhere('id', '!=', $petani->id);
            if ($penyuluhParticipant) {
                $penyuluhConvMap[$penyuluhParticipant->id] = $conv->id;
            }
        }

        // 5. Tampilkan view baru dan kirim data pakar
        return view('petani.pilih_pakar', compact('penyuluh', 'penyuluhConvMap'));
    }

    /**
     * BARU: Membuat atau menemukan obrolan dengan Pakar tertentu.
     */
    public function createConversation($id)
    {
        // 1. Cari User Pakar secara manual agar data pasti ada
        $penyuluh = User::findOrFail($id);

        $petani = auth()->user();
        $petani_id = $petani->id;
        $penyuluh_id = $penyuluh->id; // ID ini sekarang dijamin ada karena findOrFail

        // 2. Cek apakah obrolan sudah ada
        $conversation = Conversation::whereHas('participants', function ($query) use ($petani_id) {
            $query->where('user_id', $petani_id);
        })->whereHas('participants', function ($query) use ($penyuluh_id) {
            $query->where('user_id', $penyuluh_id);
        })->first();

        // 3. Jika tidak ada, buat obrolan baru
        if (!$conversation) {
            $conversation = Conversation::create();
            // Attach sekarang aman karena kedua ID pasti terisi
            $conversation->participants()->attach([$petani_id, $penyuluh_id]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    /**
     * Menampilkan ruang obrolan spesifik (digunakan oleh petani dan pakar).
     */
    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        // Keamanan: Pastikan pengguna yang login adalah bagian dari percakapan ini.
        if (! $conversation->participants->contains($user->id)) {
            abort(403);
        }

        // Tandai pesan sebagai 'dibaca' (jika ada pesan baru)
        $conversation->messages()
            ->where('sender_id', '!=', $user->id) // Pesan dari lawan bicara
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Tentukan siapa lawan bicara (participant).
        $participant = $conversation->participants->firstWhere('id', '!=', $user->id);

        if (!$participant) {
            // Jika tidak ada partisipan lain, obrolan ini rusak.
            // Hapus obrolan ini untuk membersihkan database.
            $conversation->delete();

            // Tentukan rute kembali berdasarkan peran
            $redirectRoute = $user->roles()->where('name', 'penyuluh')->exists()
                ? 'pakar.chat.index'
                : 'petani.chat.start';

            return redirect()->route($redirectRoute)
                ->with('error', 'Terjadi kesalahan pada data obrolan. Obrolan telah dihapus. Silakan mulai yang baru.');
        }

        // Tentukan view berdasarkan peran
        if ($user->roles()->where('name', 'penyuluh')->exists()) {
            return view('pakar.chat', compact('conversation', 'participant'));
        } else {
            return view('petani.konsultasi', compact('conversation', 'participant'));
        }
    }

    /**
     * Menyimpan pesan baru ke database.
     */
    public function store(Request $request, Conversation $conversation)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $user = Auth::user();

        // Keamanan: Pastikan pengguna yang login adalah bagian dari percakapan ini.
        if (! $conversation->participants->contains($user->id)) {
            abort(403);
        }

        // Tentukan siapa penerima pesan.
        $receiver = $conversation->participants->firstWhere('id', '!=', $user->id);

        $conversation->messages()->create([
            'sender_id' => $user->id,
            'message' => $request->message,
            // 'receiver_id' tidak diperlukan jika kita tidak melacak 'read_at' per pesan
        ]);

        // Perbarui timestamp 'updated_at' di percakapan agar naik ke atas
        $conversation->touch();

        return back(); // Kembali ke halaman chat setelah mengirim.
    }
}
