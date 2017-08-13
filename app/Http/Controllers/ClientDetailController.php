<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 16:00
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EFT\APIRequestClientDetail;
use Illuminate\Http\Request;

class ClientDetailController extends Controller
{

	private $request, $apiRequest;

	public function __construct(Request $request, APIRequestClientDetail $apiRequest)
	{
		$this->request = $request;
		$this->apiRequest = $apiRequest;
	}

	public function show($transactionId)
	{
		//http://odev.my//client/877123-1490085088-479
		//return $result = $this->apiRequest->doRun()->getHTMLResult('result','pages.transaction.detail');
		$result = $this->apiRequest->doRun()->getResult();
		return array_merge(
			$result,
			['htmlFormattedContentArea'=>view('pages.transaction.detail', [ 'result' => $result ] )->render()]
		);

	}
}