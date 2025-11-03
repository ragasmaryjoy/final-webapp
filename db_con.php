<?php
// db_con.php

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'emarkethub_db';

try
(
 $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
)
die('Database connection failed; ' . $mysqli->myconn);
$mysqli->set_charset('utf8mb4');
 