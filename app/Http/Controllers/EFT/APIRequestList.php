<?php
namespace App\Http\Controllers\EFT;
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 07:03
 */


class APIRequestList extends APIRequest
{
	public function initialize()
	{
		return $this;

	}

	protected function setHeaderData()
	{
		$this->header = [
			'Authorization' => $this->tokenTracker->get()
			//'Authorization' => (new TokenTracker($this->request))->get()
		];
		return $this;
	}

	protected function handleApiResponse()
	{
		/*bu veri karışık imiş, burayı düzenlemek için özel calışmak lazım. simdilik birakiyorum.
		$this->apiResponse = array_map(
			function($response){
				return [
					'per_page' => $response->per_page,
				];
			},
			$this->apiResponse
		);*/
		return $this;
	}

	protected function handleUnsuccessfulAttempt()
	{
		return $this->setResult('Bakmak istediğiniz aralığı genişletin', []);
	}

	protected function handleSuccessfulAttempt()
	{
		return $this->setResult('', $this->apiResponse);
	}

	protected function setOptionalPostFields()
	{
		return  [];
	}

	protected function setRequiredPostFields()
	{
		return  [
			ApiField::fromDate($this->request->input(FieldType::FROMDATE)),
			ApiField::toDate($this->request->input(FieldType::TODATE)),
			ApiField::page($this->request->input(FieldType::PAGE))
		];
	}

	protected function getApiEndPoint()
	{
		return env('API_BASE_URL').'transaction/list';
	}
}