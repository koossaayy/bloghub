<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $postEnAttente = Post::where('statut', 'en_attente')
            ->with(['user', 'category'])
            ->get();

        $commentsSignales = Comment::where('approuve', false)
            ->with(['post', 'user'])
            ->get();

        $users = User::all();

        return view('admin.index', compact('postEnAttente', 'commentsSignales', 'users'));
    }

    public function approuverPost($id)
    {
        Post::findOrFail($id)->update(['statut' => 'publie']);
        return back()->with('success', 'Article approuvé !');
    }

    public function rejeterPost($id)
    {
        Post::findOrFail($id)->update(['statut' => 'brouillon']);
        return back()->with('success', 'Article rejeté !');
    }

    public function approuverComment($id)
    {
        Comment::findOrFail($id)->update(['approuve' => true]);
        return back()->with('success', 'Commentaire approuvé !');
    }

    public function supprimerComment($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Commentaire supprimé !');
    }

    public function changerRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,auteur,lecteur'
        ]);

        User::findOrFail($id)->update(['role' => $request->role]);
        return back()->with('success', 'Rôle mis à jour !');
    }
}