<?php
namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Models\User;
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
use Modules\DepartamentiShitjes\Models\DshHapsiraCategory;
use Modules\DepartamentiShitjes\Models\DshModeles;
use Modules\DepartamentiShitjes\Models\DshProductsCategory;

class ShitesiController extends Controller
{
    public function shitesi_dashboard()
    {
        $clients        = Partners::all();
        $workers        = Workers::all();
        $projects_total = DshProject::where('project_seller_id', Auth::user()->id)->count();
        $clients_total  = Partners::where('referred_by', Auth::user()->id)->count();

        return view('departamentishitjes::shitesi.dashboard', compact('workers', 'clients_total', 'projects_total', 'clients'));
    }

    public function getCategories(Request $request)
    {
        $id = $request->input('hapsira_id');
        $type = $request->input('type');

        if ($type === 'hapsira') {
            $categories = DshProductsCategory::where('hapsira_id', $id)
                ->whereNull('parent_id')
                ->get(['id', 'product_category_name', 'parent_id']);
        } else {
            $categories = DshProductsCategory::where('parent_id', $id)
                ->get(['id', 'product_category_name', 'parent_id']);
        }

        return response()->json(['categories' => $categories]);
    }




    public function list(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $item = DshProject::where('project_seller_id', Auth::user()->id)
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
                        return '<a href="' . route('departamentishitjes.shitesi.projekti', $item->id) . '">' . $item->project_name . '</a>';
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

                ->addColumn('action', function ($item) {
                    if ($item->project_status >= 2 && $item->project_status != 3) {
                        return '
                        <center>
                            <i class="ri-check-fill" style="color:#16c60c; font-size:19px"></i>
                        </center>
                        ';
                    } else if ($item->project_status == 3) {
                        return '<center>
                                    <i class="ri-close-fill" style="color: #dc3545; font-size: 19px;"></i>
                                </center>';
                    } else if ($item->project_status == 0) {

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
                                <a href="' . route('departamentishitjes.shitesi.projekti', $item->id) . '" class="dropdown-item view-btn">
                                    <i class="ri-eye-fill me-1"></i> View
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item delete-btn-project" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Anullo
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
                    } else {
                        return '
                        <div class="dropdown text-center">
                            <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="' . route('departamentishitjes.shitesi.projekti', $item->id) . '" class="dropdown-item view-btn">
                                        <i class="ri-eye-fill me-1"></i> View
                                    </a>
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

    public function list_clients(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $item = Partners::where('partners.referred_by', Auth::user()->id)
                ->select([
                    'partners.id',
                    'partners.contact_name',
                    'partners.contact_email',
                    'partners.created_at',
                    'partners.type',
                    'partners.company_name',
                    'partners.contact_phone',
                    'partners.country',
                    'partners.city',
                    'partners.state',
                    'partners.zip',
                    'partners.address',
                    'partners.remarks',
                    'partners.group_id',
                    'partners.user_id',
                    'partners.nipt',
                    'partners.contact_type',
                ])
                ->orderBy('partners.id', 'desc');

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->filterColumn('contact_email', function ($query, $keyword) {
                    $query->where('partners.contact_email', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('contact_email', function ($item) {
                    return $item->contact_email;
                })
            // **Fix: Filter Client Name Properly**
                ->filterColumn('contact_name', function ($query, $keyword) {
                    $query->where('partners.contact_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('contact_name', function ($item) {
                    return '<a href="' . route('partners.show', $item->id) . '">' . $item->contact_name . '</a>';
                })

                ->editColumn('created_at', function ($item) {
                    return $item->created_at->format('d-M-Y');
                })

                ->addColumn('action', function ($item) {
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
                                            data-bs-target="#editPartnerModal">
                                            <i class="ri-edit-2-fill"></i> Edit
                                        </button>
                                    </li>
                                    <li>
                                        <a type="button" class="dropdown-item view-btn" href="' . route('partners.show', $item->id) . '">
                                            <i class="ri-eye-fill"></i> View
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                })
                ->rawColumns(['created_at', 'contact_email', 'contact_name', 'action', 'id'])
                ->make(true);
        }
    }

    public function shitesi_projekti($id)
    {
        $products                = ProductForWarehouse::all();
        $projects                = DshProject::where('id', $id)->first();
        $comments_costum_product = DshComments::where('project_id', $id)->where('comment_type', 'costum')->get();
        $comments_normal_product = DshComments::where('project_id', $id)->where('comment_type', 'normal')->get();
        $categories              = Category::all()->prepend((object) [
            'id'   => '',
            'name' => 'All Categories',
        ]);

        $hapsirat = DshHapsiraCategory::all();

        return view('departamentishitjes::shitesi.projekti', compact('id', 'products', 'categories','hapsirat', 'projects', 'comments_normal_product', 'comments_costum_product'));
    }

    public function shitesi_produkti($id)
    {
        return view('departamentishitjes::arkitekti.produkti', compact('id'));
    }

    public function project_confirm($id)
    {
        // dd($id);
        $project  = DshProject::find($id);
        $products = DshProduct::where('product_project_id', $id)->count();
        if ($products == 0) {
            return redirect()->back()->with('error', 'Kerkesa nuk mund te konfirmohet pa produkte te shtuar.');
        } else {
            if ($project) {
                $project->project_status = 2;
                $project->save();

                    $user = User::find(Auth::user()->id);

                    $comment = new DshComments();
                    $comment->comment_type = 'specifikime_teknike';
                    $comment->comment = 'Produkti u konfirmua';
                    $comment->user_id =  $user->name; // or $request->user_id if passed explicitly
                    $comment->project_id = $id;
                    $comment->save();
                return redirect()->back()->with('success', 'Kerkesa u konfirmua me sukses.');
            }
        }

        return redirect()->back()->with('error', 'Kerkesa nuk u gjet.');
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
                    $product = DshModeles::where('id', $item->product_name)->first();
                    $image = ProductForWarehouse::where('id', $product->product_id)->first();

                    // Fallback image URL
                    $defaultImage = asset('assets/images/products/default.png');

                    if ($image && $image->image) {
                        $imageUrl = asset(Storage::url($image->image));
                        $productName = $image->product_name;
                    } else {
                        $imageUrl = $defaultImage;
                        $productName = $image->product_name;
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

                ->editColumn('product_details', function ($item) {
                    $modalId = 'modalDetails_' . $item->id;

                    $details = json_decode($item->product_details, true);

                    $formattedHtml = '';

                    foreach ($details as $groupIndex => $group) {
                        $formattedHtml .= '<div style="border: 2px solid #333; padding: 15px; margin-bottom: 15px; border-radius: 8px;">';

                        foreach ($group as $question => $answer) {
                            $formattedHtml .= '
                                <div style="margin-bottom: 8px;">
                                    <strong>' . e($question) . ':</strong> ' . e($answer) . '
                                </div>
                            ';
                        }

                        $formattedHtml .= '</div>';
                    }

                    return '
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">
                            View Details
                        </button>

                        <div class="modal fade" id="' . $modalId . '" tabindex="-1" aria-labelledby="' . $modalId . 'Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="' . $modalId . 'Label">Product Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ' . $formattedHtml . '
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                })

                ->addColumn('action', function ($item) {
                    $project = DshProject::where('id', $item->product_project_id)->first();
                    if ($project->project_status == 3) {
                        return '
                        <center>
                            <i class="ri-close-large-line" style="color:red; font-size:19px"></i>
                        </center>
                        ';
                    }else if ($project->project_status >= 2 && $project->project_status != 3) {
                        return '
                        <center>
                            <i class="ri-check-fill" style="color:#16c60c; font-size:19px"></i>
                        </center>
                        ';
                    }else {
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
                                <button type="button" class="dropdown-item delete-btn-product" data-id="' . $item->id . '">
                                    <i class="ri-delete-bin-6-line me-1"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>';
                    }
                })
                ->rawColumns(['product_name','product_details', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
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
                    $project = DshProject::where('id', $item->product_project_id)->first();
                    if ($project->project_status == 3) {
                        return '
                        <center>
                            <i class="ri-close-large-line" style="color:red; font-size:19px"></i>
                        </center>
                        ';
                    }else if ($project->project_status >= 2 && $project->project_status != 3) {
                        return '
                        <center>
                            <i class="ri-check-fill" style="color:#16c60c; font-size:19px"></i>
                        </center>
                        ';
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

    public function delete_normal_product($id)
    {
        $product = DshProduct::findOrFail($id); // Find the product by ID

        // Delete the product
        $product->delete();

        // Return a JSON response indicating success
        return response()->json(['success' => true, 'message' => 'Produkti Normal u hoq me sukses!']);
    }

    public function update_product_normal(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'product_name'        => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_status'      => 'nullable|in:Ne pritje,Konfirmuar,Refuzuar',
            'product_quantity'    => 'required|numeric|min:0',
            'product_file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('product_file')) {
            $file  = $request->file('product_file');
            $paths = handleImageUploadProducts($file);

            // Check if upload already exists
            $existingFile = DshUploads::where('file_id', $id)
                ->where('file_type', 'product_image')
                ->first();

            if ($existingFile) {
                // Update existing file
                $existingFile->file_name   = $file->getClientOriginalName();
                $existingFile->file_path   = $paths['original'];
                $existingFile->file_userId = Auth::id();
                $existingFile->save();
            } else {
                // Create new file
                $newUpload              = new DshUploads();
                $newUpload->file_name   = $file->getClientOriginalName();
                $newUpload->file_id     = $id;
                $newUpload->file_path   = $paths['original'];
                $newUpload->file_type   = 'product_image';
                $newUpload->file_size   = null;
                $newUpload->file_userId = Auth::id();
                $newUpload->save();
            }
        }

        $product = DshProduct::findOrFail($id);

        $product->product_name        = $request->product_name;
        $product->product_description = $request->product_description;
        // $product->product_status      = $request->product_status;
        $product->product_quantity    = $request->product_quantity;

        $product->save();

        return redirect()->back()->with('success', 'Produkti u përditësua me sukses!');
    }
}
