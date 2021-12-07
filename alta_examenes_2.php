<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Examenes</title>
    <script src="jquery-3.3.1.min.js"></script>
    <style type="text/css">
        table {
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 1px solid black;
        }

        .bitacoratable {
            height: 400px;
            overflow-y: auto;
            width: 220px;
            float: left;
        }

        #table1 {
            margin-right: 100px;
        }

        .childgrid tr {
            cursor: pointer;
        }

        .selectedRow,
        .selectedRow:active,
        .childgrid tr:active {
            background-color: #E7E7E7;
            cursor: move;
        }
    </style>
    <script>
        $("#table1 .childgrid tr, #table2 .childgrid tr").draggable({
            helper: function() {
                var selected = $('.childgrid tr.selectedRow');
                if (selected.length === 0) {
                    selected = $(this).addClass('selectedRow');
                }
                var container = $('<div/>').attr('id', 'draggingContainer');
                container.append(selected.clone().removeClass("selectedRow"));
                return container;
            }
        });

        $("#table1 .childgrid, #table2 .childgrid").droppable({
            drop: function(event, ui) {
                $(this).append(ui.helper.children());
                $('.selectedRow').remove();
            }
        });

        $(document).on("click", ".childgrid tr", function() {
            $(this).toggleClass("selectedRow");
        });
    </script>
</head>

<body>
    <div id="table1" class="bitacoratable">
        <table id="table1" class="childgrid">
            <tr class="draggable_tr">
                <td>1</td>
                <td>Student 1</td>
            </tr>
            <tr class="draggable_tr">
                <td>2</td>
                <td>Student 2</td>
            </tr>
            <tr class="draggable_tr">
                <td>3</td>
                <td>Student 3</td>
            </tr>
            <tr class="draggable_tr">
                <td>4</td>
                <td>Student 4</td>
            </tr>
            <tr class="draggable_tr">
                <td>5</td>
                <td>Student 5</td>
            </tr>
        </table>
    </div>

    <div id="table2" class="bitacoratable">
        <table id="table2" class="childgrid">
            <tr class="draggable_tr">
                <td>6</td>
                <td>Student 6</td>
            </tr>
            <tr class="draggable_tr">
                <td>7</td>
                <td>Student 7</td>
            </tr>
            <tr class="draggable_tr">
                <td>8</td>
                <td>Student 8</td>
            </tr>
            <tr class="draggable_tr">
                <td>9</td>
                <td>Student 9</td>
            </tr>
            <tr class="draggable_tr">
                <td>10</td>
                <td>Student 10</td>
            </tr>
        </table>
    </div>
</body>

</html>