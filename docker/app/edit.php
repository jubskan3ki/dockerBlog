<?php 
    $host = 'database';
    $db   = 'php_dp';
    $root = 'root';
    $pass = 'password';
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $root, $pass);
    $msg = prompt("Edit your message", $all_blogs->content);
    $query = $pdo->prepare("UPDATE `content` SET `message` = :message WHERE ID = :id");
    $query->execute([
        ":id"=>id,
        ":message"=>$msg,
    ]);
?>  