<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
        /** 
* The attributes that are mass assignable. 
*
* @var array
*/
protected $fillable = [ 
    'id',
    'provider_name',
    'services_id',
    'products_id',
    'providers_payment_id',
    'reservations_id',
    'phone_number',
    'address',
    'rfc',
    'bank_acount',
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
