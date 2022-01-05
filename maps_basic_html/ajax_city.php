  <?php



  function get_info( $id ) {


  // Copyright 2019 Oath Inc. Licensed under the terms of the zLib license see https://opensource.org/licenses/Zlib for terms.

  function buildBaseString($baseURI, $method, $params) {
      $r = array();
      ksort($params);
      foreach($params as $key => $value) {
          $r[] = "$key=" . rawurlencode($value);
      }
      return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
  }

  function buildAuthorizationHeader($oauth) {
      $r = 'Authorization: OAuth ';
      $values = array();
      foreach($oauth as $key=>$value) {
          $values[] = "$key=\"" . rawurlencode($value) . "\"";
      }
      $r .= implode(', ', $values);
      return $r;
  }

  $url = 'https://weather-ydn-yql.media.yahoo.com/forecastrss';
  $app_id = 'KKVOnOvN';
  $consumer_key = 'dj0yJmk9VkwwaE5mbDhNR093JmQ9WVdrOVMwdFdUMjVQZGs0bWNHbzlNQT09JnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PThi';
  $consumer_secret = '80bbf474ed21ee368a02c27196a71a0187308a0e';

  $query = array(
      'location' => $id,
      'format' => 'json',
      'u' => 'c', // puede ser f(imperial) o c(metrica)
  );

  $oauth = array(
      'oauth_consumer_key' => $consumer_key,
      'oauth_nonce' => uniqid(mt_rand(1, 1000)),
      'oauth_signature_method' => 'HMAC-SHA1',
      'oauth_timestamp' => time(),
      'oauth_version' => '1.0'
  );

  $base_info = buildBaseString($url, 'GET', array_merge($query, $oauth));
  $composite_key = rawurlencode($consumer_secret) . '&';
  $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
  $oauth['oauth_signature'] = $oauth_signature;

  $header = array(
      buildAuthorizationHeader($oauth),
      'X-Yahoo-App-Id: ' . $app_id
  );
  $options = array(
      CURLOPT_HTTPHEADER => $header,
      CURLOPT_HEADER => false,
      CURLOPT_URL => $url . '?' . http_build_query($query),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false
  );

  $ch = curl_init();
  curl_setopt_array($ch, $options);
  $response = curl_exec($ch);
  curl_close($ch);

  //print_r($response);
  $return_data = json_decode($response);
  //print_r($return_data);
  //$a= ($return_data->current_observation->atmosphere);
   
      echo json_encode(array(
        'json_info' => $return_data,
        
      ));
  die();

  }

  if( isset($_POST['city']) ) {
      get_info($_POST['city']);
  } else {
      die("Solicitud no válida.");
  }


  exit();