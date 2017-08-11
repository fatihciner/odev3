<?php namespace App\Auth;

/*

aldigim yer:
https://laravel.io/forum/11-04-2014-laravel-5-how-do-i-create-a-custom-auth-in-laravel-5
fix:
https://stackoverflow.com/questions/28890409/laravel-custom-authentication
--
http://laravel-recipes.com/recipes/115/using-your-own-authentication-driver

use Illuminate\Contracts\Auth\User as UserContract;
use Illuminate\Auth\UserProviderInterface;

class CustomUserProvider implements UserProviderInterface {
*/



use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Auth\GenericUser;
use Illuminate\Auth\AuthenticationException;
use Cache;
use Session;
class CustomUserProvider  implements UserProvider {

	protected $model;

	public function __construct(UserContract $model)
	{
		$this->model = $model;
	}

	public function user() {
		//TODO: sessiondan user bilgilerini dön
		return session('userData');
	}

	public function check()
	{
		return Session::has('userData');
	}

	public function getApiToken()
	{
		//TODO: sessionda veya cachede token bilgileri yoksa "ApiTokenExpired" exception at, ona groe catche cagiran yerlerden
		if(!$this->check()) return '';
		//return Cache::has($this->user()['id']) ?  : '';
		return Cache::get($this->user()['id'],'');  //TODO: exception at eger cachede yok ise!
	}





	public function attempt()
	{
		return new \Exception('not implemented');
	}

	public function authenticate()
	{
		throw new AuthenticationException('Unauthenticated.');
	}


	public function retrieveById($identifier)
	{
		return new \Exception('not implemented');
		//return $this->dummyUser();
	}

	public function retrieveByToken($identifier, $token)
	{
		return new \Exception('not implemented');
	}


	public function updateRememberToken(UserContract $user, $token)
	{
		return new \Exception('not implemented');
	}

	public function retrieveByCredentials(array $credentials)
	{
		return $this->dummyUser();
	}

	public function validateCredentials(UserContract $user, array $credentials)
	{
		//sürekli true donsun
		return true;
	}


	/**
	 * Return a generic fake user
	 */
	protected function dummyUser()
	{
		$attributes = array(
			'id' => 123,
			'username' => 'chuckles',
			'password' => \Hash::make('SuperSecret'),
			'name' => 'Dummy User',
		);
		return new GenericUser($attributes);
	}

}