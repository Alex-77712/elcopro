<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = [
 		'name',
 		'address',
 		'inn',
 		'kpp'
 	];
 	
    protected $table = 'party';
}
