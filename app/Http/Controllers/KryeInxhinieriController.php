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
use Modules\DepartamentiShitjes\Models\DshProduct;
use Modules\DepartamentiShitjes\Models\DshProject;
use Modules\DepartamentiShitjes\Models\DshUploads;
use Modules\DepartamentiShitjes\Models\DshComments;
use Modules\DepartamentiShitjes\Models\DshPreventivItem;

class KryeInxhinieriController extends Controller
{
    public function kryeinxhinieri_dashboard()
    {
        $clients              = Partners::all();
        $workers              = Workers::all();
        $preventivs           = DshProduct::where('kostoisti_product_confirmation', '<=', 2)->where('product_type', 'custom')->count();
        $confirmed_preventivs = DshProduct::where('kostoisti_product_confirmation', '<=', 2)->where('product_type', 'custom')->where('kryeinxhinieri_product_confirmation', 2)->count();
        $waiting_preventivs   = DshProduct::where('kostoisti_product_confirmation', '<=', 2)->where('product_type', 'custom')->where('kryeinxhinieri_product_confirmation', 0)->count();
        $cancelled_preventivs = DshProduct::where('kostoisti_product_confirmation', '<=', 2)->where('product_type', 'custom')->where('kryeinxhinieri_product_confirmation', 1)->count();

        return view('departamentishitjes::kryeinxhinieri.dashboard', compact('clients', 'workers', 'preventivs', 'confirmed_preventivs', 'waiting_preventivs', 'cancelled_preventivs'));
    }

