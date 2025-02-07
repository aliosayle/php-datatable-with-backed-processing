<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP DataTable with Search Builder</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.0/css/searchBuilder.dataTables.min.css">
</head>
<body>
    <h2>PHP DataTable with Search Builder</h2>
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Country</th>
            </tr>
        </thead>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.3.0/js/dataTables.searchBuilder.min.js"></script>
    <script>
$(document).ready(function() {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'fetch_data.php', // Backend PHP file
            type: 'POST'
        },
        dom: 'Qlfrtip',  // Enables SearchBuilder ('Q' for SearchBuilder, 'lfrtip' for standard elements)
        searchBuilder: true,  // Ensure SearchBuilder is enabled
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'country' },
        ]
    });
});
    </script>
</body>
</html>
