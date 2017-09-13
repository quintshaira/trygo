<?php
include('../conn.php');


$sstr="
													<li>
								<a href='/business-cards' title='Business Cards'>
									Business Cards								</a>
							</li>
													<li>
								<a href='/stationery' title='Stationery'>
									Stationery								</a>
							</li>
													<li>
								<a href='/leaflets' title='Leaflets'>
									Leaflets								</a>
							</li>
													<li>
								<a href='/folded-leaflets' title='Folded Leaflets'>
									Folded Leaflets								</a>
							</li>
													<li>
								<a href='/perforated-leaflets' title='Perforated Leaflets'>
									Perforated Leaflets								</a>
							</li>
													<li>
								<a href='/flyers' title='Flyers'>
									Flyers								</a>
							</li>
													<li>
								<a href='/folded-flyers' title='Folded Flyers'>
									Folded Flyers								</a>
							</li>
													<li>
								<a href='/thick-flyers' title='Thick Flyers'>
									Thick Flyers								</a>
							</li>
													<li>
								<a href='/a6-booklets' title='A6 Booklets'>
									A6 Booklets								</a>
							</li>
													<li>
								<a href='/a4-booklets' title='A4 Booklets'>
									A4 Booklets								</a>
							</li>
													<li>
								<a href='/booklets-a5' title='A5 Booklets'>
									A5 Booklets								</a>
							</li>
													<li>
								<a href='/booklet-covers' title='Booklet Covers'>
									Booklet Covers								</a>
							</li>
													<li>
								<a href='/digital-booklets' title='Digital Booklets'>
									Digital Booklets								</a>
							</li>
													<li>
								<a href='/booklet-folders' title='Booklet Folders'>
									Booklet Folders								</a>
							</li>
													<li>
								<a href='/folders' title='Folders'>
									Folders								</a>
							</li>
													<li>
								<a href='/artisan-range' title='Artisan Range'>
									Artisan Range								</a>
							</li>
													<li>
								<a href='/stickers' title='Stickers'>
									Stickers								</a>
							</li>
													<li>
								<a href='/banner-stands' title='Banner Stands'>
									Banner Stands								</a>
							</li>
													<li>
								<a href='/greeting-cards' title='Greeting Cards'>
									Greeting Cards								</a>
							</li>
													<li>
								<a href='/scratch-cards' title='Scratch Cards'>
									Scratch Cards								</a>
							</li>
													<li>
								<a href='/invitations' title='Invitations'>
									Invitations								</a>
							</li>
													<li>
								<a href='/envelopes' title='Envelopes'>
									Envelopes								</a>
							</li>
													<li>
								<a href='/posters' title='Posters'>
									Posters								</a>
							</li>
													<li>
								<a href='/postcards' title='Postcards'>
									Postcards								</a>
							</li>
													<li>
								<a href='/credit-cards' title='Credit Cards'>
									Credit Cards								</a>
							</li>
													<li>
								<a href='/bookmarks' title='Bookmarks'>
									Bookmarks								</a>
							</li>
													<li>
								<a href='/ncr-products' title='NCR Products'>
									NCR Products								</a>
							</li>
													<li>
								<a href='/calendars' title='Calendars'>
									Calendars								</a>
							</li>
													<li>
								<a href='/christmas-cards' title='Christmas Cards'>
									Christmas Cards								</a>
							</li>
";

$arr1=explode("<a href='",$sstr);
$arr_2=array();
foreach($arr1 as $k=>$v)
{
    if($k)
    {
        list($a,$tt)=explode("' title",$v);
        $gg='http://www.marqetspace.co.uk'.$a;
        //mysql_query("insert into cr_l1 set link_1='$gg'");
    }
}

$arr1=explode("<li>",$sstr);
$arr_2=array();
foreach($arr1 as $k=>$v)
{
    if($k)
    {
        $name=trim(strip_tags($v));
        $gg='http://www.marqetspace.co.uk'.$a;
        print "update cr_l1 set link_name='$name' where link_id='$k';"; print "<br>";
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