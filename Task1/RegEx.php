<?php

// считывание из файла входных строк в массив 
$input_data = file("input.txt");
//поиск по регулярному выражению с использованием callback-функции
$result = preg_replace_callback(
   '/\'[0-9]+\'/',  //регулярное выражение для поиска
   function ($matches) {
      // проверка на соответствие регулярному выражению и запись результата поиска в $matche
      preg_match('/[0-9]+/', $matches[0], $matche);
      return '\'' . ($matche[0] * 2) . '\'';
   },
   $input_data
);
// запись результата в файл
$file = fopen('output.txt', 'w');
for ($i = 0; $i < count($result); $i++) {
   fwrite($file, $result[$i]);
}
fclose($file);
