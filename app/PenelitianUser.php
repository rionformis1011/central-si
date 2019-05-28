<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenelitianUser extends Model
{
    protected $table = 'penelitian_user';
    protected $guarded = [];

    // Tambahkan Kode yang diperlukan dibawah ini
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
