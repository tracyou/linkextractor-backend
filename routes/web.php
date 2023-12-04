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
    $law = Law::find('9ac47424-d896-406c-925b-ea61c5cfab5e');
    $annotation = Annotation::find('9ac47424-aa98-431d-b91b-326a2dfe0fff');


    dd($annotation->laws()->withPivot(['cursor_index'])->get());
});
