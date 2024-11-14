<?php

namespace Modules\Purchases\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Purchases\App\Models\PurchaseItem;
class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id','invoice_number','status','sub_total','tax','grand_total'];

    public function items(){
        return $this->hasMany(PurchaseItem::class)->with('product');
    }
}
