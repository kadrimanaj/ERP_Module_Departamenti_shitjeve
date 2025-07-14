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

class OfertuesiController extends Controller
{
    public function ofertuesi_dashboard()
    {
        $clients = Partners::all();
        $workers = Workers::all();
        return view('departamentishitjes::ofertuesi.dashboard', compact('clients', 'workers'));
    }

    public function list(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $item = DshProject::select([
                'dsh_projects.id',
                'dsh_projects.project_name',
                'dsh_projects.project_description',
                'dsh_projects.project_status',
                'dsh_projects.project_start_date',
                'dsh_projects.project_client',
                'dsh_projects.project_architect',
                'partners.contact_name as client_name',
                'hr_workers.name as arkitekt_name', // Corrected alias for architect name
            ])
                ->leftJoin('partners', 'dsh_projects.project_client', '=', 'partners.id')
                ->leftJoin('hr_workers', 'dsh_projects.project_architect', '=', 'hr_workers.id')
                ->orderBy('dsh_projects.id', 'desc');

            // Apply filters
            if ($request->client_name) {
                $item->where('partners.contact_name', 'LIKE', "%" . $request->client_name . "%");
            }

            if ($request->arkitekt_name) {
                $item->where('hr_workers.name', 'LIKE', "%" . $request->arkitekt_name . "%");
            }

            if ($request->project_status) {
                $search = strtolower($request->project_status);

                $statusMap = [
                    0 => 'ne pritje',
                    1 => 'ne proces',
                    2 => 'konfirmuar',
                    3 => 'refuzuar',
                    // add more if needed
                ];

                foreach ($statusMap as $code => $label) {
                    if (str_contains(strtolower($label), $search)) {
                        $item->where('dsh_projects.project_status', $code);
                        break;
                    }
                }
            }

            if ($request->has('status') && $request->status !== null) {
                $item->where('dsh_projects.project_status', $request->status);
            }

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->filterColumn('project_name', function ($query, $keyword) {
                    $query->where('dsh_projects.project_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('project_name', function ($item) {
                    if ($item->project_status == 'Konfirmuar') {
                        return $item->project_name;
                    } else {
                        return '<a href="' . route('departamentishitjes.ofertuesi.projekti', $item->id) . '">' . $item->project_name . '</a>';
                    }
                })
                ->editColumn('project_description', function ($item) {
                    return $item->project_description;
                })

            // **Fix: Filter Architect Name Properly**
                ->filterColumn('arkitekt_name', function ($query, $keyword) {
                    $query->where('workers.name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('arkitekt_name', function ($item) {
                    return $item->arkitekt_name; // Corrected reference
                })

            // **Fix: Filter Client Name Properly**
                ->filterColumn('client_name', function ($query, $keyword) {
                    $query->where('partners.contact_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('client_name', function ($item) {
                    return '<a href="{{' . route('partners.show', $item->project_client) . ' }}">' . $item->client_name . '</a>';
                })

                ->editColumn('name', function ($item) {
                    if ($item->project_status == 2) {
                        return $item->project_name;
                    } else {
                        return '<a type="button" class="view-btn"
                                data-item="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '"
                                data-bs-toggle="modal"
                                data-bs-target="#staticBackdropview">
                                ' . $item->project_name . '
                            </a>';
                    }
                })

                ->editColumn('project_start_date', function ($item) {
                    return $item->project_start_date;
                })

            // **Fix: Filter Project Status Properly**
                ->filterColumn('project_status', function ($query, $keyword) {
                    $query->where('dsh_projects.project_status', 'LIKE', "{$keyword}%");
                })

                ->editColumn('project_status', function ($item) {
                    $status = $item->project_status;
                    $class  = match ($status) {
                        'Ne pritje' => 'warning',
                        'Anulluar' => 'danger',
                        default    => 'success',
                    };
                    return '<button class="btn btn-sm btn-outline-' . getStatusColor($item->project_status) . ' filter-status" data-project_status="' . $status . '">' . getStatusName($status) . '</button>';
                })
                ->editColumn('product_confirmed', function ($item) {
                    $products          = DshProduct::where('product_project_id', $item->id)->count();
                    $product_confirmed = DshProduct::where('product_project_id', $item->id)->where('offert_price', '!=', null)->count();

                    if ($product_confirmed == 0) {
                        return '<button class="btn btn-sm btn-outline-danger filter-status">' . $product_confirmed . '/' . $products . '</button>';
                    } else if ($product_confirmed < $products && $product_confirmed > 0) {
                        return '<button class="btn btn-sm btn-outline-warning filter-status">' . $product_confirmed . '/' . $products . '</button>';
                    } else if ($product_confirmed == $products) {
                        return '<button class="btn btn-sm btn-outline-success filter-status">' . $product_confirmed . '/' . $products . '</button>';
                    }
                })
                ->addColumn('action', function ($item) {
                    if($item->project_status == 7) {
                        return '
                            <div class="dropdown text-center">
                                <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="' . route('departamentishitjes.ofertuesi.projekti', $item->id) . '" class="dropdown-item view-btn">
                                            <i class="ri-eye-fill ms-3"></i> View
                                        </a>
                                    </li>
                                    <li>
                                    <a class="dropdown-item pdf-btn text-warning" target="_blanked" href="'. route('preventiv.pdf',$item->id) .'"> <i class="ri-file-pdf-2-line ms-3"></i> PDF</a>
                                    </li>
                                </ul>
                            </div>';
                    }else{
                                            return '
                        <div class="dropdown text-center">
                            <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="' . route('departamentishitjes.ofertuesi.projekti', $item->id) . '" class="dropdown-item view-btn">
                                        <i class="ri-eye-fill ms-3"></i> View
                                    </a>
                                </li>
                            </ul>
                        </div>';
                    }


                })
                ->rawColumns(['project_start_date', 'product_confirmed', 'project_description', 'client_name', 'arkitekt_name', 'project_name', 'action', 'project_status', 'id'])
                ->make(true);
        }
    }

    public function ofertuesi_projekti($id)
    {
        $project = DshProject::find($id);
        $comments_costum_product = DshComments::where('project_id', $id)->where('comment_type', 'costum')->get();
        $comments_normal_product = DshComments::where('project_id', $id)->where('comment_type', 'normal')->get();
        $categories              = Category::all()->prepend((object) [
            'id'   => '',
            'name' => 'All Categories',
        ]);
        return view('departamentishitjes::ofertuesi.projekti', compact('comments_costum_product', 'comments_normal_product', 'id', 'categories','project'));
    }

    public function list_preorder(Request $request, $id)
    {
        // dd($request);
        if ($request->ajax()) {
            $item = DshProduct::where('product_project_id', $id)
                ->where('product_type', 'custom')->orderBy('id', 'desc');

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->addColumn('image', function ($item) {
                    $image = DshUploads::where('file_id', $item->id)->first();
                    if ($image) {

                        // $image = pfw_info($item->product_name)->image;
                        
                        return '<img src="' . asset(Storage::url($image->file_path)) . '" alt="Image" width="50" height="50" style="cursor:pointer;" onclick="showImageSwal(\'' . asset(Storage::url($image->file_path)) . '\', \'' . addslashes($image->product_name) . '\')">';
                        // return '<img src="' . asset($image->file_path) . '" alt="Image" width="50" height="50">';
                    }
                })
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                    return $item->product_name;
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

                ->editColumn('total_cost', function ($item) {
                    return $item->total_cost . ' ' . curr_symbol(1);
                })

                ->editColumn('offert_price', function ($item) {
                    $product = DshProduct::where('id', $item->id)->first();
                    if ($product->ofertuesi_status == 2) {
                        return '
                                        <center>
                                            ' . $item->offert_price . ' ' . curr_symbol(1) . '
                                        </center>
                                        ';
                    } else {
                        return '
                                    <center>
                                        ' . $item->offert_price . ' ' . curr_symbol(1) . '
                                        <button type="button" class="btn ms-3 btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#offertModal' . $item->id . '">
                                            <i class="ri-pencil-fill"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="offertModal' . $item->id . '" tabindex="-1" aria-labelledby="offertModalLabel' . $item->id . '" aria-hidden="true">
                                        <div class="modal-dialog  modal-dialog-centered">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="offertModalLabel' . $item->id . '">Edit Offert Price</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="number" class="form-control" step="0.01" value="' . $item->offert_price . '" id="inputOffert' . $item->id . '">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary btn-sm" onclick="saveOffertPrice(' . $item->id . ')">Save</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </center>
                                    ';
                    }
                })
                ->addColumn('action', function ($item) {
                    $product = DshProduct::where('id', $item->id)->first();
                    if ($product->ofertuesi_status == 2) {
                        return '
                            <center>
                                <i class="ri-check-line" style="color: #28a745; font-size: 19px;"></i>
                            </center>
                        ';
                    } else {
                        return '
                        <div class="dropdown text-center">
                            <a type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="' . route('departamentishitjes.ofertuesi.preventiv.view', $item->id) . '" class="dropdown-item">
                                        <i class="ri-eye-fill me-2"></i> Shiko
                                    </a>
                                </li>
                            </ul>
                        </div>
                        ';

                    }
                })
                ->rawColumns(['product_name', 'offert_price', 'total_cost', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }

    public function product_list(Request $request, $id)
    {
        // dd($request);
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
                    $image = pfw_info($item->product_name)->image;
                    return '<img src="' . asset(Storage::url($image)) . '" alt="Image" width="50" height="50" style="cursor:pointer;" onclick="showImageSwal(\'' . asset(Storage::url($image)) . '\', \'' . addslashes(pfw_info($item->product_name)->product_name) . '\')">';
                })
                ->editColumn('total_cost', function ($item) {
                    return pfw_info($item->product_name)->price . ' ' . curr_symbol(1);
                })

                ->editColumn('offert_price', function ($item) {
                    $product = DshProduct::where('id', $item->id)->first();
                    if ($product->ofertuesi_status == 2) {
                        return '
                        <center>
                            ' . $item->offert_price . ' ' . curr_symbol(1) . '
                        </center>
                        ';
                    } else {
                        return '
                    <center>
                        ' . $item->offert_price . ' ' . curr_symbol(1) . '
                        <button type="button" class="btn ms-3 btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#offertModal' . $item->id . '">
                            <i class="ri-pencil-fill"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="offertModal' . $item->id . '" tabindex="-1" aria-labelledby="offertModalLabel' . $item->id . '" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="offertModalLabel' . $item->id . '">Edit Offert Price</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="number" class="form-control" step="0.01" value="' . $item->offert_price . '" id="inputOffert' . $item->id . '">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary btn-sm" onclick="saveOffertPrice(' . $item->id . ')">Save</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    </center>
                    ';
                    }
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
                    if ($item->product_status == 'Ne pritje') {
                        return '<button class="btn btn-sm btn-outline-warning">' . $item->product_status . '</button>';
                    } elseif ($item->product_status == 'Anulluar') {
                        return '<button class="btn btn-sm btn-outline-danger">' . $item->product_status . '</button>';
                    } else {
                        return '<button class="btn btn-sm btn-outline-success">' . $item->product_status . '</button>';
                    }
                })
                ->addColumn('action', function ($item) {
                    $product = DshProduct::where('id', $item->id)->first();
                    if ($product->ofertuesi_status == 2) {
                        return '
                            <center>
                                <i class="ri-check-line" style="color: #28a745; font-size: 19px;"></i>
                            </center>
                        ';
                    } else {
                        return '
                                <div class="dropdown text-center">
                                    <a type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                </div>';
                    }
                })
                ->rawColumns(['product_name', 'offert_price', 'total_cost', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }

    public function view_preventiv($id)
    {
        $product              = DshProduct::where('id', $id)->first();
        $productsPerWarehouse = ProductForWarehouse::all();
        $units                = ProductUnit::all();
        $image                = DshUploads::where('file_id', $product->id)->first();
        $categories           = Category::all();

        return view('departamentishitjes::ofertuesi.preventiv', compact('id', 'product', 'categories', 'productsPerWarehouse', 'units', 'image'));
    }

    public function updateOffertPrice(Request $request)
    {
        // dd($request);
        $request->validate([
            'id'           => 'required',
            'offert_price' => 'required|numeric|min:0',
        ]);

        $product               = DshProduct::find($request->id);
        $product->offert_price = $request->offert_price;
        $product->save();

        return response()->json(['success' => true]);
    }

    public function confirm_offer($id)
    {
        // dd($id);
        $project = DshProject::find($id);
        if (!$project) {
            return redirect()->back()->with('error', 'Projekti nuk u gjet.');
        }
        $project->project_status = 7; // Konfirmuar
        $project->save();



        $items = DshProduct::where('product_project_id', $id)->get();
        foreach ($items as $item) {
            $item->product_status   = 7;
            $item->ofertuesi_status = 2;
            $item->save();
        }

        $user = User::find(Auth::user()->id);

        $comment = new DshComments();
        $comment->comment_type = 'specifikime_teknike';
        $comment->comment = 'Produkti u konfirmua';
        $comment->user_id =  $user->name; // or $request->user_id if passed explicitly
        $comment->project_id = $id;
        $comment->save();

        return redirect()->back()->with('success', 'Projekti u ofertua me sukses.');

    }


    public function pdf($id)
    {
        $project = DshProject::find($id);
        $costum_products = DshProduct::where('product_project_id', $id)->where('product_type','custom')->whereNotNull('offert_price')->get();

        $total_costum = 0;
        foreach ($costum_products as $product) {
            $total_costum += $product->product_quantity * $product->offert_price;
        }
        $total_costum_qty = $costum_products->sum('product_quantity');
        $total_costum_models = $costum_products->count();

        $normal_products = DshProduct::where('product_project_id', $id)->where('product_type','normal')->get();
        $total_normal_qty = $normal_products->sum('product_quantity');
        $total_normal_models = $normal_products->count();

        $total_normal = 0;
        foreach ($normal_products as $product) {
            $total_normal += $product->product_quantity * $product->offert_price;
        }

        if (!$project) {
            return redirect()->back()->with('error', 'Projekti nuk u gjet.');
        }
        return view('departamentishitjes::ofertuesi.pdf',compact('id','project','costum_products','normal_products','total_costum','total_normal','total_costum_qty','total_normal_qty',
            'total_costum_models','total_normal_models'));
    }

}
