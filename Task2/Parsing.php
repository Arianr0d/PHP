<?php

# соединение с базой данных
function CONNECT_db() {
    # запись в переменные имени сервера, названия базы данных и логина и пароля пользователя для дальнейшего подключения к бд
    $servername = "localhost";
    $database = "database";
    $username = "root";
    $password = "root";
    $sql = "mysql:host=$servername;dbname=$database;";
    $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];      # режим сообщений об ошибках

    # проверка соединения с базой данных
    try {
        # соединение с базой данных MySQL с использованием PDO
        $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
        echo "Соединение выполнено успешно\n";
    }
    catch (PDOException $error) {
        echo 'Ошибка при установлении связи: ' . $error->getMessage() . "\n";
    }

    return $my_Db_Connection;
}

# добавление новых записей в таблицу cinema базы данных database
function ADD_data($xml, $my_Db_Connection) {

    $del_data = true;                                          # переменная, указывающая удалять записи таблицы или нет
    $cnt_recording = count($xml->database->table->column);      # количество новых записей на добавление в таблицу

    # проверка условия на удаление всех записей таблицы
    if($del_data = true) {
        # запрос на удаление всех записей таблицы cinema
        $del = $my_Db_Connection->prepare('TRUNCATE TABLE cinema');

        if ($del->execute()) {   # запуск подготовленного запроса
            echo "Все записи таблицы были успешно удалены\n";
        }
        else {
            echo " Невозможно удалить записи таблицы\n";
        }
    }

    # добавление записей в таблицу cinema
    for($j = 0; $j < $cnt_recording; $j++) {

        $id = $xml->database->table[$j]->column[0];
        $area = $xml->database->table[$j]->column[1];
        $address = $xml->database->table[$j]->column[2];
        $phone_Number = $xml->database->table[$j]->column[3];
        $number_Halls = $xml->database->table[$j]->column[4];
        $cinema_Name = $xml->database->table[$j]->column[5];

        # подготовка запроса на добавление новой записи
        $my_Insert_Statement = $my_Db_Connection->prepare(
            "INSERT INTO cinema (ID_Cinema,Area,Address,Phone_Number,Number_Halls,Cinema_Name) 
                            VALUES ('$id','$area','$address','$phone_Number','$number_Halls', '$cinema_Name')"
        );

        # проверка на успешность добавления новой записи
        if ($my_Insert_Statement->execute()) {
            echo $j . " Новая запись была успешно создана\n";
        } else {
            echo $j . " Невозможно создать новую запись\n";
        }

    }
}

# получение записей из таблицы cinema и добавление их в массив
function SELECT_data($xml, $my_Db_Connection) {
    $array_key = array("ID_Cinema", "Area", "Address", "Phone_Number", "Number_Halls", "Cinema_Name");   # массив с ключами
    $arr = [];                                                                                           # массив, который будет хранить все записи с соответствующими ключами

    $cnt_col_data = count($xml->database->table[0]->column);                                             # количество атрибутов сущности cinema

    # добавление записей в массив
    foreach ($my_Db_Connection->query('SELECT * FROM cinema') as $data) {

        $array_data = [];                                           # массив, хранящий ключи и значения одной записи
        for($i = 0; $i < $cnt_col_data; $i++) {
            $array_data[$array_key[$i]] = $data[$i];                # добавление по ключам записей
        }

        array_push($arr, $array_data);                       # добавление в общий массив массива с очередной записью

    }

    return $arr;
}

# создание json-файла
function CREATURE_json($data){
    $file = fopen('cinema.json', 'w+');       # открытие на запись файла
    $json = json_encode($data, JSON_PRETTY_PRINT);     # cоздание JSON-представления данных
    fwrite($file, $json);                                   # запись в файл
    fclose($file);                                          # закрытие файла
}


if (file_exists('cinema.xml')) {

    # интерпретирование XML-файла в объект
    $xml = simplexml_load_file('cinema.xml');

    $connect = CONNECT_db();
    ADD_data($xml , $connect);
    $data = SELECT_data($xml, $connect);
    CREATURE_json($data);
}