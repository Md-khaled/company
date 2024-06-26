<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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

Route::get('/', function () {
    return redirect()->route('company.index');
});

Route::resource('company', CompanyController::class);

Route::post('companies/{company}/custom-fields', [CustomFieldController::class, 'store']);
Route::get('companies/{company}/custom-fields', [CustomFieldController::class, 'getFields']);

Route::post('companies/{company}/custom-fields/{field}/values', [CustomFieldValueController::class, 'store']);
Route::get('companies/{company}/custom-fields/values', [CustomFieldValueController::class, 'getValues']);
