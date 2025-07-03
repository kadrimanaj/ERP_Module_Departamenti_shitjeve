<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Modules\DepartamentiShitjes\Models\DshProduct;
use Modules\DepartamentiShitjes\Models\DshProject;

class DshProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'project_client' => 'required',
            'project_architect' => 'required',
            'priority' => 'required',
            'project_description' => 'nullable|string',
        ]);

        $project = new DshProject();
        $project->project_name = $request->project_name;
        $project->project_client = $request->project_client;
        $project->project_architect = $request->project_architect;
        $project->project_description = $request->project_description;
        $project->priority = $request->priority;
        $project->client_limit_date = $request->client_limit_date;
        $project->project_seller_id = Auth::user()->id;
        $project->project_start_date = today();
        $project->user_id = Auth::user()->id;
        $project->rruga = $request->rruga;
        $project->qarku = $request->qarku;
        $project->bashkia = $request->bashkia;
        $project->tipologjia_objektit = $request->tipologjia_objektit;
        $project->kate = $request->kate;
        $project->lift = $request->lift;
        $project->address_comment = $request->address_comment;
        $project->orari_pritjes = $request->orari_pritjes;
        $project->save();

        return redirect()->back()->with('success', 'Projekti u shtua me sukses!');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Optional validation
        $request->validate([
            'project_name' => 'required|string|max:255',
            'project_client' => 'required',
            'project_architect' => 'required',
            'priority' => 'required',
            'project_description' => 'nullable|string',
        ]);

        $asset = DshProject::findOrFail($id);

        $asset->project_name = $request->project_name;
        $asset->project_client = $request->project_client;
        $asset->project_architect = $request->project_architect;
        $asset->priority = $request->priority;
        $asset->client_limit_date = $request->client_limit_date;
        $asset->project_description = $request->project_description;
        $asset->rruga = $request->rruga;
        $asset->qarku = $request->qarku;
        $asset->bashkia = $request->bashkia;
        $asset->tipologjia_objektit = $request->tipologjia_objektit;
        $asset->kate = $request->kate;
        $asset->lift = $request->lift;
        $asset->address_comment = $request->address_comment;
        $asset->orari_pritjes = $request->orari_pritjes;
        $asset->save();

        return redirect()->back()->with('success', 'Projekti u përditësua me sukses!');
    }

    public function destroy($id)
    {
        $project = DshProject::findOrFail($id);  // Find the project by ID
        $project->project_status = 3;
        $project->save();

        // Return a JSON response indicating success
        return response()->json(['success' => true, 'message' => 'Kerkesa u anullua me sukses!']);
    }

    public function project_confirm($id)
    {
        dd('Project confirmed with ID: ' . $id);
        $project = DshProject::find($id);
        $project->arkitekt_confirm = 2;
        $project->save();

        $products = DshProduct::where('product_project_id', $id)->where('product_status','<=',2)->get();
        foreach ($products as $product) {
            $product->product_status = 8; // Assuming 2 means confirmed
            $product->save();
        }

        if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Projekti u konfirmua me sukses.'
        ]);
        }else{
            return redirect()->back()->with('success', 'Projekti u konfirmua me sukses.');
        }
    }
}