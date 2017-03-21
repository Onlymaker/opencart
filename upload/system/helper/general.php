<?php
function token($length = 32) {
	// Create random token
	$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
	$max = strlen($string) - 1;
	
	$token = '';
	
	for ($i = 0; $i < $length; $i++) {
		$token .= $string[mt_rand(0, $max)];
	}	
	
	return $token;
}

/**
 * Backwards support for timing safe hash string comparisons
 * 
 * http://php.net/manual/en/function.hash-equals.php
 */

if(!function_exists('hash_equals')) {
	function hash_equals($known_string, $user_string) {
		$known_string = (string)$known_string;
		$user_string = (string)$user_string;

		if(strlen($known_string) != strlen($user_string)) {
			return false;
		} else {
			$res = $known_string ^ $user_string;
			$ret = 0;

			for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);

			return !$ret;
		}
	}
}

function ip() {
	if(function_exists('getenv')) {
		if(getenv('Http_X_Forwarded_For')) {
			return getenv('Http_X_Forwarded_For');
		} else if(getenv('Http_X_Real_IP')) {
			return getenv('Http_X_Real_IP');
		}
	}

	return $_SERVER['REMOTE_ADDR'];
}

function trace($message, $context = []) {
	if (false !== strpos($message, '{') && !empty($context)) {
		$replacements = [];
		foreach ($context as $key => $val) {
			if (is_null($val) || is_scalar($val) || (is_object($val) && method_exists($val, "__toString"))) {
				$replacements['{' . $key . '}'] = $val;
			} elseif (is_object($val)) {
				$replacements['{' . $key . '}'] = '[object ' . get_class($val) . ']';
			} else {
				$replacements['{' . $key . '}'] = '[' . gettype($val) . ']';
			}
		}
		$message = strtr($message, $replacements);
	}

	$ip = ip();

	return file_put_contents(
		DIR_LOGS . date('Y-m-d') . '.log',
		date('[Y-m-d H:i:s] [') . $ip . '] ' . $message . PHP_EOL,
		FILE_APPEND | LOCK_EX
	);
}