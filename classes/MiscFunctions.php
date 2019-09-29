<?php
function SumTime($time1, $time2) 
{
  
  $times = array($time1, $time2);
  $seconds = 0;
  
  // loop throught all the times    
  
	foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }
	
	$hours = floor($minutes / 60);
    $minutes -= $hours * 60;
	$newTime = sprintf('%02d:%02d', $hours, $minutes); //"$hours:$minutes:$seconds";
	return $newTime;
}

function SubTime($time1, $time2) 
{
	//$time1 = '12:45:03';
	//$time2 = '14:03:48';
	$timelength = strtotime( $time2 ) - strtotime( $time1 );

	$hours = intval( $timelength / 3600 );
	$minutes = intval( ( $timelength % 3600 ) / 60 );
	//$seconds = $timelength % 60;

	$newVal = sprintf('%02d:%02d', $hours, $minutes); //str_pad( $hours, 2, '0', STR_PAD_LEFT ) . ':' . str_pad( $minutes, 2, '0', STR_PAD_LEFT ); //. ':' . str_pad( $seconds, 2, '0', STR_PAD_LEFT );
	return $newVal;
}
/*
function SumTime($time1, $time2) 
{
  
  $times = array($time1, $time2);
  $seconds = 0;
      
  foreach ($times as $time)
  {
    list($hour,$minute,$second) = explode(':', $time);
    $seconds += $hour*3600;
    $seconds += $minute*60;
    $seconds += $second;
  }
  $hours = floor($seconds/3600);
  $seconds -= $hours*3600;
  $minutes  = floor($seconds/60);
  $seconds -= $minutes*60;
  $newTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); //"$hours:$minutes:$seconds";
  return $newTime;
  
  //return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); 
}

*/

?>
