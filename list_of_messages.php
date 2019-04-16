<?php 
  include('server.php');

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Messages</title>
    </head>
    <body>
        <div class="content">
            <table>
                <tr>
    	            <th>Title</th>
                    <th>From</th>
                    <th>message</th>
                    <th>Date</th>
                </tr>
            <?php
                //retrieving username
                $username = $_SESSION['username'];
                //retrieving cipher text
                $cipher = mysqli_query($db, 'select message from message where receiver="'.$username.'"');
                //decrypting
                $end_result = decrypt($key, $cipher);
                //listing the messages
                $list = mysqli_query($db, 'select title, sender, timestamp from message where receiver="'.$username.'"');
                while($dnn = mysqli_fetch_array($list) )
                    {
            ?>
                <tr>
                    <td><?php echo htmlentities($dnn['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo $dnn['sender'] ?></td>
                    <td><?php echo date('Y/m/d H:i:s' ,$dnn['timestamp']); ?></td>
                </tr>
            <?php
                    }
                
            ?>
            <?php
            while($dnn1 = mysqli_fetch_array($end_result) )
                    {
            ?>
                <tr>
                    <td><?php echo htmlentities($dnn1, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php
                    }
            ?>
            </table>
        </div>
        <div>
            <a href="profile.php" class='btn'>Return to your profile</a></div>
        </div>
    </body>
</html>