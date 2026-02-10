<?php
$conn = new mysqli("benefit_mysql", "benefit_user", "benefit_pass", "benefit_db");
if ($conn->connect_error) die("DB Error");
session_start();
?>