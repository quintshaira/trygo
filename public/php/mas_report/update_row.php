<?php
include("connection.php");
//print "<pre>"; print_r($_POST); print "</pre>";exit;

$update_str="";
foreach($_POST as $k=>$v)
{
    if($k!='row_id')
    {
        $update_str.=$k."='".$v."', ";
    }
}

$sql="update report_dummy SET ".trim($update_str,', ')." Where id=".$_POST['row_id'];
$qry=mysql_query($sql);

header("location:index.php?row_id=".$_POST['row_id']);
exit;

?>
