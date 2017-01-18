<?php 


function print_r_pre_exit($string) 
{
	print "<pre>";
		print_r($string);
	print "</pre>"; 
	exit;
}