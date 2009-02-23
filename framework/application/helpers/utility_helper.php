<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* get time in MySQL datetime format */
function getDateTime()
{
	$dateFormat = 'Y-m-d H:i:s';
	$timeStamp = time();
	$dateTime = date($dateFormat, $timeStamp);
	
	return $dateTime;
}

/**
 * Returns a human friendly (relative) date from a UNIX timestamp
 * 
 * @param	integer	UNIX timestmap
 *
 * @return	string
 */
function get_friendly_date($timestamp)
{
	$now	= time();
	$cutoff	= $now - (60 * 60 * 24 * 14); // two weeks ago
	$diff	= $now - $timestamp;
	
	// old date, display formally
	if ($timestamp < $cutoff)
	{
		return date('M. jS g:ia', $timestamp);
	}
	
	// less than a minute ago
	if ($diff < 60)
	{
		return 'Seconds ago&hellip;';
	}
	// minutes ago
	else if ($diff < (60 * 60))
	{
		$mins = $diff / 60;
		if ($mins < 2)
		{
			return 'One minute ago';
		}
		return sprintf('%d minutes ago', $mins);
	}
	// less than a day ago
	else if ($diff < (60 * 60 * 24))
	{
		$hours = $diff / (60 * 60);
		if ($hours < 2)
		{
			return 'One hour ago';
		}
		return sprintf('%d hours ago', $hours);
	}
	// a few days ago
	else
	{
		$days = $diff / (60 * 60 * 24);
		if ($days < 2)
		{
			return 'One day ago';
		}
		return sprintf('%d days ago', $days);
	}
}

/* End of file utility_helper.php */
/* Location: ./application/helpers/utility_helper.php */