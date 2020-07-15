<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблицы</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <main>
        <div class="all-table">
            <H1>Все таблицы:</H1>
            <span id="spoil-down-all">Свернуть все</span>
            <span id="spoil-up-all">Развернуть все</span>
            <? include('main_generate_table.php')?>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

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

            $('#spoil-down-all').click(function() {
                console.log("Все свернулось y")
                $('.spoil').each(function() {
                    if ($('#' + $(this).attr('value')).is(':visible')) {
                        $('#' + $(this).attr('value')).slideUp();
                        $(this).css('transform', 'rotate(-90deg)');
                    }

                });
            });

            $('#spoil-up-all').click(function() {
                console.log("Все раскрылось y")
                $('.spoil').each(function() {
                    if ($('#' + $(this).attr('value')).not(':visible')) {
                        $('#' + $(this).attr('value')).slideDown();
                        $(this).css('transform', 'none');
                    }
                });
            });
        });
    </script>

</body>

</html>