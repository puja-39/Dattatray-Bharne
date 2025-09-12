<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'cities';

    // Specify the fillable attributes (columns you want to insert)
    protected $fillable = ['state_id', 'name'];

    // Define the relationship with the state (Many to One)
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
