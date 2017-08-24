<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 18.08.2017
 * Time: 11:34
 */

namespace App\Http\Controllers\EFT;

use Cache;
use Session;

trait LoginTrait
{

	private function getUserId($userCredentials=[])
	{
		return md5($userCredentials['email'].$userCredentials['password']);
	}

	private function logUser($userCredentials=[])
	{
		$userId = $this->getUserId($userCredentials);

		Cache::put(
			$userId,
			array_merge(
				$this->getValidPostFields(),
				['token' => $userCredentials['token']]
			),
			env('API_TOKEN_EXPIRE_TIME_IN_MINUTES') * 1
		);

		Session::put( 'userData', [ 'id' => $userId, 'email'=> $userCredentials['email'] ] );
		Session::save();

		return $this;
	}



}