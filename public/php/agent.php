<?php
include('conn.php');
$step1=0;


print "<pre>";
$sql1="
SELECT a.salesforce_sal_id,a.salesforce_reporting_to,a.role_rol_id,a.status_level,
b.sal_code as code,c.sal_code as rep_to
FROM `j_salesforce_movement` as a
left join j_salesforce as b on a.salesforce_sal_id=b.sal_id
left join j_salesforce as c on a.salesforce_reporting_to=c.sal_id
where (a.salesforce_sal_id!=a.salesforce_reporting_to or a.status_level=1)
and b.sal_code LIKE '69%' and c.sal_code LIKE '69%'
order by a.salesforce_sal_id asc ,
a.sar_promotion_start asc";

$qqery1=mysql_query($sql1);
while($row1=mysql_fetch_assoc($qqery1))
{
    $rep_to[$row1['salesforce_sal_id']]=$row1['salesforce_reporting_to'];
    $rep_to_code[$row1['code']]=$row1['rep_to'];
    if($row1['status_level'])
    {
        $status_l[$row1['salesforce_sal_id']]=$row1['status_level'];
    }

    $role[$row1['salesforce_sal_id']]=$row1['role_rol_id'];
}
//print_r($rep_to_code);
//print_r($status_l);



$dd_arr=array();

$sql1="
SELECT
a.sal_id,
a.sal_code,
a.sal_business_name,
b.acc_preffered_name

FROM `j_salesforce` as a
left join j_user_account as b on a.sal_code=b.acc_sal_code
WHERE a.sal_code LIKE '69%'";
$ssql_role="insert into bsc_agent (fname,lname,preffered_name,sales_code,agent_designation_id,tier ) VALUES ";
$qqery1=mysql_query($sql1);
while($row1=mysql_fetch_assoc($qqery1))
{
    $dd_arr[$row1['sal_code']]=$row1;
    list($a,$b)=explode(' ',$row1['sal_business_name']);

    $dd_arr[$row1['sal_code']]['f_name']=$a;
    $dd_arr[$row1['sal_code']]['l_name']=trim(substr($row1['sal_business_name'],strlen($a),strlen($row1['sal_business_name'])));
$tear=(($status_l[$row1['sal_id']])?3:(($role[$row1['sal_id']]==5)?1:2));
    $ssql_role.="('".$dd_arr[$row1['sal_code']]['f_name']."','".$dd_arr[$row1['sal_code']]['l_name']."','".$dd_arr[$row1['sal_code']]['acc_preffered_name']."','".$dd_arr[$row1['sal_code']]['sal_code']."','".$role[$dd_arr[$row1['sal_code']]['sal_id']]."','$tear'),
    ";

}
if($step1)
{
    print $ssql_role;
    $step2=0;
}
else
{
    $step2=1;
}


if($step2)
{
    print $sql1="
    SELECT
    agent_id,sales_code,tier
    FROM `bsc_agent` as a
    ";
    $ssql_role="update bsc_agent SET";
    $qqery1=mysql_query($sql1);
    while($row1=mysql_fetch_assoc($qqery1))
    {
        $arr_data[$row1['sales_code']]=$row1;
    }
    foreach($arr_data as $k=>$v)
    {
        if($v['tier']!=3)
        {
            $t2=$t3=$t2t=0;
            print $v['sales_code']; print "<br>";
            print $v['tier']; print "<br>";
            if($v['tier']==1)
            {
                print $t2t=$rep_to_code[$v['sales_code']]; print "<br>";
                print $t3=$rep_to_code[$t2t]; print "<br>";
                print $t2=(($t2t!=$t3)?$t2t:"");print "<br>";
            }
            else
            {
                print $t3=$rep_to_code[$v['sales_code']]; print "<br>";
            }
            print $sqql="update bsc_agent SET tier2_supervisor='".$arr_data[$t2]['agent_id']."', tier3_supervisor='".$arr_data[$t3]['agent_id']."' where agent_id=".$v['agent_id'];
            mysql_query($sqql);
            print "<br>";
        }
        print "<br>";

        //$dd_arr[$row1['sal_code']]=$row1;
        //list($a,$b)=explode(' ',$row1['sal_business_name']);

       // $dd_arr[$row1['sal_code']]['f_name']=$a;
        //$dd_arr[$row1['sal_code']]['l_name']=substr($row1['sal_business_name'],strlen($a),strlen($row1['sal_business_name']));
        //$tear=(($status_l[$row1['sal_id']])?3:(($role[$row1['sal_id']]==5)?1:2));
        //$ssql_role.="('".$dd_arr[$row1['sal_code']]['f_name']."','".$dd_arr[$row1['sal_code']]['l_name']."','".$dd_arr[$row1['sal_code']]['acc_preffered_name']."','".$dd_arr[$row1['sal_code']]['sal_code']."','".$role[$dd_arr[$row1['sal_code']]['sal_id']]."','$tear'),
    //";
    }
}








exit;
print "<table border='1'>";
$c=0;
foreach($dd_arr as $k=>$v)
{
    if(!$c)
    {
        print "<tr>";
        foreach($v as $k1=>$v1)
        {
            print "<td><b>";
            print $k1;
            print "</b></td>";
        }
        print "</tr>";
    }
    print "<tr>";
    foreach($v as $k1=>$v1)
    {
        print "<td>";
print $v1;
        print "</td>";
    }
    print "</tr>";
    $c++;
}
print "</table>";

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