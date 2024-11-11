<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
{
    // Fetch all messages from the supports table
    //$contacts = Contact::simplePaginate(3); // You can adjust the pagination as needed

    // Pass the contacts to the view
    //return view('home', compact('contacts')); // Replace 'your-view-name' with the actual view name

    }
       public function store()
    {
      
    //Form validation

    request()->validate([
      'name' => ['required', 'min:3'],
      'email' => ['required'],
      'referal' => ['required'],
      'message' => ['required']


    ]);

   Contact::create([
    'name' => request('name'),
    'email' =>request('email'),
    'referal' =>request('referal'),
    'message' =>request('message'),
    'file' =>request('file')
    
   ]);


   return redirect('/contact')->with('success' ,'Thank you for Submitting! We will get to you shortly');
    
    }
}
