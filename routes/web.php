<?php

use App\Models\Annotation;
use App\Models\Law;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/test', function () {
    $law = Law::find('9ac46543-6b12-4175-b728-02436eab7f34');
    $annotation = Annotation::find('9ac46543-43af-43ae-85f0-5a9abfcad920');


    dd($annotation->laws()->withPivot(['cursor_index'])->get());
});
