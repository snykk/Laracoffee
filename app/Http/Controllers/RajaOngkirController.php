<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RajaOngkirController extends Controller
{
    function _ongkir_post($origin, $destination, $weight, $courier)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: " . env("API_RAJAONGKIR")
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }


    function _ongkir_get($data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/" . $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: " . env("API_RAJAONGKIR")
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return  $err;
        } else {
            return $response;
        }
    }


    public function province()
    {
        $province = $this->_ongkir_get('province');
        $data = json_decode($province, true);
        header("Content-Type: application/json");
        echo json_encode($data['rajaongkir']['results']);
    }

    public function city($province_id)
    {
        if (!empty($province_id)) {
            if (is_numeric($province_id)) {
                $city = $this->_ongkir_get('city?province=' . $province_id);
                $data = json_decode($city, true);
                echo json_encode($data['rajaongkir']['results']);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }


    public function cost($origin, $destination, $quantity, $courier)
    {
        $weight = (int)$quantity * 300; // 300 gram/pieces for every product
        $price = $this->_ongkir_post($origin, $destination, $weight, $courier);
        $data = json_decode($price, true);
        echo json_encode($data['rajaongkir']["results"]);
    }
}
