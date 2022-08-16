<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        Log::alert('dashboard');
        return view('admin.pages.home');
    }
}