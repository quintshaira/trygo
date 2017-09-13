<?php
try {
    $CONN = new PDO('mysql:host=localhost;dbname=bsc_work;charset=utf8mb4', 'root', '');
} catch(PDOException $ex) {
    die($ex->getMessage());
}

