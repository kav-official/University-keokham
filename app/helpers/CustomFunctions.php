<?php
class CustomFunctions
{

	function header_token(){
		$authorizationHeader  = $_SERVER['HTTP_AUTHORIZATION'];
		$headerParts          = explode(' ', $authorizationHeader);
		$authenticationScheme = $headerParts[0];
		$token                = $headerParts[1] ?? null;
		return $token;
	}
	function get_domain($url)
	{
		$str = str_replace(["www.", "https://", "http://", "sg."], [''], $url);
		return strtolower('//' . $str);
	}

	function checkaccess($role, $access)
	{
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
		$domainLink = $protocol . '://' . $_SERVER['HTTP_HOST'];
		if (!in_array($role, $access)) {
			header("location: " . $domainLink . "/admin?error=You do not have permission to access this page.");
		}
	}

	function uploadFile($path)
	{
		$f3 = \Base::instance();
		$f3->set('UPLOADS', $path); // don't forget to set an Upload directory, and make it writable!
		$web = \Web::instance();
		$overwrite = true; // set to true, to overwrite an existing file; Default: false
		$slug = true; // rename file to filesystem-friendly version
		$files = $web->receive(function ($file, $formFieldName) {
			$arrAceptFile = array('jpeg', 'jpg', 'png', 'gif', 'docx', 'doc', 'xlsx', 'xls', 'pdf');
			$file_name = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
			if (in_array($file_name, $arrAceptFile)) {
				return true;
			} else {
				return false;
			}
			return $file_name;
		},
			$overwrite,
			function ($fileBaseName, $formFieldName) {
				$arrName = explode(".", $fileBaseName);
				return substr(sha1(mt_rand() . time()), 0, 17) . '.' . end($arrName);
			}
		);
		return $files;
	}

	function uploadMultiFile($path)
	{
		$f3 = \Base::instance();
		$f3->set('UPLOADS', $path); // don't forget to set an Upload directory, and make it writable!
		$web = \Web::instance();
		$overwrite = true; // set to true, to overwrite an existing file; Default: false
		$slug = true; // rename file to filesystem-friendly version
		$files = $web->receive(function ($file, $formFieldName) {
			$arrAceptFile = array('jpeg', 'jpg', 'png', 'gif', 'docx', 'doc', 'xlsx', 'xls', 'pdf');
			$arrFileName = explode("/", $file['type']);
			$file_name = strtolower($arrFileName[1]);
			if (in_array($file_name, $arrAceptFile)) {
				return true;
			} else {
				return false;
			}
		},
			$overwrite,
			function ($fileBaseName, $formFieldName) {
				$arrName = explode(".", $fileBaseName);
				return $formFieldName . '-' . substr(sha1(mt_rand() . time()), 0, 17) . '.' . end($arrName);
			}
		);
		return $files;
	}

	function image_exists($url)
	{
		if (@getimagesize($url)) {
			return true;
		} else {
			return false;
		}
	}

	public function file_exists($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($code == 200) {
			$status = true;
		} else {
			$status = false;
		}
		curl_close($ch);
		return $status;
	}

	public function url_exist($url)
	{
		$array = @get_headers($url);
		$string = $array[0];
		if (strpos($string, "200")) {
			return true;
		} else {
			return false;
		}
	}

	public function get_real_ip()
	{
		$ip = false;
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) {
				array_unshift($ips, $ip);
				$ip = false;
			}
			for ($i = 0; $i < count($ips); $i++) {
				if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
					if (version_compare(phpversion(), "5.0.0", ">=")) {
						if (ip2long($ips[$i]) != false) {
							$ip = $ips[$i];
							break;
						}
					} else {
						if (ip2long($ips[$i]) != -1) {
							$ip = $ips[$i];
							break;
						}
					}
				}
			}
		}
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}

	public function post_captcha($user_response)
	{
		$f3 = Base::instance();
		$fields_string = '';
		$fields = array(
			'secret' => $f3->get('RECAPTCHA_SECRET'),
			'response' => $user_response,
			'remoteip' => $this->get_real_ip()
		);
		foreach ($fields as $key => $value)
			$fields_string .= $key . '=' . $value . '&';
		$fields_string = rtrim($fields_string, '&');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result, true);
	}
	
	function renderValue($arrData, $data)
	{
		$arr = explode(",", $data);
		foreach ($arr as $key => $value) {
			echo("<li>" . $arrData[$value] . "</li>");
		}
	}
	public function renderArraySelect($arrayObj, $selectedItem)
	{
		foreach (array_keys($arrayObj) as $fields) {
			if (is_array($selectedItem) && $selectedItem != 0) {
				if (in_array($fields, $selectedItem)) {
					echo("<option selected value=\"" . $fields . "\">" . $arrayObj[$fields] . "</option>");
				} else {
					echo("<option value=\"" . $fields . "\">" . $arrayObj[$fields] . "</option>");
				}
			} else {
				if ($selectedItem == $fields) {
					echo("<option selected value=\"" . $fields . "\">" . $arrayObj[$fields] . "</option>");
				} else {
					echo("<option value=\"" . $fields . "\">" . $arrayObj[$fields] . "</option>");
				}
			}
		}
	}

	function truncate($text, $limit = 25, $ending = '...')
	{
		$text = strip_tags($text);
		if (strlen($text) > $limit) {
			$text = substr($text, 0, $limit);
			$text = substr($text, 0, -(strlen(strrchr($text, ' '))));
			$text = $text . $ending;
		}
		return $text;
	}

	function full_url()
	{
		$s = &$_SERVER;
		$ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
		$sp = strtolower($s['SERVER_PROTOCOL']);
		$protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
		$port = $s['SERVER_PORT'];
		$port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
		$host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
		$host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
		$uri = $protocol . '://' . $host . $s['REQUEST_URI'];
		$segments = explode('?', $uri, 2);
		$url = $segments[0];
		return $url;
	}

	function friendlyURL($string)
	{
		$string = preg_replace("`\[.*\]`U", "", $string);
		$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $string);
		$string = htmlentities($string, ENT_COMPAT, 'utf-8');
		$string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string);
		$string = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $string);
		return strtolower(trim($string, '-'));
	}

}
