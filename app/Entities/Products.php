<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Products  extends Model
{
	protected $table = 'products';
	protected $primaryKey = 'id';
}
