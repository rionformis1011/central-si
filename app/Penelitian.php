<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    protected $table = 'penelitian';
    protected $guarded = [];

    // Tambahkan Kode yang diperlukan dibawah ini
    public function anggotas()
    {
        return $this->hasMany(PenelitianUser::class);
    }

    public function sumber_dana()
    {
        return $this->belongsTo(RefSumberDana::class, 'sumber_dana_id');
    }

    public function skema_penelitian()
    {
        return $this->belongsTo(RefSkemaPenelitian::class, 'skema_penelitian_id');
    }
}
