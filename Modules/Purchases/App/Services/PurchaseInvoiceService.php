<?php 

namespace Modules\Purchases\App\Services;

use Modules\Purchases\App\Repositories\PurchaseInvoiceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class PurchaseInvoiceService
{
    protected Collection $invoiceFormItems;
    protected array $productIdsFromInvoiceForm;
    protected array $existingInvoiceProductIdsInDB;
    protected $purchaseInvoiceRepository;

    public function __construct(PurchaseInvoiceRepositoryInterface $purchaseInvoiceRepository)
    {
        $this->purchaseInvoiceRepository = $purchaseInvoiceRepository;
    }

    /**
     * Initialize the invoice items data.
     *
     * @param object $invoice
     * @param Collection $items
     */
    protected function initializeInvoiceItemsData($invoice, Collection $items)
    {
        // Initialize and map items to the required structure
        $this->invoiceFormItems = $items->map(function($item) use ($invoice) {
            return [
                'purchase_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'sub_total' => $item['sub_total'],
                'tax_amount' => $item['tax_amount'],
                'total' => $item['total'],
            ];
        });

        // Extract product IDs
        $this->productIdsFromInvoiceForm = $this->invoiceFormItems->pluck('product_id')->toArray();
        $this->existingInvoiceProductIdsInDB = $invoice->items->pluck('product_id')->toArray();
    }

    /**
     * Save or update the invoice.
     *
     * @param array $data Invoice data
     * @param int|null $invoiceId Invoice ID (if it exists)
     * @return mixed The saved or updated invoice
     */
    public function saveOrUpdateInvoice(array $data, $invoiceId = null)
    {
        DB::beginTransaction();

        try {
            $invoice = $this->createOrUpdateInvoice($data, $invoiceId);

            $this->updateInvoiceItems($invoice, collect($data['items']));
            $this->calculateAndUpdateInvoiceTotals($invoice->id);

            DB::commit();

            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('An error occurred while saving the invoice: ' . $e->getMessage());
        }
    }

    /**
     * Create or update an invoice.
     *
     * @param array $data
     * @param int|null $invoiceId
     * @return mixed
     */
    protected function createOrUpdateInvoice(array $data, $invoiceId = null)
    {
        $data['status'] = 'submitted';
        return $invoiceId
            ? $this->purchaseInvoiceRepository->updateInvoice($invoiceId, $data)
            : $this->purchaseInvoiceRepository->createInvoice($data);
    }

    /**
     * Update the items of the invoice.
     *
     * @param object $invoice The invoice
     * @param Collection $items Items containing product data
     */
    protected function updateInvoiceItems($invoice, Collection $items)
    {
        $this->initializeInvoiceItemsData($invoice, $items);

        $this->purchaseInvoiceRepository->upsertItems($invoice->id, $this->invoiceFormItems->toArray());

        $this->deleteRemovedProducts($invoice->id);
    }

    /**
     * Delete products that were removed from the invoice.
     *
     * @param object $invoice The invoice
     */
    protected function deleteRemovedProducts($invoiceId)
    {
        $removedProductIds = array_diff($this->existingInvoiceProductIdsInDB, $this->productIdsFromInvoiceForm);

        if (!empty($removedProductIds)) {
            $this->purchaseInvoiceRepository->deleteItems($invoiceId, $removedProductIds);
        }
    }

    /**
     * Calculate and update the invoice totals.
     *
     * @param object $invoice The invoice
     */
    protected function calculateAndUpdateInvoiceTotals($invoiceId)
    {
        $totals = $this->calculateInvoiceTotals();

        $this->purchaseInvoiceRepository->updateInvoice($invoiceId, $totals);
    }

    /**
     * Calculate the subtotal, tax, and grand total of the invoice.
     *
     * @return array
     */
    protected function calculateInvoiceTotals()
    {
        $subTotal = $this->invoiceFormItems->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = $subTotal * 0.15;
        $grandTotal = $subTotal + $tax;

        return [
            'sub_total' => $subTotal,
            'tax' => $tax,
            'grand_total' => $grandTotal,
        ];
    }
}
