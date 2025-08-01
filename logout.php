<?php
session_start();
session_unset();
session_destroy();

header("Location:  http://localhost:8080/event_registration/index.html"); 
exit();
?>
