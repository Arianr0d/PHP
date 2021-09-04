<?php
$keyAPI = '';
$obs = array();

$paramsCoord = array(
   'geocode' => $_POST['address'], // адрес
   'format'  => 'json',            // формат ответа
   'apikey'  => $keyAPI
);

$response = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?' . http_build_query($paramsCoord, '', '&')), true);
// координаты указанного адреса

if ($response->response->GeoObjectCollection->metaDataProperty->GeocoderResponseMetaData->found > 0) {

   $coord = str_replace(' ', '.', $response->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);

   $paramsMetro = array(
      'geocode' => $coord,      // адрес
      'format'  => 'json',      // формат ответа
      'results' => 1,           // количество выводимых результатов
      'apikey'  => $keyAPI,
      'kind'    => 'metro'      // вид необходимого топонима
   );

   $response = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?' . http_build_query($paramsMetro, '', '&')), true);
   $metro = str_replace(' ', '.',  $response->response->GeoObjectCollection->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->Address->formatted);

   $obj['message'] = 'ok';
   $obj['address'] = $_POST['address'];
   $obs['coordinat'] = $coord;
   $obj['metroAddress'] = $metro;
} else {
   $obs['message'] = 'Указанный адресс не был найден';
}

echo json_encode($obj);
