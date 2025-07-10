<?php

use Illuminate\Support\Facades\Route;
use Modules\DepartamentiShitjes\Http\Controllers\ArkitektiController;
use Modules\DepartamentiShitjes\Http\Controllers\CommentController;
use Modules\DepartamentiShitjes\Http\Controllers\DepartamentiShitjesController;
use Modules\DepartamentiShitjes\Http\Controllers\DshProductController;
use Modules\DepartamentiShitjes\Http\Controllers\DshProductItemController;
use Modules\DepartamentiShitjes\Http\Controllers\DshProjectController;
use Modules\DepartamentiShitjes\Http\Controllers\FinancaController;
use Modules\DepartamentiShitjes\Http\Controllers\KostoistiController;
use Modules\DepartamentiShitjes\Http\Controllers\KryeInxhinieriController;
use Modules\DepartamentiShitjes\Http\Controllers\OfertuesiController;
use Modules\DepartamentiShitjes\Http\Controllers\ShitesiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::prefix('departamentishitjes')->group(function () {
        Route::resource('departamentishitjes', DepartamentiShitjesController::class)->names('departamentishitjes');

        Route::get('arkitekti/dashboard', [ArkitektiController::class, 'arkitekti_dashboard'])->name('departamentishitjes.arkitekti.dashboard');
        Route::get('arkitekti/statistic', [ArkitektiController::class, 'arkitekti_statistic'])->name('departamentishitjes.arkitekti.statistic');
        Route::get('arkitekti/projekti/{id}', [ArkitektiController::class, 'arkitekti_projekti'])->name('departamentishitjes.arkitekti.projekti');
        Route::get('arkitekti/projektet/list', [ArkitektiController::class, 'list'])->name('arkitekti.projektet.list');
        Route::get('arkitekti/product/list_preorder/{id}', [ArkitektiController::class, 'list_preorder'])->name('arkitekti.preorder.list_preorder');
        Route::get('arkitekti/product/product_list/{id}', [ArkitektiController::class, 'product_list'])->name('arkitekti.preorder.product_list');
        Route::get('arkitekti/produkti/{id}', [ArkitektiController::class, 'arkitekti_produkti'])->name('departamentishitjes.arkitekti.produkti');

        Route::get('kostoisti/dashboard', [KostoistiController::class, 'kostoisti_dashboard'])->name('departamentishitjes.kostoisti.dashboard');
        Route::get('kostoisti/projektet/list/{id}', [KostoistiController::class, 'list'])->name('kostoisti.projektet.list');
        Route::get('kostoisti/projektet/lista', [KostoistiController::class, 'list_dashboard'])->name('kostoisti.projektet.list_dashboard');
        Route::get('kostoisti/second/list/{id}', [KostoistiController::class, 'second_list'])->name('kostoisti.second.list');
        Route::get('kostoisti/third/list/{id}', [KostoistiController::class, 'third_list'])->name('kostoisti.third.list');
        Route::get('kostoisti/projekti/{id}', [KostoistiController::class, 'kostoisti_projekti'])->name('departamentishitjes.kostoisti.projekti');
        Route::get('kostoisti/produkti', [KostoistiController::class, 'kostoisti_produkti'])->name('departamentishitjes.kostoisti.produkti');
        Route::get('kostoisti/preventiv/create/{id}', [KostoistiController::class, 'kostoisti_preventiv'])->name('departamentishitjes.kostoisti.preventiv.create');
        Route::get('kostoisti/product/list_preorder/{id}', [KostoistiController::class, 'list_preorder'])->name('kostoisti.preorder.list_preorder');
        Route::post('kostoisti/first/materiale/{id}', [KostoistiController::class, 'first_store'])->name('kostoisti.first.materiale.store');
        Route::post('kostoisti/second/materiale/{id}', [KostoistiController::class, 'second_store'])->name('kostoisti.second.materiale.store');
        Route::post('kostoisti/third/materiale/{id}', [KostoistiController::class, 'third_store'])->name('kostoisti.third.materiale.store');
        Route::post('kostoisti/product/confirm/{id}', [KostoistiController::class, 'product_confirm'])->name('product.kostoisti.confirm');
        Route::post('kostoisti/product/cancel/{id}', [KostoistiController::class, 'product_cancel'])->name('product.kostoisti.cancel');
        Route::delete('kostoisti/product/delete/{id}', [KostoistiController::class, 'product_delete'])->name('product.kostoisti.delete');

        Route::get('kryeinxhinieri/dashboard', [KryeInxhinieriController::class, 'kryeinxhinieri_dashboard'])->name('departamentishitjes.kryeinxhinieri.dashboard');

        Route::get('kryeinxhinieri/projekti', [KryeInxhinieriController::class, 'kryeinxhinieri_projekti'])->name('departamentishitjes.kryeinxhinieri.projekti');

        Route::get('kryeinxhinieri/preventiv', [KryeInxhinieriController::class, 'kryeinxhinieri_preventiv'])->name('departamentishitjes.kryeinxhinieri.preventiv');
        Route::get('kryeinxhinieri/projektet/lista', [KryeInxhinieriController::class, 'list_dashboard'])->name('kryeinxhinieri.projektet.list_dashboard');

        Route::get('kryeinxhinieri/projekti/{id}', [KryeInxhinieriController::class, 'kryeinxhinieri_projekti'])->name('departamentishitjes.kryeinxhinieri.projekti.id');

        Route::get('kryeinxhinieri/preventiv/view/{id}', [KryeInxhinieriController::class, 'view_preventiv'])->name('departamentishitjes.kryeinxhinieri.preventiv.view');
        Route::get('kryeinxhinieri/product/list_preorder/{id}', [KryeInxhinieriController::class, 'list_preorder'])->name('kryeinxhinieri.preorder.list_preorder');
        Route::get('kryeinxhinieri/projektet/list/{id}', [KryeInxhinieriController::class, 'list'])->name('kryeinxhinieri.projektet.list');
        Route::get('kryeinxhinieri/second/list/{id}', [KryeInxhinieriController::class, 'second_list'])->name('kryeinxhinieri.second.list');
        Route::get('kryeinxhinieri/third/list/{id}', [KryeInxhinieriController::class, 'third_list'])->name('kryeinxhinieri.third.list');
        Route::post('kryeinxhinieri/product/return/{id}', [KryeInxhinieriController::class, 'product_return'])->name('product.kryeinxhinieri.return');
        Route::post('kryeinxhinieri/product/confirm/{id}', [KryeInxhinieriController::class, 'product_confirm'])->name('product.kryeinxhinieri.confirm');

        Route::get('financa/dashboard', [FinancaController::class, 'financa_dashboard'])->name('departamentishitjes.financa.dashboard');
        Route::get('financa/projekti', [FinancaController::class, 'financa_projekti'])->name('departamentishitjes.financa.projekti');

        Route::get('shitesi/dashboard', [ShitesiController::class, 'shitesi_dashboard'])->name('departamentishitjes.shitesi.dashboard');
        Route::get('shitesi/projektet/list', [ShitesiController::class, 'list'])->name('shitesi.list');
        Route::get('shitesi/projekti/{id}', [ShitesiController::class, 'shitesi_projekti'])->name('departamentishitjes.shitesi.projekti');
        Route::post('shitesi/projekti/confirm/{id}', [ShitesiController::class, 'project_confirm'])->name('project.shitesi.confirm');
        Route::get('shitesi/projektet/clients', [ShitesiController::class, 'list_clients'])->name('shitesi.clients');
        Route::get('shitesi/product/list_preorder/{id}', [ShitesiController::class, 'list_preorder'])->name('shitesi.preorder.list_preorder');
        Route::get('shitesi/product/product_list/{id}', [ShitesiController::class, 'product_list'])->name('product.preorder.product_list');
        Route::delete('delete/product/product_list/{id}', [ShitesiController::class, 'delete_normal_product'])->name('normal_product.destroy');
        Route::put('shitesi/update/product_list/{id}', [ShitesiController::class, 'update_product_normal'])->name('departamentishitjes.shitesi.update_product_normal');

        Route::post('product/store/{id}', [DshProductController::class, 'store'])->name('departamentishitjes.product.store');
        Route::get('projektet/product/list_preorder/{id}', [DshProductController::class, 'list_preorder'])->name('product.preorder.list_preorder');
        Route::get('projektet/product/list/{id}', [DshProductController::class, 'list'])->name('product.preorder.list');
        Route::post('product/confirm/{id}', [DshProductController::class, 'product_confirm'])->name('product.arkitekti.confirm');
        Route::post('project/confirm/{id}', [DshProjectController::class, 'project_confirm'])->name('project.arkitekti.confirm');
        Route::get('products/list/{id}', [DshProductController::class, 'porducts_list'])->name('products.list');

        Route::post('shitesi/project/store', [DshProjectController::class, 'store'])->name('departamentishitjes.shitesi.store');
        Route::put('shitesi/update/project/{id}', [DshProjectController::class, 'update'])->name('departamentishitjes.shitesi.update_project');
        Route::put('shitesi/projects/{id}', [DshProjectController::class, 'destroy'])->name('projects.destroy');

        Route::post('project/comment/{id}', [CommentController::class, 'store'])->name('departamentishitjes.comment.store');
        Route::post('skicat/store/{id}', [DshProductController::class, 'skicat'])->name('departamentishitjes.skicat.store');
        Route::post('elements/store/{id}', [DshProductController::class, 'elements'])->name('departamentishitjes.elements.store');

        Route::get('produkti/elements/{id}', [DshProductItemController::class, 'elements_list'])->name('departamentishitjes.elements.list');
        Route::get('produkti/skicat/{id}', [DshProductItemController::class, 'skicat_list'])->name('departamentishitjes.skicat.list');
        Route::delete('produkti/item/{id}', [DshProductItemController::class, 'destroy'])->name('produkti.item.destroy');
        Route::put('produkti/update/product_item/{id}', [DshProductItemController::class, 'update'])->name('departamentishitjes.produkti.item.update');

        Route::get('/get-products-by-category/{id}', [KostoistiController::class, 'getProductsByCategory'])->name('kostoisti.getProductsByCategory');
        Route::get('/get-product-details/{id}', [KostoistiController::class, 'getProductDetails'])->name('kostoisti.getProductDetails');
        Route::get('/kosto-total/{id}/{type}', [KostoistiController::class, 'getKostoTotalPerElement'])->name('kostoisti.getKostoTotalPerElement');

        Route::get('ofertuesi/dashboard', [OfertuesiController::class, 'ofertuesi_dashboard'])->name('departamentishitjes.ofertuesi.dashboard');
        Route::get('ofertuesi/projektet/list', [OfertuesiController::class, 'list'])->name('ofertuesi.list');
        Route::get('ofertuesi/projekti/{id}', [OfertuesiController::class, 'ofertuesi_projekti'])->name('departamentishitjes.ofertuesi.projekti');
        Route::get('ofertuesi/product/list_preorder/{id}', [OfertuesiController::class, 'list_preorder'])->name('ofertuesi.preorder.list_preorder');
        Route::get('ofertuesi/product/product_list/{id}', [OfertuesiController::class, 'product_list'])->name('ofertuesi.preorder.product_list');
        Route::get('ofertuesi/preventiv/view/{id}', [OfertuesiController::class, 'view_preventiv'])->name('departamentishitjes.ofertuesi.preventiv.view');
        Route::post('/product/update-offert-price', [OfertuesiController::class, 'updateOffertPrice'])->name('product.updateOffertPrice');
        Route::post('/offer/confirm/{id}', [OfertuesiController::class, 'confirm_offer'])->name('offer.confirm');
        Route::get('/pdf/preventiv/{id}', [OfertuesiController::class, 'pdf'])->name('preventiv.pdf');


    });
});
