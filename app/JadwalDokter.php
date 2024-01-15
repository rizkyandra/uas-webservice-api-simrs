<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    public $timestamps = false;
    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'id_jadwal';
}
