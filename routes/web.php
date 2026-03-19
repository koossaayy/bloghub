<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// ─── Routes publiques ───────────────────────────────────────
Route::get('/', [PostController::class, 'index'])->name('accueil');
Route::get('/articles', [PostController::class, 'index'])->name('posts.index');
Route::get('/articles/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{slug}', [TagController::class, 'show'])->name('tags.show');

// ─── Commentaires (public) ──────────────────────────────────
Route::post('/articles/{id}/comments', [CommentController::class, 'store'])->name('comments.store');

// ─── Routes Auteur (connecté + rôle auteur ou admin) ────────
Route::middleware(['auth', 'isAuteur'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/mes-articles', [PostController::class, 'mesArticles'])->name('posts.mes');
});

// ─── Likes (connecté) ───────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
});

// ─── Routes Admin ────────────────────────────────────────────
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/posts/{id}/approuver', [AdminController::class, 'approuverPost'])->name('admin.posts.approuver');
    Route::put('/posts/{id}/rejeter', [AdminController::class, 'rejeterPost'])->name('admin.posts.rejeter');
    Route::put('/comments/{id}/approuver', [AdminController::class, 'approuverComment'])->name('admin.comments.approuver');
    Route::delete('/comments/{id}', [AdminController::class, 'supprimerComment'])->name('admin.comments.supprimer');
    Route::put('/users/{id}/role', [AdminController::class, 'changerRole'])->name('admin.users.role');
});

// ─── Profil ─────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Auth (Breeze) ───────────────────────────────────────────
require __DIR__.'/auth.php';