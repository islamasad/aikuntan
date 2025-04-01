<?php

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\ChatStreamController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/save-theme', function (Request $request) {
    $request->session()->put('color-theme', $request->theme);

    return response()->json(['status' => 'Theme saved']);
});


// Route::get('/chat', function () {
//    return view('chat');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat', [ChatController::class, 'index'])->name('dashboard');
    Route::post('/chat/ask', [ChatController::class, 'ask'])->name('chat.ask');
    Route::get('/chat/stream', [ChatStreamController::class, 'stream'])->name('chat.stream');
});

require __DIR__.'/auth.php';
