<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 9.08.2017
 * Time: 18:52
 */

namespace app\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EFT\DataFetcher;

class ListController extends Controller
{

	protected $dataTransporter;

	/**
	 * ListController constructor.
	 */
	public function __construct(DataFetcher $dataFetcher)
	{
		$this->dataTransporter = $dataFetcher;
	}



	public function index()
	{

		$output = $this->dataTransporter->getResponse('http://www.bloomberght.com');
		dd($output);
		return view('transaction.list');
	}
}