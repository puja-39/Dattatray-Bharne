<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'states';

    // Specify the fillable attributes (columns you want to insert)
    protected $fillable = ['name'];

    // Define the relationship with cities (One to Many)
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
