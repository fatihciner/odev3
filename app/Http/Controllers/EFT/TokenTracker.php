<?php
namespace App\Http\Controllers\EFT;

/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 02:39
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TokenTracker
{
	use LoginTrait;

	public function __construct(Request $request)
	{
		$this->request      = $request;
	}

	public function get()
	{
		//$this->delete();
		foreach(Cache::get(Auth::userData('id'), function(){return [];}) AS $key=>$value) {
			if ($key == 'token' ) return $value;
		}
		return $this->renew();
	}

	public function renew()
	{
		if(!Auth::check())
			throw new \RuntimeException('Cant auto renew token', 9999);
		$cachedData = Cache::get(Auth::userData('id'));
		$this->request->request->add( [ 'email' => $cachedData['email'], 'password' => $cachedData['password'] ] );
		$apiRequest = new APIRequestLogin($this->request,$this);
		$result = $apiRequest->doRun()->getJsonResult();
		if(!empty($result['error']))
			redirect('login'); //throw new \RuntimeException('Couldnt renew token', 9999);
		else
			ret
	}

	public function set($userCredentials=[])
	{
		Cache::put(
			$this->getUserId($userCredentials),
			$userCredentials,
			env('API_TOKEN_EXPIRE_TIME_IN_MINUTES') * 1
		);
	}

	//for testing purposes
	public function delete() {
		//dd(Auth::user());
		$userCredentials = Cache::get(Auth::userData('id'));
		//dd($userCredentials);
		$userId = md5($userCredentials['email'].$userCredentials['password']);
		Cache::put(
			$userId,
			array_merge(
				['email'=>'demo@bumin.com.tr', 'password'=>'cjaiU8CV'],
				['token' => 'xxxx']
			),
			env('API_TOKEN_EXPIRE_TIME_IN_MINUTES') * 1
		);
		dd("Token Deleted");
	}

}

/*
 * [Authorization] => eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJhZG1pbiIsIm1lcmNoYW50SWQiOjMsInN1Yk1lcmNoYW50SWRzIjpbMyw3NCw5MywxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OF0sInRpbWVzdGFtcCI6MTUwMjY3MzM3OX0.sGhXENF51Ne9QeGqp3DccbZCoyFgz217OsaUpOfCn3s
 * */