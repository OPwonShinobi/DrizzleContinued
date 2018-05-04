<?php
	// goto this page at localhost:urPort/phpinfo.php to see if ur browser support sessions. 
	$pathToTmp = session_save_path();
	$writable = is_writable($pathToTmp);
	if ($writable)
		echo 'Session path "'.$pathToTmp.'"is writable for PHP!'; 
	else
		echo 'You\'re gonna need to chmod 755 this folder: '.$pathToTmp.' to host the site'; 
?>