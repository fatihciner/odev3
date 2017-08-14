<?php
namespace App\Http\Controllers\EFT;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

abstract class APIRequest
{
	protected $request, $tokenTracker, $postFields, $apiResponse, $header;
	private $result;

	const fieldTypeNameRequired = 'required';
	const fieldTypeNameOptional = 'optional';

	public function __construct(Request $request, TokenTracker $tokenTracker)
	{
		$this->tokenTracker = $tokenTracker;
		$this->request = $request;
	}

	protected function getPostFields($type='')
	{
		return array_filter (
			$this->postFields,
			function ($parameters,$parameter_type) use ($type)
			{
				return ( empty($type) || $type == $parameter_type ) ? $parameters : null;
			},
			ARRAY_FILTER_USE_BOTH
		);
	}

	protected function getValidPostFields()
	{
		$validFields = [];
		array_walk_recursive (
			$this->postFields,
			function ($apiField) use (& $validFields)
			{
				!$apiField->getValue() ? : $validFields[$apiField->getName() ] = $apiField->getValue() ;
			}
		);
		return $validFields;
	}

	abstract protected function setOptionalPostFields();
	abstract protected function setRequiredPostFields();
	abstract protected function handleApiResponse();
	abstract protected function setHeaderData();
	abstract protected function handleSuccessfulAttempt();
	abstract protected function handleUnsuccessfulAttempt();
	abstract protected function getApiEndPoint();
	abstract protected function initialize();


	public function doRun()
	{

		// * isareti ile isaretlenmis alari her bir cagrilan class ilgili api end pointine gore kendi i$lerini yapar
		// (her class veya endpoint in istegi davranisi farkli olabileceginden)
		// gerisi merkezi abstract class tarafindan handle edilir (hafif monolitik oldu - refactor edilebilir)
		// single responsibility icin bir kisim metodlari kendi classlarina ayirmak daiyi bir refctoring olabilir.
		// bir diger yapilmasi gerken de her bir islemin kendi ozel exceptionuu atmasi gerekiyor. simdilik ben
		// hepsini tek bir exception turu altinda  catch ediyorum  : )

		try {

			$this->setPostFields()				//apiye gidecek inputlar varsa onlari duzenler
				->initialize()					// * apiye cagri atmadan once gereken duzenlemeleri yapar
				->setHeaderData()				// * apiye gidecek header degerleri varsa onlari duzenler
				->setApiResponse()				//apiden gelen sonuc var mi varsa onu kullanmamizi saglar
				->checkApiResponse()			//apiden gelen sonuclari analiz eder
				->handleApiResponse()			// * api den donen sonuclari duzenler - api node isimlerini kendi isimlerimiz ile degistirir
				->handleSuccessfulAttempt();	// *basarili islemler sonu her bir class kendi basarili islemler sonunda ne yapmak isterse onu yapabilir
		}
		catch (ValidationException $exception) //validator exceptionlarini oldugunu gibi gonderiyorum
		{
			throw $exception;
		}
		catch (\Exception $exception)
		{
			Log::alert("kod: {$exception->getCode()} | mesaj: ".$exception->getMessage().'|'.$exception->getTraceAsString());
			$this->handleUnsuccessfulAttempt();	// * basarisiz islemler sonu neler yapilacak ise onlar yapilir
		}

		return $this;
	}

	private function setPostFields()
	{
		$this->postFields = [
			self::fieldTypeNameRequired => $this->setRequiredPostFields(),
			self::fieldTypeNameOptional => $this->setOptionalPostFields()
		];
		return $this;
	}

	protected function setApiResponse()
	{
		$curl = new DataFetcher();
		$this->apiResponse = $curl->getResponse(
										$this->getApiEndPoint(),
										$this->getValidPostFields(),
										$this->header
									);
		return $this;
	}

	protected function checkApiResponse()
	{
		if(!empty($this->apiResponse->error) || (!empty($this->apiResponse->status) && $this->apiResponse->status != 'APPROVED') )  {
			if($this->apiResponse->message == 'Token Expired') redirect('login');
//			if($this->apiResponse->message == 'Token Expired')
//				$this->tokenTracker->renew();
			throw new \RuntimeException(
				'Basarisiz islem|apiResponse:'.print_r($this->apiResponse,true).
				'|gonderilenler: hedef:'.$this->getApiEndPoint().
				'|'.print_r(array_merge($this->header,$this->getValidPostFields()),true)
			);
		}
		return $this;
	}

	protected function setResult($error_message='Default Error', $data=[])
	{
		$this->result = [
			'error' => $error_message,
			'data' => $data
		];
		return $this;
	}

	public function getJsonResult()
	{
		return json_encode($this->result);
	}

	public function getResult()
	{
		return $this->result;
	}

	public function getHTMLResult($dataName='data',$viewName='')
	{
		return view($viewName, [ $dataName => $this->result ] )->render();
	}
}