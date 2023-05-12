<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory; 
/** 
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
    'id',
    'service_name',
    'description',
    'price',
    'disponibility',
    'duration',
    'image',
    'created_at',
    'updated_at',
  ];
  
  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [];
  
  /**
  * The attributes that should be cast to native types.
  *
  * @var array
  */
  protected $casts = [];
}
