<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 8.08.2017
 * Time: 13:51
 */

namespace App\Http\Controllers;
use App\Http\Controllers\EFT\APIRequestLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
	public function index()
	{
		if(Auth::check()) dd("already logged in ");
		return view('login.index');
	}

	public function store(Request $request, APIRequestLogin $apiRequest)
	{
		return $apiRequest->doRun()->getJsonResult();
	}


	//<editor-fold defaultstate="collapsed" desc="ıvır zıvır denemeler yapmıştım bakmayın hiç :) ">
	private function testlersil() {
		$validator = Validator::make(
			$request->all(),
			[
				'id' => 'required|between:1,5',
				'password' => 'required|between:1,5'
			]
		);
		$validator->validate();

		//dd($this->getMessageBag());
		//dd($validator);
		$validator->after(function ($validator)  use ($request){
			if (!Auth::attempt(['id' => $request->id, 'password' => $request->password]))
			{
				$validator->errors()->add('field', 'Giriş Bilgileri Geçersiz!');
			}
		})->validate();

		if ($validator->fails()) {
			//dd($validator->errors());
			return redirect()->back()->withInput(Request::except('password'))->withErrors($validator);
		}
//		dd("ALL OK");
//		if (Auth::attempt(['id' => $request->id, 'password' => $request->password]))
//		{
//			//$validator->getMessageBag()->add('password', 'Password wrong');
////			dd(Auth::user());
////			dd("logged in");
//		}
		//dd(Auth::check());
		//dd(Auth::check());
	}
	//</editor-fold>


}