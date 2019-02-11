<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
	protected $fillable = [
 		'bank_name',
 		'bank_address',
 		'bic',
 		'swift'
 	];
 	
    protected $table = 'bank';
}
