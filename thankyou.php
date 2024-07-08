<?php

    ob_end_clean();
	header("Connection: close");
	ignore_user_abort(); // optional
	ob_start();
	$file_out = "img/pixel.gif";
	if (file_exists($file_out)) {
		$image_info = getimagesize($file_out);
		switch ($image_info[2]) {
		    case IMAGETYPE_JPEG:
		        header("Content-Type: image/jpeg");
		        break;
		    case IMAGETYPE_GIF:
		        header("Content-Type: image/gif");
		        break;
		    case IMAGETYPE_PNG:
		        header("Content-Type: image/png");
		        break;
		   default:
		        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
		        break;
		}
		header('Content-Length: ' . filesize($file_out));
		readfile($file_out);
		$size = ob_get_length();
		header("Content-Length: $size");
		ob_end_flush(); // Strange behaviour, will not work
		flush();            // Unless both are called !
		session_write_close();
	}

		$url = "https://mybrandsecure.com/secure.php?".$_SERVER['QUERY_STRING'];
		$ch = curl_init();                
		$post['test'] = 'test';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POST, TRUE);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $post); 
		curl_setopt($ch, CURLOPT_USERAGENT, 'api');
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, false);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10); 
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		$data = curl_exec($ch);   
		curl_close($ch);

		echo "test";
?>