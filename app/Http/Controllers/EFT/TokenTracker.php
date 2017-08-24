<?php
namespace App\Http\Controllers\EFT;

/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 02:39
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TokenTracker
{

	public function __construct()
	{
	}

	public function set($userId='', $userCredentials=[])
	{
		Cache::put(
			$userId,
			$userCredentials,
			env('API_TOKEN_EXPIRE_TIME_IN_MINUTES') * 10
		);
	}

	public function get()
	{
		foreach(Cache::get(Auth::userData('id'), function(){return [];}) AS $key=>$value) {
			if ($key == 'token' ) return $value;
		}
		return $this->renew();
	}

	public function renew() {
		if(!Auth::check())
			throw new \RuntimeException('Cant renew token', 9999);
		$cachedData = Cache::get(Auth::userData('id'));
		$this->request->request->add( [ 'email' => $cachedData['email'], 'password' => $cachedData['password'] ] );
		$result = $this->apiRequest->doRun()->getJsonResult();
		//dd($result);
		if(!empty($result['error']))
			redirect('login');//throw new \RuntimeException('Couldnt renew token', 9999);
	}


}

/*
 * [Authorization] => eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJhZG1pbiIsIm1lcmNoYW50SWQiOjMsInN1Yk1lcmNoYW50SWRzIjpbMyw3NCw5MywxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OF0sInRpbWVzdGFtcCI6MTUwMjY3MzM3OX0.sGhXENF51Ne9QeGqp3DccbZCoyFgz217OsaUpOfCn3s
 * */