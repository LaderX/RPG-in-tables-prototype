<?

function parse_conftable($path){
    $csv = file_get_contents($path);
    $list_tables = explode(PHP_EOL, $csv);  
}

$delimiter = ';';
$file_test = 'complexity';

$csv = file_get_contents("tables/$file_test.csv");
$rows = explode(PHP_EOL, $csv);
$data = [];

foreach ($rows as $row)
{
  $data[] = explode($delimiter, $row);
}

// print_r($data);
?>

<div id="<?= $file_test ?>" class="separate-table">
    <div class="table-top">
        <H2 class="table-title">Сложность броска</H2>
        <button class="spoil" value="containers-table"></button>
    </div>
    <div id="containers-table">
        <table id="containers">
            <thead>
                <tr>
                    <? 
                                   foreach ($data[0] as $value) {
                                       echo ("<th>$value</th>");
                                   }
                                ?>
                </tr>
            </thead>
            <tbody>
                <? 
                                   for ($i=1; $i < count($data); $i++) { 
                                       echo('<tr>');
                                       foreach ($data[$i] as $value) {
                                        echo ("<td>$value</td>");
                                    }
                                    echo('</tr>');
                                   }
                                ?>
            </tbody>
        </table>
    </div>
</div>