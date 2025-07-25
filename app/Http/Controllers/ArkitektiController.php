<?php
namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Models\Category;
use App\Models\Partners;
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

class ArkitektiController extends Controller
{
    public function arkitekti_dashboard()
    {
        $clients            = Partners::all();
        $workers            = Workers::all();
        $total_projects     = DshProject::where('project_architect', Auth::user()->id)->where('project_status', '!=', 3)->count();
        $confirmed_projects = DshProject::where('project_architect', Auth::user()->id)->where('project_status', 2)->count();
        $cancelled_projects = DshProject::where('project_architect', Auth::user()->id)->where('project_status', 3)->count();
        $waiting_projects   = DshProject::where('project_architect', Auth::user()->id)->where('project_status', 0)->count();
        return view('departamentishitjes::arkitekti.dashboard', compact('workers', 'clients', 'total_projects', 'confirmed_projects', 'cancelled_projects', 'waiting_projects'));
    }

    public function arkitekti_statistic()
    {
        return view('departamentishitjes::arkitekti.statistic');
    }

    public function list(Request $request)
    {
        // dd($request->project_name);
        $worker = Workers::where('user_id', Auth::user()->id)->first();

        if ($request->ajax() && $worker) {
            $item = DshProject::where(function ($query) use ($worker) {
                    $query->where('project_architect', $worker->id)
                        ->where('project_seller_id', $worker->user_id)
                        ->where('project_status', 0);
                })->orWhere(function ($query) use ($worker) {
                    $query->where('project_architect', $worker->id)
                        ->where('project_status', '>=', 2);
                })
                ->select([
                    'dsh_projects.id',
                    'dsh_projects.project_name',
                    'dsh_projects.rruga',  
                    'dsh_projects.qarku',
                    'dsh_projects.bashkia',
                    'dsh_projects.tipologjia_objektit',
                    'dsh_projects.kate',
                    'dsh_projects.lift',
                    'dsh_projects.orari_pritjes',  
                    'dsh_projects.client_limit_date',
                    'dsh_projects.address_comment',
                    'dsh_projects.project_description',
                    'dsh_projects.project_status',
                    'dsh_projects.project_start_date',
                    'dsh_projects.project_client',
                    'dsh_projects.project_architect',
                    'dsh_projects.arkitekt_confirm',
                    'partners.contact_name as client_name',
                    'hr_workers.name as arkitekt_name',
                ])
                ->leftJoin('partners', 'dsh_projects.project_client', '=', 'partners.id')
                ->leftJoin('hr_workers', 'dsh_projects.project_architect', '=', 'hr_workers.id')
                ->orderBy('dsh_projects.id', 'desc');

                if ($request->filled('status')) {
                    $item->where('dsh_projects.project_status', $request->status);
                }

                if ($request->filled('name')) {
                    $item->where('partners.contact_name', 'LIKE', '%' . $request->name . '%');
                }

                if ($request->filled('project_name')) {
                    $item->where('dsh_projects.project_name', 'LIKE', '%' . $request->project_name . '%');
                }

                if ($request->filled('date')) {
                    $item->whereDate('dsh_projects.project_start_date', $request->date);
                }

                // To fetch the filtered results
                $item = $item->get();


            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                // ->filterColumn('project_name', function ($query, $keyword) {
                //     $query->where('project_name', 'LIKE', "%{$keyword}%");
                // })
                ->editColumn('project_name', function ($item) {
                    return '<a href="' . route('departamentishitjes.arkitekti.projekti', $item->id) . '">' . $item->project_name . '</a>';
                })
                ->editColumn('project_description', function ($item) {
                    return $item->project_description;
                })
            // **Fix: Filter Client Name Properly**
                // ->filterColumn('client_name', function ($query, $keyword) {
                //     $query->where('partners.contact_name', 'LIKE', "%{$keyword}%");
                // })
                ->editColumn('client_name', function ($item) {
                    return '<a href="' . route('partners.show', $item->project_client) . '">' . $item->client_name . '</a>';
                })

                ->editColumn('name', function ($item) {
                    return '<a type="button" class="view-btn"
                                data-item="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '"
                                data-bs-toggle="modal"
                                data-bs-target="#staticBackdropview">
                                ' . $item->project_name . '
                            </a>';
                })

                ->editColumn('project_start_date', function ($item) {
                    return $item->project_start_date;
                })

                // ->filterColumn('project_status', function ($query, $keyword) {
                //     $query->where('dsh_projects.arkitekt_confirm', 'LIKE', "{$keyword}%");
                // })

                ->editColumn('project_status', function ($item) {
                    $status = $item->arkitekt_confirm;

                    if($status == null || $status == 0){
                        $status = 'Ne Pritje';
                        return '<button class="btn btn-sm btn-outline-warning filter-status" data-project_status="' . $status . '">' . $status . '</button>';
                    }else if($status == 1){
                        $status = 'Ne Perpunim';
                        return '<button class="btn btn-sm btn-outline-info filter-status" data-project_status="' . $status . '">' . $status . '</button>';
                    }else if($status == 2){
                        $status = 'Konfirmuar';
                        return '<button class="btn btn-sm btn-outline-success filter-status" data-project_status="' . $status . '">' . $status . '</button>';
                    }else if($status == 3){
                        $status = 'Anulluar';
                        return '<button class="btn btn-sm btn-outline-danger filter-status" data-project_status="' . $status . '">' . $status . '</button>';
                    } 
                })

                ->addColumn('action', function ($item) {
                    if ($item->arkitekt_confirm == 2) {
                        return '
                                     <div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="' . route('departamentishitjes.arkitekti.projekti', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                        </ul>
                    </div>';
                    } else {

                        return '
                    <div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item edit-btn"
                                    data-item="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '"
                                    data-id="' . $item->id . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#staticBackdropedit">
                                    <i class="ri-edit-2-fill me-1"></i> Edit
                                </button>
                            </li>
                            <li>
                                <a href="' . route('departamentishitjes.arkitekti.projekti', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item delete-btn-project" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Delete
                                </button>
                            </li>
                            <li>
                                 <button type="button"
                                        class="dropdown-item confirm-project-btn"
                                        data-id="' . $item->id . '"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmProjectModal">
                                    <i class="ri-send-plane-fill me-1"></i> Confirm
                                </button>
                            </li>
                        </ul>
                    </div>';
                    }
                })
                ->rawColumns(['project_start_date', 'project_description', 'client_name', 'arkitekt_name', 'project_name', 'action', 'project_status', 'id'])
                ->make(true);
        }
    }

