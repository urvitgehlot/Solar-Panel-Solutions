<?php

session_start();

unset($_SESSION['logined']);
session_unset();
session_destroy();
header('Location: ./index.php');
exit();

?>