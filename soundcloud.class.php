<?php

/*
 * Class which use Souncloud API
 * refer to API console : https://developers.soundcloud.com/console
 * index of the API guide : https://developers.soundcloud.com/docs/api/guide
*/

class Soundcloud
{
	private $client_id;
	private static $base_url = 'http://api.soundcloud.com';


	/*
	 * If needed for further functions, initialize $client_id
	 * 
	*/
	public function __construct()
	{

	}


	/*
	 * Execute and get result from a CURL query
	*/
	public function executeQuery($url)
	{		
		$url = self::$base_url.$url;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		
		if ($info['http_code'] != 200) {
			return $result['error'] = 'Error HTTP '.$info['http_code'];
		}

 		return json_decode($response);
	}
	
	
	/*
	 * Get 'following' of a user, regarding id
	 * TODO : get number of following and set it as limit
	*/
	public function getFollowing($user_id)
	{
		$arr_following = $this->executeQuery('/users/'.$user_id.'/followings.json?consumer_key=apigee&limit=250');
	
		$i = 0;
		foreach ($arr_following as $following) {
			$result[$i]['id'] = $following->id;
			$result[$i]['username'] = $following->username;
			$result[$i]['country'] = $following->country;
			$result[$i]['track_count'] = $following->track_count;
			$result[$i]['last_modified'] = $following->last_modified;
			$result[$i]['permalink_url'] = $following->permalink_url;
			$result[$i]['avatar_url'] = $following->avatar_url;

			++$i;
		}

		return $result;
	}


	/*
	 * Get tracks regarding id of a soundcloud user
	*/
	public function getTracks($user_id)
	{
		$arr_tracks = $this->executeQuery('/users/'.$user_id.'/tracks.json?consumer_key=apigee');

		$i = 0;
		foreach ($arr_tracks as $track) {
			$track = (array)$track;
			$result[$i]['id'] = $track['id'];
			$result[$i]['created_at'] = $track['created_at'];
			$result[$i]['user_id'] = $track['user_id'];
			$result[$i]['permalink'] = $track['permalink'];
			$result[$i]['genre'] = $track['genre'];
			$result[$i]['title'] = $track['title'];
			$result[$i]['description'] = $track['description'];
			$result[$i]['permalink_url'] = $track['permalink_url'];
			$result[$i]['artwork_url'] = $track['artwork_url'];
			$result[$i]['tag_list'] = $track['tag_list'];

			++$i;
		}

		return $result;

	}


	/*
	 * Get recent sounds of a stream (less than a week)
	 * TODO : return results order by date
	*/
	public function getRecentSounds($arr_account)
	{
		$now = new DateTime("now");
		$weekBefore = $now->sub(new DateInterval('P7D'));
		unset($now);

		$i = 0;
		foreach ($arr_account as $account) {	
			if ($account['track_count'] > 0){
				$arr_tracks = $this->getTracks((int)$account['id']);
				foreach ($arr_tracks as $track) {
					$objDateTrack = new DateTime($track['created_at']);
					if ($objDateTrack > $weekBefore) {
						$result[$i]['created_at'] = $track['created_at'];
						$result[$i]['title'] = $track['title'];
						$result[$i]['artwork_url'] = $track['artwork_url'];
						$result[$i]['permalink_url'] = $track['permalink_url'];

						++$i;
					}
				}
			}

		}

		return $result;
	}

	

}