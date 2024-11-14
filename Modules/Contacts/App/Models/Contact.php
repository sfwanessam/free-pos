<?php

namespace Modules\Contacts\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\App\Models\Sales;
use Modules\Purchases\App\Models\Purchase;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['type','name','email','mobile_number','phone_number','fax_number','address','note',
    'sales_person_name','sales_person_email','sales_person_mobile_number','sales_person_note','purchase_person_name'
    ,'purchase_person_email','purchase_person_mobile_number','purchase_person_note','default_on_sales','default_on_purchases'];


    public function sales(){
        return $this->hasMany(Sales::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }


    public  function loadVueSelectOptions()
    {
        return $this->select('id', 'name');
    }
}
