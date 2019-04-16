<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Users</title>
    </head>
    <body>
        <div class="content">
            <h4><b>This is the list of members:</b></h4>
        <table>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        <?php
            $req = mysqli_query($db, 'select id, username, email, password from users');
            while($dnn = mysqli_fetch_array($req))
                {
        ?>
        <tr>
            <td><?php echo $dnn['id']; ?></td>
            <td><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlentities($dnn['password'], ENT_QUOTES, 'UTF-8'); ?></td>
        </tr>
        <?php
                }
        ?>
        </table>
		</div>
		<a href="profile.php" class='btn'>Your Profile</a>
	</body>
</html>