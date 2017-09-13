<?php
include('../conn.php');
set_time_limit(0);
function extract_all($contt,$link_id)
{
    list($tt,$a)=explode('<div id="rightColumn">',$contt);
    list($b,$tt)=explode('<div id="paging-bottom">',$a);
    //print $b;
    $arr1=explode("<div class='product'",$b);
    foreach($arr1 as $k=>$v)
    {
        if(!$k)
            continue;
        list($tt,$c)=explode('document.location.href=',$v);
        list($p_link,$nn)=explode("' style='cursor:pointer",$c);
        $p_link='http://www.marqetspace.co.uk'.trim(trim($p_link),'"');

        list($tt,$c)=explode('<img src=',$nn);
        list($pic_link,$nn)=explode("alt=",$c);
        $pic_link=trim(trim($pic_link),"'");
        list($tt,$pp)=explode('TEMP/',$pic_link);
        list($photo_name,$tt)=explode("?",$pp);
        list($photo_idd,$tt)=explode("-",$photo_name);

        list($tt,$mm)=explode("<div class='product_info'>",$nn);
        //print $mm;
        $arr2=explode("<br>",$mm);
        //print "<pre>"; print_r($arr2); print "</pre>";
        $name_1=trim(strip_tags($arr2[0]));
        $name_2=trim(strip_tags($arr2[1]));

        $price_2=trim(str_replace('&pound;','',str_replace('from','',strip_tags($arr2[2]))));

        //print "<br>"; print "<br>";

        $ssql="insert into cr_l2 set cid='$link_id', name_1='".stripcslashes($name_1)."', name_2='".stripcslashes($name_2)."', price_p='$price_2', photopath='$pic_link', photo_name='$photo_name', photo_idd='$photo_idd', link_to='$p_link'";
        mysql_query($ssql);
    }
    //print "<pre>"; print_r($arr1); print "</pre>";
}


$sql1="SELECT * from cr_l1 where is_done=0";
$qqery1=mysql_query($sql1);
$arr_1=array();
while($row1=mysql_fetch_assoc($qqery1))
{
    $arr_1[$row1['role_id']][]=$row1['user_id'];
    $full_f=file_get_contents($row1['link_1']);

    //print $full_f;
    list($tt,$a)=explode("<li>of ",$full_f);
    list($page,$tt)=explode("</li>",$a);

//print $page;
    extract_all($full_f,$row1['link_id']);
if((trim($page)*1)>1)
{
    for($i=2;$i<=$page;$i++)
    {
        $full_f=file_get_contents($row1['link_1']."?keywords=&page=".$i."&per_page=&order=salesrank_asc&colour=&max_price=");
        extract_all($full_f,$row1['link_id']);
    }
}


    mysql_query("update cr_l1 set is_done='1' where link_id=".$row1['link_id']);
    //break;
}


exit;
$arr1=explode("<a href='",$sstr);
$arr_2=array();
foreach($arr1 as $k=>$v)
{
    if($k)
    {
        list($a,$tt)=explode("' title",$v);
        $gg='http://www.marqetspace.co.uk'.$a;
        mysql_query("insert into cr_l1 set link_1='$gg'");
    }


}
print "<pre>"; print_r($arr_2); print "</pre>";
exit;

if ($_SERVER['REQUEST_METHOD']=="POST")
{
    $arr_menuids=explode(',',$_POST['menuids']);
    $arr_role=$_POST['role'];
    print "<pre>"; print_r($arr_menuids); print "</pre>";
    print "<pre>"; print_r($arr_role); print "</pre>";

    print $sql1="SELECT user_id,role_id from xm_user_login_details where is_activated=1 and role_id in (".implode(',',$_POST['role']).")";
    $qqery1=mysql_query($sql1);
    $role_dd_arr=array();
    while($row1=mysql_fetch_assoc($qqery1))
    {
        $role_dd_arr[$row1['role_id']][]=$row1['user_id'];
    }
    print "<pre>"; print_r($role_dd_arr); print "</pre>";
    $ssql_role="insert into xm_role_menu_permission (role_id,menu_id) VALUES ";
    $ssql_user="insert into xm_user_menu_permission (user_id,menu_id) VALUES ";
    foreach($arr_menuids as $k=>$v)
    {
        foreach($arr_role as $k1=>$v1)
        {
            $ssql_role.="('$v1','$v'),";
            foreach($role_dd_arr[$v1] as $k2=>$v2)
            {
                $ssql_user.="('$v2','$v'),";
            }
        }
    }
    print $ssql_role=trim($ssql_role,',').';';
    print "<br>";
    print $ssql_user=trim($ssql_user,',').';';
        //mysql_query($ssql_emi);


}


?>
<form enctype="multipart/form-data" method="post" action="">
<table>
    <tr>
        <td>
            <input type="text" name="menuids">
        </td>
        <td>
            <select name="role[]" multiple size="3">
                <option value="1">admin</option>
                <option value="2">manager</option>
                <option value="3">user</option>
            </select>
        </td>
        <td>
            <input type="submit" value="submit">
        </td>
    </tr>
</table>
</form>