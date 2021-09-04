<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$keyAPI = 'dfacaa08-8380-46c2-a591-b5c76cb329cc';
$obj = array();

$paramsCoord = array(
   'geocode' => $_POST['address'], // адрес
   'format'  => 'json',            // формат ответа
   'apikey'  => $keyAPI
);

$response = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?' . http_build_query($paramsCoord)), true); //, '', '&')), true);
// координаты указанного адреса

$coord = str_replace(' ', ', ', $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);
//$response->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);

$paramsMetro = array(
   'geocode' => $coord,      // адрес
   'format'  => 'json',      // формат ответа
   'results' => 1,           // количество выводимых результатов
   'apikey'  => $keyAPI,
   'kind'    => 'metro'      // вид необходимого топонима
);

$response = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?' . http_build_query($paramsMetro)), true); //, '', '&')), true);
$metro = $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
//$response->response->GeoObjectCollection->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->Address->formatted;

$obj['message'] = 'ok';
$obj['address'] = $_POST['address'];
$obj['coordinat'] = $coord;
$obj['metroAddress'] = $metro;

header('Content-type: application/json');
echo json_encode($obj);
