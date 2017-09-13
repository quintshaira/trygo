<?php
include("connection.php");

$sql="insert into report_dummy SET add_date='$CD'";
$qry=mysql_query($sql);

header("location:index.php");
exit;

?>