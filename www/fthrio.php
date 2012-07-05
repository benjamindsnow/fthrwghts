<?php
if(isset($_POST['req']))
  $req = $_POST['req'];
session_start();
if($_SESSION['winner']){
  $sock = open_socket();
  if($sock){
    switch($req){
      case "ack":
        socket_write($sock, "ack", 1024);
        $answer = socket_read($sock, 1024);
        echo $answer;
        break;
      case "f":
        socket_write($sock, "forward", 1024);
        break;
      case "r":
        socket_write($sock, "right", 1024);
        break;
      case "b":
        socket_write($sock, "backward", 1024);
        break;
      case "l":
        socket_write($sock, "left", 1024);
        break;
      case "s":
        socket_write($sock, "stop", 1024);
        break;
      case "x":
        socket_write($sock, "xx", 1024);
        break;
    }
    socket_close($sock);
  }
  else{
    echo false;
  }
}
  
function open_socket()
{
  $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  if ($sock === false) {
    return false;
  }
  else {
    if(socket_connect($sock, 'fthrwghts.dyndns.org', 81)){
      socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 15, 'usec' => 0));
      return $sock;
    }
    else{
      $errorcode = socket_last_error();
      $errormsg = socket_strerror($errorcode);
      echo $errormsg;
      return false;
    }
  }
}
?>