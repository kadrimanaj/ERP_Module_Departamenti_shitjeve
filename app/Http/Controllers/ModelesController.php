<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ProductForWarehouse;
use App\Http\Controllers\Controller;
use Modules\FormManager\Models\Form;
use Illuminate\Support\Facades\Storage;
use Modules\FormManager\Models\FormItem;
use Modules\DepartamentiShitjes\Models\DshModels;
use Modules\DepartamentiShitjes\Models\DshModeles;
use Modules\DepartamentiShitjes\Models\DshModeleItems;
use Modules\DepartamentiShitjes\Models\DshHapsiraCategory;
use Modules\DepartamentiShitjes\Models\DshProductsCategory;

class ModelesController extends Controller
{
    public function index()
    {
        return view('departamentishitjes::modeles.dashboard');
    }

    public function create()
    {
        $products = ProductForWarehouse::all();
        $hapsiraCategories = DshHapsiraCategory::all();
        $productCategories = DshProductsCategory::all();
        $modules = Form::all();
        return view('departamentishitjes::modeles.add_model',compact('products','hapsiraCategories','productCategories','modules'));
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $item = DshModeles::all();

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->editColumn('model_name', function ($item) {
                    $url = route('modeles.show.form', ['id' => $item->id]);
                    return 
                    '<center><a href="' . $url . '">' . $item->model_name . '</a></center>';
                })
                ->editColumn('product_id', function ($item) {
                    if($item->product_id != null){
                        return 
                        '<center>'.$item->product_id.'</center>';
                    }else if($item->product_name != null){
                        return 
                        '<center>'.$item->product_name.'</center>';
                    }else{
                        return ' - ';
                    }
                })
                ->editColumn('module_name', function ($item) {
                    return 
                    '<center>'.$item->module_name.'</center>';
                })
                ->editColumn('hapsira_category_id', function ($item) {
                    return 
                    '<center>'.$item->hapsira_category_id.'</center>';
                })
                ->editColumn('product_category_id', function ($item) {
                    return 
                    '<center>'.$item->product_category_id.'</center>';
                })
                ->addColumn('action', function ($item) {
                    $editBtn = '
                        <button type="button"
                                class="btn btn-sm btn-outline-primary editFormBtn"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditForm"
                                data-id="' . $item->id . '"
                                data-name="' . e($item->name) . '"
                                data-status="' . $item->status . '">
                                <i class="ri-edit-2-fill me-1"></i>  Edit
                        </button>';
                    return '<center>
                        '.$editBtn.'</center>
                    ';
                })
                ->rawColumns(['model_name','product_id','module_name','hapsira_category_id','product_category_id', 'action', 'id'])
                ->make(true);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'model_name' => 'required',
            'product_id' => 'required',
            'hapsira_category_id' => 'required',
            'product_category_id' => 'required',
            'module_name' => 'required', // This is your form_id
        ]);

        // Save the model
        $model = new DshModeles();
        $model->model_name = $request->model_name;
        $model->product_id = $request->product_id;
        $model->hapsira_category_id = $request->hapsira_category_id;
        $model->product_category_id = $request->product_category_id;
        $model->module_name = $request->module_name;
        $model->save();

        // Fetch all form items from FormItem where form_id = module_name
        $formItems = FormItem::where('form_id', $request->module_name)->get();

        foreach ($formItems as $formItem) {
            DshModeleItems::create([
                'modele_item_id'  => $formItem->id, // ← This is the key mapping
                'model_id'        => $model->id,
                'input_type'      => $formItem->input_type,
                'input_name'      => $formItem->input_name,
                'input_options'   => $formItem->input_options,
                'parent_name'     => $formItem->parent_name,
                'icon'            => $formItem->icon,
                'cols'            => $formItem->cols,
            ]);
        }

        return redirect()->back()->with('success', 'Modeli u shtua me sukses!');
    }

    public function show($id)
    {
        // dd($id);
        $form = DshModeles::findOrFail($id);
        // dd($form);

        $items = DshModeleItems::where('model_id', $form->id)->get()->values(); // ✅ Convert to indexed array

        return view('departamentishitjes::modeles.formdisplay', compact('form'));
    }

    public function getFormItems($formId)
    {
        $items = DshModeleItems::where('model_id', $formId)->get()->values();
        return response()->json($items);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');

        $products = ProductForWarehouse::where('product_name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'product_name']);

        return response()->json($products);
    }



    public function storeFormModel(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'items'                 => 'required|array',
            'items.*.input_name'    => 'required|string',
            'items.*.input_type'    => 'required|string|in:text,checkbox,select,radio,text-area,date,number',
            'items.*.cols'          => 'nullable|string',
            'items.*.icon'          => 'nullable|string',
            'items.*.filter'        => 'nullable|boolean',
            'items.*.input_options' => 'nullable|string',
            'items.*.parent_name'   => 'nullable|string',
            'items.*.parent_index'  => 'nullable|string',  // <- NEW
            'module_name'           => 'required',
            'model_name'           => 'required',
            'product_id'           => 'nullable',
            'product_name'           => 'nullable',
            'hapsira_category_id'           => 'nullable',
            'product_category_id'           => 'nullable',
        ]);

        $module = Module::where('module_name',$validated['module_name'])->first();

        $form = DshModeles::create([
            'model_name'        => $validated['name'],
            'product_id' => $validated['product_id'] ?? null,
            'product_name' => $validated['product_name'] ?? null,
            'module_name' => $module->id,
            'hapsira_category_id'    => $validated['hapsira_category_id'] ?? null,
            'product_category_id'    => $validated['product_category_id'] ?? null,
        ]);
        $itemsMap = []; // Temporary map to store [index => modele_item_id]

        foreach ($validated['items'] as $index => $item) {
            $parentIndex = $item['parent_index'] ?? null;
            $formItemId = $parentIndex !== null && isset($itemsMap[$parentIndex]) ? $itemsMap[$parentIndex] : null;

            $itemModel = $form->items()->create([
                'input_type'    => $item['input_type'],
                'input_name'    => $item['input_name'],
                'cols'          => $item['cols'] ?? null,
                'icon'          => $item['icon'] ?? null,
                'filter'        => $item['filter'] ?? 0,
                'input_options' => $item['input_options'] ?? null,
                'modele_item_id'  => $formItemId, // Set parent relationship
                'parent_name'   => $item['parent_name'] ?? null,
            ]);

            $itemsMap[$index] = $itemModel->id; // Save ID for future children
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Formulari u ruajt me sukses!',
            'redirect' => route('departamentishitjes.modeles.dashboard'),
        ]);

    }

    public function edit($id)
    {
        $form = DshModeles::with('items')->findOrFail($id);
        // dd($form);

        return response()->json([
            'id'                 => $form->id,
            'name'               => $form->model_name,
            'module_name'        => $form->module_name,
            'placement_position' => $form->position,
            'items'              => $form->items,
        ]);
    }


    public function update(Request $request)
    {
        
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            // 'module_name' => 'nullable',
            'placement_position' => 'nullable|string|max:255',
            'items' => 'array',
        ]);

        $form = DshModeles::findOrFail($validated['id']);

        $form->update([
            'name' => $validated['name'],
            // 'module_name' => $validated['module_name'],
            'placement_position' => $validated['placement_position'],
        ]);

        // 🔧 Initialize arrays
        $incomingItemIds = [];
        $formItemMap = [];

        // 🔧 Fetch all existing items once to avoid querying in loop
        $existingItems = $form->items->keyBy('id');

        // 🔁 First pass: Create or update items (without setting modele_item_id)
        foreach ($validated['items'] as $index => $item) {
            if (!empty($item['id']) && isset($existingItems[$item['id']])) {
                // Update existing item
                $formItem = $existingItems[$item['id']];
                $formItem->update([
                    'input_name' => $item['input_name'],
                    'input_type' => $item['input_type'],
                    'input_options' => $item['input_options'] ?? null,
                    'icon' => $item['icon'] ?? null,
                    'cols' => $item['cols'] ?? 12,
                    'parent_name' => $item['parent_name'] ?? null,
                    // ❌ Don't update modele_item_id yet
                ]);
                $incomingItemIds[] = $formItem->id;
                $formItemMap[$index] = $formItem->id;
            } else {
                // Create new item
                $newItem = $form->items()->create([
                    'input_name' => $item['input_name'],
                    'input_type' => $item['input_type'],
                    'input_options' => $item['input_options'] ?? null,
                    'icon' => $item['icon'] ?? null,
                    'cols' => $item['cols'] ?? 12,
                    'parent_name' => $item['parent_name'] ?? null,
                    // ❌ Don't set modele_item_id yet
                ]);
                $incomingItemIds[] = $newItem->id;
                $formItemMap[$index] = $newItem->id;
            }
        }

        // 🔁 Second pass: Set parent-child relationships
        foreach ($validated['items'] as $index => $item) {
            if (
                isset($item['parent_index']) &&
                $item['parent_index'] !== '' &&
                isset($formItemMap[$item['parent_index']])
            ) {
                $parentId = $formItemMap[$item['parent_index']];
                $childId = $formItemMap[$index];
                $childItem = DshModeleItems::find($childId);

                if ($childItem) {
                    $childItem->update([
                        'modele_item_id' => $parentId
                    ]);
                }
            }
        }

        // 🧹 Delete items removed from form
        $form->items()->whereNotIn('id', $incomingItemIds)->delete();

        return response()->json(['success' => true]);
    }


    public function getProductsByCategory(Request $request,$id){
        //  dd($request);
         if ($request->ajax()) {
                    if ($id == 0) {
            // Return empty data for id=0 (no category)
            return DataTables::of(collect([]))->make(true);
        }
            $item = DshModeles::where('product_category_id',$id)->get();
   
            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->addColumn('image', function ($item) {
                    $product = ProductForWarehouse::find($item->product_id)->first();
                    return '<img src="' . asset(Storage::url($product->image)) . '" alt="Image" width="50" height="50" style="cursor:pointer;" onclick="showImageSwal(\'' . asset($product->image) . '\', \'' . addslashes($product->product_name) . '\')">';
                })
                ->editColumn('model_name', function ($item) {
                    return $item->model_name;
                })
                ->editColumn('product_id', function ($item) {
                    return $item->product_id;
                })
                ->editColumn('hapsira_category_id', function ($item) {
                    $hapsira = DshHapsiraCategory::find($item->hapsira_category_id);
                    $name = $hapsira->hapsira_category_name ?? '';
                    return '<div style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">' . e($name) . '</div>';
                })
                ->editColumn('product_category_id', function ($item) {
                    $category = DshProductsCategory::find($item->product_category_id);
                    return $category ? $category->product_category_name : '';
                })
                ->editColumn('module_name', function ($item) {
                    $module = Module::find($item->module_name);
                    return $module->module_name ?? '';
                })
                ->addColumn('action', function ($item){
                    $product = ProductForWarehouse::where('id',$item->product_id)->first();
                    return '
                        <div class="d-flex gap-2 align-items-center">
                            <input type="number" class="form-control w-50" name="product_quantity" min="1" value="1" required>
                            <input type="hidden" name="product_name" value="' . $item->id . '">
                            <input type="hidden" name="product_type" value="custom">
                            <button type="button" class="btn btn-primary btn-sm add-to-cart-btn" data-id="' . $item->id . '" data-model-name="' . $item->model_name . '"
                                    data-product-image="'. asset(Storage::url($product->image)) .'" data-product-name="'. addslashes($product->product_name) .'">+</button>
                        </div>';   
                })


                ->rawColumns(['product_id','hapsira_category_id', 'image','model_name','module_name', 'product_category_id', 'action', 'id'])
                ->make(true);
        }
    }

    public function formPreview($id)
    {
        $form = DshModeles::with('items')->findOrFail($id); // Replace with your actual model if needed
        $product = ProductForWarehouse::where('id',$form->product_id)->first();
        // dd($form);
        return view('departamentishitjes::modeles.form_modal', compact('form','product'));
    }


}