    public function list_dashboard(Request $request)
    {
        // if ($request->ajax()) {
        //     $item = DshProject::where('preventiv_status', '!=',0)->select([
        //         'dsh_projects.id',
        //         'dsh_projects.project_name',
        //         'dsh_projects.project_description',
        //         'dsh_projects.project_status',
        //         'dsh_projects.project_start_date',
        //         'dsh_projects.project_client',
        //         'dsh_projects.project_architect',
        //         'dsh_projects.arkitekt_confirm',
        //         'dsh_projects.preventiv_status',
        //         'partners.contact_name as client_name',
        //         'workers.name as arkitekt_name' // Corrected alias for architect name
        //     ])
        //         ->leftJoin('partners', 'dsh_projects.project_client', '=', 'partners.id')
        //         ->leftJoin('workers', 'dsh_projects.project_architect', '=', 'workers.id')
        //         ->orderBy('dsh_projects.id', 'desc');

        //         if ($request->has('status') && $request->status !== null) {
        //             $item->where('dsh_projects.project_status', $request->status);
        //         }

        //     return DataTables::of($item)
        //         ->editColumn('id', function ($item) {
        //             return $item->id;
        //         })
        //         ->filterColumn('project_name', function ($query, $keyword) {
        //             $query->where('dsh_projects.project_name', 'LIKE', "%{$keyword}%");
        //         })
        //         ->editColumn('project_name', function ($item) {
        //             return '<a href="' . route('departamentishitjes.kryeinxhinieri.projekti', $item->id) . '">' . $item->project_name . '</a>';
        //         })
        //         ->editColumn('project_description', function ($item) {
        //             return $item->project_description;
        //         })
        //         // **Fix: Filter Client Name Properly**
        //         ->filterColumn('client_name', function ($query, $keyword) {
        //             $query->where('partners.contact_name', 'LIKE', "%{$keyword}%");
        //         })
        //         ->editColumn('client_name', function ($item) {
        //             return '<a href="' . route('partners.show', $item->project_client) . '">' . $item->client_name . '</a>';
        //         })

        //         ->editColumn('name', function ($item) {
        //             return '<a type="button" class="view-btn"
        //                         data-item="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '"
        //                         data-bs-toggle="modal"
        //                         data-bs-target="#staticBackdropview">
        //                         ' . $item->project_name . '
        //                     </a>';
        //         })

        //         ->editColumn('project_start_date', function ($item) {
        //             return $item->project_start_date;
        //         })

        //         ->filterColumn('project_status', function ($query, $keyword) {
        //             $query->where('dsh_projects.project_status', 'LIKE', "{$keyword}%");
        //         })

        //         ->editColumn('project_status', function ($item) {
        //             $products = DshProduct::where('product_project_id', $item->id)->count();
        //             $product_confirmed = DshProduct::where('product_project_id', $item->id)->where('kryeinxhinieri_product_confirmation',2)->count();

        //             if($product_confirmed == 0){
        //                 return '<button class="btn btn-sm btn-outline-danger filter-status">' . $product_confirmed.'/'. $products .'</button>';
        //             }else if($product_confirmed < $products && $product_confirmed > 0){
        //                 return '<button class="btn btn-sm btn-outline-warning filter-status">' . $product_confirmed.'/'. $products .'</button>';
        //             }else if($product_confirmed == $products){
        //                 return '<button class="btn btn-sm btn-outline-success filter-status">' . $product_confirmed.'/'. $products .'</button>';
        //             }
        //         })

        //         ->addColumn('action', function ($item) {

        //                 return '
        //             <div class="dropdown text-center">
        //                 <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        //                     <i class="ri-more-2-fill"></i>
        //                 </a>
        //                 <ul class="dropdown-menu">

        //                     <li>
        //                         <a href="' . route('departamentishitjes.kryeinxhinieri.projekti', $item->id) . '" class="dropdown-item view-btn">
        //                             <i class="ri-eye-fill me-1"></i> View
        //                         </a>
        //                     </li>
        //                 </ul>
        //             </div>';

        //         })
        //         ->rawColumns(['project_start_date', 'project_description', 'client_name', 'arkitekt_name', 'project_name', 'action', 'project_status', 'id'])
        //         ->make(true);
        // }

        if ($request->ajax()) {
            $item = DshProduct::where('kostoisti_product_confirmation', '<=', 2)
                ->where('product_type', 'custom')
                ->orderBy('id', 'desc');

            if ($request->has('status') && $request->status !== null) {
                $item->where('dsh_products.kryeinxhinieri_product_confirmation', $request->status);
            }
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->editColumn('client_limit_date', function ($item) {
                    $project = DshProject::find($item->product_project_id);
                    return \Carbon\Carbon::parse($project->client_limit_date)->format('d M Y');
                })
                ->editColumn('project', function ($item) {
                    $project = DshProject::where('id', $item->product_project_id)->first();

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
                    return '<a href="' . route('departamentishitjes.kryeinxhinieri.projekti.id', $project->id) . '">' . $project->project_name . '</a>' . ' / <span class="' . $class . '">' . $project->priority . '</span>';
                })
                ->addColumn('image', function ($item) {
                    $image = DshUploads::where('file_id', $item->id)->first();
                    if ($image) {
                       return '
                        <img src="' . asset('storage/' . $image->file_path) . '" 
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
                                            src="' . asset('storage/' . $image->file_path) . '" 
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
                    return '<a href="' . route('departamentishitjes.kryeinxhinieri.preventiv.view', $item->id) . '" class="dropdown-item view-btn">
                    ' . $item->product_name . '
                                </a>';
                })
                ->editColumn('product_description', function ($item) {
                    return '
                    <div class="hstack flex-wrap gap-2 justify-content-center">
                    <center>
                        <button type="button"
                                class="btn btn-sm btn-outline-info popover-trigger"
                                data-bs-toggle="popover"
                                data-bs-content="' . e($item->product_description) . '">
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
                    return '<b>' . code_currency(1) . ' ' . number_format($item->total_cost, 2) . '</b>';
                })
            // **Fix: Filter Client Name Properly**
                ->filterColumn('product_supplier_confirmation', function ($query, $keyword) {
                    $query->where('product_supplier_confirmation', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_supplier_confirmation', function ($item) {
                    return $item->product_supplier_confirmation;
                })

                ->editColumn('product_quantity', function ($item) {
                    return $item->product_quantity;
                })

            // **Fix: Filter Project Status Properly**
                ->filterColumn('product_status', function ($query, $keyword) {
                    $query->where('product_status', 'LIKE', "{$keyword}%");
                })

                ->editColumn('product_status', function ($item) {
                    $status = $item->kryeinxhinieri_product_confirmation;
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
                                <a href="' . route('departamentishitjes.kryeinxhinieri.preventiv.view', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['product_name','refuse_comment', 'total_cost', 'project', 'client_limit_date', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }

    public function kryeinxhinieri_projekti($id)
    {
        $products                = ProductForWarehouse::all();
        $projects                = DshProject::find($id);
        $comments_costum_product = DshComments::where('project_id', $id)->where('comment_type', 'costum')->get();
        $comments_normal_product = DshComments::where('project_id', $id)->where('comment_type', 'normal')->get();
        $categories              = Category::all();

        return view('departamentishitjes::kryeinxhinieri.projekti', compact('id', 'categories', 'products', 'comments_costum_product', 'projects', 'comments_normal_product'));
    }

    public function view_preventiv($id)
    {
        $product              = DshProduct::where('id', $id)->first();
        $productsPerWarehouse = ProductForWarehouse::all();
        $units                = ProductUnit::all();
        $image                = DshUploads::where('file_id', $product->id)->first();
        $categories           = Category::all();

        return view('departamentishitjes::kryeinxhinieri.preventiv', compact('id', 'product', 'categories', 'productsPerWarehouse', 'units', 'image'));
    }

    public function list_preorder(Request $request, $id)
    {
        // dd($request);
        if ($request->ajax()) {
            $item = DshProduct::where('product_project_id', $id)
                ->where('kostoisti_product_confirmation', 2)
                ->where('product_type', 'custom')
                ->orderBy('id', 'desc');

            if ($request->has('status') && $request->status !== null) {
                $item->where('dsh_products.product_status', $request->status);
            }
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->addColumn('image', function ($item) {
                    $image = DshUploads::where('file_id', $item->id)->first();
                    if ($image) {
                        return '<img src="' . asset('storage/' . $image->file_path) . '" alt="Image" width="50" height="50" style="cursor:pointer;" onclick="showImageSwal(\'' . asset('storage/' .$image->file_path) . '\', \'' . addslashes($image->product_name) . '\')">';
                    }
                })
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                    return '<a href="' . route('departamentishitjes.kryeinxhinieri.preventiv.view', $item->id) . '" class="dropdown-item view-btn">
                    ' . $item->product_name . '
                                </a>';
                })
                ->editColumn('product_description', function ($item) {
                    return $item->product_description;
                })

                ->editColumn('total_cost', function ($item) {
                    return '<b>' . code_currency(1) . ' ' . number_format($item->total_cost, 2) . '</b>';
                })

                ->editColumn('grand_total', function ($item) {
                    return '<b>' . code_currency(1) . ' ' . number_format($item->total_cost * $item->product_quantity, 2) . '</b>';
                })
                ->editColumn('other_costs', function ($item) {
                    return '<b>' . code_currency(1) . ' ' . number_format($item->other_costs, 2) . '</b>';
                })
                ->editColumn('lenda_ndihmese', function ($item) {
                    return '<b>' . code_currency(1) . ' ' . number_format($item->lenda_ndihmese, 2) . '</b>';
                })
                ->editColumn('lenda_pare', function ($item) {
                    return '<b>' . code_currency(1) . ' ' . number_format($item->lenda_pare, 2) . '</b>';
                })
            // **Fix: Filter Client Name Properly**
                ->filterColumn('product_supplier_confirmation', function ($query, $keyword) {
                    $query->where('product_supplier_confirmation', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_supplier_confirmation', function ($item) {
                    return $item->product_supplier_confirmation;
                })

                ->editColumn('product_quantity', function ($item) {
                    return $item->product_quantity;
                })

            // **Fix: Filter Project Status Properly**
                ->filterColumn('product_status', function ($query, $keyword) {
                    $query->where('product_status', 'LIKE', "{$keyword}%");
                })

                ->editColumn('product_status', function ($item) {
                    $status = $item->product_status;
                    $class  = match ($status) {
                        'Ne pritje' => 'warning',
                        'Anulluar' => 'danger',
                        default    => 'success',
                    };
                    return '<button class="btn btn-sm btn-outline-' . getStatusColor($status) . ' filter-status" data-project_status="' . $status . '">' . getStatusName($status) . '</button>';
                })

                ->addColumn('action', function ($item) {
                    return '<div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="' . route('departamentishitjes.kryeinxhinieri.preventiv.view', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['product_name', 'lenda_pare', 'grand_total', 'total_cost', 'other_costs', 'lenda_ndihmese', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
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
                ->editColumn('sku_code', function ($item) {
                    return $item->sku_code;
                })
                ->editColumn('unit_id', function ($item) {
                    $unit = ProductUnit::where('id', $item->unit_id)->first();
                    return $unit->unit_name;
                })

                ->editColumn('quantity', function ($item) {
                    return $item->quantity;
                })

                ->editColumn('cost', function ($item) {

                    return code_currency(1) . ' ' . number_format($item->cost, 2);
                })

                ->addColumn('image', function ($item) {
                    $image = ProductForWarehouse::where('id', $item->product_id)->first();
                    if ($image) {
                        return '
                            <img src="' . asset('storage/' . $image->image) . '"
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
                                                src="' . asset('storage/' . $image->image) . '"
                                                alt="Enlarged image"
                                                class="img-fluid rounded m-5"
                                                style="max-height: 80vh; max-width: 75%; object-fit: contain;" />
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                })

                ->addColumn('total', function ($item) {
                    return code_currency(1) . ' ' . number_format($item->quantity * $item->cost, 2);
                })
                ->addColumn('action', function ($item) {
                    $prduct = DshProduct::where('id', $item->element_id)->first();
                    if ($prduct->kryeinxhinieri_product_confirmation == 2) {
                        return '
                        <center><i class="ri-check-line" style="color:green"></i></center>';
                    } else {
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
                ->rawColumns(['action', 'product_id', 'image', 'sku_code', 'unit_id', 'quantity', 'cost', 'total', 'id'])
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
                ->editColumn('product_id', function ($item) {
                    $product = ProductForWarehouse::where('id', $item->product_id)->first();
                    return $product->product_name;
                })
                ->editColumn('sku_code', function ($item) {
                    return $item->sku_code;
                })
                ->editColumn('unit_id', function ($item) {
                    $unit = ProductUnit::where('id', $item->unit_id)->first();
                    return $unit->unit_name;
                })

                ->editColumn('quantity', function ($item) {
                    return $item->quantity;
                })

                ->editColumn('cost', function ($item) {
                    return code_currency(1) . ' ' . number_format($item->cost, 2);
                })

                ->addColumn('total', function ($item) {
                    return code_currency(1) . ' ' . number_format($item->quantity * $item->cost, 2);
                })
                ->addColumn('image', function ($item) {
                    $image = ProductForWarehouse::where('id', $item->product_id)->first();
                    if ($image) {
                        return '
                            <img src="' . asset('storage/' . $image->image) . '"
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
                                                src="' . asset('storage/' . $image->image) . '"
                                                alt="Enlarged image"
                                                class="img-fluid rounded m-5"
                                                style="max-height: 80vh; max-width: 75%; object-fit: contain;" />
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                })
                ->addColumn('action', function ($item) {
                    $prduct = DshProduct::where('id', $item->element_id)->first();
                    if ($prduct->kryeinxhinieri_product_confirmation == 2) {
                        return '
                        <center><i class="ri-check-line" style="color:green"></i></center>';
                    } else {
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
                ->rawColumns(['action', 'product_id', 'image', 'sku_code', 'unit_id', 'quantity', 'cost', 'total', 'id'])
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
                    return $unit->unit_name;
                })

                ->editColumn('quantity', function ($item) {
                    return $item->quantity;
                })

                ->editColumn('cost', function ($item) {
                    return code_currency(1) . ' ' . number_format($item->cost, 2);
                })

                ->addColumn('total', function ($item) {
                    return code_currency(1) . ' ' . number_format($item->quantity * $item->cost, 2);
                })
                ->addColumn('action', function ($item) {
                    $prduct = DshProduct::where('id', $item->element_id)->first();
                    if ($prduct->kryeinxhinieri_product_confirmation == 2) {
                        return '
                        <center><i class="ri-check-line" style="color:green"></i></center>';
                    } else {
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
                ->rawColumns(['action', 'product_name', 'unit_id', 'quantity', 'cost', 'total', 'id'])
                ->make(true);
        }
    }

    public function product_return(Request $request , $id)
    {
        // dd($request);
        $product = DshProduct::find($id);
        $product->product_status = 4;
        $product->total_cost = 0;
        $product->lenda_pare = 0;
        $product->other_costs = 0;
        $product->lenda_ndihmese = 0;
        $product->kostoisti_product_confirmation = 4;
        $product->refuse_comment = $request->refuse_comment;
        $product->save();

        $project = DshProject::where('id', $product->product_project_id)->first();
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
            'message' => 'Produkti u kthye per rishikim.',
        ]);
    }

    public function product_confirm($id)
    {
        $product                                      = DshProduct::find($id);
        $product->product_status                      = 6;
        $product->kryeinxhinieri_product_confirmation = 2;
        $product->save();

        $project = DshProject::where('id', $product->product_project_id)->first();

        $products          = DshProduct::where('product_project_id', $project->id)->count();
        $product_confirmed = DshProduct::where('product_project_id', $project->id)->where('kryeinxhinieri_product_confirmation', 2)->count();

        if ($products == $product_confirmed) {
            $project->preventiv_status = 2;
            $project->save();
        }

        $user = User::find(Auth::user()->id);

        $comment = new DshComments();
        $comment->comment_type = 'specifikime_teknike';
        $comment->comment = 'Produkti u konfirmua';
        $comment->user_id =  $user->name; // or $request->user_id if passed explicitly
        $comment->project_id = $id;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Produkti u konfirmua me sukses.',
        ]);
    }



}
