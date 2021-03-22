<?php

session_start();

unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['message']);
unset($_SESSION['type']);
unset($_SESSION['avatar_image']);

session_destroy();

header("Location: ./index.php");