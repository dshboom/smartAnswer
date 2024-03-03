<?php
$servername = "localhost";
$username = "askLyb";
$password = 'password';
$database = "askLyb";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("连接数据库失败: " . $conn->connect_error);
} 
// 使用 sql 创建数据表
$sql = 
"
CREATE TABLE IF NOT EXISTS messages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
if ($conn->query($sql) == 0) 
{
    die("创建数据表错误: " . $conn->error);
}
$sql = 
"
CREATE TABLE IF NOT EXISTS MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL)
";
if ($conn->query($sql) == 0) 
{
    die("创建数据表错误: " . $conn->error);
}
?>