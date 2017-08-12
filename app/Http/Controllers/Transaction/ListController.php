<?php
namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EFT\APIRequestList;
use Illuminate\Http\Request;

class ListController extends Controller
{
	private $request,$apiRequest;

	public function __construct(Request $request, APIRequestList $apiRequest)
	{
		$this->request = $request;
		$this->apiRequest = $apiRequest;
	}

	public function index()
	{
		$this->request->request->add(['fromDate' => '2010-03-19', 'toDate' => '2017-08-12' , 'page' => 1]);
		$result = $this->apiRequest->doRun()->getResult();
		//dd($result);
		return view('pages.transaction.list.index', [ 'result' => $result ] );
	}

	public function store()
	{
		$result = $this->apiRequest->doRun()->getResult();
		return array_merge(
				$result,
				['htmlFormattedContentArea'=>view('pages.transaction.list.tableArea', [ 'result' => $result ] )->render()]
		);
	}

	//TODO: https://datatables.net e gecir


}