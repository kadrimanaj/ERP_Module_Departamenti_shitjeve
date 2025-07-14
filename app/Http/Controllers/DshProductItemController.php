<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use PDO;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\DepartamentiShitjes\Models\DshProduct;
use Modules\DepartamentiShitjes\Models\DshUploads;
use Modules\DepartamentiShitjes\Models\DshProductItems;

class DshProductItemController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        $product_id = $request->input('product_id');
        $item_name = $request->input('item_name');
        $item_description = $request->input('item_description');
        $item_quantity = $request->input('item_quantity');
        $item_price = $request->input('item_price');

        // Insert the new item into the database
        DB::table('dsh_product_items')->insert([
            'product_id' => $product_id,
            'item_name' => $item_name,
            'item_description' => $item_description,
            'item_quantity' => $item_quantity,
            'item_price' => $item_price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function elements_list(Request $request, $id)
    {
        if ($request->ajax()) {
            $item = DshProductItems::where('product_id', $id)
                ->where('product_type', 'element')->orderBy('id', 'desc');
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->filterColumn('item_name', function ($query, $keyword) {
                    $query->where('item_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('item_name', function ($item) {
                    return $item->item_name;
                })
                ->editColumn('item_description', function ($item) {
                    return $item->item_description;
                })

                ->editColumn('item_quantity', function ($item) {
                    return $item->item_quantity;
                })
                ->editColumn('item_dimensions', function ($item) {
                    return $item->item_dimensions;
                })

                ->addColumn('action', function ($item) {
                    $product = DshProduct::find($item->product_id);
                    // dd($product);
                    if ($product->product_status == 2 || $product->product_status == 8) {
                        return '<center>
                                    <button type="button" class="btn btn-sm btn-success" disabled>
                                        <i class="ri-check-line"></i>
                                    </button>
                                </center>';
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
                                    data-id="' . $item->id  . '"
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
                ->rawColumns(['item_name', 'item_description', 'item_quantity','item_dimensions', 'action', 'id'])
                ->make(true);
        }
    }

    public function skicat_list(Request $request, $id)
    {
        if ($request->ajax()) {
            $item = DshProductItems::where('product_id', $id)
                ->where('product_type', 'skice')->orderBy('id', 'desc');

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->addColumn('item_document', function ($item) {
                    $upload = DshUploads::where('file_id', $item->id)->first();

                    if ($upload) {
                        $filePath = asset(Storage::url($upload->file_path));
                        $extension = strtolower(pathinfo($upload->file_path, PATHINFO_EXTENSION));

                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

                        if (in_array($extension, $imageExtensions)) {
                            // Show actual image
                            return '<a href="' . $filePath . '" target="_blank">
                                        <img src="' . $filePath . '" alt="Image" width="50" height="50" style="object-fit: cover;">
                                    </a>';
                        } else {
                            // Show icon for other file types
                            switch ($extension) {
                                case 'pdf':
                                    $icon = 'ri-file-pdf-line text-danger';
                                    break;
                                case 'doc':
                                case 'docx':
                                    $icon = 'ri-file-word-line text-primary';
                                    break;
                                case 'xls':
                                case 'xlsx':
                                    $icon = 'ri-file-excel-line text-success';
                                    break;
                                case 'ppt':
                                case 'pptx':
                                    $icon = 'ri-file-ppt-line text-warning';
                                    break;
                                default:
                                    $icon = 'ri-file-line text-secondary';
                                    break;
                            }

                            return '<a href="' . $filePath . '" target="_blank">
                                        <i class="' . $icon . '" style="font-size: 24px;"></i>
                                    </a>';
                        }
                    }

                    return '';
                })
                ->filterColumn('item_name', function ($query, $keyword) {
                    $query->where('item_name', 'LIKE', "%{$keyword}%");
                })
                ->editColumn('item_name', function ($item) {
                    return $item->item_name;
                })
                ->editColumn('item_description', function ($item) {
                    return $item->item_description;
                })

                ->addColumn('action', function ($item) {
                    $product = DshProduct::find($item->product_id);
                    // dd($product);
                    if ($product->product_status == 2 || $product->product_status == 8) {
                        return '<center>
                                    <button type="button" class="btn btn-sm btn-success" disabled>
                                        <i class="ri-check-line"></i>
                                    </button>
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
                                    data-id="' . $item->id  . '"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#staticBackdropedit2">
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
                ->rawColumns(['item_name', 'item_document', 'item_description', 'action', 'id'])
                ->make(true);
        }
    }

    public function destroy($id)
    {
        $item = DshProductItems::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'item_name' => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'item_quantity' => 'required|numeric|min:0',
            'product_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('product_file')) {
            $file = $request->file('product_file');
            $paths = handleImageUploadProducts($file);

            // Check if upload already exists
            $existingFile = DshUploads::where('file_id', $id)
                ->where('file_type', 'skice')
                ->first();

            if ($existingFile) {
                // Update existing file
                $existingFile->file_name = $file->getClientOriginalName();
                $existingFile->file_path = $paths['original'];
                $existingFile->file_userId = Auth::id();
                $existingFile->save();
            } else {
                // Create new file
                $newUpload = new DshUploads();
                $newUpload->file_name = $file->getClientOriginalName();
                $newUpload->file_id = $id;
                $newUpload->file_path = $paths['original'];
                $newUpload->file_type = 'skice';
                $newUpload->file_size = null;
                $newUpload->file_userId = Auth::id();
                $newUpload->save();
            }
        }

        $product = DshProductItems::findOrFail($id);

        $product->item_name = $request->item_name;
        $product->item_description = $request->item_description;
        $product->item_quantity = $request->item_quantity;

        $product->save();

        return redirect()->back()->with('success', 'Produkti u përditësua me sukses!');
    }
}
