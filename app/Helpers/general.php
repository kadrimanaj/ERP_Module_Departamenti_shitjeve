<?php

use App\Models\User;
use Modules\DepartamentiShitjes\Models\DshPreventivItem;
use Modules\DepartamentiShitjes\Models\DshProduct;
use Modules\DepartamentiShitjes\Models\DshProject;

// function handleImageUploadProducts($image)
// {
//     $year      = date('Y');
//     $month     = date('m');
//     $directory = "uploads/{$year}/{$month}";

//     $extension = $image->getClientOriginalExtension() ?: 'jpg';
//     $filename  = time() . '_' . \Str::random(5) . '.' . $extension;

//     $destination = public_path($directory);

//     if (! file_exists($destination)) {
//         mkdir($destination, 0755, true);
//     }

//     $image->move($destination, $filename);

//     return [
//         'original' => $directory . '/' . $filename,
//     ];
// }

function getStatistics($id)
{
    $projects_total = DshProduct::where('product_type', 'custom')->where('product_status', '>=', 2)->where('kostoisti_product_confirmation', $id)->count();
    return $projects_total;
}

function getProjectName($id)
{
    $project = DshProject::find($id);
    if ($project) {
        return $project->project_name;
    }
    return 'N/A';
}

function getStatusColor($id)
{
    if ($id == 0) {
        return 'warning';
    } elseif ($id == 1) {
        return 'info';
    } elseif ($id == 2 || $id == 5 || $id == 6 || $id == 7 || $id == 8) {
        return 'success';
    } elseif ($id == 3 || $id == 4 || $id == 9) {
        return 'danger';
    }
}

function getStatusName($id)
{
    if ($id == 0) {
        return 'Ne Pritje';
    } elseif ($id == 1) {
        return 'Ne Perpunim';
    } elseif ($id == 2) {
        return 'Konfirmuar nga Shitesi';
    } elseif ($id == 3) {
        return 'Refuzuar';
    } elseif ($id == 4) {
        return 'Refuzuar nga Kryeinxhinieri';
    } elseif ($id == 5) {
        return 'Konfirmuar nga Kostoisti';
    } elseif ($id == 6) {
        return 'Konfirmuar nga Kryeinxhinieri';
    } elseif ($id == 7) {
        return 'Konfirmuar nga Ofertuesi';
    } elseif ($id == 8) {
        return 'Konfirmuar nga Arkitekti';
    } elseif ($id == 9) {
        return 'Refuzuar nga Kostoisti';
    }
}

function getStatusColorKostoisti($id)
{
    if ($id == null || $id == 0) {
        return 'warning';
    } elseif ($id == 1) {
        return 'info';
    } elseif ($id == 2) {
        return 'success';
    } elseif ($id == 3 || $id == 4) {
        return 'danger';
    }
}

function getStatusNameKostoisti($id)
{
    if ($id == 0) {
        return 'Ne Pritje';
    } elseif ($id == 1) {
        return 'Ne Perpunim';
    } elseif ($id == 2) {
        return 'Konfirmuar';
    } elseif ($id == 3) {
        return 'Refuzuar';
    } elseif ($id == 4) {
        return 'Refuzuar nga Kryeinxhinieri';
    }
}

function getKostoTotalPerElement($id, $type)
{
    $items = DshPreventivItem::where('dsh_preventiv_items.element_id', $id)
        ->where('dsh_preventiv_items.product_type', $type)->get();

    $total = 0;
    foreach ($items as $item) {
        $total += $item->quantity * $item->cost;
    }
    return $total;
}

function get_user_name($id)
{
    $user = User::find($id);
    if ($user) {
        return $user->name;
    }
    return 'N/A';
}
