<?php
session_start();
include('header.html');
echo "<script src='js/cam.js'></script>";
if($_COOKIE['winner']!=''){
  $winner = $_COOKIE['winner'];
  
  $con = mysql_connect('localhost','bensnow_fw','thunderdome')
    or die('Could not connect to the server!');
   
  mysql_select_db('bensnow_fw')
    or die('Could not select a database.');
    
  $sql = "SELECT winner, cat FROM round WHERE winner='$winner' AND end_timestamp IS NULL";
  $result = mysql_query($sql) or die('A error occured: ' . mysql_error());
  $count = mysql_num_rows($result);
  $result = mysql_fetch_assoc($result);
  $activeWinner = $result['winner'];
  $activeCat = $result['cat'];
  if($winner == $activeWinner){
    echo "<script src='js/fthrio.js'></script>";
    //if(!isset($_SESSION['winner']))
    echo "<script>fthrio('x');</script>";
    $_SESSION['winner'] = true;
    echo "<div class='row'>
            <div class='span6' id='stream'>
              <img src='http://dome.fthrwghts.com/mjpg/video.mjpg' alt='Camera Stream'>
              <h3>Use the arrow keys to control the ball and play with " . $activeCat . "</h3>
            </div>
          </div>";
  }
  else  
    echo "<div class='alert alert-info'>
            <button class='close' data-dismiss='alert'>×</button>
            <strong>This round is history:</strong> Thanks for playing.
          </div>";
}
else
  echo "<div class='alert'>
          <button class='close' data-dismiss='alert'>×</button>
          <strong>Kitties want cookies:</strong> Please make sure they are enabled.
        </div>";
include('footer.html');
?>
