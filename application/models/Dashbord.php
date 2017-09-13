<?php
/**
 * @author Eman Daryl Ycot
 * @copyright 2010
 */
class Dashbord extends Zend_Db_Table{

    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');

    }

    public function get_for_total_car_count($comp_id,$date_arr)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),
            array(
                'num'=>'count(rental_id)'
            ));
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }
//print $select;
        $ret_res=$this->DB->fetchRow($select);
        return $ret_res['num'];
    }

    public function get_for_rented_car_count($comp_id,$date_arr)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'num'=>'count(request_id)'
            ));
        $select->joinleft(array('tu'=>'tranzgo_rental'),'tu.rental_id=tr.vehicle_id',array(''));
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);
        $select->where('tu.is_delete=?',0);
        $select->where('tu.is_active=?',1);
        $select->where("(('".$date_arr['sd']."' >= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' <= DATE_FORMAT(tr.rent_to,'%Y-%m-%d') ) )");

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
            $select->where('tu.company_id=?',$comp_id);
        }
//print $select;exit;
        $ret_res=$this->DB->fetchRow($select);
        return $ret_res['num'];
    }

    public function get_for_down_car_count($comp_id,$date_arr)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),
            array(
                'num'=>'count(rental_id)'
            ));

        $select->where("tr.rental_status = 0");
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }

        $ret_res=$this->DB->fetchRow($select);
        return $ret_res['num'];
    }



    public function get_for_assignment_rows($comp_id,$date_arr)
    {
        $ii=1;
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'req_gen_id',
                'vehicle_id',
                'tu.rental_id',
                'rent_from'=>"DATE_FORMAT(rent_from,'%b %d %Y %h:%i %p')",
                'rent_to',
                'driver_name'=>"if(driver_task_id=2,td2.nick_name,td1.nick_name)",
                'customer_id',
                'estimated_price',
                'sn'=>new Zend_Db_Expr("'|SN|'")
            ));
        $select->joinleft(array('tu'=>'tranzgo_rental'),'tu.rental_id=tr.vehicle_id',array('assigned_vehicle_name'));
        $select->joinleft(array('td1'=>'tranzgo_user'),'td1.user_id=tr.assigned_driver_1_id',array(''));
        $select->joinleft(array('td2'=>'tranzgo_user'),'td2.user_id=tr.assigned_driver_2_id',array(''));
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array('customer_name'));

        //$select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array('transmission_name'));

        $select->where("tr.request_status_id in (1,3)");
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);

        $select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) )");
        //$select->where("('".$date_arr['sd']."' = DATE_FORMAT(tr.rent_from,'%Y-%m-%d') )");

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }

        //$select->order('tr.'.$arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            //$select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }


    public function get_for_assignment_rows_today($comp_id,$date_arr)
    {
        $ii=1;
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'req_gen_id',
                'vehicle_id',
                'tu.rental_id',
                'rent_from'=>"DATE_FORMAT(rent_from,'%b %d %Y %h:%i %p')",
                'rent_to',
                'driver_name'=>"if(driver_task_id=2,td2.nick_name,td1.nick_name)",
                'customer_id',
                'estimated_price',
                'sn'=>new Zend_Db_Expr("'|SN|'")
            ));
        $select->joinleft(array('tu'=>'tranzgo_rental'),'tu.rental_id=tr.vehicle_id',array('assigned_vehicle_name'));
        $select->joinleft(array('td1'=>'tranzgo_user'),'td1.user_id=tr.assigned_driver_1_id',array(''));
        $select->joinleft(array('td2'=>'tranzgo_user'),'td2.user_id=tr.assigned_driver_2_id',array(''));
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array('customer_name'));

        //$select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array('transmission_name'));

        $select->where("tr.request_status_id in (1,3)");
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);
        $select->where('tr.is_assigned=?',0);

        //$select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) )");
        $select->where("('".$date_arr['sd']."' <= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') )");

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }

        //$select->order('tr.'.$arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            //$select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }





    public function get_for_duepay_rows($comp_id,$date_arr,$is_today)
    {

        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'req_gen_id',
                'vehicle_id',
                'driver_status_id',
                //'rent_from'=>"DATE_FORMAT(rent_from,'%b %d %Y %h:%i %p')",
                'rent_to',
                'driver_name'=>"if(driver_task_id=2,td2.nick_name,td1.nick_name)",
                'customer_id',
                'estimated_price',
                'recieved_amount',
                'sn'=>new Zend_Db_Expr("'|SN|'")
            ));
        $select->joinleft(array('tu'=>'tranzgo_rental'),'tu.rental_id=tr.vehicle_id',array('assigned_vehicle_name'));
        $select->joinleft(array('td1'=>'tranzgo_user'),'td1.user_id=tr.assigned_driver_1_id',array(''));
        $select->joinleft(array('td2'=>'tranzgo_user'),'td2.user_id=tr.assigned_driver_2_id',array(''));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'),'tds.driver_status_id=tr.driver_status_id',array('status_name'));
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array('customer_name'));

        //$select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array('transmission_name'));

        //$select->where("tr.request_status_id in (1,3)");
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);
        $select->where('tr.driver_status_id<>?',8);
        if($is_today)
        {
            $select->where("('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d'))");

        }else{
            $select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.rent_from_date,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d') ) )");

        }

        //$select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d') ) ) or ( tr.rent_to_date < '".$date_arr['ed']."' AND tr.driver_status_id <> 8 )");


        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }

        $select->order('tr.rent_to ASC');
        if($arr_limit['limit'])
        {
            //$select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }


    public function get_for_remitted_rows($comp_id,$date_arr,$is_today)
    {

        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'req_gen_id',
                'vehicle_id',
                'driver_status_id',
                'received_on'=>"DATE_FORMAT(received_on,'%b %d %Y %h:%i %p')",
                'rent_to',
                'driver_name'=>"if(driver_task_id=2,td2.nick_name,td1.nick_name)",
                'customer_id',
                'estimated_price',
                'recieved_amount',
                'recieved_remarks',
                'sn'=>new Zend_Db_Expr("'|SN|'")
            ));
        $select->joinleft(array('tu'=>'tranzgo_rental'),'tu.rental_id=tr.vehicle_id',array('assigned_vehicle_name'));
        $select->joinleft(array('td1'=>'tranzgo_user'),'td1.user_id=tr.assigned_driver_1_id',array(''));
        $select->joinleft(array('td2'=>'tranzgo_user'),'td2.user_id=tr.assigned_driver_2_id',array(''));
        $select->joinleft(array('td3'=>'tranzgo_user'),'td3.user_id=tr.received_by',array('nick_name'));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'),'tds.driver_status_id=tr.driver_status_id',array('status_name'));
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array('customer_name'));

        //$select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array('transmission_name'));

        //$select->where("tr.request_status_id in (1,3)");
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);
        $select->where('tr.driver_status_id=?',8);
        if($_SESSION['tranzgo_session']['account_id']==3)
        {
            $select->where('tr.received_by=?',$_SESSION['tranzgo_session']['user_id']);
        }

        if($is_today)
        {
            $select->where("('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d'))");

        }else{
            $select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.rent_from_date,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d') ) )");

        }

        //$select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.received_on,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.received_on,'%Y-%m-%d') ) )");

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }

        //$select->order('tr.'.$arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            //$select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }


    public function update_collected($data,$idd)
    {
        $this->DB->update('tranzgo_request',$data,array("request_id=$idd"));
    }

    public function get_request_approval_rows($company_id,$request_status,$quick_search,$arr_limit,$arr_order,$TD_arr)
    {

        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'requested_by',
                'request_status_id',
                'driver_task_id',
                'rent_from',
                'rent_to',
                'customer_id',
                'assigned_driver_1_id',
                'assigned_driver_2_id',
                'req_gen_id',
                'vehicle_id',
                'company_id',
                'driver_status_id'

            ));
        $select->joinleft(array('trs'=>'tranzgo_request_status'),'tr.request_status_id=trs.request_status_id',array('request_status_name'));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'),'tr.driver_status_id=tds.driver_status_id',array('status_name'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.assigned_driver_1_id',array('tu.user_fname','tu.user_lname', 'assigned_driver_1_id_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.assigned_driver_2_id',array('tu1.user_fname','tu1.user_lname','assigned_driver_2_id_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('tu11'=>'tranzgo_user'),'tu11.user_id=tr.requested_by',array('requested_by_name'=>new Zend_Db_Expr("CONCAT(tu11.user_fname,' ',tu11.user_lname)")));
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array('tcu.customer_name'));
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'),'tr.driver_task_id=tdt.driver_task_id',array('driver_task_name','driver_task_status'));
        $select->joinleft(array('trl'=>'tranzgo_rental'),'trl.rental_id=tr.vehicle_id',array('assigned_vehicle_name','rental_id'));
        $select->joinleft(array('tc'=>'tranzgo_company'),'tc.company_id=tr.company_id',array('company_name'));
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);
        $select->where('tr.request_status_id IN(?)',$request_status);
        $select->where("(('".$TD_arr['sd']."' <= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) AND ('".$TD_arr['ed']."' >= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) )");
        if($company_id)
        {
            $select->where('tr.company_id=?',$company_id);
        }

        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tu1.user_fname like '%$quick_search%' or
            tu1.user_lname like '%$quick_search%' or
            tr.req_gen_id like '%$quick_search%' or
            tr.request_id like '%$quick_search%' or
            trs.request_status_name like '%$quick_search%' or
			tdt.driver_task_name like '%$quick_search%' or
			trl.assigned_vehicle_name like '%$quick_search%' or
			tcu.customer_name like '%$quick_search%'");
        }

        $select->order($arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }
    public function get_request_approval_rows_count($company_id,$request_status,$quick_search,$TD_arr)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),array('num'=>'count(tr.request_id)'));
        $select->joinleft(array('trs'=>'tranzgo_request_status'),'tr.request_status_id=trs.request_status_id',array());
        $select->joinleft(array('tds'=>'tranzgo_driver_status'),'tr.driver_status_id=tds.driver_status_id',array());
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.assigned_driver_1_id',array());
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.assigned_driver_2_id',array());
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array());
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'),'tr.driver_task_id=tdt.driver_task_id',array());
        $select->joinleft(array('trl'=>'tranzgo_rental'),'trl.rental_id=tr.vehicle_id',array('assigned_vehicle_name','rental_id'));
        $select->where('tr.is_delete=?',0);
        $select->where('tr.request_status_id IN(?)',$request_status);
        $select->where("(('".$TD_arr['sd']."' <= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) AND ('".$TD_arr['ed']."' >= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') ) )");
        if($company_id)
        {
            $select->where('tr.company_id=?',$company_id);
        }

        if($quick_search)
        {

            $select->where("
            tr.request_id like '%$quick_search%' or
            trs.request_status_name like '%$quick_search%' or
			tdt.driver_task_name like '%$quick_search%' or
			trl.assigned_vehicle_name like '%$quick_search%' or
			tcu.customer_name like '%$quick_search%'");
        }
        // print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }


    public function get_request_approval_rows_today($company_id,$request_status,$quick_search,$arr_limit,$arr_order,$TD_arr)
    {

        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'requested_by',
                'request_status_id',
                'driver_task_id',
                'rent_from',
                'rent_to',
                'customer_id',
                'assigned_driver_1_id',
                'assigned_driver_2_id',
                'req_gen_id',
                'vehicle_id',
                'company_id',
                'driver_status_id'

            ));
        $select->joinleft(array('trs'=>'tranzgo_request_status'),'tr.request_status_id=trs.request_status_id',array('request_status_name'));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'),'tr.driver_status_id=tds.driver_status_id',array('status_name'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.assigned_driver_1_id',array('tu.user_fname','tu.user_lname', 'assigned_driver_1_id_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.assigned_driver_2_id',array('tu1.user_fname','tu1.user_lname','assigned_driver_2_id_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('tu11'=>'tranzgo_user'),'tu11.user_id=tr.requested_by',array('requested_by_name'=>new Zend_Db_Expr("CONCAT(tu11.user_fname,' ',tu11.user_lname)")));
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array('tcu.customer_name'));
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'),'tr.driver_task_id=tdt.driver_task_id',array('driver_task_name','driver_task_status'));
        $select->joinleft(array('trl'=>'tranzgo_rental'),'trl.rental_id=tr.vehicle_id',array('assigned_vehicle_name','rental_id'));
        $select->joinleft(array('tc'=>'tranzgo_company'),'tc.company_id=tr.company_id',array('company_name'));
        $select->where('tr.is_delete=?',0);
        $select->where('tr.is_active=?',1);
        $select->where('tr.request_status_id IN(?)',$request_status);
        $select->where("('".$TD_arr['sd']."' <= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') )");
        if($company_id)
        {
            $select->where('tr.company_id=?',$company_id);
        }

        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tu1.user_fname like '%$quick_search%' or
            tu1.user_lname like '%$quick_search%' or
            tr.req_gen_id like '%$quick_search%' or
            tr.request_id like '%$quick_search%' or
            trs.request_status_name like '%$quick_search%' or
			tdt.driver_task_name like '%$quick_search%' or
			trl.assigned_vehicle_name like '%$quick_search%' or
			tcu.customer_name like '%$quick_search%'");
        }

        $select->order($arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }
    public function get_request_approval_rows_count_today($company_id,$request_status,$quick_search,$TD_arr)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),array('num'=>'count(tr.request_id)'));
        $select->joinleft(array('trs'=>'tranzgo_request_status'),'tr.request_status_id=trs.request_status_id',array());
        $select->joinleft(array('tds'=>'tranzgo_driver_status'),'tr.driver_status_id=tds.driver_status_id',array());
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.assigned_driver_1_id',array());
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.assigned_driver_2_id',array());
        $select->joinleft(array('tcu'=>'tranzgo_customers'),'tcu.customer_id=tr.customer_id',array());
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'),'tr.driver_task_id=tdt.driver_task_id',array());
        $select->joinleft(array('trl'=>'tranzgo_rental'),'trl.rental_id=tr.vehicle_id',array('assigned_vehicle_name','rental_id'));
        $select->where('tr.is_delete=?',0);
        $select->where('tr.request_status_id IN(?)',$request_status);
        $select->where("('".$TD_arr['sd']."' <= DATE_FORMAT(tr.rent_from,'%Y-%m-%d') )");
        if($company_id)
        {
            $select->where('tr.company_id=?',$company_id);
        }

        if($quick_search)
        {

            $select->where("
            tr.request_id like '%$quick_search%' or
            trs.request_status_name like '%$quick_search%' or
			tdt.driver_task_name like '%$quick_search%' or
			trl.assigned_vehicle_name like '%$quick_search%' or
			tcu.customer_name like '%$quick_search%'");
        }
        // print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }





}

?>