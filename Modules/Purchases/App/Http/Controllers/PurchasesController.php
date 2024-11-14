<?php

namespace Modules\Purchases\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Catalog\App\Models\Product;
use Modules\Catalog\App\Models\Category;
use Modules\Contacts\App\Models\Contact;
use Modules\Purchases\App\Models\Purchase;
use Modules\Purchases\App\Models\PurchaseItem;
use Modules\Catalog\App\Http\Resources\ProductResource;
use Modules\Purchases\App\Http\Resources\PurchaseResource;
use Modules\Contacts\App\Http\Resources\ContactsResource;
use Modules\Purchases\App\Http\Requests\Purchases\CreateRequest;
use Modules\Purchases\App\Http\Requests\Purchases\UpdateRequest;
use Inertia\Inertia;
use Storage;
use Illuminate\Validation\Rule;
use Modules\Purchases\App\Services\PurchaseInvoiceService; 
use Modules\Purchases\App\Repositories\PurchaseInvoiceRepository;

class PurchasesController extends Controller
{

    public function __construct(PurchaseInvoiceService $purchaseInvoiceService , PurchaseInvoiceRepository $purchaseInvoiceRepository)
    {
        // حقن خدمة PurchaseInvoiceService
        $this->purchaseInvoiceService = $purchaseInvoiceService;
        // حقن  PurchaseInvoiceRepository
        $this->purchaseInvoiceRepository = $purchaseInvoiceRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Purchase::query();


        if ($request->has('search')) {
            $query = $query->where('invoice_number','LIKE','%'.$request->get('search').'%');
        }

        $invoices = PurchaseResource::collection($query->with('items')->paginate(15));

        return Inertia::render('Purchases::Purchases/Index',[
            'invoices' => $invoices,
            'search' => $request->get('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function invoice(Request $request)
    {
        $contacts_records = Contact::select('id','name')->take(10)->get();

        $minimalContactsResource = ContactsResource::collection($contacts_records->map(function ($contact) {
            return new ContactsResource($contact, true);  // minimal as true
        }));

        $contacts = $minimalContactsResource;


        $products_records = Product::select('id','name')->take(10)->get();

        $minimalProductsResource = ProductResource::collection($products_records->map(function ($product) {
            return new ProductResource($product, true);  // minimal as true
        }));
        
        $products = $minimalProductsResource;

        $args = ['products' => $products , 'contacts' => $contacts];

        if ($request->invoice_id > 0) {
            $invoice = $invoice = Purchase::with(['items.product' => function($query) {
                $query->select(['id', 'name', 'stock_quantity']); // Customize the fields you want to retrieve
            }])->where('id', $request->invoice_id)->first();

            if ($invoice) {
                $args['invoice'] = $invoice;
            }else{
                abort(404);
            }
        }

        return Inertia::render('Purchases::Purchases/Invoice', $args);
    }


    public function contact_search(Request $request)
    {
        $contacts = Contact::select('id','name')->where('name','LIKE', '%'.$request->name.'%')->get();

        $minimalContactsResource = ContactsResource::collection($contacts->map(function ($contact) {
            return new ContactsResource($contact, true);  // minimal as true
        }));

        return $minimalContactsResource;
    }



    public function product_search(Request $request)
    {
        $products = Product::select('id','name')->where('name','LIKE', '%'.$request->name.'%')->take(10)->get();

        $minimalProductsResource = ProductResource::collection($products->map(function ($product) {
            return new ProductResource($product, true);  // minimal as true
        }));
        
        return $minimalProductsResource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contact_id' => 'required',
            'items.*.price' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|exists:products,id|distinct'
        ]);

        try {
            $invoice = $this->purchaseInvoiceService->saveOrUpdateInvoice($request->all());

            return redirect()->route('purchases.invoices.invoice',$invoice->id)->with('success','success');
        } catch (\Exception $e) {
            return redirect()->route('purchases.invoices.invoice')->with('error','error');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('purchases::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('purchases::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
