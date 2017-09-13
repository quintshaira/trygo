<?php
$con = mysql_connect("localhost", "root", "");
mysql_select_db("test", $con);
ini_set('memory_limit','1024M');
ini_set('max_execution_time', 0);

require_once 'PHPExcel/PHPExcel.php';
require_once 'PHPExcel/PHPExcel/IOFactory.php';


if(1)//prodect
{
    print $new_file_name="a.png";
    //$qry_sstr_c="insert into new(`id`, `file`, `client_phone`) values ('".addslashes($v['B'])."','".addslashes($v['A'])."','".addslashes($v['C'])."')";
    //$qry_sstr_c="INSERT INTO new (file) VALUES (LOAD_FILE($new_file_name));";
    $qry_sstr_c='INSERT INTO new (file) VALUES (\'' . mysql_real_escape_string (file_get_contents ($new_file_name)) . '\');';
    print $qry_sstr_c; print "<br>";
    mysql_query($qry_sstr_c);

    print mysql_real_escape_string (file_get_contents ($new_file_name));
}

if(0)//prodect
{
    print $new_file_name="client.xlsx";
    $company_arr=array('Aviva'=>1,'AXA'=>2);

    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($sheetData);
    $query_pre_c="";
    $qry_sstr="";
    $arr_sp['Jerry - SL']=12;
    $arr_sp['Kenneth - Aki']=12;

    $arr_pt['Private']=1;
    $arr_pt['Industrial']=4;
    $arr_pt['COMMERCIAL - OFFICE']=3;
    $arr_pt['Commercial']=3;
    foreach($sheetData as $k=>$v)
    {
        //if($k>1)
        {
            $sql="select client_id from mg_client where client_name='".addslashes($v['B'])."' and client_company='".addslashes($v['A'])."' and client_phone='".addslashes($v['C'])."'";
            //print $sql; print "<br>";
            $qry=mysql_query($sql);
            $row=mysql_fetch_assoc($qry);
            $client_id=($row['client_id'])?$row['client_id']:0;
            if(!$client_id)
            {
                $qry_sstr_c="insert into mg_client(`client_name`, `client_company`, `client_phone`) values ('".addslashes($v['B'])."','".addslashes($v['A'])."','".addslashes($v['C'])."')";
                //print $qry_sstr_c; print "<br>";
                mysql_query($qry_sstr_c);
                $client_id=mysql_insert_id();
                //print $client_id; print "<br>";
            }

            $qry_sstr_n="insert into mg_loan_request
            set
            user_id='11',sales_person='".$arr_sp[addslashes($v['H'])]."',client_id='$client_id',status='1',loan_request_date='".date("Y-m-d")."',
            loan_amount='".addslashes(str_replace('$','',str_replace(',','',$v['G'])))."',property_address='".addslashes($v['D'])."',property_type='".$arr_pt[addslashes($v['E'])]."',
            purpose='3',refferal_from='".addslashes($v['H'])."',
            add_date='".date("Y-m-d H:i:s")."',mod_date='".date("Y-m-d H:i:s")."'";
            //print $qry_sstr_n; print "<br>";
            mysql_query($qry_sstr_n);


        }

        //mysql_query($query_pre.$qry_sstr);
    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr;
    print "</pre>";
}



if(0)//prodect
{
    print $new_file_name="prod.xlsx";
    $company_arr=array('Aviva'=>1,'AXA'=>2);

    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($sheetData);
    $query_pre="insert into pfr_master_plan(`company_id`, `plan_given_id`, `plan_name`, `category`, `feature`) values ";
    $qry_sstr="";

    foreach($sheetData as $k=>$v)
    {
        $qry_sstr="('".$company_arr[$v['E']]."','".addslashes($v['C'])."','".addslashes($v['B'])."','".addslashes($v['F'])."','".addslashes($v['G'])."')";
        print $query_pre.$qry_sstr; print "<br>";
        //mysql_query($query_pre.$qry_sstr);
    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr;
    print "</pre>";
}

if(0)//prodect benifit
{


    $new_file_name="prod_benifit.xlsx";

    $t_code_arr=array();
    $sql="select plan_id,plan_given_id from pfr_master_plan";
    $qry=mysql_query($sql);
    while($row=mysql_fetch_assoc($qry))
    {
        $t_code_arr[$row['plan_given_id']]=$row['plan_id'];
    }

    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($sheetData);
    $query_pre="insert into pfr_master_plan_benifit(`plan_id`, `benifit`, `benifit_details`) values ";
    $qry_sstr="";

    foreach($sheetData as $k=>$v)
    {
        list($a,$b)=explode(':',$v['B']);
        $b=substr($v['B'],strlen($a)+2,strlen($v['B']));
        if(strpos($v['B'],':')!=strlen($a))
        {
            print ($v['B']);print "<br>";print "<br>";
            print ($a);print "<br>";
            print ($b);print "<br>";print "<br>";

            print strpos($v['B'],':');print "<br>";
            print strlen($a);print "<br>";

        }
        $qry_sstr="('".$t_code_arr[$v['A']]."','".addslashes(trim($a))."','".addslashes(trim($b))."')";
        print $query_pre.$qry_sstr; print ";<br>";
        //mysql_query($query_pre.$qry_sstr);
    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr
    print "</pre>";
}

if(0)//prodect prod_risk
{
    $new_file_name="prod_risk.xlsx";

    $t_code_arr=array();
    $sql="select plan_id,plan_given_id from pfr_master_plan";
    $qry=mysql_query($sql);
    while($row=mysql_fetch_assoc($qry))
    {
        $t_code_arr[$row['plan_given_id']]=$row['plan_id'];
    }

    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($sheetData);
    $query_pre="insert into pfr_master_plan_risk(`plan_id`, `risk`, `risk_details`) values ";
    $qry_sstr="";

    foreach($sheetData as $k=>$v)
    {
        list($a,$b)=explode(':',$v['B']);
        $b=substr($v['B'],strlen($a)+2,strlen($v['B']));
        if(strpos($v['B'],':')!=strlen($a))
        {
            print ($v['B']);print "<br>";print "<br>";
            print ($a);print "<br>";
            print ($b);print "<br>";print "<br>";

            print strpos($v['B'],':');print "<br>";
            print strlen($a);print "<br>";

        }
        $qry_sstr="('".$t_code_arr[$v['A']]."','".addslashes(trim($a))."','".addslashes(trim($b))."')";
        print $query_pre.$qry_sstr; print ";<br>";
        //mysql_query($query_pre.$qry_sstr);
    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr
    print "</pre>";
}

if(0)//rider
{
    $new_file_name="rider.xlsx";

    $t_code_arr=array();
    $sql="select plan_id,plan_name from pfr_master_plan";
    $qry=mysql_query($sql);
    while($row=mysql_fetch_assoc($qry))
    {
        $t_code_arr[$row['plan_id']]=$row['plan_name'];
    }

    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($t_code_arr);
    print_r($sheetData);
    $query_pre="insert into pfr_master_plan_rider( `rider_name`, `rider_features`) values ";
    $qry_sstr="";

    foreach($sheetData as $k=>$v)
    {
        $qry_sstr="('".addslashes(trim($v['A']))."','".addslashes(trim($v['B']))."')";
        //print $query_pre.$qry_sstr; print "<br>";
        mysql_query($query_pre.$qry_sstr);
    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr
    print "</pre>";
}

if(0)//rider benifit
{
    $new_file_name="rider_benifit.xlsx";

    $t_code_arr=array();
    $sql="select rider_id,rider_name from pfr_master_plan_rider";
    $qry=mysql_query($sql);
    while($row=mysql_fetch_assoc($qry))
    {
        $t_code_arr[$row['rider_name']]=$row['rider_id'];
    }

    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($t_code_arr);
    print_r($sheetData);
    $query_pre="insert into pfr_master_plan_rider_benifit( `rider_id`, `benifit`,`benifit_details`) values ";
    $qry_sstr="";

    foreach($sheetData as $k=>$v)
    {
        //$arr_temp=explode('\n',$v['B']);
        list($a,$b)=explode(':',$v['B']);
        $b=substr($v['B'],strlen($a)+2,strlen($v['B']));
        if(strpos($v['B'],':')!=strlen($a))
        {
            print ($v['B']);print "<br>";print "<br>";
            print ($a);print "<br>";
            print ($b);print "<br>";print "<br>";

            print strpos($v['B'],':');print "<br>";
            print strlen($a);print "<br>";

        }
        $qry_sstr="('".$t_code_arr[$v['A']]."','".addslashes(trim($a))."','".addslashes(trim($b))."')";
        print $query_pre.$qry_sstr; print "<br>";
        mysql_query($query_pre.$qry_sstr);
        //print_r($arr_temp);
    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr
    print "</pre>";
}

if(0)//rider risk
{
    $new_file_name="rider_risk.xlsx";

    $t_code_arr=array();
    $sql="select rider_id,rider_name from pfr_master_plan_rider";
    $qry=mysql_query($sql);
    while($row=mysql_fetch_assoc($qry))
    {
        $t_code_arr[$row['rider_name']]=$row['rider_id'];
    }

    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($t_code_arr);
    //print_r($sheetData);
    $query_pre="insert into pfr_master_plan_rider_risk( `rider_id`, `risk`,`risk_details`) values ";
    $qry_sstr="";

    foreach($sheetData as $k=>$v)
    {
        //$arr_temp=explode('\n',$v['B']);
        list($a,$b)=explode(':',$v['B']);
        $b=substr($v['B'],strlen($a)+2,strlen($v['B']));
        if(strpos($v['B'],':')!=strlen($a))
        {
            print ($v['B']);print "<br>";print "<br>";
            print ($a);print "<br>";
            print ($b);print "<br>";print "<br>";

            print strpos($v['B'],':');print "<br>";
            print strlen($a);print "<br>";

        }
//exit;
        $qry_sstr="('".$t_code_arr[$v['A']]."','".addslashes(trim($a))."','".addslashes(trim($b))."')";
        //print $query_pre.$qry_sstr; print "<br>";
        mysql_query($query_pre.$qry_sstr);
        //print_r($arr_temp);
    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr
    print "</pre>";
}

if(0)//rider plan reletion
{
    $new_file_name="rider_relation.xlsx";

    $t_code_arr=array();
    $sql="select plan_id,plan_name from pfr_master_plan";
    $qry=mysql_query($sql);
    while($row=mysql_fetch_assoc($qry))
    {
        $t_code_arr[strtolower($row['plan_name'])]=$row['plan_id'];
    }
    $r_code_arr=array();
    $sql="select rider_id,rider_name from pfr_master_plan_rider";
    $qry=mysql_query($sql);
    while($row=mysql_fetch_assoc($qry))
    {
        $r_code_arr[$row['rider_name']]=$row['rider_id'];
    }
    $objPHPExcel = PHPExcel_IOFactory::load($new_file_name);

    $objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

    print "<pre>";
    //print_r($sheetData);
    //print_r($t_code_arr);
    //print_r($r_code_arr);
    $query_pre="insert into pfr_master_plan_rider_relation( `rider_id`, `plan_id`) values ";
    $qry_sstr="";
$counter=1;
    foreach($sheetData as $k=>$v)
    {
        $arr_chk=explode('|',strtolower(trim($v['B'])));
        foreach($arr_chk as $kkk=>$vvv)
        {
            //print $vvv; print "<br>";
            $qry_sstr="('".addslashes($r_code_arr[trim($v['A'])])."','".addslashes($t_code_arr[$vvv])."')";
            //print $counter++;
            //print $query_pre.$qry_sstr; print "<br>";
            //mysql_query($query_pre.$qry_sstr);
        }

    }
//mysql_query($query_pre.$qry_sstr);
//print $query_pre.$qry_sstr
    print "</pre>";
}
exit;
?>