<?php
session_start();
session_unset();
session_destroy();
setcookie("loggedin", "", time() - 3600, '/');
header("Location: ../");