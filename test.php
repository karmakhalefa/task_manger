<?php

require_once 'Database.php';

$db = Database::getInstance();

$connection = $db->getConnection();

echo "Connected successfully!";