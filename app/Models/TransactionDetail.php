<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $with = ['transaction', 'product'];

    public function transaction()
    {
    	return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
