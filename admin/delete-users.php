<?php
require("../user/connexBDD.php");
include_once("../class/users.php");
include_once("./layouts/header.php");
?>

<h1>DELETE user</h1>
<?php 
if (isset($action[1])) {
    $users->deleteUser($action[1]); 
}
?>
<p>The User has been delete</p>
<a href="/admin/check-users.php">Users Page</a> 

<?php
include_once("./layouts/footer.php");
?>