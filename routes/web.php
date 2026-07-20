<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/destinasi', [PublicController::class, 'destinations'])->name('destinations.index');
Route::get('/destinasi/{slug}', [PublicController::class, 'destinationDetail'])->name('destinations.show');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/tentang', [PublicController::class, 'about'])->name('about');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');
// Berita (kondisional)
Route::get('/berita', [PublicController::class, 'news'])->name('news.index');
Route::get('/berita/{slug}', [PublicController::class, 'newsDetail'])->name('news.show');