<?PHP

session_start();
session_destroy();
header('refresh:2; url= index.html');
echo "You're being redirected";

?>