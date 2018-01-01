<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Portfolio;

class PortfoliosController extends Controller
{
    public function execute() {

        if(view()->exists('admin.portfolios')) {

            $portfolio = Portfolio::all();

            $data = [
                'title'=>'Страницы',
                'portfolios'=>$portfolio
            ];

            return view('admin.portfolios',$data);
        }

    }
}
