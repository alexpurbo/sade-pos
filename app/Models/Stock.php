<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_stock';
    public $timestamps = false;

    protected $guarded = ['id_stock'];
}
