<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = [
        'app_title',
        'app_short_title',
        'app_timezone',
    ];

}
