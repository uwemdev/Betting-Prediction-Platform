<?php

session_start();
session_unset();
session_destroy();

setcookie( "rt", "", (time() - time()), "/" );

header("location:index.php");
exit();