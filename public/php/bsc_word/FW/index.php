<?php
include("connection.php");
if(0)
{
    $row=10;
    $table="B1";
    for($i=1;$i<=$row;$i++)
    {
        print "ALTER TABLE `report_dummy` ADD `".$table."_".$i."` VARCHAR( 50 ) NOT NULL; "; print "<br>";
    }

    $row=4;
    $table="B2a";
    for($i=1;$i<=$row;$i++)
    {
        print "ALTER TABLE `report_dummy` ADD `".$table."_".$i."` VARCHAR( 50 ) NOT NULL; "; print "<br>";
    }

    $row=1;
    $table="B2b";
    for($i=1;$i<=$row;$i++)
    {
        print "ALTER TABLE `report_dummy` ADD `".$table."_".$i."` VARCHAR( 50 ) NOT NULL; "; print "<br>";
    }

    $row=18;
    $table="B2c";
    for($i=1;$i<=$row;$i++)
    {
        print "ALTER TABLE `report_dummy` ADD `".$table."_".$i."` VARCHAR( 50 ) NOT NULL; "; print "<br>";
    }

    $row=12;
    $table="C1";
    for($i=1;$i<=$row;$i++)
    {
        print "ALTER TABLE `report_dummy` ADD `".$table."_".$i."` VARCHAR( 50 ) NOT NULL; "; print "<br>";
    }

    $row=1;
    $table="C2";
    for($i=1;$i<=$row;$i++)
    {
        print "ALTER TABLE `report_dummy` ADD `".$table."_".$i."` VARCHAR( 50 ) NOT NULL; "; print "<br>";
    }
    exit;

}
$sql="select id,report_name,add_date,name_FA,MQ_from,MQ_to from report_dummy order by id asc";
$qry=mysql_query($sql);

if($_GET['row_id'])
{
    $sql1="select * from report_dummy where id=".$_GET['row_id'];
    $rrow=mysql_fetch_assoc(mysql_query($sql1));
}

$row_update_test=0;
?>
<div style="float:left; width: 45%; overflow-y: scroll; height: 700px;">
    <table border="1">
        <tr>
            <td>report_name</td>
            <td>date</td>
            <td>Name of FA</td>
            <td>MQ</td>
            <td><a href="add_row.php" style="text-decoration: none;"><input type="button" value="Add Row"></a></td>
        </tr>
           <?php
           while($row=mysql_fetch_assoc($qry))
           {
               ?>
        <tr>
               <td><?php print $row['report_name']; ?></td>
               <td><?php print $row['add_date']; ?></td>
               <td><?php print $row['name_FA']; ?></td>
               <td><?php print $row['MQ_from']; ?> to <?php print $row['MQ_to']; ?></td>
               <td>
                   <a href="index.php?row_id=<?php print $row['id']; ?>" style="text-decoration: none;"><input type="button" value="Edit Row"></a>
                   <a href="gen_report.php?row_id=<?php print $row['id']; ?>" style="text-decoration: none;"><input type="button" value="Report"></a>
               </td>
        </tr>
               <?php
               $row_data[$row[id]]=$row;
           }
           ?>
    </table>
</div>
<form action="update_row.php" method="post">
    <input type="hidden" value="<?php print $_GET['row_id']; ?>" name="row_id">
<div style="float:left; width: 45%; overflow-y: scroll; height: 700px;">
    <table border="1">
        <?php foreach($rrow as $k=>$v) {
            if($k!='id' && $k!='add_date'){
                $val=($row_update_test)?"{"."$".$k."}":$v;
            ?>
            <tr>
                <td><?php print $k; ?></td>
                <td><input type="text" name="<?php print $k; ?>" value="<?php print $val; ?>"></td>
            </tr>
        <?php }} ?>
    </table>
</div>
<div style="float:left; width: 8%; overflow-y: scroll; height: 700px;">
    <input type="submit" value="save">
</div>
</form>