<?php
session_start();
if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] != true) {
    $_SESSION['link'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    header("Location: ./login");
} else {
    $admin_id = $_SESSION['admin_id'];
    $_SESSION['link'] = '';
}
require_once '../includes/database_conn.php';

$get_admin_info = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id = $admin_id");

$info = mysqli_fetch_array($get_admin_info);

$userProfileIcon = $info['profile_image'];
$admin_type = $info['admin_type'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <!-- datatable lib -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700;800&family=Poppins:wght@200;300;400;500;600;700&display=swap">

    <link rel="stylesheet" href="../assets/css/admin.css">

    <style>
        .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody::-webkit-scrollbar {
            width: 0px;
        }

        .dataTables_wrapper .dataTables_info {
            color: #936500 !important;
        }

        .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_filter label {
            color: #ffaf08;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ffaf08;
            color: #ffaf08;
        }

        table.dataTable thead {
            border-radius: 5px !important;
        }

        table.dataTable thead tr {
            background-color: #ffaf08;
            color: #070506;
            white-space: nowrap;
            font-weight: 900;
            text-transform: uppercase;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            background-color: #ffaf08 !important;
            color: #070506 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #070506 !important;
            border-color: #ffaf08;
            color: #ffaf08 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background-color: #936500 !important;
            color: #070506 !important;
        }

        .dataTables_wrapper .dataTables_length select {
            color: #ffaf08 !important;
            border-color: #936500;
            background: #070506 !important;
        }

        .dataTables_wrapper .dataTables_length label {
            color: #936500 !important;
        }

        table thead tr th:first-child {
            border-top-left-radius: 5px !important;
        }

        table thead tr th:last-child {
            border-top-right-radius: 5px !important;
        }
    </style>
    <title>Admin Panel</title>
</head>

<body>
    <input type="hidden" name="admin_type" id="admin_type" value="<?php echo $admin_type; ?>">
    <!-- TOAST -->
    <div class="toast" id="toast">
        <div class="toast-content" id="toast-content">
            <i id="toast-icon" class="fa-solid fa-triangle-exclamation warning"></i>

            <div class="message">
                <span class="text text-1" id="text-1"></span>
                <span class="text text-2" id="text-2"></span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress"></div>
    </div>

    <!-- DELETE -->
    <div id="popup-box" class="popup-box delete-modal">
        <div class="top">
            <h3>Delete Category</h3>
            <div id="modalClose" class="fa-solid fa-xmark"></div>
        </div>
        <hr>
        <form id="delete_category">
            <div style="display: none;" class="form-group">
                <span>Category ID</span>
                <input type="text" id="delete_category_id" name="delete_category_id" value="">
            </div>
            <p>Are you sure, you want to delete this category?</p>
        </form>
        <hr>
        <div class="bottom">
            <div class="buttons">
                <button id="modalClose" type="button" class="cancel">CLOSE</button>
                <button form="delete_category" id="deleteSubCategory" type="submit" class="save">DELETE</button>
            </div>

        </div>
    </div>

    <!-- UPDATE -->
    <div id="popup-box" class="popup-box edit-modal">
        <div class="top">
            <h3>Edit Store Open Hour Time</h3>
            <div id="modalClose" class="fa-solid fa-xmark"></div>
        </div>
        <hr>
        <form enctype="multipart/form-data" id="edit_open_hours">
            <input type="hidden" name="day_id" id="day_id">
            <div style="display: none;" class="form-group">
                <span>Day</span>
                <input type="text" id="day" name="day" value="">
            </div>
            <div class="form-group">
                <span>Open Hour</span>
                <input type="time" id="open_hour" name="open_hour" value="" required>
            </div>
            <div class="form-group">
                <span>Close Hour</span>
                <input type="time" id="close_hour" name="close_hour" value="" required>
            </div>
        </form>
        <hr>
        <div class="bottom">
            <div class="buttons">
                <button id="modalClose" type="button" class="cancel">CANCEL</button>
                <button form="edit_open_hours" type="submit" id="update_category" name="update_category" class="save">SAVE
                    CHANGES</button>
            </div>
        </div>
    </div>

    <?php include 'top.php';?>

    <!-- MAIN -->
    <main>
        <h1 class="title">View Store Open Hour Time</h1>
        <ul class="breadcrumbs">
            <li><a href="index">Home</a></li>
            <li class="divider">/</li>
            <li><a href="view-category" class="active">View Store Open Hour Time</a></li>
        </ul>
        <section class="view-category">
            <div class="wrapper">
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Open Hour</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>

        <script>
            if($('#admin_type').val() != 1) {
                $('#getInsert').hide();
                $('.edit-modal').hide();
                $('.delete-modal').hide();
            } else {
                $('#getInsert').show();
                $('.edit-modal').show();
                $('.delete-modal').show();
            }
        </script>

        <script>
            // DATA TABLES
            var dataTable = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "pagingType": "simple",
                "scrollX": true,
                "sScrollXInner": "100%",
                "aLengthMenu": [
                    [5, 10, 15, 100],
                    [5, 10, 15, 100]
                ],
                "iDisplayLength": 5,
                order: [[0, 'desc']],
                "ajax": {
                    url: "./functions/store-open-time-table",
                    type: "post"
                }
            });
        </script>

        <script>
            // GET EDIT
            $(document).on('click', '#getEdit', function (e) {
                e.preventDefault();
                var day_id_edit = $(this).data('id');
                $.ajax({
                    url: './functions/crud/store-open-time',
                    type: 'POST',
                    data: 'day_id_edit=' + day_id_edit,
                    success: function (res) {
                        var obj = JSON.parse(res);
                        $(".edit-modal").addClass("active");
                        $("#day_id").val(obj.day_id);
                        $("#open_hour").val(obj.open_hour);
                        $("#close_hour").val(obj.close_hour);
                        console.log(res);
                    }
                })
            });

            // GET DELETE
            $(document).on('click', '#getDelete', function (e) {
                e.preventDefault();
                // console.log('clicked');
                var day_id_remove = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/store-open-time",
                    data: 'day_id_remove=' + day_id_remove,
                    success: function (response) {
                        if(response == 'success') {
                            $('#example').DataTable().ajax.reload();
                        }
                        console.log(response);
                    }
                })
            });

            // CLOSE MODAL
            $(document).on('click', '#modalClose', function () {
                $('.edit-modal').removeClass("active");
                $('.view-modal').removeClass("active");
                $('.insert-modal').removeClass("active");
                $(".delete-modal").removeClass("active");
                $("#edit-category")[0].reset();
                $("#insert-category")[0].reset();
                $('#file').attr("src", '');
            })
        </script>

        <script>
            // SUBMIT EDIT
            $(document).ready(function () {
                $("#edit_open_hours").on('submit', function (e) {
                    e.preventDefault();
                    var form = new FormData(this);
                    form.append('update_open_hour_time', true);
                    $.ajax({
                        type: "POST",
                        url: "./functions/crud/store-open-time",
                        data: form,
                        dataType: 'text',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (response) {
                            if (response === 'success') {
                                $('.edit-modal').removeClass("active");
                                $('#toast').addClass('active');
                                $('.progress').addClass('active');
                                $('#toast-icon').removeClass(
                                    'fa-solid fa-triangle-exclamation').addClass(
                                    'fa-solid fa-check warning');
                                $('.text-1').text('Success!');
                                $('.text-2').text(
                                    'Open-Closed Hour Successfully Updated!'
                                );
                                setTimeout(() => {
                                    $('#toast').removeClass("active");
                                    $('.progress').removeClass("active");
                                }, 5000);
                                $('#example').DataTable().ajax.reload();
                                $("#edit-category")[0].reset();
                            } else {
                                $('#toast').addClass('active');
                                $('.progress').addClass('active');
                                $('.text-1').text('Error!');
                                $('.text-2').text('Something went wrong!');
                                setTimeout(() => {
                                    $('#toast').removeClass("active");
                                    $('.progress').removeClass("active");
                                }, 5000);
                                $('#example').DataTable().ajax.reload();
                            }
                            console.log(response);
                        }
                    })
                })
            });
        </script>


        <?php include 'bottom.php'?>

</body>

</html>