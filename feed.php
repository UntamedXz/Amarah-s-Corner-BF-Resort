
    <?php
$c_email = $_POST['email'];
$q_score = $_POST['quality'];
$feedback_txt = $_POST['suggestion'];

$conn = mysqli_connect('localhost', 'root', '', 'theserve-amarah-s-corner-db');
$query ="insert into feedback(email, quality_score, feedback)values('$c_email', '$q_score', '$feedback_txt')";
$result = mysqli_query($conn, $query);
if($result)
  echo 'Thank you for your feedback!';
else
die("Something terrible happened. Please try again. ");
?>
