<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Page;
use App\People;
use App\Portfolio;
use App\Service;
use DB;
use Mail;

class IndexController extends Controller
{
    //
    public function execute(Request $request)
    {


        if ($request->isMethod('post')){

            $messages = [
                'required' => "Поле :attribute обязательно к заполению",
                'email' => "Поле :attribute должно соответствовать email адресу"


            ];
            $this->validate($request, [

                                        'name' => 'required|max:255',
                                        'email' => 'required|email',
                                        'text' => 'required'

            ], $messages);


         $date = $request->all();
         //dump($date);
         $result = Mail::send('site.mail', ['date' => $date], function ($message) use ($date){


                $mail_admin = env('MAIL_ADMIN');
                $message->from($date['email'], $date['name'] );
                $message->to( $mail_admin, 'Mr. Admin')->subject('Question');

         });

         if ($result){

             return redirect()->route('home')->with('status', 'Email is send');
         }


        }




        $pages = Page::all();
        $portfolios = Portfolio::get(array('name', 'filter', 'images'));
        $services = Service::where('id', '<', 20)->get();
        $peoples = People::take(3)->get();

        $tags = DB::table('portfolios')->distinct()->lists('filter');




        $menu = [];
        foreach ($pages as $page) {

            $item = array('title' => $page->name, 'alias' => $page->alias);
            array_push($menu, $item);
        }

        $item = ['title' => 'Services', 'alias' => 'service'];
        array_push($menu, $item);


        $item = ['title' => 'Portfolio', 'alias' => 'Portfolio'];
        array_push($menu, $item);


        $item = ['title' => 'Team', 'alias' => 'team'];
        array_push($menu, $item);


        $item = ['title' => 'Contact', 'alias' => 'contact'];
        array_push($menu, $item);

        return view('site.index', [

            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'peoples' => $peoples,
            'tags' => $tags

        ]);

    }
}
