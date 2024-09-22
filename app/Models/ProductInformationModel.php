<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInformationModel extends Model
{
    use HasFactory;
    protected $table = 'product_information';
    protected $guarded = [];
}
