<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 16:01
 */

namespace App\Http\Controllers\EFT;


class APIRequestClientDetail extends APIRequest
{

	public function initialize()
	{
		return $this;
	}

	protected function setHeaderData()
	{
		$this->header = [
			'Authorization' => $this->tokenTracker->get()
		];
		return $this;
	}

	protected function handleApiResponse()
	{
		return $this;
	}

	protected function handleUnsuccessfulAttempt()
	{
		return $this->setResult('Aradiginiz client bulunamadi', []);
	}

	protected function handleSuccessfulAttempt()
	{
		return $this->setResult('', $this->apiResponse);
	}

	protected function setOptionalPostFields()
	{
		return [];
	}

	protected function setRequiredPostFields()
	{
		return  [
			ApiField::transactionId($this->request->{FieldType::TRANSACTIONID})
		];
	}

	protected function getApiEndPoint()
	{
		return env('API_BASE_URL').'client';
	}
}