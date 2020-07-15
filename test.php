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
//Функция модифицирует полученную строку в соответсвии с ее триггером
function modify_td_content($string){
    $need_modify = true;
    $modify_string['value'] = $string;
    while ($need_modify){
        if(false){
            strstr($modify_string['value'], 'desc::');
            $string = trim($string, 'desc::');
            $desc_title = substr($string, 0, strpos($string, "$"));
            $desc_content = substr($string, strpos($string, "$")+1);
            $modify_string['value'] =  '<a tabindex="0" class="info-button" role="button" data-toggle="modal" data-target="#exampleModal" data-trigger="click hover focus" title="'.trim($desc_title).' '.trim($desc_content).'" data-title="'.trim($desc_title).'" data-content="'.trim($desc_content).'"></a>';
        }
        else if(strstr($modify_string['value'], 'modalinfo::')){
            preg_match("/\(modalinfo::(.*)\)/", $modify_string['value'], $string_in);
            preg_match("/(.*)\\$\\%(.*)\\$\\%(.*)/", $string_in[1], $string_arr);
            $modify_string['value'] = '<a tabindex="0" class="info-button" role="button" data-toggle="modal" data-target="#exampleModal" data-trigger="click hover focus" title="'.trim($string_arr[1]).' '.trim($string_arr[2]).'" data-title="'.trim($string_arr[1]).'" data-content="'.trim($string_arr[2]).'<hr>'.trim($string_arr[3]).'"></a>';
        }
        else if(strstr($modify_string['value'], 'money::')){
            preg_match("/\(money::\W*([0-9]+)(\W*)\\$\\%\W([0-9]+)\)/m", $modify_string['value'], $string_arr);
            $modify_string['value'] = '<!-- '.$string_arr[1]*$string_arr[3].' -->'.$string_arr[1].$string_arr[2];
            $modify_string['data-sort'] = 'data-sort='.$string_arr[1]*$string_arr[3];
        }       
        else{
            $need_modify = false;
        }
    }
    // print_r($modify_string);
    // echo ('<hr>');
    return $modify_string;   
}
// function modify_td_content($string){
//     if(strstr($string, 'desc::')){
//         $string = trim($string, 'desc::');
//         $desc_title = substr($string, 0, strpos($string, "$"));
//         $desc_content = substr($string, strpos($string, "$")+1);
//         return '<a tabindex="0" class="info-button" role="button" data-toggle="modal" data-target="#exampleModal" data-trigger="click hover focus" title="'.trim($desc_title).' '.trim($desc_content).'" data-title="'.trim($desc_title).'" data-content="'.trim($desc_content).'"></a>';
//     }else{
//         return $string;
//     }
// }

// print_r(parse_conftable('config_table.conf'));
$list_tables = parse_conftable('config_table.conf');
$tables_constructor = [];

foreach ($list_tables as $key => $value) {
    $tables_constructor[$value[0]]=parse_table_data($value[0], $value[1], $value[2]);
}

// print_r($tables_constructor);

