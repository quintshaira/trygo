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
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'req_gen_id',
                'vehicle_id',
                'tu.rental_id',
                'rent_from'=>"DATE_FORMAT(rent_from,'%b %d %Y %h:%i %p')",
                'rent_to',
                'driver_id'=>new Zend_Db_Expr("if(assigned_driver_1_id<>0,tr.assigned_driver_1_id,tr.assigned_driver_2_id)"),
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

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }

        //$select->order('tr.'.$arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            //$select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        return $this->DB->fetchAssoc($select);

    }


    public function get_for_duepay_rows($comp_id,$date_arr)
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
                'driver_id'=>new Zend_Db_Expr("if(assigned_driver_1_id<>0,tr.assigned_driver_1_id,tr.assigned_driver_2_id)"),
                'customer_id',
                'estimated_price',
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
        $select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.rent_to_date,'%Y-%m-%d') ) ) or ( tr.rent_to_date < '".$date_arr['ed']."' AND tr.driver_status_id <> 8 )");

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


    public function get_for_remitted_rows($comp_id,$date_arr)
    {

        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'),
            array(
                'request_id',
                'req_gen_id',
                'vehicle_id',
                'driver_status_id',
                'received_by',
                'received_on'=>"DATE_FORMAT(received_on,'%b %d %Y %h:%i %p')",
                'rent_to',
                'driver_id'=>new Zend_Db_Expr("if(assigned_driver_1_id<>0,tr.assigned_driver_1_id,tr.assigned_driver_2_id)"),
                'customer_id',
                'estimated_price',
                'recieved_amount',
                'recieved_remarks',
                'sn'=>new Zend_Db_Expr("'|SN|'")
            ));
        $select->joinleft(array('tu'=>'tranzgo_rental'),'tu.rental_id=tr.vehicle_id',array('assigned_vehicle_name'));
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.received_by',array('received_by_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
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
        $select->where("(('".$date_arr['sd']."' <= DATE_FORMAT(tr.received_on,'%Y-%m-%d') ) AND ('".$date_arr['ed']."' >= DATE_FORMAT(tr.received_on,'%Y-%m-%d') ) )");

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

    public function get_driver_name($idd)
    {
        $select =   $this->DB->select();
        $select->from(array('tu'=>'tranzgo_user'),
            array(
                'driver_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)")
            ));

        $select->where("tu.user_id=?" ,$idd);
        return $this->DB->fetchRow($select);
    }



}

?>