<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    public $timestamps = false;
    protected $table = 'poliklinik';
    protected $primaryKey = 'id_poli';
}
