<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;

Route::get('/', function () {
    return view('custom');
})->name('custom');

Route::get('/products-xml1', [ShopifyController::class, 'getProductsXml1']);
Route::get('/products-xml2', [ShopifyController::class, 'getProductsXml2']);

Route::get('/fetch-products/{apiName}', [ShopifyController::class, 'fetchAndSaveProducts'])->name('fetch-products');

Route::get('/save-products', [ShopifyController::class, 'saveProducts'])->name('save-products');
