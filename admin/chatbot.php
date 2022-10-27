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
            <h3>Delete Response</h3>
            <div id="modalClose" class="fa-solid fa-xmark"></div>
        </div>
        <hr>
        <form id="delete_chat">
            <div style="display: none;" class="form-group">
                <span>Chat ID</span>
                <input type="text" id="delete_chat" name="delete_chat" value="">
            </div>
            <p>Are you sure, you want to delete this Response?</p>
        </form>
        <hr>
        <div class="bottom">
            <div class="buttons">
                <button id="modalClose" type="button" class="cancel">CLOSE</button>
                <button form="delete_chat" id="deleteSubCategory" type="submit" class="save">DELETE</button>
            </div>

        </div>
    </div>

    <!-- ADD RESPONSE -->
    <div id="popup-box" class="popup-box add-modal">
        <div class="top">
            <h3>Add Response</h3>
            <div id="modalClose" class="fa-solid fa-xmark"></div>
        </div>
        <hr>
        <form enctype="multipart/form-data" id="add_chat">
            <div class="form-group" style="display: flex;">
                <span>Chat ID</span>
                <input type="text" style="border-radius: 5px; padding: 0 5px;" name="add_id" id="add_id"></input>
            </div>
            <div class="form-group">
                <span>Messages</span>
                <textarea style="border-radius: 5px; padding: 0 5px;" name="add_messages" id="add_messages" cols="20" rows="5"></textarea>
                <span class="error-text-update" style="color: #ffaf08; font-size: 13px; font-weight: 600;"></span>
            </div>
            <div class="form-group">
                <span>Response</span>
                <textarea style="border-radius: 5px; padding: 0 5px;" name="add_response" id="add_response" cols="20" rows="5"></textarea>
                <span class="error-text-update" style="color: #ffaf08; font-size: 13px; font-weight: 600;"></span>
            </div>
           
        </form>
        <hr>
        <div class="bottom">
            <div class="buttons">
                <button id="modalClose" type="button" class="cancel">CANCEL</button>
                <button form="add_chat" type="submit" id="add_chat" name="add_chat" class="save">ADD RESPONSE</button>
            </div>
        </div>
    </div>

    <!-- EDIT RESPONSE -->
    <div id="popup-box" class="popup-box edit-modal">
        <div class="top">
            <h3>Edit Response</h3>
            <div id="modalClose" class="fa-solid fa-xmark"></div>
        </div>
        <hr>
        <form enctype="multipart/form-data" id="update_chat">
            <div class="form-group" style="display: flex;">
                <span>Chat ID</span>
                <input type="text" style="border-radius: 5px; padding: 0 5px;" name="id" id="id"></input>
            </div>
            <div class="form-group">
                <span>Messages</span>
                <textarea style="border-radius: 5px; padding: 0 5px;" name="messages" id="messages" cols="20" rows="5"></textarea>
                <span class="error-text-update" style="color: #ffaf08; font-size: 13px; font-weight: 600;"></span>
            </div>
            <div class="form-group">
                <span>Response</span>
                <textarea style="border-radius: 5px; padding: 0 5px;" name="response" id="response" cols="20" rows="5"></textarea>
                <span class="error-text-update" style="color: #ffaf08; font-size: 13px; font-weight: 600;"></span>
            </div>
           
        </form>
        <hr>
        <div class="bottom">
            <div class="buttons">
                <button id="modalClose" type="button" class="cancel">CANCEL</button>
                <button form="update_chat" type="submit" id="update_chat" name="update_chat" class="save">SAVE
                    CHANGES</button>
            </div>
        </div>
    </div>

    <?php include 'top.php';?>

    <!-- MAIN -->
    <main>
        <h1 class="title">CHATBOT</h1>
        <ul class="breadcrumbs">
            <li><a href="index">Home</a></li>
            <li class="divider">/</li>
            <li><a href="chatbot" class="active">View Message & Response</a></li>
        </ul>
        <section class="view-category">
            <div class="wrapper">
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Messages</th>
                            <th>Response</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>

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
                    url: "./functions/chatbot-table",
                    type: "post"
                }
            });
        </script>

        <script>
              // GET ADD
              $(document).on('click', '#getAdd', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: './functions/crud/chatbot',
                    type: 'POST',
                    data: 'id=' + id,
                    success: function (res) {
                        var obj = JSON.parse(res);
                        $(".add-modal").addClass("active");
                        $("#id").val(obj.id);
                        $("#messages").val(obj.messages);
                        $("#response").val(obj.response);
                        console.log(res);
                    }
                })
            });
            // GET EDIT
            $(document).on('click', '#getEdit', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    url: './functions/crud/chatbot',
                    type: 'POST',
                    data: 'id=' + id,
                    success: function (res) {
                        var obj = JSON.parse(res);
                        $(".edit-modal").addClass("active");
                        $("#id").val(obj.id);
                        $("#messages").val(obj.messages);
                        $("#response").val(obj.response);
                        console.log(res);
                    }
                })
            });


            // GET DELETE
            $(document).on('click', '#getDelete', function (e) {
                e.preventDefault();
                $('.delete-modal').addClass('active');
                var updates_id = $(this).data('id');
                $("#delete_chat").val(id);
            });

            // CLOSE MODAL
            $(document).on('click', '#modalClose', function () {
                $('.edit-modal').removeClass("active");
                $('.add-modal').removeClass("active");
                $(".delete-modal").removeClass("active");
                $("#edit-chat")[0].reset();
                $("#insert_chat")[0].reset();
                $('#file').attr("src", '');
                $('.error-text').text('');
                $('.error-image').text('');
            })
        </script>

        <script>
            // SUBMIT EDIT
                $(document).ready(function () {
                $("#update_chat").on('submit', function (e) {
                    e.preventDefault();

                    if($('#messages').val() == '') {
                        $('.error-text-update').text('');
                    } else {
                        $('.error-text-update').text('');
                    } 

                    if($('#response').val() == '') {
                        $('.error-text-update').text('');
                    } else {
                        $('.error-text-update').text('');
                    } 

                    if($('.error-text-update').text() != '' && $('.error-image-update').text() != '') {
                        $('#toast').addClass('active');
                        $('.progress').addClass('active');
                        $('.text-1').text('Error!');
                        $('.text-2').text('Fill all required fields!');
                        setTimeout(() => {
                            $('#toast').removeClass("active");
                            $('.progress').removeClass("active");
                        }, 5000);
                    } else {
                        var form = new FormData(this);
                        form.append('update_chat', true);
                        $.ajax({
                            url: "./functions/crud/chatbot",
                            type: "POST",
                            data: form,
                            dataType: 'text',
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                if(data == 'success') {
                                    $('.edit-modal').removeClass("active");
                                    $('#toast').addClass('active');
                                    $('.progress').addClass('active');
                                    $('#toast-icon').removeClass(
                                        'fa-solid fa-triangle-exclamation').addClass(
                                        'fa-solid fa-check warning');
                                    $('.text-1').text('Success!');
                                    $('.text-2').text('Update updates successfully!');
                                    setTimeout(() => {
                                        $('#toast').removeClass("active");
                                        $('.progress').removeClass("active");
                                    }, 5000);
                                    $('#example').DataTable().ajax.reload();
                                    $('#update_chat')[0].reset();
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
                                console.log(data);
                            }
                        })
                    }
                })


                // SUBMIT DELETE
                $("#delete_chat").on('submit', function (e) {
                    e.preventDefault();
                    var form = new FormData(this);
                    form.append('delete_chat', true);
                    $.ajax({
                        type: "POST",
                        url: "./functions/crud/chatbot",
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
                                $('.text-2').text('Update deleted successfully!');
                                setTimeout(() => {
                                    $('#toast').removeClass("active");
                                    $('.progress').removeClass("active");
                                }, 5000);
                                $('#example').DataTable().ajax.reload();
                                $('#delete_chat')[0].reset();
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
                        }
                    })
                })
            });
        </script>


        <?php include 'bottom.php'?>

</body>

</html>