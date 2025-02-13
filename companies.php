<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'layouts/session.php';
//include 'layouts/head-main.php';
include 'layouts/config.php';

if (!$link) {
    die("Connection not established: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['delete_message'])) {
    $alert_type = strpos($_SESSION['delete_message'], 'successfully') !== false ? 'success' : 'danger';
    echo "<div class='alert alert-$alert_type alert-dismissible fade show' role='alert'>" . htmlspecialchars($_SESSION['delete_message']) . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    unset($_SESSION['delete_message']); // Unset after displaying the message
}

// Fetch user permissions
$user_id = $_SESSION['id']; // Assuming user_id is stored in session
$permission_query = "SELECT canedit, candelete, canadd FROM users WHERE id = '$user_id'";
$permission_result = mysqli_query($link, $permission_query);
$permissions = mysqli_fetch_assoc($permission_result);


// Protect POST actions with permission checks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['company_name']) && $permissions['canadd'] == 1) {
    $company_name = mysqli_real_escape_string($link, $_POST['company_name']);
    $insert_query = "INSERT INTO companies (company_name) VALUES ('$company_name')";
    if (mysqli_query($link, $insert_query)) {
        echo "<script>alert('New company added successfully');</script>";
    } else {
        echo "<script>alert('Error adding company: " . mysqli_error($link) . "');</script>";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<script>alert('You do not have permission to add companies.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Companies Table | Admin Template</title>
    <?php //include 'layouts/head.php'; ?>
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.dataTables.min.css">
    <script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <?php // include 'layouts/head-style.php'; ?>

</head>

<body>
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-3">
                                    <li class="breadcrumb-item">Login</li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Companies
                                    </li>
                                </ol>
                            </nav>
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Companies Table</h4>
                                </div>
                                <div class="card-body">


                                    <table id="myTable" class="display w-full">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>All Quantity</th>
                                                <th>Total</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'layouts/vendor-scripts.php'; ?>

    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/libs/jszip/jszip.min.js"></script>
    <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/js/pages/dashboard.init.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.3.0/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>


<script>
    $(document).ready(function () {
        var columnMapping = {
            'Item': 'item',
            'All Quantity': 'allqty',
            'Total': 'total',
            'Description': 'descr1'
        };

        var columnNames = [];
        $('#myTable th').each(function () {
            var headerText = $(this).text().trim();
            if (columnMapping[headerText]) {
                columnNames.push(columnMapping[headerText]);
            }
        });

        var tableName = 'items';

        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'fetch_data.php',
                type: 'POST',
                data: function (d) {
                    d.columns = columnNames;
                    d.tableName = tableName;
                }
            },
            dom: 'QBlfrtip',
            colReorder: true,
            searchBuilder: true,
            columns: columnNames.map(function (col) {
                return { data: col };
            }).concat([{
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm" onclick="editCompany(${row.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteCompany(${row.id})">Delete</button>
                    `;
                },
                orderable: false
            }]),
            buttons: [
                {
                    text: 'Add New Company',
                    action: function () {
                        window.location.href = 'add_company.php';
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Column Visibility'
                },
                {
                    text: 'Save Search',
                    action: function (e, dt) {
                        var searchConfig = dt.searchBuilder.getDetails();
                        var searchName = prompt('Enter a name for this search configuration:');
                        if (searchName) {
                            $.ajax({
                                url: 'save_search.php',  // PHP file to save the search configuration
                                type: 'POST',
                                data: {
                                    searchName: searchName,
                                    searchConfig: JSON.stringify(searchConfig)
                                },
                                success: function (response) {
                                    if (response.success) {
                                        alert('Search configuration saved!');
                                    } else {
                                        alert('Error saving search configuration.');
                                    }
                                }
                            });
                        }
                    }
                },
                {
                    text: 'Load Search',
                    action: function (e, dt) {
                        $.ajax({
                            url: 'load_search.php',  // PHP file to load saved search configurations
                            type: 'GET',
                            success: function (response) {
                                if (response.savedSearches.length === 0) {
                                    alert('No saved search configurations found.');
                                    return;
                                }

                                var dropdown = $('<select id="savedSearchDropdown"></select>');
                                dropdown.append('<option value="">Select a search configuration</option>');
                                response.savedSearches.forEach(function (search, index) {
                                    dropdown.append('<option value="' + index + '">' + search.name + '</option>');
                                });

                                var modal = $('<div class="modal" tabindex="-1" role="dialog">' +
                                    '<div class="modal-dialog" role="document">' +
                                    '<div class="modal-content">' +
                                    '<div class="modal-header">' +
                                    '<h5 class="modal-title">Load Search Configuration</h5>' +
                                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                                    '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                    '</div>' +
                                    '<div class="modal-body"></div>' +
                                    '<div class="modal-footer">' +
                                    '<button type="button" class="btn btn-primary">Load</button>' +
                                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>');

                                modal.find('.modal-body').append(dropdown);
                                modal.find('.btn-primary').on('click', function () {
                                    var selectedSearchIndex = $('#savedSearchDropdown').val();
                                    if (selectedSearchIndex) {
                                        var selectedSearchConfig = response.savedSearches[selectedSearchIndex].config;
                                        dt.searchBuilder.rebuild(selectedSearchConfig);
                                        dt.draw();
                                        alert('Search configuration loaded!');
                                        modal.modal('hide');
                                    } else {
                                        alert('Please select a search configuration.');
                                    }
                                });

                                $('body').append(modal);
                                modal.modal('show');
                            }
                        });
                    }
                }
            ]
        });
    });

    function editCompany(companyId) {
        alert('Edit company ID: ' + companyId);
    }

    function deleteCompany(companyId) {
        if (confirm('Are you sure you want to delete this company?')) {
            alert('Deleted company ID: ' + companyId);
        }
    }
</script>

</body>

</html>
