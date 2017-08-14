<?php namespace App\Auth;

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
		return session('userData');
	}

	public function userData($type='') {
		if(Session::has('userData')) {
			foreach($this->user() AS $key=>$value) {
				if ($type == $key) return $value;
			}
		}
		return '';
	}

	public function check()
	{
		//return false;
		if(!Session::has('userData')) return false;
		$cachedData = Cache::get($this->userData('id'));
		if(empty($cachedData) || empty($cachedData['email']) || empty($cachedData['password'])) {
			return false;
		}
		return true;
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