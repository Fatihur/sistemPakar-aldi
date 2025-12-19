<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'farmer_id',
        'expert_id',
    ];

    /**
     * Mendefinisikan bahwa sebuah percakapan memiliki banyak pesan.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participant', 'conversation_id', 'user_id');
    }

    /**
     * Mendefinisikan relasi ke pengguna yang berperan sebagai petani.
     */
    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    /**
     * Mendefinisikan relasi ke pengguna yang berperan sebagai pakar.
     */
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }
}
