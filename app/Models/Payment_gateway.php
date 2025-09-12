<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_gateway extends Model
{
    use HasFactory;
    protected $table = 'payment_gateway';
    protected $primaryKey = "id";
}
