<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 8.08.2017
 * Time: 13:51
 */

namespace app\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
	public function index()
	{
		return view('login.index');
	}
	public function store(Request $request)
	{
		//validation için: https://laravel.com/docs/5.4/validation#rule-between
		$this->validate($request, [
			'id' => 'required|between:3,5',
			'password' => 'required|between:3,5',
		]);

		if($request->id);


	}
}