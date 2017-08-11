<?php

namespace App\Http\Controllers\EFT;


class DataFetcher
{
	private $ch;


	public function __construct()
	{
//		foreach ($data as $key => $val) {
//			curl_setopt($this->ch, $key, $val);
//		}
//
//		curl_setopt($this->ch, CURLOPT_URL, $url);
	}

	public function getResponse($url, array $post_data = [])
	{

		//https://testreportingapi.clearsettle.com/api/v3/merchant/user/login?email=demo@bumin.com.tr&password=cjaiU8CV

		//return $this->TestLogin();

		/*$headers = array
		(
			'Accept: application/json',
			'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
			'Accept-Encoding: gzip,deflate',
			'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7',
			'Content-Type: application/json',
			'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJhZG1pbiIsIm1lcmNoYW50SWQiOjMsInN1Yk1lcmNoYW50SWRzIjpbMyw3NCw5MywxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OF0sInRpbWVzdGFtcCI6MTUwMjQ1MzMzNn0.NyJuuxqbNS0mIYPKD9J0tUNfx1H8L6nfhUp9k1O_wiM'
		);*/
		//$url = 'https://testreportingapi.clearsettle.com/api/v3/transactions/report';
		//dd($post_data);
		$this->ch = curl_init($url);

//		$post_data = [ "email" => "demo@bumin.com.tr", "password" => "cjaiU8CV"];
//		"email=demo%40bumin.com.tr&password=cjaiU8CV"
//		"email=demo%40bumin.com.tr&password=cjaiU8CV"
//		dd(http_build_query($post_data));
		if(!empty($post_data)) {
			curl_setopt($this->ch, CURLOPT_POST, true);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		}

		$headers = array();
		//$headers[] = 'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6NTMsInJvbGUiOiJhZG1pbiIsIm1lcmNoYW50SWQiOjMsInN1Yk1lcmNoYW50SWRzIjpbMyw3NCw5MywxMTEsMTM3LDEzOCwxNDIsMTQ1LDE0NiwxNTMsMzM0LDE3NSwxODQsMjIwLDIyMSwyMjIsMjIzLDI5NCwzMjIsMzIzLDMyNywzMjksMzMwLDM0OSwzOTAsMzkxLDQ1NSw0NTYsNDc5LDQ4OCw1NjMsMTE0OSw1NzAsMTEzOCwxMTU2LDExNTcsMTE1OF0sInRpbWVzdGFtcCI6MTUwMjQ1MzMzNn0.NyJuuxqbNS0mIYPKD9J0tUNfx1H8L6nfhUp9k1O_wiM';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
		$headers[] = 'Accept-Encoding: gzip, deflate';
		$headers[] = 'Accept-Language: en-US,en;q=0.5';
		$headers[] = 'Cache-Control: no-cache';
		$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
		//$headers[] = 'Host: 202.71.152.126';
		//$headers[] = 'Referer: http://www.example.com/index.php'; //Your referrer address
		$headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
		//$headers[] = 'X-MicrosoftAjax: Delta=true';

		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36");
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_ENCODING, "gzip");
		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 50);

		//debuggin..
//		curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);
//		$verbose = fopen('php://temp', 'w+');
//		curl_setopt($this->ch, CURLOPT_VERBOSE, true);
//		curl_setopt($this->ch, CURLOPT_STDERR, $verbose);

		$response = curl_exec($this->ch);
		$error_message   = curl_error($this->ch);
		$error_no    = curl_errno($this->ch);

		//dd($response);

//		rewind($verbose);
//		$verboseLog = stream_get_contents($verbose);
//		echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
//		$info = curl_getinfo($this->ch); dd($info);   //TODO <- curl infoya göre sonucu kontrol et. //$http_result = $info ['http_code'];

		if (is_resource($this->ch)) {
			curl_close($this->ch);
		}

		if (0 !== $error_no) {
			throw new \RuntimeException($error_message.'|response: '.print_r($response,true), $error_no);
		}
		return json_decode($response);
	}

	private  function TestLogin() {
		return json_encode(
			[
				'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudFVzZXJJZCI6MSwicm9sZSI6ImFkbWluIiwi',
				'status' => 'APPROVED'
			]
		);
	}


}