<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    public $timestamps = false;
    protected $table = 'registrasi';
    protected $primaryKey = 'no_registrasi';
}
