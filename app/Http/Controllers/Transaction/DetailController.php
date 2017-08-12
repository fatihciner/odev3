<?php
namespace app\Http\Controllers\Transactions;
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 13:43
 */

use App\Http\Controllers\Controller;
use App\Http\Controllers\EFT\APIRequestTransactionDetail;
use Illuminate\Http\Request;

class DetailController extends Controller
{
	private $request, $apiRequest;

	public function __construct(Request $request, APIRequestTransactionDetail $apiRequest)
	{
		$this->request = $request;
		$this->apiRequest = $apiRequest;
	}

	public function show($transactionId)
	{

		//http://odev.my/transaction/877123-1490085088-479
		return $result = $this->apiRequest->doRun()->getHTMLResult('result','pages.transaction.detail');


		//'htmlFormattedContentArea'=>view('pages.transaction.list.tableArea', [ 'result' => $result ] )->render()
		//return view('pages.transaction.list.tableArea', ['result' => $result]);
	}
}