<?php

namespace Modules\Purchases\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\App\Models\Product;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_id','product_id','quantity','price','sub_total','tax_amount','total'];


    public function product(){
        return $this->belongsTo(Product::class);
    }
}
