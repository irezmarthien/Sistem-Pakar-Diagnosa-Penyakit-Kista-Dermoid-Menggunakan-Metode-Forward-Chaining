<?php
include "../config/database.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM rule_detail WHERE id_rule = $id");
mysqli_query($conn, "DELETE FROM rules WHERE id_rule = $id");
header("Location: data_rules.php");
?>