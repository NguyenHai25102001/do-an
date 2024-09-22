<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageVariantModel extends Model
{
    use HasFactory;
    protected $table = 'image_variant';
    protected $guarded = [];
}
