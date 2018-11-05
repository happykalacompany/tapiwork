<?php
namespace App\Utilities;
use GuzzleHttp\Client;
/**
 * 地图工具类
 */
class GaodeMaps{

    /**
     * @abstract 使用高德地图返回对应地址的经纬度
     * @param $address
     * @param $city
     * @param $state
     * @return mixed
     */
    public static function geocodeAddress($address, $city, $state){
        //拼接省市区的详细地址
        $address = urlencode($state.$city.$address);
        //获取高德应用的key
        $apiKey = config('services.gaode.ws_api_key');
        //拼接访问地址
        $url = 'https://restapi.amap.com/v3/geocode/geo?address='.$address.'&key='.$apiKey;

        //创建请求客户端
        $client = new Client();
        //发送请求并获取响应
        $geocodeResponse =  $client->get($url)->getBody();
        $geocodeData = json_decode($geocodeResponse);

        //初始化经纬度的值
        $coordinates['latitude'] = null;
        $coordinates['longtitude'] = null;
        //测试返回值的空值状态
        if(!empty($geocodeData) && $geocodeData->status && isset($geocodeData->geocodes) && isset($geocodeData->geocodes[0])){
            list($latitude,$longtitude) = explode(',', $geocodeData->geocodes[0]->location);
            $coordinates['latitude'] = $latitude;
            $coordinates['longtitude'] = $longtitude;
        }
        return $coordinates;

    }
}