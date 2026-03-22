<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id)
{
    $request->validate([
        'nom'     => 'required|max:255',
        'email'   => 'required|email',
        'contenu' => 'required',
    ]);

    // Auto-approuver si connecté
    $approuve = auth()->check() ? true : false;

    Comment::create([
        'post_id'  => $id,
        'user_id'  => auth()->id() ?? null,
        'nom'      => $request->nom,
        'email'    => $request->email,
        'contenu'  => $request->contenu,
        'approuve' => $approuve,
    ]);

    if ($approuve) {
        return back()->with('success', 'Commentaire publié !');
    }

    return back()->with('success', 'Commentaire soumis pour modération !');
}
}