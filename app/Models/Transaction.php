<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $with = ['customer', 'user'];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
    	return $this->hasMany(TransactionDetail::class);
    }
}
