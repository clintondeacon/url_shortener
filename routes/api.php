<?php

use App\Http\Controllers\ShortedUrlController;
use Illuminate\Support\Facades\Route;

Route::match(['post','get'],'/encode', [ShortedUrlController::class, 'encode']);
Route::match(['post','get'],'/decode', [ShortedUrlController::class, 'decode']);

