<?php

namespace App\Http\Controllers;

use App\Models\Product; // Adjust the model based on your data structure
use App\Models\Tag; // If you have a Tag model
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Fetch data for the welcome page
        $featuredProducts = Product::where('user_id', true)->get();
        $recentProducts = Product::orderBy('created_at', 'desc')->take(5)->get();
        //$tags = Tag::all(); // Fetch all tags
        $tags = ['Web Development', 'Design', 'Marketing', 'SEO', 'E-commerce']; // Example tags

        // Return the welcome view with the data
        return view('welcome', compact('featuredProducts', 'recentProducts', 'tags'));
    }
}