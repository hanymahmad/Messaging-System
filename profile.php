<?php 
    session_start(); 

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
    <title>Profile</title>
</head>
<body>
    <div class="header">
	    <h2>Your Profile</h2>
    </div>
    <div class="content">
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
                <h3>
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <?php  if (isset($_SESSION['username'])) : ?>
            <p style="font-size:20px;">Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	    <a href="new_message.php" class="btn">Send a Message</a>
    	    <a href="list_of_messages.php" class="btn">View your Messages</a>
    	    <a href="users.php" class="btn">View all users and passwords</a>
    	    <a href="logout.php" class = 'btn' style="text-align: right;">logout</a>
        <?php endif ?>
    </div>	
</body>
</html>