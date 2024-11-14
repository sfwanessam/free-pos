<?php 
namespace Modules\Purchases\App\Repositories;

use Modules\Purchases\App\Models\Purchase as Invoice;
use Modules\Purchases\App\Models\PurchaseItem;
use Modules\Purchases\App\Repositories\PurchaseInvoiceRepositoryInterface;
use Illuminate\Support\Collection;

class PurchaseInvoiceRepository implements PurchaseInvoiceRepositoryInterface
{
    public function createInvoice($data)
    {
        
        return Invoice::create($data);
    }

    public function updateInvoice($invoiceId, $data)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $invoice->update($data);
        return $invoice;
    }

    public function upsertItems($invoiceId, array $items){
        // Use upsert to insert or update items
        PurchaseItem::upsert(
            $items,               // The data to insert or update
            ['purchase_id', 'product_id'], // Unique combination to identify the item (by invoice and product)
            ['quantity', 'price', 'sub_total', 'tax_amount', 'total'] // Columns to update if the record already exists
        );
    }


    public function deleteItems($invoiceId, array $productIds)
    {
        // Delete items from the invoice where product_id matches
        PurchaseItem::where('purchase_id',$invoiceId)->whereIn('product_id', $productIds)->delete();
    }

}
