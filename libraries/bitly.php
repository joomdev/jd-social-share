<?php
/**
 * @package		JD Social Share
 * @version		1.5
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2020 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
define('bitly_api', 'http://api.bit.ly/v3/'); 
define('bitly_oauth_api', 'https://api-ssl.bit.ly/v3/'); 
define('bitly_oauth_access_token', 'https://api-ssl.bit.ly/oauth/');

class Bitly{

function bitly_oauth_access_token($code, $redirect, $client_id, $client_secret) {
  $results = array();
  $url = bitly_oauth_access_token . "access_token";
  $params = array();
  $params['client_id'] = $client_id;
  $params['client_secret'] = $client_secret;
  $params['code'] = $code;
  $params['redirect_uri'] = $redirect;
  $output = $this->bitly_post_curl($url, $params);
  $parts = explode('&', $output);
  foreach ($parts as $part) {
    $bits = explode('=', $part);
    $results[$bits[0]] = $bits[1];
  }
  return $results;
}

/**
 * Returns an OAuth access token via the user's bit.ly login Username and Password
 *
 * @param $username
 *   The user's Bitly username
 * @param $password
 *   The user's Bitly password
 * @param $client_id
 *   The client_id assigned to your OAuth app. (http://bit.ly/a/account)
 * @param $client_secret
 *   The client_secret assigned to your OAuth app. (http://bit.ly/a/account)
 *
 * @return
 *   An associative array containing:
 *   - access_token: The OAuth access token for specified user.
 *
 */
 
function bitly_oauth_access_token_via_password($username, $password, $client_id, $client_secret) {
  $results = array();
  $url = bitly_oauth_access_token . "access_token";
  
  $headers = array();
  $headers[] = 'Authorization: Basic '.base64_encode($client_id . ":" . $client_secret);
    
  $params = array();
  $params['grant_type'] = "password";
  $params['username'] = $username;
  $params['password'] = $password;
  
  $output = $this->bitly_post_curl($url, $params, $headers);
  
  $decoded_output = json_decode($output,1);

  $results = array(
  	"access_token" => $decoded_output['access_token']
  );
  
  return $results;
}

/**
 * Format a GET call to the bit.ly API.
 *
 * @param $endpoint
 *   bit.ly API endpoint to call.
 * @param $params
 *   associative array of params related to this call.
 * @param $complex
 *   set to true if params includes associative arrays itself (or using <php5)
 *
 * @return
 *   associative array of bit.ly response
 *
 * @see http://code.google.com/p/bitly-api/wiki/ApiDocumentation#/v3/validate
 */
function bitly_get($endpoint, $params, $complex=false) {
  $result = array();
  if ($complex) {
    $url_params = "";
    foreach ($params as $key => $val) {
      if (is_array($val)) {
        // we need to flatten this into one proper command
        $recs = array();
        foreach ($val as $rec) {
          $tmp = explode('/', $rec);
          $tmp = array_reverse($tmp);
          array_push($recs, $tmp[0]);
        }
        $val = implode('&' . $key . '=', $recs);
      }
      $url_params .= '&' . $key . "=" . $val;
    }
    $url = bitly_oauth_api . $endpoint . "?" . substr($url_params, 1);
  } else {
    $url = bitly_oauth_api . $endpoint . "?" . http_build_query($params);
  }

  //echo $url . "\n";

  $result = json_decode($this->bitly_get_curl($url), true);

  return $result;
}

/**
 * Format a POST call to the bit.ly API.
 *
 * @param $uri
 *   URI to call.
 * @param $fields
 *   Array of fields to send.
 */
function bitly_post($endpoint, $params) {
  $result = array();
  $url = bitly_oauth_api . $api_endpoint;
  $output = json_decode(bitly_post_curl($url, $params), true);
  $result = $output['data'][str_replace('/', '_', $api_endpoint)];
  $result['status_code'] = $output['status_code'];
  return $result;
}

/**
 * Make a GET call to the bit.ly API.
 *
 * @param $uri
 *   URI to call.
 */
function bitly_get_curl($uri) {
  $output = "";
  try {
    $ch = curl_init($uri);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $output = curl_exec($ch);
  } catch (Exception $e) {
  }
  return $output;
}

/**
 * Make a POST call to the bit.ly API.
 *
 * @param $uri
 *   URI to call.
 * @param $fields
 *   Array of fields to send.
 */
function bitly_post_curl($uri, $fields, $header_array = array()) {
  $output = "";
  $fields_string = "";
  foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
  rtrim($fields_string,'&');
  try {
    $ch = curl_init($uri);
    
    if(is_array($header_array) && !empty($header_array)){
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
    }
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_POST,count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $output = curl_exec($ch);
  } catch (Exception $e) {
  }
  return $output;
}

}
?>