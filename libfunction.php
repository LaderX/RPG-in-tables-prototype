<?
    //Функция разбирает таблицу конфигурации
function parse_conftable($path){
    $delimiter = ';';
    $list_tables = [];
    $csv = file_get_contents($path);
    $rows = explode(PHP_EOL, $csv);
    foreach ($rows as $key => $value) {
        if(strripos($value, '#')){
            unset($rows[$key]);
        }
        else{
            $list_tables[] = explode($delimiter, $value);
        }
    }
    return $list_tables;
}


//Функция разбирает таблицу
function parse_table_data($name_table, $title_tables, $desc_table){
    $delimiter = ';';

    $csv = file_get_contents("tables/$name_table.csv");
    $rows = explode(PHP_EOL, $csv);
    $data = [];
    $data['title_tables'] = $title_tables;
    $data['desc_table'] = $desc_table;

    foreach ($rows as $row)
    {
        $data[] = explode($delimiter, $row);
    }

    return $data;
}

//Создаем и заполняем table _constructor
$list_tables = parse_conftable('config_table.conf');
$tables_constructor = [];
foreach ($list_tables as $key => $value) {
    $tables_constructor[$value[0]]=parse_table_data($value[0], $value[1], $value[2]);
}

?>