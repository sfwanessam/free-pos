<?php

namespace Modules\Purchases\App\Repositories;
use Modules\Purchases\App\Models\Purchase as Invoice;

interface PurchaseInvoiceRepositoryInterface
{
    public function createInvoice(array $data);
    public function updateInvoice($invoiceId, array $data);
    public function upsertItems($invoiceId, array $items);
    public function deleteItems($invoiceId, array $removedProductIds);
}
