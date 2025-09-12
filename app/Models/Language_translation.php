<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language_translation extends Model
{
    use HasFactory;
    protected $table = 'language_translation';
    protected $primaryKey = "id";
    public $timestamps = false;
}
