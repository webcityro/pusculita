<?php
namespace App\Services;

class ApiCallerService {

	protected $config;

	public function __construct() {
		$this->config = [
			'url' => 'http://api.profitshare.ro',
			'home' => 'http://profitshare.ro',
			'user' => config('api.user'),
			'key' => config('api.key')
		];
	}

	public function call($method, $path, $fields = [], $query = '') {
		return $this->curl($method, $path, $fields, $query);
	}

	public function curl($method, $path, $fields = [], $query = '', $headers = []) {
		$method = strtoupper($method);
		$date = gmdate('D, d M Y H:i:s T', time());
		$signatureString = $method . $path . '/?' . $query . '/' . $this->config['user'] . $date;
		$auth = hash_hmac('sha1', $signatureString, $this->config['key']);
		$url = $this->config['url'].'/'.$path.'/?'.$query;
		$curl_init = curl_init();

		curl_setopt($curl_init, CURLOPT_HEADER, false);
		curl_setopt($curl_init, CURLOPT_URL, $url);
		curl_setopt($curl_init, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($curl_init, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_init, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($curl_init, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($curl_init, CURLINFO_HEADER_OUT, true);

		if ($method == 'POST') {
			curl_setopt($curl_init, CURLOPT_POST, true);
			curl_setopt($curl_init, CURLOPT_POSTFIELDS, http_build_query($fields));
		}

		curl_setopt($curl_init, CURLOPT_HTTPHEADER, array_merge([
			"Date: $date",
			"X-PS-Client: ".$this->config['user'],
			"X-PS-Accept: json",
			"X-PS-Auth: $auth"
		], $headers));
		$content = curl_exec($curl_init);

		if (!curl_errno($curl_init)) {
			$info = curl_getinfo($curl_init);

			if ($info['http_code'] != 200) {
				$error = curl_error($curl_init);
				curl_close($curl_init);
				return $error;
			}
		} else {
			curl_close($curl_init);
			return false;
		}
		return json_decode($content);
	}
}
