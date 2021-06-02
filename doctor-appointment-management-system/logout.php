<?php

//logout.php

session_start();
unset($_SESSION["patient_id"]);
session_destroy();

header("location:index.php");

?>