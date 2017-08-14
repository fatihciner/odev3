<?php
namespace App\Http\Controllers;

use App\Http\Controllers\EFT\APIRequestLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{


	public function __construct()
	{

	}

	public function index()
	{
		if(Auth::check()) {
			return  redirect()->route('transactionListController');
		}

		return view('pages.login');
	}

	public function store(Request $request, APIRequestLogin $apiRequest)
	{
		return $apiRequest->doRun()->getJsonResult();
	}






	//<editor-fold defaultstate="collapsed" desc=" ">

	//</editor-fold>


}