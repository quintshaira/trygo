<?php
include('../conn.php');


$sql1="
SELECT
a.*,
 b.link_1
from cr_l2 as a
left join cr_l1 as b on a.cid=b.link_id
order by pid asc
";

$qqery1=mysql_query($sql1);
$arr_1=array();
$arr_l=array();
while($row1=mysql_fetch_assoc($qqery1))
{
    $arr_1[$row1['cid']][$row1['pid']]=$row1;
    $arr_l[$row1['cid']]=$row1['link_1'];
}

//print "<pre>"; print_r($arr_1); print "</pre>";

?>
<br><br><br><br>
<form enctype="multipart/form-data" method="post" action="">
    <?php foreach($arr_1 as $k=>$v) { ?>
        <a href="<?php print $arr_l[$k]; ?>"><?php print $arr_l[$k]; ?></a>
        <br><br>
<table border="1">
    <tr>
        <?php $cc=1; foreach($v as $k1=>$v1) {
            list($pp300,$tt)=explode($v1['photo_idd'],$v1['photopath']);
            //if(!file_exists("images/200/".$v1['photo_name']))
            {


            ?>
            <td style=" width: 200px;">
<!--                <img src="--><?php //print $v1['photopath']; ?><!--">-->
                <img src="images/200/<?php print $v1['photo_idd']; ?>-200-200.jpg">
                <img src="images/300/<?php print $v1['photo_idd']; ?>-300-300.png">
                <br>
                <a href="<?php print $v1['link_to']; ?>"><?php print $v1['name_1']; ?></a>
                <br>
                <?php print $v1['name_2']; ?>
                <br>
                &pound; <?php print $v1['price_p']; ?>
                <br>
            </td>
            <?php if(!($cc%5)) { print "</tr><tr>"; } ?>
        <?php $cc++; }} ?>

    </tr>
</table>
        <br><br>
    <?php } ?>
</form>