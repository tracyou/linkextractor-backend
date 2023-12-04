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
    $law = Law::find('9ac4a955-316b-42b8-ae56-b18325ca0563');
    $annotation = Annotation::find('9ac4a955-0df2-438d-b21e-91420aeb64b7');


    dd($annotation->laws()->withPivot(['cursorIndex'])->get());
});
