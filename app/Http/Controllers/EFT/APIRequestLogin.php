<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 10.08.2017
 * Time: 15:52
 */

namespace App\Http\Controllers\EFT;

use Session;
//use Illuminate\Support\Facades\Log;
//use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Cache;

class APIRequestLogin extends APIRequest
{


	public function initialize()
	{
		//parent::doRun();
		return $this;
	}

	protected function handleApiResponse()
	{
		return $this->LogUser();
	}

	private function logUser()
	{
		$userId = md5(
				$this->getValidPostFields(APIRequest::fieldTypeNameRequired)['email'].
				$this->getValidPostFields(APIRequest::fieldTypeNameRequired)['password']
		);

		$this->tokenTracker->set(
			$userId,
			array_merge(
				$this->getValidPostFields(),
				['token' => $this->apiResponse->token]
			)
		);

		Session::put(
			'userData',
			[
				'id' => $userId,
				'email'=> $this->getValidPostFields(APIRequest::fieldTypeNameRequired)['email']
			]
		);
		Session::save();

		return $this;
	}

	protected function handleUnsuccessfulAttempt()
	{
		return $this->setResult('Giriş Bilgilerinizi Kontrol Edin', []);
	}

	protected function handleSuccessfulAttempt()
	{
		return $this->setResult('', []);
	}

	protected function setOptionalPostFields()
	{
		return  [];
	}

	protected function setRequiredPostFields()
	{
		return  [
			ApiField::email($this->request->input(FieldType::EMAIL)),
			ApiField::password($this->request->input(FieldType::PASSWORD))
		];
	}

	protected function getApiEndPoint()
	{
		return env('API_BASE_URL').'merchant/user/login';
	}

	protected function setHeaderData()
	{
		$this->header = [];
		return $this;
	}
}