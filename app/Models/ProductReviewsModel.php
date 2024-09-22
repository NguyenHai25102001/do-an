<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviewsModel extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $guarded = [];
}
