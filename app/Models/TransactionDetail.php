<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transactions_detail';
    protected $primaryKey = 'id_transaction_detail';
    public $timestamps = false;
    protected $guarded = ['id_transaction_detail'];
}
