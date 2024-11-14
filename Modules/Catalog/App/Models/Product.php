<?php

namespace Modules\Catalog\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\App\Models\Category;
use Modules\Sales\App\Models\SalesItem;
use Modules\Purchases\App\Models\PurchaseItem;

class Product extends Model
{
    use HasFactory;


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function salesItems(){
        return $this->hasMany(SalesItem::class);
    }

    public function purchaseItems(){
        return $this->hasMany(PurchaseItem::class);
    }

    
}
