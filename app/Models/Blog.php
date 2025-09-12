<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'is_active',
        'image', 'slug', 'short_description', 
        'seo_description', 'seo_keywords', 'description', 
        'created_by', 'updated_by', 'created_at','updated_at'
    ];

}
