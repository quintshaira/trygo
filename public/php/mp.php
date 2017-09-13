<?php
include('conn.php');



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






































[AGE] => 1
[CE1] => 2
[CEP1] => 3
[CEP2] => 4
[CIT] => 5
[WP3] => 6
[LF1] => 7
[MB3] => 8
[MB4] => 9
[FB1] => 10
[FB2] => 11
[ES3] => 12
[ES7] => 13
[ES4] => 14
[ES8] => 15
[ES5] => 16
[ES6] => 17
[EC1] => 18
[MB5] => 19
[RE3] => 20
[ML1] => 21
[ML2] => 22
[ML3] => 23
[MLR] => 24
[CPE] => 25
[CPU] => 26
[ENTU] => 27
[ENTT] => 28
[CPV] => 29
[ENTV] => 30
[ENTX] => 31
[CPW] => 32
[ENTW] => 37
[ENTY] => 38
[CPM] => 39
[ENTG] => 40
[RP1] => 41
[MB8] => 42
[RE1] => 43
[HCB1] => 44
[HCB2] => 45
[HCB3] => 46
[HCB4] => 47
[HCB5] => 48
[HCB6] => 49
[HCB7] => 50
[HCB8] => 51
[HCB9] => 52
[HCBA] => 53
[HCBB] => 54
[HCBC] => 55
[HCBI] => 56
[HCBJ] => 57
[HCBK] => 58
[HCBL] => 59
[HCBM] => 60
[HCBN] => 61
[MB6] => 62