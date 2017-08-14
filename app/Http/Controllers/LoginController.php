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
		return view('pages.login');
	}

	public function store(Request $request, APIRequestLogin $apiRequest)
	{
		return $apiRequest->doRun()->getJsonResult();
	}






	//<editor-fold defaultstate="collapsed" desc="ıvır zıvır denemeler yapmıştım bakmayın hiç :) ">

	//</editor-fold>


}