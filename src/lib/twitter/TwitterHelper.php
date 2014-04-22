<?php

class TwitterHelper {

	/**
	 * Returns the time since the post was made.
	 * @param  [date] $timestamp
	 * @return [string]
	 */
	public function time_passed($timestamp){
	    //type cast, current time, difference in timestamps
	    $timestamp      = (int) $timestamp;
	    $current_time   = time();
	    $diff           = $current_time - $timestamp;
	    
	    //intervals in seconds
	    $intervals      = array (
	        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
	    );
	    
	    //now we just find the difference
	    if ($diff == 0)
	    {
	        return 'just now';
	    }    

	    if ($diff < 60)
	    {
	        return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
	    }        

	    if ($diff >= 60 && $diff < $intervals['hour'])
	    {
	        $diff = floor($diff/$intervals['minute']);
	        return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
	    }        

	    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
	    {
	        $diff = floor($diff/$intervals['hour']);
	        return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
	    }    

	    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
	    {
	        $diff = floor($diff/$intervals['day']);
	        return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
	    }    

	    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
	    {
	        $diff = floor($diff/$intervals['week']);
	        return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
	    }    

	    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
	    {
	        $diff = floor($diff/$intervals['month']);
	        return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
	    }    

	    if ($diff >= $intervals['year'])
	    {
	        $diff = floor($diff/$intervals['year']);
	        return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
	    }
	}

	/**
	 * Internal function which creates UI for the Twitter List.
	 * @param  [string] $profile_image
	 * @param  [string] $name
	 * @param  [string] $time
	 * @param  [string] $text
	 * @return [string]
	 */
	public function create_list_text($profile_image, $name, $time, $text){
		$message = "<div class='row'><div style='display:inline-block;'><img src='".$profile_image. "'></div>";
		$message .= "<div style='display:inline-block; vertical-align: top; padding-left: 2%; width:80%;'><strong>".$name."</strong><span style='float:right'>".$time."</span><br>".$text."</div></div>";
		return $message;
	}

	public function authenticate($credentials){
		$consumerKey = $credentials->getConsumerKey();
		$consumerSecret = $credentials->getConsumerSecret();
		$accessToken = $credentials->getAccessToken();
		$accessTokenSecret = $credentials->getAccessTokenSecret();
		$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
		return $twitter;
	}
}

?>