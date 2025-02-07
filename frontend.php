<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP DataTable with Search Builder and Column Visibility</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.dataTables.min.css">
    <script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>


</head>

<body>
    <h2>PHP DataTable with Search Builder</h2>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Number</th>
                <th>Weight</th>
                <th>Content</th>
                <th>Bol ID</th>
            </tr>
        </thead>
    </table>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.3.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>

    <script>
        $(document).ready(function () {
            // Define a mapping of header text to data column names
            var columnMapping = {
                'ID': 'id',
                'Number': 'number',
                'Weight': 'weight',
                'Content': 'content',
                'Bol ID': 'bol_id',
                // Add more mappings here as needed
            };

            // Get column headers and map them to the data fields
            var columnNames = [];
            $('#myTable th').each(function () {
                var headerText = $(this).text().trim();
                if (columnMapping[headerText]) {
                    columnNames.push(columnMapping[headerText]); // Use the mapped data field
                }
            });

            var tableName = 'containers';  // Define the table name

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'fetch_data.php', // Backend PHP file
                    type: 'POST',
                    data: function (d) {
                        // Send column names to the backend along with other request data
                        d.columns = columnNames;
                        d.tableName = tableName;
                    }
                },
                dom: 'QBlfrtip',  // Enables SearchBuilder ('Q' for SearchBuilder, 'lfrtip' for standard elements, 'B' for buttons)
                colReorder: true,  // Enable column rearranging
                searchBuilder: true,  // Ensure SearchBuilder is enabled
                columns: columnNames.map(function (col) {
                    return { data: col }; // Use the data column names for DataTable's 'data' property
                }),
                buttons: [
                    {
                        extend: 'colvis',
                        text: 'Column Visibility'
                    }
                ]
            });
        });
    </script>

</body>

</html>