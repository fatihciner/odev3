<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 10.08.2017
 * Time: 15:52
 */

namespace App\Http\Controllers\EFT;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Session;

class APIRequestLogin extends APIRequest
{

	protected $request;


	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function doRun()
	{
		parent::doRun();
		try {
			$this->handleApiResponse()
				->LogUser()
				->handleSuccessfulAttempt();
		} catch (\Exception $exception) {
			Log::alert("kod: {$exception->getCode()} | mesaj: ".$exception->getMessage());
			$this->handleUnsuccessfulAttempt();
		}
		return $this;
	}

	protected function handleApiResponse()
	{
		$this->apiResponse = $this->getApiResponse();
		if(empty($this->apiResponse->status) || $this->apiResponse->status != 'APPROVED') {
			throw new \RuntimeException('Başarısız işlem, gonderilenler: '.$this->getApiEndPoint(). '|'.print_r($this->getValidPostFields(),true));
		}
		return $this;
	}

	protected function logUser()
	{
		$userId = md5(
				$this->getValidPostFields(APIRequest::fieldTypeNameRequired)['email'].
				$this->getValidPostFields(APIRequest::fieldTypeNameRequired)['password']
		);

		Cache::put(
			$userId,
			$this->apiResponse->token,
			env('API_TOKEN_EXPIRE_TIME_IN_MINUTES')
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
}