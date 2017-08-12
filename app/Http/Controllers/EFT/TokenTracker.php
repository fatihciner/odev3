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
use Illuminate\Http\Request;

class TokenTracker
{

	public function set($userId='', $userCredentials=[])
	{
		Cache::put(
			$userId,
			$userCredentials,
			env('API_TOKEN_EXPIRE_TIME_IN_MINUTES') *2
		);
	}

	public function get()
	{
		foreach(Cache::get(Auth::userData('id'), function(){return [];}) AS $key=>$value) {
			if ($key == 'token' ) return $value;
		}
		return $this->renew();
	}

	public function renew(Request $request, APIRequestLogin $apiRequest) {
		if(!Auth::check())
			throw new \RuntimeException('Cant renew token', 9999);
		$cachedData = Cache::get(Auth::userData('id'));
		$this->request->request->add( [ 'email' => $cachedData['email'], 'password' => $cachedData['password'] ] );
		$result = $this->apiRequest->doRun()->getJsonResult();
		if(!empty($result['error']))
			throw new \RuntimeException('Couldnt renew token', 9999);
	}


}