<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Modules\DepartamentiShitjes\Models\DshHapsiraCategory;
use Modules\DepartamentiShitjes\Models\DshProductsCategory;

class CategoriesController extends Controller
{
    public function hapsira()
    {
        return view('departamentishitjes::categories.space_categories');
    }

    public function hapsira_store(Request $request)
    {
        $request->validate([
            'hapsira_category_name' => 'required',
        ]);

        DshHapsiraCategory::create([
            'hapsira_category_name' => $request->hapsira_category_name,
        ]);

        return redirect()->back()->with('success', 'Kategoria u shtua me sukses.');
    }

    public function hapsira_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'hapsira_category_name' => 'required',
        ]);

        $category = DshHapsiraCategory::findOrFail($request->id);
        $category->hapsira_category_name = $request->hapsira_category_name;
        $category->save();

        return redirect()->back()->with('success', 'Kategoria u përditësua me sukses!');
    }

    public function hapsira_list(Request $request)
    {
        if ($request->ajax()) {
            $item = DshHapsiraCategory::all();

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->editColumn('hapsira_category_name', function ($item) {
                    return 
                    '<center>'.$item->hapsira_category_name.'</center>';
                })
                ->addColumn('action', function ($item) {
                    return '<center>
                        <button type="button" class="btn btn-sm btn-outline-primary edit-btn"
                            data-item="' . htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') . '"
                            data-id="' . $item->id . '"
                            data-bs-toggle="modal"
                            data-bs-target="#staticBackdropedit">
                            <i class="ri-edit-2-fill me-1"></i> Edit
                        </button></center>
                    ';
                })
                ->rawColumns(['hapsira_category_name', 'action', 'id'])
                ->make(true);
        }
    }


    public function products_categories()
    {
        $categories = DshProductsCategory::all(); // or with filters
        $hapsirat = DshHapsiraCategory::all();
        // dd($hapsirat);
        return view('departamentishitjes::categories.products_categories',compact('categories','hapsirat'));
    }

    public function products_categories_list(Request $request)
    {
        if ($request->ajax()) {
            $item = DshProductsCategory::all();

            return DataTables::of($item)
                ->editColumn('id', function ($item) {
                    return $item->id;
                })
                ->editColumn('product_category_name', function ($item) {
                    return 
                    '<center>'.$item->product_category_name.'</center>';
                })
                ->editColumn('parent_id', function ($item) {
                    return 
                    '<center>'.$item->parent_id ?? '-' .'</center>';
                })
                ->editColumn('hapsira_id', function ($item) {
                    return 
                    '<center>'.$item->hapsira_id ?? '-' .'</center>';
                })
              ->addColumn('action', function ($item) {
                    return '<center>
                        <button type="button" class="btn btn-sm btn-outline-primary edit-btn"
                            data-id="' . $item->id . '"
                            data-name="' . e($item->product_category_name) . '"
                            data-parent-id="' . ($item->parent_id ?? '') . '"
                            data-hapsira-id="' . ($item->hapsira_id ?? '') . '"
                            data-bs-toggle="modal"
                            data-bs-target="#staticBackdropedit">
                            <i class="ri-edit-2-fill me-1"></i> Edit
                        </button>
                    </center>';
                })

                ->rawColumns(['product_category_name','parent_id','hapsira_id','action', 'id'])
                ->make(true);
        }
    }

        public function products_categories_store(Request $request)
    {
        $request->validate([
            'product_category_name' => 'required',
            'parent_id' => 'nullable',
            'hapsira_id' => 'nullable',
        ]);

        DshProductsCategory::create([
            'product_category_name' => $request->product_category_name,
            'parent_id' => $request->parent_id,
            'hapsira_id' => $request->hapsira_id,
        ]);

        return redirect()->back()->with('success', 'Kategoria u shtua me sukses.');
    }

    public function products_categories_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'product_category_name' => 'required',
            'hapsira_id' => 'nullable',
            'parent_id' => 'nullable',
        ]);

        $category = DshProductsCategory::findOrFail($request->id);
        $category->product_category_name = $request->product_category_name;
        $category->parent_id = $request->parent_id;
        $category->hapsira_id = $request->hapsira_id;
        $category->save();

        return redirect()->back()->with('success', 'Kategoria u përditësua me sukses!');
    }

}