    public function arkitekti_projekti($id)
    {
        $products                = ProductForWarehouse::all();
        $projects                = DshProject::find($id);
        $comments_costum_product = DshComments::where('project_id', $id)->where('comment_type', 'costum')->get();
        $comments_normal_product = DshComments::where('project_id', $id)->where('comment_type', 'normal')->get();
        $categories              = Category::all();

        return view('departamentishitjes::arkitekti.projekti', compact('id', 'products', 'categories', 'comments_costum_product', 'projects', 'comments_normal_product'));
    }
    public function arkitekti_produkti($id)
    {
        $product          = DshProduct::find($id);
        $image            = DshUploads::where('file_id', $product->id)->first();
        $project_products = DshProduct::where('product_project_id', $product->product_project_id)->where('product_type', 'custom')->get();
        // dd($project_products);
        $comments_product = DshComments::where('project_id', $id)->where('comment_type', 'specifikime_teknike')->get();
        return view('departamentishitjes::arkitekti.produkti', compact('id', 'product', 'comments_product', 'image', 'project_products'));
    }

    public function list_preorder(Request $request, $id)
    {
        // dd($request);
        if ($request->ajax()) {
            $item = DshProduct::where('product_project_id', $id)
                ->where('product_type', 'custom')->orderBy('id', 'desc');

            if ($request->has('status') && $request->status !== null) {
                $item->where('dsh_products.product_status', $request->status);
            }
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->addColumn('image', function ($item) {
                    $image = DshUploads::where('file_id', $item->id)->first();

                    // Fallback image URL
                    $defaultImage = asset('assets/images/products/default.png');

                    if ($image && $image->file_path) {
                        $imageUrl = asset(Storage::url($image->file_path));
                        $productName = $item->product_name;
                    } else {
                        $imageUrl = $defaultImage;
                        $productName = $item->product_name;
                    }

                    return '<img src="' . $imageUrl . '" 
                                alt="Image" 
                                width="50" 
                                height="50" 
                                style="cursor:pointer;" 
                                onclick="showImageSwal(\'' . $imageUrl . '\', \'' . $productName . '\')">';
                })
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                    return '<a href="' . route('departamentishitjes.arkitekti.produkti', $item->id) . '" class="dropdown-item view-btn">
                    ' . $item->product_name . '
                                </a>';
                })
                ->editColumn('product_description', function ($item) {
                    return $item->product_description;
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
                    // dd($product);
                    if ($item->product_status != 2) {
                        return '<div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="' . route('departamentishitjes.arkitekti.produkti', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                        </ul>
                    </div>';
                    } else {
                        return '
                    <div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item edit-btn"
                                    data-item="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '"
                                    data-id="' . $item->id . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#staticBackdropedit">
                                    <i class="ri-edit-2-fill me-1"></i> Edit
                                </button>
                            </li>
                            <li>
                                <a href="' . route('departamentishitjes.arkitekti.produkti', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item delete-btn-product" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>';
                    }
                })
                ->rawColumns(['product_name', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }

    public function product_list(Request $request, $id)
    {
        if ($request->ajax()) {
            $item = DshProduct::where('product_project_id', $id)
                ->where('product_type', 'normal')->orderBy('id', 'desc');

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                    return pfw_info($item->product_name)->product_name;
                })
                ->editColumn('product_description', function ($item) {
                    $info = pfw_info($item->product_name);
                    $imagePath = $info->image ?? null;

                    // Default image fallback
                    $defaultImage = asset('assets/images/products/default.png');

                    // Check if image exists
                    $imageUrl = $imagePath ? asset(Storage::url($imagePath)) : $defaultImage;
                    $productName = addslashes($info->product_name ?? 'Product');

                    return '<img src="' . $imageUrl . '" 
                                alt="Image" 
                                width="50" 
                                height="50" 
                                style="cursor:pointer;" 
                                onclick="showImageSwal(\'' . $imageUrl . '\', \'' . $productName . '\')">';
                })

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
                    if ($item->product_status == 'Ne pritje') {
                        return '<button class="btn btn-sm btn-outline-warning">' . $item->product_status . '</button>';
                    } elseif ($item->product_status == 'Anulluar') {
                        return '<button class="btn btn-sm btn-outline-danger">' . $item->product_status . '</button>';
                    } else {
                        return '<button class="btn btn-sm btn-outline-success">' . $item->product_status . '</button>';
                    }
                })
                ->addColumn('action', function ($item) {
                     if ($item->product_status != 2) {
                        return '<center>
                                    <i class="ri-check-fill" style="color:#16c60c; font-size:19px"></i>
                                </center>';
                    } else {
                    return '
                    <div class="dropdown text-center">
                        <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <button type="button" class="dropdown-item edit-btn2"
                                    data-item="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '"
                                    data-id="' . $item->id . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#staticBackdropeditproductStatic">
                                    <i class="ri-edit-2-fill me-1"></i> Edit
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item delete-btn-product" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>';
                    }
                })
                ->rawColumns(['product_name', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }
}
