<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* get time in MySQL datetime format */
function getDateTime()
{
	$dateFormat = 'Y-m-d H:i:s';
	$timeStamp = time();
	$dateTime = date($dateFormat, $timeStamp);
	
	return $dateTime;
}


/* End of file utility_helper.php */
/* Location: ./application/helpers/utility_helper.php */