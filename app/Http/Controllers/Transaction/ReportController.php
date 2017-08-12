<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 00:49
 */
namespace app\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EFT\APIRequestReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
	private $request,$apiRequest;

	public function __construct(Request $request, APIRequestReport $apiRequest)
	{
		$this->request = $request;
		$this->apiRequest = $apiRequest;
	}

	public function index()
	{
		$this->request->request->add(['fromDate' => '2015-07-01', 'toDate' => '2017-07-01' ]);
		$result = json_decode($this->apiRequest->doRun()->getJsonResult());
		return view('pages.transaction.report', [ 'result' => $result ] );
	}

	public function store()
	{
		$result = json_decode($this->apiRequest->doRun()->getJsonResult());
		return view('pages.transaction.report', [ 'result' => $result ] );
	}
}