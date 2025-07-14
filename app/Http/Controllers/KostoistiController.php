<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Partners;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Modules\HR\Models\Workers;
use Yajra\DataTables\DataTables;
use App\Models\ProductForWarehouse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\DepartamentiShitjes\Models\DshProduct;
use Modules\DepartamentiShitjes\Models\DshProject;
use Modules\DepartamentiShitjes\Models\DshUploads;
use Modules\DepartamentiShitjes\Models\DshComments;
use Modules\DepartamentiShitjes\Models\DshPreventivItem;

class KostoistiController extends Controller
{
    public function kostoisti_dashboard()
    {
        $clients = Partners::all();
        $workers = Workers::all();

        return view('departamentishitjes::kostoisti.dashboard', compact('clients', 'workers'));
    }

    public function getProductsByCategory($id)
    {
        if ($id === 'all') {
            $products = ProductForWarehouse::all();
        } else {
            $products = ProductForWarehouse::where('category_id', $id)->get();
        }
        // Transform products to include unit name
        $products = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'unit_name' => unit_name($product->unit_id), // Your helper function
            ];
        });

        return response()->json($products);
    }

    public function getProductDetails($id)
    {
        $product = ProductForWarehouse::select('id', 'product_name', 'image', 'qty', 'cost')
            ->findOrFail($id);

        // Optional: make sure the image is a full URL
        $product->image_url = asset(Storage::url($product->image));

        return response()->json($product);
    }


    public function kostoisti_projekti($id)
    {
        $products = ProductForWarehouse::all();
        $projects = DshProject::find($id);
        $comments_costum_product = DshComments::where('project_id', $id)->where('comment_type', 'costum')->get();
        $comments_normal_product = DshComments::where('project_id', $id)->where('comment_type', 'normal')->get();
        $categories  = Category::all();

        return view('departamentishitjes::kostoisti.projekti', compact('id', 'products', 'comments_costum_product','categories','projects', 'comments_normal_product'));
    }

    public function kostoisti_produkti($id)
    {
        return view('departamentishitjes::kostoisti.produkti');
    }

    public function kostoisti_preventiv($id)
    {
        $product = DshProduct::where('id', $id)->first();
        $productsPerWarehouse = ProductForWarehouse::all();
        $units = ProductUnit::all();
        $image = DshUploads::where('file_id', $product->id)->first();
        $categories = Category::all();
        
        return view('departamentishitjes::kostoisti.preventiv', compact('id','product','productsPerWarehouse','categories', 'units','image'));
    }

    public function list(Request $request, $id)
    {
        // dd('kostoisti');
        if ($request->ajax()) {
            $item = DshPreventivItem::where('dsh_preventiv_items.element_id', $id)
            ->where('dsh_preventiv_items.product_type', 1)
                ->select([
                    'dsh_preventiv_items.id',
                    'dsh_preventiv_items.sku_code',
                    'dsh_preventiv_items.product_id',
                    'dsh_preventiv_items.unit_id',
                    'dsh_preventiv_items.quantity',
                    'dsh_preventiv_items.user_id',
                    'dsh_preventiv_items.element_id',
                    'dsh_preventiv_items.cost',
                ])
                ->orderBy('dsh_preventiv_items.id', 'desc');

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->filterColumn('product_id', function ($query, $keyword) {
                    $query->where('dsh_projects.product_id', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_id', function ($item) {
                    $product = ProductForWarehouse::where('id', $item->product_id)->first();
                    return $product->product_name;
                })
                 ->addColumn('image', function ($item) {
                    $image = ProductForWarehouse::where('id', $item->product_id)->first();
                    if ($image) {   
                        return '
                            <img src="' . asset(Storage::url( $image->image)) . '" 
                                class="img-thumbnail clickable-image" 
                                style="object-fit: cover; cursor: pointer;"  
                                data-bs-toggle="modal" 
                                data-bs-target="#imageModal' . $item->id . '" 
                                alt="Image" 
                                width="50" 
                                height="50">

                            <div class="modal fade" id="imageModal' . $item->id . '" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-white border-0 rounded shadow">
                                        <div class="modal-body p-0 text-center">
                                            <img id="modalImage" 
                                                src="' . asset(Storage::url( $image->image)) . '" 
                                                alt="Enlarged image" 
                                                class="img-fluid rounded m-5" 
                                                style="max-height: 80vh; max-width: 75%; object-fit: contain;" />
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                })
                ->editColumn('sku_code', function ($item) {
                    return $item->sku_code;
                })
                ->editColumn('unit_id', function ($item) {
                    $unit = ProductUnit::where('id', $item->unit_id)->first();
                    return  $unit->unit_name;
                })

                ->editColumn('quantity', function ($item) {
                    return $item->quantity;
                })

                ->editColumn('cost', function ($item) {
                   
                    return code_currency(1) . ' '. number_format($item->cost,2);
                })

                ->addColumn('total', function ($item) {
                        return code_currency(1) . ' '. number_format($item->quantity * $item->cost,2);
                })
                ->addColumn('action', function ($item) {
                    $prduct = DshProduct::where('id', $item->element_id)->first();
                    if($prduct->kostoisti_product_confirmation == 2){
                        return '
                        <center><i class="ri-check-line" style="color:green"></i></center>';
                    }else if($prduct->kostoisti_product_confirmation == 3){
                        return '
                        <center><i class="ri-close-line" style="color:red"></i></center>';
                    }else{
                    return '
                    <div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item delete-btn-project" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>';
                }
                })
                ->rawColumns(['image','action','product_id', 'sku_code', 'unit_id', 'quantity', 'cost', 'total', 'id'])
                ->make(true);
        }
    }
    public function second_list(Request $request, $id)
    {
        // dd('kostoisti');
        if ($request->ajax()) {
            $item = DshPreventivItem::where('dsh_preventiv_items.element_id', $id)
            ->where('dsh_preventiv_items.product_type', 2)
                ->select([
                    'dsh_preventiv_items.id',
                    'dsh_preventiv_items.sku_code',
                    'dsh_preventiv_items.product_id',
                    'dsh_preventiv_items.unit_id',
                    'dsh_preventiv_items.quantity',
                    'dsh_preventiv_items.user_id',
                    'dsh_preventiv_items.element_id',
                    'dsh_preventiv_items.cost',
                ])
                ->orderBy('dsh_preventiv_items.id', 'desc');

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->filterColumn('product_id', function ($query, $keyword) {
                    $query->where('dsh_projects.product_id', 'LIKE', "%{$keyword}%");
                })
                ->addColumn('image', function ($item) {
                    $image = ProductForWarehouse::where('id', $item->product_id)->first();
                    if ($image) {   
                        return '
                            <img src="' . asset(Storage::url($image->image)) . '" 
                                class="img-thumbnail clickable-image" 
                                style="object-fit: cover; cursor: pointer;"  
                                data-bs-toggle="modal" 
                                data-bs-target="#imageModal' . $item->id . '" 
                                alt="Image" 
                                width="50" 
                                height="50">

                            <div class="modal fade" id="imageModal' . $item->id . '" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-white border-0 rounded shadow">
                                        <div class="modal-body p-0 text-center">
                                            <img id="modalImage" 
                                                src="' . asset(Storage::url($image->image)) . '" 
                                                alt="Enlarged image" 
                                                class="img-fluid rounded m-5" 
                                                style="max-height: 80vh; max-width: 75%;  object-fit: contain;" />
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                })
                ->editColumn('product_id', function ($item) {
                    $product = ProductForWarehouse::where('id', $item->product_id)->first();
                    return $product->product_name;
                })
                ->editColumn('sku_code', function ($item) {
                    return $item->sku_code;
                })
                ->editColumn('unit_id', function ($item) {
                    $unit = ProductUnit::where('id', $item->unit_id)->first();
                    return  $unit->unit_name;
                })

                ->editColumn('quantity', function ($item) {
                    return $item->quantity;
                })

                ->editColumn('cost', function ($item) {
                    return code_currency(1) . ' '. number_format($item->cost,2);
                })

                ->addColumn('total', function ($item) {
                        return code_currency(1) . ' '. number_format($item->quantity * $item->cost,2);
                })
                ->addColumn('action', function ($item) {
                    $prduct = DshProduct::where('id', $item->element_id)->first();
                    if($prduct->kostoisti_product_confirmation == 2){
                        return '
                        <center><i class="ri-check-line" style="color:green"></i></center>';
                    }else if($prduct->kostoisti_product_confirmation == 3){
                        return '
                        <center><i class="ri-close-line" style="color:red"></i></center>';
                    }else{
                    return '
                    <div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item delete-btn-project" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>';
                }
                })
                ->rawColumns(['image','action','product_id', 'sku_code', 'unit_id', 'quantity', 'cost', 'total', 'id'])
                ->make(true);
        }
    }
    public function third_list(Request $request, $id)
    {
        // dd('kostoisti');
        if ($request->ajax()) {
            $item = DshPreventivItem::where('dsh_preventiv_items.element_id', $id)
            ->where('dsh_preventiv_items.product_type', 3)
                ->select([
                    'dsh_preventiv_items.id',
                    'dsh_preventiv_items.product_name',
                    'dsh_preventiv_items.unit_id',
                    'dsh_preventiv_items.quantity',
                    'dsh_preventiv_items.user_id',
                    'dsh_preventiv_items.element_id',
                    'dsh_preventiv_items.cost',
                ])
                ->orderBy('dsh_preventiv_items.id', 'desc');

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('dsh_projects.product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                    return $item->product_name;
                })
                ->editColumn('unit_id', function ($item) {
                    $unit = ProductUnit::where('id', $item->unit_id)->first();
                    return  $unit->unit_name;
                })

                ->editColumn('quantity', function ($item) {
                    return $item->quantity;
                })

                ->editColumn('cost', function ($item) {
                    return code_currency(1) . ' '. number_format($item->cost,2);
                })

                ->addColumn('total', function ($item) {
                        return code_currency(1) . ' '. number_format($item->quantity * $item->cost,2);
                })
                ->addColumn('action', function ($item) {
                    $prduct = DshProduct::where('id', $item->element_id)->first();
                    if($prduct->kostoisti_product_confirmation == 2){
                        return '
                        <center><i class="ri-check-line" style="color:green"></i></center>';
                    }else if($prduct->kostoisti_product_confirmation == 3){
                        return '
                        <center><i class="ri-close-line" style="color:red"></i></center>';
                    }else{
                    return '
                    <div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item delete-btn-project" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>';
                }
                })
                ->rawColumns(['action','product_name', 'unit_id', 'quantity', 'cost', 'total', 'id'])
                ->make(true);
        }
    }


    public function list_dashboard(Request $request)
    {
        // dd('kostoisti');
        if ($request->ajax()) {
            $item = DshProduct::where('product_type', 'custom')->where('product_status','>=',2)->orderBy('id', 'desc');

                if ($request->has('status') && $request->status !== null) {
                    $item->where('dsh_products.kostoisti_product_confirmation', $request->status);
                }
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->editColumn('client_limit_date', function ($item) {
                    $project = DshProject::find($item->product_project_id);
                    if (!$project || !$project->client_limit_date) {
                        return '';
                    }
                    return \Carbon\Carbon::parse($project->client_limit_date)->format('d M Y');
                })
                ->editColumn('project', function ($item) {
                    $project = DshProject::where('id', $item->product_project_id)->first();

                    if (!$project) {
                        return '<span class="text-danger">Project not found</span>';
                    }

                    $class = '';
                    if ($project->priority == 'extremly important') {
                        $class = 'blink fw-bold';
                    } elseif ($project->priority == 'hight') {
                        $class = 'btn btn-sm btn-danger  rounded-pill';
                    } elseif ($project->priority == 'medium') {
                        $class = 'btn btn-sm btn-warning  rounded-pill';
                    } elseif ($project->priority == 'low') {
                        $class = 'btn btn-sm btn-success  rounded-pill';
                    }
                    return '<a href="' . route('departamentishitjes.kostoisti.projekti', $project->id) . '">' . $project->project_name . '</a>' . ' / <span class="'.$class.'">'.$project->priority.'</span>';
                })
              ->addColumn('image', function ($item) {
                    $image = DshUploads::where('file_id', $item->id)->first();
                    if ($image) {   
                       return '
                        <img src="' . asset(Storage::url($image->file_path)) . '" 
                            class="img-thumbnail clickable-image" 
                            style="object-fit: cover; cursor: pointer;"  
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal' . $item->id . '" 
                            alt="Image" 
                            width="50" 
                            height="50">

                        <div class="modal fade" id="imageModal' . $item->id . '" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: auto; max-height: 90vh;">
                                <div class="modal-content bg-white border-0 rounded shadow" style="padding: 15px;">
                                    <div class="modal-body p-0 text-center">
                                        <img 
                                            src="' .  asset(Storage::url($image->file_path)) . '" 
                                            alt="Enlarged image" 
                                            style="
                                                max-width: 450px;
                                                max-height: 500px;
                                                width: auto;
                                                height: auto;
                                                object-fit: contain;
                                                display: block;
                                                margin: auto;
                                            " />
                                    </div>
                                </div>
                            </div>
                        </div>';

                    }
                })

                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                    return  '<a href="' . route('departamentishitjes.kostoisti.preventiv.create', $item->id) . '" class="dropdown-item view-btn">
                    ' . $item->product_name . '
                                </a>';
                })
                // ->editColumn('product_description', function ($item) {
                //     return $item->product_description;
                // })
                ->editColumn('product_description', function ($item) {
                    return '
                    <div class="hstack flex-wrap gap-2 justify-content-center">
                    <center>
                        <button type="button" 
                                class="btn btn-sm btn-outline-info popover-trigger" 
                                data-bs-toggle="popover" 
                                data-bs-content="'.e($item->product_description).'">
                            <i class="ri-chat-unread-fill"></i>
                        </button>
                        </center>
                        </div>';
                })
                ->editColumn('refuse_comment', function ($item) {
                    if(empty($item->refuse_comment)){
                        return '<center>-</center>';
                    }
                    return '
                    <div class="hstack flex-wrap gap-2 justify-content-center">
                    <center>
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger popover-trigger2" 
                                data-bs-toggle="popover" 
                                data-bs-content="'.e($item->refuse_comment).'">
                            <i class="ri-chat-unread-fill"></i>
                        </button>
                        </center>
                        </div>';
                })

                ->editColumn('total_cost', function ($item) {
                    return '<b>'.code_currency(1) . ' ' . number_format($item->total_cost, 2).'</b>' ;
                })

                // **Fix: Filter Client Name Properly**
                ->filterColumn('product_supplier_confirmation', function ($query, $keyword) {
                    $query->where('product_supplier_confirmation', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_supplier_confirmation', function ($item) {
                    return  $item->product_supplier_confirmation;
                })

                ->editColumn('product_quantity', function ($item) {
                    return $item->product_quantity;
                })

                // **Fix: Filter Project Status Properly**
                ->filterColumn('product_status', function ($query, $keyword) {
                    $query->where('kostoisti_product_confirmation', 'LIKE', "{$keyword}%");
                })

                ->editColumn('product_status', function ($item) {
                    $status = $item->kostoisti_product_confirmation;
                    return '<center>
                                <button class="btn btn-sm btn-outline-' . getStatusColorKostoisti($status) . ' filter-status" data-project_status="' . $status . '">' . getStatusNameKostoisti($status) . '</button>
                            </center>';
                })

                ->addColumn('action', function ($item) {
                        return '<div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="' . route('departamentishitjes.kostoisti.preventiv.create', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['product_name', 'refuse_comment', 'project', 'total_cost','client_limit_date', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }
    public function list_preorder(Request $request, $id)
    {
        // dd($request);
        if ($request->ajax()) {
            $item = DshProduct::where('product_project_id', $id)
                ->where('product_type', 'custom')->orderBy('id', 'desc');

                if ($request->has('status') && $request->status !== null) {
                    $item->where('dsh_products.kostoisti_product_confirmation', $request->status);
                }
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->addColumn('image', function ($item) {
                    $image = DshUploads::where('file_id', $item->id)->first();
                    if ($image) {
                        return '<img src="' . asset(Storage::url($image->file_path)) . '" alt="Image" width="50" height="50">';
                    }
                })
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                     if($item->kostoisti_product_confirmation == 3){
                        return $item->product_name ;
                    }else{
                    return  '<a href="' . route('departamentishitjes.kostoisti.preventiv.create', $item->id) . '" class="dropdown-item view-btn">
                    ' . $item->product_name . '
                                </a>';
                    }
                })
                ->editColumn('product_description', function ($item) {
                    return $item->product_description;
                })

                // **Fix: Filter Client Name Properly**
                ->filterColumn('product_supplier_confirmation', function ($query, $keyword) {
                    $query->where('product_supplier_confirmation', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_supplier_confirmation', function ($item) {
                    return  $item->product_supplier_confirmation;
                })

                ->editColumn('product_quantity', function ($item) {
                    return $item->product_quantity;
                })

                ->editColumn('total_cost', function ($item) {
                    return '<b>'.code_currency(1) . ' ' . number_format($item->total_cost, 2).'</b>' ;
                })

                ->editColumn('grand_total', function ($item) {
                    return '<b>'. code_currency(1) . ' ' . number_format($item->total_cost * $item->product_quantity, 2).'</b>';
                })
                ->editColumn('other_costs', function ($item) {
                    return '<b>'. code_currency(1) . ' ' . number_format($item->other_costs, 2).'</b>';
                })
                ->editColumn('lenda_ndihmese', function ($item) {
                    return '<b>'. code_currency(1) . ' ' . number_format($item->lenda_ndihmese, 2).'</b>';
                })
                ->editColumn('lenda_pare', function ($item) {
                    return '<b>'.  code_currency(1) . ' ' . number_format($item->lenda_pare, 2).'</b>';
                })

                // **Fix: Filter Project Status Properly**
                ->filterColumn('product_status', function ($query, $keyword) {
                    $query->where('kostoisti_product_confirmation', 'LIKE', "{$keyword}%");
                })

                ->editColumn('product_status', function ($item) {
                    $status = $item->kostoisti_product_confirmation;
                    $class = match ($status) {
                        'Ne pritje' => 'warning',
                        'Anulluar' => 'danger',
                        default => 'success',
                    };
                    return '<button class="btn btn-sm btn-outline-' . getStatusColorKostoisti($status) . ' filter-status" data-project_status="' . $status . '">' . getStatusNameKostoisti($status) . '</button>';
                })

                ->addColumn('action', function ($item) {
                    if($item->kostoisti_product_confirmation == 3){
                        return '<center>
                                    <i class="ri-close-line" style="color:#F70505;"></i>
                                </center>';
                    }else{
                        return '<div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="' . route('departamentishitjes.kostoisti.preventiv.create', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                        </ul>
                    </div>';
                    }
                })
                ->rawColumns(['product_name', 'lenda_pare', 'grand_total', 'total_cost', 'other_costs', 'lenda_ndihmese', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }

    public function first_store(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $product = ProductForWarehouse::find($validated['product_id']);
        if (!$product) {
            return redirect()->back()->with('error', 'Produkti nuk u gjet!');
        }

        $validated['user_id'] = Auth::user()->id;

        $purchase = new DshPreventivItem();
        $purchase->product_id = $validated['product_id'];
        $purchase->element_id = $id;
        $purchase->product_type = 1; // 1 for custom
        $purchase->quantity = $validated['quantity'];
        $purchase->cost = $product->cost;
        $purchase->unit_id = $product->unit_id;
        $purchase->sku_code = $product->sku;
        $purchase->user_id = Auth::user()->id;

        $purchase->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Materiali u ruajt me sukses!'], 200);
        }
    
        return redirect()->back()->with('success', 'Materiali u ruajt me sukses!');
    }

    public function second_store(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $product = ProductForWarehouse::find($validated['product_id']);
        if (!$product) {
            return redirect()->back()->with('error', 'Produkti nuk u gjet!');
        }

        $validated['user_id'] = Auth::user()->id;

        $purchase = new DshPreventivItem();
        $purchase->product_id = $validated['product_id'];
        $purchase->element_id = $id;
        $purchase->product_type = 2; // 1 for custom
        $purchase->quantity = $validated['quantity'];
        $purchase->cost = $product->cost;
        $purchase->unit_id = $product->unit_id;
        $purchase->sku_code = $product->sku;
        $purchase->user_id = Auth::user()->id;

        $purchase->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Materiali u ruajt me sukses!'], 200);
        }
    
        return redirect()->back()->with('success', 'Materiali u ruajt me sukses!');
    }

    public function third_store(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'product_name' => 'required',
            'quantity' => 'required',
            'unit_id' => 'required',
            'cost' => 'required',
        ]);

        $validated['user_id'] = Auth::user()->id;

        $purchase = new DshPreventivItem();
        $purchase->product_name = $validated['product_name'];
        $purchase->element_id = $id;
        $purchase->product_type = 3; // 1 for custom
        $purchase->quantity = $validated['quantity'];
        $purchase->cost = $validated['cost'];
        $purchase->unit_id = $validated['unit_id'];
        $purchase->user_id = Auth::user()->id;

        $purchase->save();

        if ($request->ajax()) {
            return response()->json(['message' => 'Materiali u ruajt me sukses!'], 200);
        }
    
        return redirect()->back()->with('success', 'Materiali u ruajt me sukses!');
    }


    public function getKostoTotalPerElement($id, $type){
        $items = DshPreventivItem::where('dsh_preventiv_items.element_id', $id)
                ->where('dsh_preventiv_items.product_type', $type)->get();
    
        $total = 0;
        foreach($items as $item){
            $total += $item->quantity * $item->cost;
        }
        return response()->json($total);
    }

    public function product_confirm($id ,Request $request)
    {
        // dd($request);
        $product = DshProduct::find($id);
        $product->product_status = 5;
        $product->total_cost = $request->total_cost;
        $product->lenda_pare = $request->lenda_pare;
        $product->other_costs = $request->other_costs;
        $product->lenda_ndihmese = $request->lenda_ndihmese;
        $product->kostoisti_product_confirmation = 2;
        $product->refuse_comment = null;
        $product->save();


        $project = DshProject::where('id',$product->product_project_id)->first();
        $project->preventiv_status = 1;
        $project->save();

        $user = User::find(Auth::user()->id);

        $comment = new DshComments();
        $comment->comment_type = 'specifikime_teknike';
        $comment->comment = 'Produkti u konfirmua';
        $comment->user_id =  $user->name; // or $request->user_id if passed explicitly
        $comment->project_id = $id;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Produkti u konfirmua me sukses.'
        ]);
    }


    public function product_cancel($id ,Request $request)
    {
        // dd($request);
        $product = DshProduct::find($id);
        $product->product_status = 9;
        $product->total_cost = 0;
        $product->lenda_pare = 0;
        $product->other_costs = 0;
        $product->lenda_ndihmese = 0;
        $product->kostoisti_product_confirmation = 3;
        $product->refuse_comment = $request->refuse_comment;
        $product->save();


        $project = DshProject::where('id',$product->product_project_id)->first();
        $project->preventiv_status = 1;
        $project->save();

        $user = User::find(Auth::user()->id);

        $comment = new DshComments();
        $comment->comment_type = 'specifikime_teknike';
        $comment->comment = 'Produkti u refuzua sepse:' . $request->refuse_comment;
        $comment->user_id =  $user->name; // or $request->user_id if passed explicitly
        $comment->project_id = $id;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Produkti u anullua me sukses.'
        ]);
    }

    public function product_delete($id)
    {
        // dd($id);
        $product = DshPreventivItem::find($id);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Elementi u fshi me sukses.'
        ]);
    }


}
