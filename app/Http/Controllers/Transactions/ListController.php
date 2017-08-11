<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 00:41
 */
namespace app\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
class ListController extends Controller
{
	public function index()
	{
		return view('pages.transaction.list');
	}
}