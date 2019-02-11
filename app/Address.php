<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
 	protected $fillable = [
 		'address',
 		'postcode',
 		'codefias',
 		'codekladr'
 	];

 	protected $table = 'address';
}
