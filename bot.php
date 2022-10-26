<?php


$conn = mysqli_connect("localhost","root","","theserve-amarah-s-corner-db");

if($conn){
$user_messages = mysqli_real_escape_string($conn, $_POST['messageValue']);

$query = "SELECT * FROM chatbot WHERE messages LIKE '%$user_messages%'";
$runQuery = mysqli_query($conn, $query);

if(mysqli_num_rows($runQuery) > 0){
    // fetch result
    $result = mysqli_fetch_assoc($runQuery);
    // echo result
    echo $result['response'];
}else{
    $sql ="INSERT INTO chatbot(messages, response)values('$user_messages', ' ')";
    $result = mysqli_query($conn, $sql);
    echo "Sorry can't be able to understand you! Amarah will set a response for this message.";
}
}else{
    echo "connection Failed " . mysqli_connect_errno();
}
?>