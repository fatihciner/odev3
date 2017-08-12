<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 15:33
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EFT\APIRequestMerchantDetail;
use Illuminate\Http\Request;

class MerchantDetailController extends Controller
{
	private $request, $apiRequest;

	public function __construct(Request $request, APIRequestMerchantDetail $apiRequest)
	{
		$this->request = $request;
		$this->apiRequest = $apiRequest;
	}

	public function show($transactionId)
	{

		//http://odev.my/transaction/merchant/877123-1490085088-479
		return $result = $this->apiRequest->doRun()->getHTMLResult('result','pages.transaction.detail');

		//'htmlFormattedContentArea'=>view('pages.transaction.list.tableArea', [ 'result' => $result ] )->render()
		//return view('pages.transaction.list.tableArea', ['result' => $result]);
	}
}