<?php

error_reporting(E_ALL ^ E_WARNING);

$seed = '';

$con = mysql_connect('localhost','','')
  or die('Could not connect to the server!');
 
mysql_select_db('')
  or die('Could not select a database.');

if(isset($_POST['timestamp']) and isset($_POST['cat'])){
  $timestamp = $_POST['timestamp'];
  $cat = $_POST['cat'];
  $hash = substr(md5($timestamp . $cat . $seed), 0, 8);
  $sql = "SELECT end_timestamp FROM round WHERE end_timestamp IS NULL";
  $result = mysql_query($sql) or die('A error occured: ' . mysql_error());
  $count = mysql_num_rows($result);
  include 'header.html';
  if($count < 1){ // new round
    echo "<a href='tweet?hash=" . $hash . "'>New round</a>";
    $sql = "INSERT INTO round (hash, hash_active, cat) VALUES ('$hash', '1', '$cat')";
    $result = mysql_query($sql) or die('A error occured: ' . mysql_error());
  }
  else if($count > 0){ // end of round
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
    $sql = "UPDATE round SET hash_active='0', end_timestamp=NOW() WHERE end_timestamp IS NULL";
    mysql_query($sql) or die('A error occured: ' . mysql_error());
  }
  include 'footer.html';
}
else if(isset($_GET['hash'])){
  $hash = $_GET['hash'];
  $sql = "SELECT round_id FROM round WHERE hash='$hash' AND hash_active='1'";
  $result = mysql_query($sql) or die('A error occured: ' . mysql_error());
  $activeRound = mysql_fetch_assoc($result);
  $activeRound = $activeRound['round_id'];
  if ($activeRound != ''){ //winner
    $winner = substr(md5(time() . $seed), 0, 8);
    $sql = "UPDATE round SET hash_active='0', winner='$winner' WHERE round_id='$activeRound'";
    $result = mysql_query($sql) or die('A error occured: ' . mysql_error());
    setcookie('winner',$winner,time() + (60 * 30),'/','fthrwghts.com');
    header('Location: play', true, 307); //redirect
  }
  else{ //loser
    include 'header.html';
    echo "<div class='alert alert-info'>
            <button class='close' data-dismiss='alert'>×</button>
            <strong>This round has already been claimed:</strong> Better luck next time.
          </div>";
    include 'footer.html';
  }
}
else
  header('Location: /', true, 307); //redirect
?>
