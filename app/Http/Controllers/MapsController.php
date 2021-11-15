<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\log;
use App\Models\City;


class MapsController extends Controller
{

    public function home(){
        $datos= City::where('estado', '=', 1)->get();
        return view('home', [
            "datos" => $datos,
        ]);
    }

    public function mapas()
    {

        if (isset($_POST['city'])) {
            $this->get_info($_POST['city']);
        } else {
            die("Solicitud no válida.");
        }
    }

    private function get_info($id)
    {


        // Copyright 2019 Oath Inc. Licensed under the terms of the zLib license see https://opensource.org/licenses/Zlib for terms.

        function buildBaseString($baseURI, $method, $params)
        {
            $r = [];
            ksort($params);
            foreach ($params as $key => $value) {
                $r[] = "$key=".rawurlencode($value);
            }

            return $method."&".rawurlencode($baseURI).'&'.rawurlencode(implode('&', $r));
        }

        function buildAuthorizationHeader($oauth)
        {
            $r = 'Authorization: OAuth ';
            $values = [];
            foreach ($oauth as $key => $value) {
                $values[] = "$key=\"".rawurlencode($value)."\"";
            }
            $r .= implode(', ', $values);

            return $r;
        }

        $url = 'https://weather-ydn-yql.media.yahoo.com/forecastrss';
        $app_id = 'KKVOnOvN';
        $consumer_key = 'dj0yJmk9VkwwaE5mbDhNR093JmQ9WVdrOVMwdFdUMjVQZGs0bWNHbzlNQT09JnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PThi';
        $consumer_secret = '80bbf474ed21ee368a02c27196a71a0187308a0e';

        $query = [
            'location' => $id,
            'format' => 'json',
            'u' => 'c', // puede ser f(imperial) o c(metrica)
        ];

        $oauth = [
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => uniqid(mt_rand(1, 1000)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0',
        ];

        $base_info = buildBaseString($url, 'GET', array_merge($query, $oauth));
        $composite_key = rawurlencode($consumer_secret).'&';
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $header = [
            buildAuthorizationHeader($oauth),
            'X-Yahoo-App-Id: '.$app_id,
        ];
        $options = [
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url.'?'.http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        if (is_null($response)) {

        }else{
            $response = '
                    {
                       "location":{
                          "woeid": 2502265,
                          "city":"Sunnyvale",
                          "region":" CA",
                          "country":"United States",
                          "lat":37.371609,
                          "long":-122.038254,
                          "timezone_id":"America/Los_Angeles"
                       },
                       "current_observation":{
                          "wind":{
                             "chill":59,
                             "direction":165,
                             "speed":8.7
                          },
                          "atmosphere":{
                             "humidity":76,
                             "visibility":10,
                             "pressure":29.68
                          },
                          "astronomy":{
                             "sunrise":"7:23 am",
                             "sunset":"5:7 pm"
                          },
                          "condition":{
                             "text":"Scattered Showers",
                             "code":39,
                             "temperature":60
                          },
                          "pubDate":1546992000
                       },
                       "forecasts":[
                          {
                             "day":"Tue",
                             "date":1546934400,
                             "low":52,
                             "high":61,
                             "text":"Rain",
                             "code":12
                          },
                          {
                             "day":"Wed",
                             "date":1547020800,
                             "low":51,
                             "high":62,
                             "text":"Scattered Showers",
                             "code":39
                          },
                          {
                             "day":"Thu",
                             "date":1547107200,
                             "low":46,
                             "high":60,
                             "text":"Mostly Cloudy",
                             "code":28
                          },
                          {
                             "day":"Fri",
                             "date":1547193600,
                             "low":48,
                             "high":61,
                             "text":"Showers",
                             "code":11
                          },
                          {
                             "day":"Sat",
                             "date":1547280000,
                             "low":47,
                             "high":62,
                             "text":"Rain",
                             "code":12
                          },
                          {
                             "day":"Sun",
                             "date":1547366400,
                             "low":48,
                             "high":58,
                             "text":"Rain",
                             "code":12
                          },
                          {
                             "day":"Mon",
                             "date":1547452800,
                             "low":47,
                             "high":58,
                             "text":"Rain",
                             "code":12
                          },
                          {
                             "day":"Tue",
                             "date":1547539200,
                             "low":46,
                             "high":59,
                             "text":"Scattered Showers",
                             "code":39
                          },
                          {
                             "day":"Wed",
                             "date":1547625600,
                             "low":49,
                             "high":56,
                             "text":"Rain",
                             "code":12
                          },
                          {
                             "day":"Thu",
                             "date":1547712000,
                             "low":49,
                             "high":59,
                             "text":"Scattered Showers",
                             "code":39
                          }
                       ]
                    }';
        }

        //print_r($response);
        $return_data = json_decode($response);



        //print_r($return_data);
        //$a= ($return_data->current_observation->atmosphere);

        $this->create_log($id,$return_data);

        echo json_encode([
            'json_info' => $return_data,

        ]);
        die();
    }

    private function create_log($ciduad = '',$return_data = '')
    {
        $registo = new log;
        $registo->city = $ciduad;
        $registo->json_responsive = json_encode($return_data);
        $registo->save();
    }

    public function history(){
        $datos= log::where('estado', '=', 1)->get();
        return view('history', [
            "datos" => $datos,
        ]);
    }

    public function info(){
                return view('info');
    }

}
