<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PagesRequest;
use Validator;
use App\Portfolio;

class PortfoliosEditController extends Controller
{
    public function execute(Portfolio $portfolio,Request $request) {


        if(!$portfolio) {
            return redirect('admin');
        }

        if($request->isMethod('delete')) {
            $portfolio->delete();
            return redirect('admin')->with('status','Портфолио удалено');
        }


        if($request->isMethod('post')) {

            $input = $request->except('_token');


            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'filter' => 'required|max:255'
            ]);

            if ($validator->fails()) {

                return redirect()->route('portfoliosEdit',['portfolio'=>$input['id']])
                    ->withErrors($validator);
            }

            if ($request->hasFile('images')) {
                //
                $file = $request->file('images');
                $request->file('images')->move(public_path().'/assets/img',$file->getClientOriginalName());

                $input['images'] = $file->getClientOriginalName();
            }
            else {
                $input['images'] = $input['old_images'];
            }

            unset($input['old_images']);

            $portfolio->fill($input);
            if($portfolio->update()) {
                return redirect('admin')->with('status', 'Страница обновлена');
            }
        }



        $old = $portfolio->toArray();

        //dd($old);
        if(view()->exists('admin.portfolios_edit')) {

            $data = [

                'title' => 'Редактирование страницы - '.$old['name'],
                'data'  => $old
            ];

            return view('admin.portfolios_edit',$data);
        }
    }
}
