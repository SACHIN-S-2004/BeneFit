<?php
$conn = new mysqli("localhost", "root", "", "diet_system");
if ($conn->connect_error) die("DB Error");
session_start();
?>