// foreach ($tables_constructor as $key => $value) {
//     echo('<div id="'.$file_test.'" class="separate-table">
//             <div class="table-top">
//                 <H2 class="table-title">Сложность броска</H2>
//                 <button class="spoil" value="containers-table"></button>
//             </div>
//             <div id="containers-table">
//                 <table id="containers">');
//         for ($i=0; $i < count($value); $i++) { echo('<tr>');
//             foreach ($value[$i] as $subvalue) {
//             echo ("<td>$subvalue</td>");
//             }
//             echo('</tr>');
//             }
//         echo("</table>");
//     }
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body>
    <!-- Эксперемент с модалкой -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <!-- footer -->
                </div>
            </div>
        </div>
    </div>
    <!-- Конец -->


    <div class="bar">
        <a type="button" class="switch-bar"></a>
        <ul>
            <!-- <li><a href=""></a></li> -->
            <?foreach ($tables_constructor as $key => $value) {
                    echo('<li><a href="#'.$key.'-head">'.$value['title_tables'].'</a></li>');
                }?>
        </ul>
    </div>
    <main>
        <div class="all-table">
            <H1>Все таблицы:</H1>
            <span id="spoil-down-all">Свернуть все</span>
            <span id="spoil-up-all">Развернуть все</span>
            <div id="accordion">
                <? 
            foreach ($tables_constructor as $key => $value) {
                $title_tables = $value['title_tables'];
                $desc_table = $value['desc_table'];
                unset($value['title_tables']);
                unset($value['desc_table']);
                echo('<div class="card">
                <div class="card-header" id="'.$key.'-head">
                    <h2 class="mb-0 clickability" data-toggle="collapse" data-target="#'.$key.'-clipping" aria-expanded="true" aria-controls="'.$key.'-clipping">
                        '.$title_tables.'
                    </h2>
                </div>

                <div id="'.$key.'-clipping" class="table-responsive collapse show" aria-labelledby="'.$key.'-head">
                <div class="panel panel-default">
            <div class="panel-heading" role="tab">
                <span class="panel-title">
                    <a id="accordionformatText" role="button" data-toggle="collapse" href="#formatText">
                        <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Открыть/Скрыть описание
                    </a>
                </span>
            </div>
            <div id="formatText" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body">
                '.$desc_table.'
                </div>
            </div>
        </div>');
                echo('<table class="table table-striped table-bordered table-sm table-hover smartTable"><thead><tr>');
                foreach ($value[0] as $subvalue) {
                    echo ('<th>'.trim($subvalue).'</th>');
                }
                echo('</tr></thead>');
                for ($i=1; $i < count($value); $i++) { 
                    echo('<tr>');
                    foreach ($value[$i] as $subvalue) {
                    $after_modify=  modify_td_content($subvalue);
                    echo ('<td '.$after_modify['data-sort'].'>'.trim($after_modify['value']).'</td>');
                    }
                    echo('</tr>');
                    }
                echo("</table></div></div>");
    }?>
            </div>
        </div>

        <!-- <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Разворачиваемая панель #1
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>
        </div> -->


        <!-- <div class="panel panel-default">
            <div class="panel-heading" role="tab">
                <h4 class="panel-title">
                    <a id="accordionformatText" role="button" data-toggle="collapse" href="#formatText">
                        <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Открыть/Скрыть описание
                    </a>
                </h4>
            </div>
            <div id="formatText" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body">
                    Некоторые особые способности и опасности окружающей среды, такие как недоедание и длительное воздействие очень низких или высоких температур, могут стать причиной состояния, называемого истощением. Истощение делится на шесть степеней. Эффект даёт существу ту или иную степень истощения, согласно описанию.<br>Если существо, уже находящееся в состоянии истощения, подвергается воздействию другого эффекта, вызывающего истощение, его текущая степень истощения повышается на значение, указанное в описании эффекта.<br> На существо воздействуют эффекты не только текущей степени истощения, но и более слабых степеней. Например, существо на 2 степени истощения перемещается в два раза медленнее и совершает с помехой проверки характеристик.<br> Эффект, снимающий истощение, понижает его степень согласно описанию эффекта, вплоть до окончания действия истощения, если степень истощения существа становится ниже 1.<br> Продолжительный отдых снижает степень истощения на 1, при условии, что существо что-нибудь съесть и выпьет.
                </div>
            </div>
        </div> -->

        <!-- <button type="button" class="info-button" data-toggle="popover" data-placement="left" title="Таран, портативный. Вы можете вышибать портативным тараном двери. Вы получаете бонус +4 к проверкам Силы. Если другой персонаж помогает вам использовать таран, вы совершаете проверку с преимуществом. ">
        </button>

        <a href="#" tabindex="0" class="info-button" role="button" data-toggle="popover" data-trigger="focus" title="Таран, портативный." data-content="Таран, портативный. Вы можете вышибать портативным тараном двери. Вы получаете бонус +4 к проверкам Силы. Если другой персонаж помогает вам использовать таран, вы совершаете проверку с преимуществом."></a> -->
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="popper.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>



    <script>
        $(document).ready(function() {
            var table1 = $('table.smartTable').DataTable({
                "paging": false,
                "language": {
                    "search": "Найти значение:"
                },
                fixedColumns: true,
                "info": false,

            });

            function spoil(element) {
                if ($('#' + element.attr('value')).is(':visible')) {
                    $('#' + element.attr('value')).slideUp();
                    element.css('transform', 'rotate(-90deg)');
                } else {
                    $('#' + element.attr('value')).slideDown();
                    element.css('transform', 'none');
                }

            }

            $('.spoil').click(function() {
                console.log("y")
                spoil($(this))
            });

            // $('#spoil-down-all').click(function() {
            //     console.log("Все свернулось y")
            //     $('.spoil').each(function() {
            //         if ($('#' + $(this).attr('value')).is(':visible')) {
            //             $('#' + $(this).attr('value')).slideUp();
            //             $(this).css('transform', 'rotate(-90deg)');
            //         }

            //     });
            // });

            $('#spoil-down-all').click(function() {
                console.log("Все свернулось y");
                $('.collapse').collapse('hide');
            });

            // $('#spoil-up-all').click(function() {
            //     console.log("Все раскрылось y")
            //     $('.spoil').each(function() {
            //         if ($('#' + $(this).attr('value')).not(':visible')) {
            //             $('#' + $(this).attr('value')).slideDown();
            //             $(this).css('transform', 'none');
            //         }
            //     });
            // });

            $('#spoil-up-all').click(function() {
                console.log("Все раскрылось y");
                $('.collapse').collapse('show');
            });

            $('.switch-bar').click(function() {
                if ($('.bar').css('left') == '0px') {
                    $('.bar').css('left', '-200px')
                } else {
                    $('.bar').css('left', '0px')
                }
            });

            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });

            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var title = button.data('title')
                var desc = button.data('content')
                var modal = $(this)
                modal.find('.modal-title').text(title)
                modal.find('.modal-body').html(desc)
            })
        });
    </script>

</body>

</html>