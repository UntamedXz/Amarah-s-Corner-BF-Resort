<?php
session_start();
if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] != true) {
    header("Location: ./login");
} else {
    $admin_id = $_SESSION['admin_id'];
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
        <form id="delete_admin">
            <div style="display: none;" class="form-group">
                <span>Category ID</span>
                <input type="text" name="admin_id" id="admin_id" value="<?php echo $admin_id; ?>">
                <input type="text" id="delete_admin_id" name="delete_admin_id" value="">
            </div>
            <p>Are you sure, you want to delete this user?</p>
        </form>
        <hr>
        <div class="bottom">
            <div class="buttons">
                <button id="modalClose" type="button" class="cancel">CLOSE</button>
                <button form="delete_admin" id="deleteSubCategory" type="submit" class="save">DELETE</button>
            </div>

        </div>
    </div>

    <!-- INSERT -->
    <div id="popup-box" class="popup-box insert-modal">
        <div class="top">
            <h3>INSERT USER</h3>
            <div id="modalClose" class="fa-solid fa-xmark"></div>
        </div>
        <hr>
        <form id="insert-user">
            <div class="form-group">
                <span>Name</span>
                <input type="text" id="insert_admin_name" name="insert_admin_name" value="">
                <span style="color: #fff; font-size: 13px; font-weight: 800;" class="error-name"></span>
            </div>
            <div class="form-group">
                <span>Username</span>
                <input type="text" id="insert_admin_username" name="insert_admin_username" value="">
                <span style="color: #fff; font-size: 13px; font-weight: 800;" class="error-username"></span>
            </div>
            <div class="form-group">
                <span>Password</span>
                <input type="password" id="insert_admin_password" name="insert_admin_password" value="">
                <span style="color: #fff; font-size: 13px; font-weight: 800;" class="error-password"></span>
            </div>
            <div class="form-group">
                <span>Admin Type</span>
                <select name="admin_type" id="admin_type">
                    <option value="">Select</option>
                    <?php
                    $get_admin_types = mysqli_query($conn, "SELECT * FROM admin_type");

                    foreach($get_admin_types as $type) {
                    ?>
                    <option value="<?php echo $type['admin_type_id']; ?>"><?php echo strtoupper($type['admin_type']); ?></option>
                    <?php
                    }
                    ?>
                </select>
                <span style="color: #fff; font-size: 13px; font-weight: 800;" class="error-type"></span>
            </div>
        </form>
        <hr>
        <div class="bottom">
            <div class="buttons">
                <button id="modalClose" type="button" class="cancel">CANCEL</button>
                <button form="insert-user" type="submit" id="insert_category_btn" name="insert_category_btn"
                    class="save">INSERT</button>
            </div>
        </div>
    </div>

    <?php include 'top.php';?>

    <!-- MAIN -->
    <main>
        <h1 class="title">View Users</h1>
        <ul class="breadcrumbs">
            <li><a href="index">Home</a></li>
            <li class="divider">/</li>
            <li><a href="users" class="active">View Users</a></li>
        </ul>
        <section class="view-category">
            <button id="getInsert" class="insert_cat" type="button"><i class="fa-solid fa-plus"></i> <span>ADD USER</span> </button>
            <div class="wrapper">
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Profile Image</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Admin Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>

        <script>
            if($('#admin_type').val() != 1) {
                $('#getInsert').hide();
                $('.delete-modal').hide();
            } else {
                $('#getInsert').show();
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
                "ajax": {
                    url: "./functions/users-table",
                    type: "post"
                }
            });

            // GET INSERT
            $(document).on('click', '#getInsert', function (e) {
                e.preventDefault();
                $('.insert-modal').addClass('active');
            });

            // GET DELETE
            $(document).on('click', '#getDelete', function (e) {
                e.preventDefault();
                var admin_id = $(this).data('id');
                $('.delete-modal').addClass('active');
                $('#delete_admin_id').val(admin_id);
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
            // SUBMIT INSERT
            $('#insert-user').on('submit', function (e) {
                e.preventDefault();

                if($('#insert_admin_name').val() == 0) {
                    $('#toast').addClass('active');
                    $('.progress').addClass('active');
                    $('.text-1').text('Error!');
                    $('.text-2').text('Input name!');
                    setTimeout(() => {
                        $('#toast').removeClass("active");
                        $('.progress').removeClass("active");
                    }, 5000);
                } else if ($('#insert_admin_username').val() == 0) {
                    $('#toast').addClass('active');
                    $('.progress').addClass('active');
                    $('.text-1').text('Error!');
                    $('.text-2').text('Input username!');
                    setTimeout(() => {
                        $('#toast').removeClass("active");
                        $('.progress').removeClass("active");
                    }, 5000);
                } else if($('#insert_admin_password').val() == 0) {
                    $('#toast').addClass('active');
                    $('.progress').addClass('active');
                    $('.text-1').text('Error!');
                    $('.text-2').text('Input password!');
                    setTimeout(() => {
                        $('#toast').removeClass("active");
                        $('.progress').removeClass("active");
                    }, 5000);
                } else if($('#admin_type').val() == "") {
                    $('#toast').addClass('active');
                    $('.progress').addClass('active');
                    $('.text-1').text('Error!');
                    $('.text-2').text('Set user type!');
                    setTimeout(() => {
                        $('#toast').removeClass("active");
                        $('.progress').removeClass("active");
                    }, 5000);
                } else {
                    var form = new FormData(this);
                    form.append('insert_user', true);
                    $.ajax ({
                        type: "POST",
                        url: "./functions/crud/user",
                        data: form,
                        dataType: 'text',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (response) {
                            if (response === 'success') {
                                $('.insert-modal').removeClass("active");
                                $('#toast').addClass('active');
                                $('.progress').addClass('active');
                                $('#toast-icon').removeClass(
                                    'fa-solid fa-triangle-exclamation').addClass(
                                    'fa-solid fa-check warning');
                                $('.text-1').text('Success!');
                                $('.text-2').text('Account successfully created!');
                                setTimeout(() => {
                                    $('#toast').removeClass("active");
                                    $('.progress').removeClass("active");
                                }, 5000);
                                $('#example').DataTable().ajax.reload();
                                $("#insert-user")[0].reset();
                            } else {
                                $('#toast').addClass('active');
                                $('.progress').addClass('active');
                                $('.text-1').text('Error!');
                                $('.text-2').text('Something went wrong!');
                                setTimeout(() => {
                                    $('#toast').removeClass("active");
                                    $('.progress').removeClass("active");
                                }, 5000);
                            }
                            console.log(response);
                        }
                    })
                }
            })

            // SUBMIT DELETE
            $("#delete_admin").on('submit', function (e) {
                e.preventDefault();
                var form = new FormData(this);
                form.append('delete_user', true);
                $.ajax({
                    type: "POST",
                    url: "./functions/crud/user",
                    data: form,
                    dataType: 'text',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        if (response === 'success') {
                            $('.delete-modal').removeClass("active");
                            $('#toast').addClass('active');
                            $('.progress').addClass('active');
                            $('#toast-icon').removeClass(
                                'fa-solid fa-triangle-exclamation').addClass(
                                'fa-solid fa-check warning');
                            $('.text-1').text('Success!');
                            $('.text-2').text('User deleted successfully!');
                            setTimeout(() => {
                                $('#toast').removeClass("active");
                                $('.progress').removeClass("active");
                            }, 5000);
                            $('#example').DataTable().ajax.reload();
                        } else if(response === 'failed') {
                            $('#toast').addClass('active');
                            $('.progress').addClass('active');
                            $('.text-1').text('Error!');
                            $('.text-2').text('You can\'t delete your own account!');
                            setTimeout(() => {
                                $('#toast').removeClass("active");
                                $('.progress').removeClass("active");
                            }, 5000);
                        } else {
                            $('#toast').addClass('active');
                            $('.progress').addClass('active');
                            $('.text-1').text('Error!');
                            $('.text-2').text('Something went wrong!');
                            setTimeout(() => {
                                $('#toast').removeClass("active");
                                $('.progress').removeClass("active");
                            }, 5000);
                        }
                        console.log(response);
                    }
                })
            })
        </script>


        <?php include 'bottom.php'?>

</body>

</html>