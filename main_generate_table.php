<?
include 'libfunction.php';


foreach ($tables_constructor as $key => $value) {
    $title_tables = $value['title_tables'];
    $desc_table = $value['desc_table'];
    unset($value['title_tables']);
    unset($value['desc_table']);
    echo('<div class="separate-table">
            <div class="table-top">
                <H2 class="table-title">'.$title_tables.'</H2>
                <button class="spoil" value="'.$key.'-table"></button>
            </div>
            <div id="'.$key.'-table" class = "spoil-block">
            <div id="desc-table">'.$desc_table.'</div>
                <table id="'.$key.'" class="smartTable">');
    echo('<thead><tr>');
    foreach ($value[0] as $subvalue) {
        echo ('<th>'.trim($subvalue).'</th>');
    }
    echo('</tr></thead>');
    for ($i=1; $i < count($value)-1; $i++) { 
        echo('<tr>');
        foreach ($value[$i] as $subvalue) {
        echo ('<td>'.trim($subvalue).'</td>');
        }
        echo('</tr>');
        }
    echo("</table></div></div>");
}