<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;

class PagesController extends Controller
{
    //
    public function execute(){

       if (view()->exists('admin.pages')){

            $pages = Page::all();

            $date = [

                'title' => 'Страницы',
                'pages' => $pages

            ];

            return view('admin.pages', $date);

       }

       abort(404);


    }
}
