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
    <script src="https://get.mavo.io/stable/mavo.es5.min.js"></script>
    <script src="https://get.mavo.io/stable/mavo.es5.min.js"></script>
    <script src="https://codepen.io/username/pen/aBcDef.css"></script>
    <link rel="stylesheet" href="https://codepen.io/username/pen/aBcDef.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700;800&family=Poppins:wght@200;300;400;500;600;700&display=swap">

    <link rel="stylesheet" href="../assets/css/admin.css">

    <style>
       /* Style the tab */
.tab {
  overflow: hidden;
  background-color: black;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
  color: #ffaf08;
  border: 1px solid #ffaf08;
  border-radius: 5px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ffaf08;
  color: black;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ffaf08;
  color: black;
}

/* Style the tab content */
.tabcontent {

  padding: 6px 12px;
  border: 1px solid #ffaf08;
  border-radius: 5px;
  border-top: none;
}
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #ffaf08;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: black;
  border: 2px solid #ffaf08;
  color: #ffaf08;
}

div.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
.full { width: 100%; 
        padding: 10px;}

.full tr:hover {background-color: #ddd;
color: black;
}

.full th {
  padding-top: 12px;
  padding-bottom: 12px;
  background-color: #ffaf08;
  color: black;
}
.full tr{
  text-align: center;
  padding: 10px;
}
    </style>
    <title>Admin Panel</title>
</head>

<body>
    
    <?php include 'top.php';?>

    <!-- MAIN -->
    <main>
        <h1 class="title">Chatbot</h1>
        <ul class="breadcrumbs">
            <li><a href="index">Home</a></li>
            <li class="divider">/</li>
            <li><a href="view-category" class="active">View Customer's Chat</a></li>
        </ul>
        <section class="orders">
        <div class="wrapper">

        <!--Chatbot tabs-->
        <div class="tabs-wrapper">
        <div class="tab">
        <button class="tablinks active" onclick="openCity(event, 'Settings')">Settings</button>
        <button class="tablinks" onclick="openCity(event, 'Response')">Response List</button>
        <button class="tablinks" onclick="openCity(event, 'Unanswered')">Unanswered List</button>
        </div>

         <div id="Settings" class="tabcontent">
             <br><h3>Chatbot Information</h3>
             <br><form action="/action_page.php">
    <label for="chatbot_name">Chatbot Name</label>
    <input type="text" id="chatbot_name" name="chatbot_name" placeholder="Chatbot Name" value="Amarah's Corner">

    <label for="intro">Introduction Message</label>
    <input type="text" id="intro" name="intro" placeholder="Introduction Message" value="Hi! I'm Era, a ChatBot of Amarah's Corner-Las Pinas. How can I help you?">

    <label for="noresult">No Result Message</label>
    <input type="text" id="noresult" name="noresult" placeholder="No Result Message" value="I am sorry. I can't understand your question. Please rephrase your question and make sure it is related to this site. Thank you :)">

    <label for="country">Upload Bot Avatar</label>
 <br>
  <input type="file" name="fileToUpload" id="fileToUpload">
 <br> 
    <input type="submit" value="UPDATE">
  </form>
         </div>

        <div id="Response" class="tabcontent" style="display:none">
             <br><h3>Response List</h3>
             <br><table class="full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Response</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <td>1</td>
                           <td>What is Pizza?</td>
                           <td>Pizza is a dish of Italian origin consisting of a usually round, flat base of leavened wheat-based dough topped with tomatoes, cheese, and often various ingredients.</td>
                           <td>
              <button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>
              <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
            </td>
                        </tr>
                      </tbody>
                </table>
              
        </div>

        <div id="Unanswered" class="tabcontent" style="display:none">
             <br><h3>Unanswered List</h3>
             <br><table class="full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Total Who Asks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <td>1</td>
                           <td>Bakit?</td>
                           <td>9<td>
              <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button>
              <button type="button" class="btn btn-success"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
            </td>
                        </tr>
                      </tbody>
                </table>
        </div>
        </section>
</main>
        
            <script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
        </script>




        <?php include 'bottom.php'?>

</body>

</html>