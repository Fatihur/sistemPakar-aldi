<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'read_at'
    ];

    /**
     * Mendefinisikan bahwa sebuah pesan dimiliki oleh satu percakapan.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Mendefinisikan relasi ke pengguna yang mengirim pesan.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
