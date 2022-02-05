<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('App\Http\Controllers\api')->middleware('auth')->group(function () {
    Route::get('/panel' , function (){ return view('pages.panel'); });

    Route::get('/index' , function (){ return view('pages.index'); })->name('index');

    Route::get('/reportForm' , [ OrderController::class , 'showOrderReportForm' ])->name('reportForm');
    Route::post('/sendReport' , [ OrderController::class , 'sendOrderReport' ])->name('sendReport');
    Route::post('/downloadReport' , [OrderController::class , 'export'])->name('downloadReport');

    Route::get('/reportProduct' , [ ProductController::class , 'showProductReportForm' ])->name('productReportForm');
    Route::post('/sendProductReport' , [ ProductController::class , 'sendProductReport' ])->name('sendProductReport');

    Route::get('/importRegPrice' , function (){ return view('pages.import.regPrice'); })->name('importRegPrice');
    Route::post('/importRegularPriceFile' , [ProductController::class , 'sendImportRegularPriceFile'])->name('importRegularPriceFile');

    Route::get('/importSalePrice' , function (){ return view('pages.import.salePrice'); })->name('importSalePrice');
    Route::post('/importSalePriceFile' , [ProductController::class , 'sendImportSalePriceFile'])->name('importSalePriceFile');

    Route::get('/importPrice' , function (){ return view('pages.import.price'); })->name('importPrice');
    Route::post('/importPriceFile' , [ProductController::class , 'sendImportPriceFile'])->name('importPriceFile');

    Route::get('/importQuantity' , function (){ return view('pages.import.quantity'); })->name('importQuantity');
    Route::post('/importQuantityFile' , [ProductController::class , 'sendImportQuantityFile'])->name('importQuantityFile');

    Route::get('/importName' , function (){ return view('pages.import.name'); })->name('importName');
    Route::post('/importNameFile' , [ProductController::class , 'sendImportNameFile'])->name('importNameFile');

});

