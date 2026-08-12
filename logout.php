<?php

session_start();

// تدمير الـ Session
session_unset();
session_destroy();

// التوجيه إلى صفحة Login
header('Location: login.php');
exit;