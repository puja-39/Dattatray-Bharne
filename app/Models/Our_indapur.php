<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Our_indapur extends Model
{
    use HasFactory;

    protected $table = 'our_indapur';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'is_active',
        'image'
    ];

}
