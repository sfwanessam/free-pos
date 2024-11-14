<?php

namespace Modules\Catalog\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'image' , 'active'];


    public function products(){
        return $this->hasMany(Product::class);
    }
}
