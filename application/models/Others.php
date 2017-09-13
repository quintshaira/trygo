<?php
class Others extends Zend_Db_Table{

    private $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');
    }

    public function get_company()
    {
        $select = $this->DB->select();
        $select->from(array('tmc' => "tranzgo_company"), array('company_id','company_name' ) );
        $select->where('tmc.company_status =?',1);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_cartype()
    {
        $select = $this->DB->select();
        $select->from(array('trvt' => "tranzgo_rental_vehicle_type"), array('vehicle_type_id','vehicle_type_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_transmissions()
    {
        $select = $this->DB->select();
        $select->from(array('tt' => "tranzgo_transmission"), array('transmission_id','transmission_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_driver_type()
    {
        $select = $this->DB->select();
        $select->from(array('tdt' => "tranzgo_driver_type"), array('driver_type_id','driver_type_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_item_type()
    {
        $select = $this->DB->select();
        $select->from(array('tdt' => "tranzgo_item_type"), array('item_type_id','item_type_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_frequency()
    {
        $select = $this->DB->select();
        $select->from(array('tf' => "tranzgo_request_rate"), array('request_rate_id','request_rate_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }








    public function add_company($txt_value,$ses_user)
    {
        $query = array(
            'company_name'=>$txt_value,
            'added_by'=>$ses_user,
            'company_created_at'=>CD,
            'company_updated_at'=>CD,
            'company_status'=>1
        );

        $this->DB->insert('tranzgo_company',$query);
        return $this->DB->lastInsertId();
    }

    public function add_car_type($txt_value,$ses_user)
    {
        $query = array(
            'vehicle_type_name'=>$txt_value,
            'added_by'=>$ses_user,
            'rental_vehicle_type_status'=>1
        );

        $this->DB->insert('tranzgo_rental_vehicle_type',$query);
        return $this->DB->lastInsertId();
    }

    public function add_driver_type($txt_value,$ses_user)
    {
        $query = array(
            'driver_type_name'=>$txt_value,
            'added_by'=>$ses_user,
            'driver_type_status'=>1
        );

        $this->DB->insert('tranzgo_driver_type',$query);
        return $this->DB->lastInsertId();
    }

    public function add_item_type($txt_value,$ses_user)
    {
        $query = array(
            'item_type_name'=>$txt_value,
            'added_by'=>$ses_user,
            'item_type_status'=>1
        );

        $this->DB->insert('tranzgo_item_type',$query);
        return $this->DB->lastInsertId();
    }

    public function add_transmission($txt_value,$ses_user)
    {
        $query = array(
            'transmission_name'=>$txt_value,
            'added_by'=>$ses_user,
            'transmission_status'=>1
        );

        $this->DB->insert('tranzgo_transmission',$query);
        return $this->DB->lastInsertId();
    }

    public function add_frequesncy($txt_value,$ses_user)
    {
        $query = array(
            'request_rate_name'=>$txt_value,
            'added_by'=>$ses_user,
            'request_rate_status'=>1
        );

        $this->DB->insert('tranzgo_request_rate',$query);
        return $this->DB->lastInsertId();
    }

    public function list_company()
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_company'),array('company_id','company_name'));
        return $ret=$this->DB->fetchAssoc($select);
    }

    public function get_company_list_rows($quick_search,$arr_limit,$arr_order)
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_company'),
            array(
                'company_id',
                'added_by',
                'company_name',
                'company_created_at'

            ));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tc.added_by',array('tu.user_fname','tu.user_lname'));
        $select->where('tc.is_delete=?',0);

        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tc.company_name like '%$quick_search%'");
        }

        $select->order($arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }
    public function get_company_list_rows_count($quick_search)
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_company'),array('num'=>'count(tc.company_id)'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tc.added_by',array('tu.user_fname','tu.user_lname'));
        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tc.company_name like '%$quick_search%'");
        }
        //print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }


    public function get_car_list_rows($quick_search,$arr_limit,$arr_order)
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_rental_vehicle_type'),
            array('*'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tc.added_by',array('tu.user_fname','tu.user_lname'));
        $select->where('tc.is_delete=?',0);

        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tc.vehicle_type_name like '%$quick_search%'");
        }

        $select->order($arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }

    public function get_car_list_rows_count($quick_search)
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_rental_vehicle_type'),array('num'=>'count(tc.vehicle_type_id)'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tc.added_by',array());
        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tc.vehicle_type_name like '%$quick_search%'");
        }
        //print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }























    public function get_company_name_byid($idd)
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_company'),array('company_id','company_name'));
        $select->where('company_id =?',$idd);
        return $ret=$this->DB->fetchrow($select);
    }


    public function delete_company($del_id)
    {
        $query = array(
            'is_delete' =>1
        );
        $this->DB->update('tranzgo_company',$query,array("company_id=$del_id"));
    }





























}
?>
