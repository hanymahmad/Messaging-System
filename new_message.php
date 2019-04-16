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
        <title>New Message</title>
    </head>
    <body>
        <?php
            //Setting variables
            $form = true;
            $otitle = '';
            $orecip = '';
            $omessage = '';
            //Checking if the form has been sent
            if(isset($_POST['title'], $_POST['recip'], $_POST['message']))
                {
                    $otitle = $_POST['title'];
                    $orecip = $_POST['recip'];
                    $omessage = $_POST['message'];
                    $user = $_SESSION['username'];
                    //Removing slashes depending on the configuration
                    if(get_magic_quotes_gpc())
                        {
                            $otitle = stripslashes($otitle);
                            $orecip = stripslashes($orecip);
                            $omessage = stripslashes($omessage);
                        }
                    //Checking if all the fields are filled
                    if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='')
                        {
                            //Protecting the variables
                            $title = mysqli_real_escape_string($db, $otitle);
                            $recip = mysqli_real_escape_string($db, $orecip);
                            $message = mysqli_real_escape_string($db, nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8')));
                            //Checking if the recipient exists
                            $dn1 = mysqli_fetch_array(mysqli_query($db, 'select count(username) as recip, username as recipname, (select count(*) from message) as npm from users where username="'.$recip.'"'));
                            if($dn1['recip']==1)
                                {
                                    //Checking if the recipient is not the actual user
		            	            if($recip!=$user)
		            	                {
		            	                    $payload = $message;
		            	                    $garble = encrypt($key, $payload);
		            	                    //If all good we send the message
                                            if(mysqli_query($db, 'insert into message (title, sender, receiver, message, timestamp)values("'.$title.'","'.$user.'", "'.$recip.'", "'.$message.'", "'.time().'")') and mysqli_query($db, 'insert into messageenc (title, sender, receiver, message, timestamp)values("'.$title.'","'.$user.'", "'.$recip.'", "'.$garble.'", "'.time().'")'))
                                                {
        ?>
        <div class="message"><h4>The message has successfully been sent.</h4><br />
        <a href="profile.php" class='btn'>Return to your profile</a></div>
        <?php
                                                    $form = false;
                                                }
                                            else
                                                {
                                                    //Otherwise, we say that an error occured
                                                    $error = 'An error occurred while sending the message';
                                                }
                                        }
                                    else
		            	                {
			            	                //Otherwise, we say the user cannot send a message to himself
			            	                $error = 'You cannot send a message to yourself.';
		            	                }
                                }
                            else
                                {
                                    //Otherwise, we say the recipient does not exists
                                    $error = 'The recipient does not exists.';
                                }
                        }
                    else
                        {
                            //Otherwise, we say a field is empty
                            $error = 'A field is empty. Please fill of the fields.';
                        }
                }
        ?>
        <div class="content">
            <h1 style='text-align: center;'>New Message</h1>
            <form action="new_message.php" method="post">
                <b>Please fill the following form.</b><br/><br/>
                <label for="title">Title</label><br /><input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="title" /><br />
                <label for="recip">Recipient<span>(Username)</span></label><br /><input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>" id="recip" name="recip" /><br />
                <label for="message">Message</label><textarea cols="40" rows="5" id="message" name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br />
                <input type="submit" value="Send" />
            </form>
        </div>
        <div>
            <a href="profile.php" class='btn'>Return to your profile</a></div>
        </div>
        </body>
</html>