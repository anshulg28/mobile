<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * curl Library
 */
class curl_library
{
	public function getApiData($url, $time_out, $optHeaders)
	{
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		if($time_out != 0)
		{
			curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if($optHeaders != '')
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $optHeaders);
		}
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec ($curl);
		curl_close ($curl);
        return $result;
	}

	public function getApiDataByPost($url, $data, $time_out, $optHeaders)
	{
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		if($time_out != 0)
		{
			curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);
		}
		if($optHeaders != '')
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $optHeaders);
		}
		curl_setopt($curl, CURLOPT_POST, true);  // tell curl you want to post something
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		curl_close ($curl);
		return $result;
	}

    public function getApiJSONDataByPost($url, $data, $time_out, $optHeaders)
    {
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        if($time_out != 0)
        {
            curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);
        }
        if($optHeaders != '')
        {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $optHeaders);
        }
        curl_setopt($curl, CURLOPT_POST, true);  // tell curl you want to post something
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close ($curl);
        return $result;
    }

    public function getApiDataByDelete($url, $data, $time_out, $optHeaders)
    {
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        if($time_out != 0)
        {
            curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);
        }
        if($optHeaders != '')
        {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $optHeaders);
        }
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        //curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close ($curl);
        return $result;
    }

	private function getDataByGet($url, $timeOut = 0, $headers = '')
	{
		$detailsTemp = $this->getApiData($url, $timeOut, $headers);
		$details = json_decode($detailsTemp, true);
		return $details;
	}

	private function getDataByPost($url, $parameters, $timeOut = 0, $headers = '')
	{
		$detailsTemp = $this->getApiDataByPost($url, $parameters, $timeOut, $headers);
		$details = json_decode($detailsTemp, true);
		return $details;
	}

    private function getJSONDataByPost($url, $parameters, $timeOut = 0, $headers = '')
    {
        $detailsTemp = $this->getApiJSONDataByPost($url, $parameters, $timeOut, $headers);
        $details = json_decode($detailsTemp, true);
        return $details;
    }

    private function getDataByDelete($url, $parameters, $timeOut = 0, $headers = '')
    {
        $detailsTemp = $this->getApiDataByDelete($url, $parameters, $timeOut, $headers);
        $details = json_decode($detailsTemp, true);
        return $details;
    }
	/*public function banquetGetList($filters)
	{
		$url = API_BASE.'productbanquet/getList?'.http_build_query(array('bypass' => API_AUTH_TOKEN));
		return $this->getDataByPost($url, $filters);
	}*/

    public function getFacebookPosts($storeName,$params)
    {
        $url = FACEBOOK_API.$storeName.'/tagged?'.http_build_query($params);
        return $this->getDataByGet($url, 30);
    }
    public function getInstagramPosts()
    {
        $url = 'https://www.juicer.io/api/feeds/24816';
        return $this->getDataByGet($url, 30);
    }
    public function getMoreInstaFeeds()
    {
        $url = 'https://www.juicer.io/api/feeds/31761';
        return $this->getDataByGet($url, 30);
    }

    /* Instamojo API */

    public function getInstaImageLink()
    {
        $url = 'https://www.instamojo.com/api/1.1/links/get_file_upload_url/';
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        return $this->getDataByGet($url,0, $header);
    }
    public function uploadInstaImage($imgLink, $img)
    {
        $url = $imgLink;
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        //var_dump(base_url().EVENT_PATH_THUMB.$img);
        return $this->getDataByPost($url,array('url'=>base_url().EVENT_PATH_THUMB.$img),0, $header);
    }
    public function createInstaLink($details)
    {
        $url = 'https://www.instamojo.com/api/1.1/links/';
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        //var_dump(base_url().EVENT_PATH_THUMB.$img);
        return $this->getDataByPost($url,$details,0, $header);
    }
    public function getInstaMojoRecord($payId)
    {
        $url = 'https://www.instamojo.com/api/1.1/payments/'.$payId.'/';
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        return $this->getDataByGet($url,0, $header);
    }

    public function refundInstaPayment($details)
    {
        $url = 'https://www.instamojo.com/api/1.1/refunds/';
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        return $this->getDataByPost($url,$details,0, $header);
    }
    public function allInstaRefunds()
    {
        $url = 'https://www.instamojo.com/api/1.1/refunds/';
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        return $this->getDataByGet($url,0, $header);
    }

    public function archiveInstaLink($slug)
    {
        $url = 'https://www.instamojo.com/api/1.1/links/'.$slug.'/';
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        return $this->getDataByDelete($url,'',0,$header);
    }
    public function createInstaMugLink($details)
    {
        $url = 'https://www.instamojo.com/api/1.1/payment-requests/';
        $header = array(
            'X-Api-Key:'.INSTA_API_KEY,
            'X-Auth-Token:'.INSTA_AUTH_TOKEN
        );
        //var_dump(base_url().EVENT_PATH_THUMB.$img);
        return $this->getDataByPost($url,$details,0, $header);
    }

    /* JukeBox API */
    public function getJukeboxTaprooms()
    {
        $url = 'https://api.bcjukebox.in/api/restaurants/';
        $header = array(
            'bcclientid:'.BCJUKEBOX_CLIENT,
        );
        return $this->getDataByGet($url,0, $header);
    }
    public function getTaproomInfo($id)
    {
        $url = 'https://api.bcjukebox.in/api/restaurants/'.$id.'/request_queue/';
        $header = array(
            'bcclientid:'.BCJUKEBOX_CLIENT,
        );
        return $this->getDataByGet($url,0, $header);
    }
    public function checkJukeboxUser($email, $pwd)
    {
        $url = 'https://api.bcjukebox.in/signup/email/';
        $post = array(
            'client_id' => BCJUKEBOX_CLIENT,
            'email' => $email,
            'password1' => $pwd
        );

        return $this->getDataByPost($url,$post,0);
    }

    public function loginJukeboxUser($email, $pwd)
    {
        $url = 'https://api.bcjukebox.in/oauth2/access_token/';
        $post = array(
            'client_id' => BCJUKEBOX_CLIENT,
            'username' => $email,
            'password' => $pwd,
            'grant_type' => 'password'
        );

        return $this->getDataByPost($url,$post,0);
    }

    //Fetching playlist of taproom
    public function getTapPlaylist($resId)
    {
        $url = 'https://api.bcjukebox.in/api/restaurants/'.$resId.'/playlistsongs/';
        $header = array(
            'bcclientid:'.BCJUKEBOX_CLIENT,
        );
        return $this->getDataByGet($url,0, $header);
    }

    //Fetching songs in a playlist
    public function getTapSongsByPlaylist($resId,$playId)
    {
        $url = 'https://api.bcjukebox.in/api/restaurants/'.$resId.'/playlistsongs/'.$playId.'/';
        $header = array(
            'bcclientid:'.BCJUKEBOX_CLIENT,
        );
        return $this->getDataByGet($url,0, $header);
    }

    public function requestTapSong($post)
    {
        $url = 'https://api.bcjukebox.in/api/restaurants/'.$post['tapId'].'/requests/';
        $details = array(
            'song' => $post['songId']
        );
        $headers = array(
            'bcclientid: '.BCJUKEBOX_CLIENT,
            'Authorization: Bearer '.$post['Auth'],
            'bclocation: '.$post['location']
        );

        return $this->getDataByPost($url,$details,0,$headers);
    }

    public function requestThirdPartySong($post)
    {
        $url = 'https://api.bcjukebox.in/api/restaurants/'.$post['tapId'].'/thirdpartyrequests/';

        if(isset($post['email']))
        {
            $details = array(
                'song' => $post['songId'],
                'email' => $post['email']
            );
        }
        else
        {
            $details = array(
                'song' => $post['songId']
            );
        }
        $headers = array(
            'bcclientid: '.BCJUKEBOX_CLIENT,
            'bcuniqueid: '.$post['Auth'],
            'bclocation: '.$post['location']
        );

        return $this->getDataByPost($url,$details,0,$headers);
    }

    public function verifyThirdPartyUser($post)
    {
        $url = 'https://api.bcjukebox.in/signup/thirdparty/';

        $headers = array(
            'bcclientid: '.BCJUKEBOX_CLIENT,
            'bcuniqueid: '.encrypt_jukebx_data($post['email'])
        );

        return $this->getDataByPost($url,$post,0,$headers);
    }

    public function sendEventSMS($details)
    {
        $url = 'http://api.textlocal.in/send/';

        return $this->getDataByPost($url,$details,0);
    }

    //EventsHigh Disable Event
    public function disableEventsHigh($eventsHighId)
    {
        $url = 'https://developer.eventshigh.com/disable_event/'.$eventsHighId.'?key='.EVENT_HIGH_KEY;
        return $this->getDataByGet($url,0, array());
    }
    //EventsHigh Getting Attendee List
    public function attendeeEventsHigh($eventsHighId)
    {
        $url = 'https://developer.eventshigh.com/get_event_attendees/'.$eventsHighId.'?key='.EVENT_HIGH_KEY;
        return $this->getDataByGet($url,0, array());
    }

    public function refundEventsHigh($details)
    {
        $url = 'https://developer.eventshigh.com/refund_booking?key='.EVENT_HIGH_KEY;
        $headers = array(
            'Content-Type: application/json'
        );
        return $this->getJSONDataByPost($url,$details,0,$headers);
    }
}