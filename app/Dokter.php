<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    public $timestamps = false;
    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';
}
