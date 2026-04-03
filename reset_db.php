<?php
$mysqli = new mysqli("localhost", "root", "", "sicubit");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$mysqli->query("SET FOREIGN_KEY_CHECKS = 0;");
$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $table = $row[0];
    $mysqli->query("DROP TABLE IF EXISTS `$table`");
}
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1;");
echo "All tables dropped successfully.\n";
