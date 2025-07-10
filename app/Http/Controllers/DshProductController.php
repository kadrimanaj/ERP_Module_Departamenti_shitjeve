<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ProductForWarehouse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\DepartamentiShitjes\Models\DshProduct;
use Modules\DepartamentiShitjes\Models\DshProject;
use Modules\DepartamentiShitjes\Models\DshUploads;
use Modules\DepartamentiShitjes\Models\DshComments;
use Modules\DepartamentiShitjes\Models\DshProductItems;

class DshProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('departamentishitjes::index');
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
                        return '<img src="' . asset('storage/' . $image->file_path) . '" alt="Image" width="50" height="50">';
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
                    return  $item->product_supplier_confirmation;
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
                    return '<center>
                                
                                 <a href="' . route('departamentishitjes.produkti', $item->id) . '" class="btn btn-success btn-sm">
                                    Shiko
                                </a>
                
                            </center>';
                })
                ->rawColumns(['product_name', 'image', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }
    public function list(Request $request, $id)
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
                    return product_name($item->product_name);
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
                    return '<center>
                                
                                <a href="' . route('departamentishitjes.produkti', $item->id) . '" class="btn btn-success btn-sm">
                                    Shiko
                                </a>
                
                            </center>';
                })
                ->rawColumns(['product_name', 'product_description', 'product_supplier_confirmation', 'product_quantity', 'action', 'product_status', 'id'])
                ->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departamentishitjes::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_file' => 'nullable', // max 10MB
        ]);

        $project = new DshProduct();
        $project->product_name = $request->product_name;
        $project->product_type = $request->product_type;
        $project->product_quantity = $request->product_quantity;
        $project->product_description = $request->product_description;
        $project->product_project_id = $id;
        $project->color = $request->color;
        $project->dimension = $request->dimension;
        $project->afati_realizimit_product = $request->afati_realizimit_product;
        $project->user_id = Auth::user()->id;
        $project->save();


        // Check if file is uploaded
        if ($request->hasFile('product_file')) {

            $file = $request->file('product_file');
            // dd($file);

            $paths = handleImageUploadProducts($file);


            // Save info to DB
            $uploads = new DshUploads();
            $uploads->file_name = $file->getClientOriginalName();
            $uploads->file_id = $project->id;
            $uploads->file_path = $paths['original']; // full path for internal tracking
            // dd($paths['original']);
            $uploads->file_type = 'product_image';
            $uploads->file_size = null;
            $uploads->file_userId = Auth::id();
            $uploads->save();
        }

        if ($request->product_type === 'normal') {
            return response()->json([
                'success' => true,
                'message' => 'Produkti u shtua me sukses!'
            ]);

        }else{
            return redirect()->back()->with('success', 'Produkti u shtua me sukses!');
        }


    }

    public function skicat(Request $request, $id)
    {
        $request->validate([
            'product_file' => 'required',
            'item_name' => 'required',
            'item_description' => 'nullable',
        ]);


        $product = new DshProductItems();
        $product->item_name = $request->item_name;
        $product->item_description = $request->item_description;
        $product->item_quantity = 1;
        $product->product_id = $id;
        $product->product_type = 'skice';
        $product->user_id = Auth::user()->id;
        $product->save();



        if ($request->hasFile('product_file')) {

            $file = $request->file('product_file');

            $paths = handleImageUploadProducts($file);

            $uploads = new DshUploads();
            $uploads->file_name = $file->getClientOriginalName();
            $uploads->file_id = $product->id;
            $uploads->file_path = $paths['original'];
            $uploads->file_type = 'skice';
            $uploads->file_size = null;
            $uploads->file_userId = Auth::id();
            $uploads->save();
        }
        return redirect()->back()->with('success', 'Skica u shtua me sukses!');
    }


    public function elements(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'item_name' => 'required',
            'item_description' => 'nullable',
            'item_dimensions' => 'nullable',
            'item_quantity' => 'required',
        ]);
        $product = new DshProductItems();
        $product->item_name = $request->item_name;
        $product->item_description = $request->item_description;
        $product->item_quantity = $request->item_quantity;
        $product->item_dimensions = $request->item_dimensions;
        $product->product_id = $id;
        $product->product_type = 'element';
        $product->user_id = Auth::user()->id;
        $product->save();

        return redirect()->back()->with('success', 'Elementi u shtua me sukses!');
    }


    public function product_confirm($id)
    {
        $product = DshProduct::find($id);
        $product->product_confirmation = 1;
        $product->product_status = 8;
        $product->save();

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


    public function porducts_list(Request $request,$id){
        //  dd($request);
         if ($request->ajax()) {
            $project = DshProject::find($id);
            $item = ProductForWarehouse::orderBy('id', 'desc');

                if ($request->has('status') && $request->status !== null) {
                    $item->where('dsh_products.product_status', $request->status);
                }
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->addColumn('image', function ($item) {
                    return '<img src="' . asset('storage/' . $item->image) . '" alt="Image" width="50" height="50" style="cursor:pointer;" onclick="showImageSwal(\'' . asset($item->image) . '\', \'' . addslashes($item->product_name) . '\')">';
                })
                
                ->filterColumn('product_name', function ($query, $keyword) {
                    $query->where('product_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('product_name', function ($item) {
                    return  '<a href="' . route('departamentishitjes.arkitekti.produkti', $item->id) . '" class="dropdown-item view-btn">
                    ' . $item->product_name . '
                                </a>';
                })


                ->editColumn('qty', function ($item) {
                    return $item->qty;
                })
                ->editColumn('category_id', function ($item) {
                    return all_about_category($item->category_id)->name;
                })
                ->editColumn('price', function ($item) {
                    return $item->price;
                })

                ->addColumn('action', function ($item) use ($project) {
                    // dd($product);
                    return '
                            <form class="add-to-cart-form" data-url="' . route('departamentishitjes.product.store', $project->id) . '" method="POST">
                                '.csrf_field().'
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="number" class="form-control w-50" name="product_quantity" min="1" value="1" required>
                                    <input type="hidden" name="product_name" value="' . $item->id . '">
                                    <input type="hidden" name="product_type" value="normal">
                                    <button type="button" class="btn btn-primary btn-sm add-to-cart-btn">+</button>
                                </div>
                            </form>';   
                })
                ->rawColumns(['product_name','category_id', 'image','price', 'qty', 'action', 'id'])
                ->make(true);
        }
    }
}
