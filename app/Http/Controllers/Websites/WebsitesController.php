<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsitesController extends Controller
{
    public function index(){
        return view('pages.admin.websites.websites');
    }
}
