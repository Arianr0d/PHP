<?php

//считывание ссылок из файла в массив
$data_link = file('input.txt');
//регулярное выражение 
$pattern = '/(http:\/\/)asozd\.duma\.(gov\.ru\/)main\.nsf\/\(Spravka\)\?OpenAgent&RN=((\d|-)+(&)(\d)+)/';
//вид возвращаемого результата
$replacement = '$1sozd.parlament.$2bill/$3';
$result = preg_replace($pattern, $replacement, $data_link);

//запись результата в файл
$file = fopen('output.txt', 'w');
for ($i = 0; $i < count($result); $i++) {
   fwrite($file, $result[$i]);
}
fclose($file);
