<?php
/**
 * @author Eman Daryl Ycot
 * @copyright 2010
 */
class Package extends Zend_Db_Table{

    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');

    }

    public function add_package($data)
    {
        $this->DB->insert('tranzgo_package',$data);
        return $this->DB->lastInsertId();
    }

    public function update_package($dataWhere,$idd)
    {
        $this->DB->update('tranzgo_package',$dataWhere,array("package_id=$idd"));
        return true;
    }

    public function get_package_list_rows($comp_id,$quick_search,$arr_limit,$arr_order)
    {
        $select = $this->DB->select();
        $select->from(array('tp'=>'tranzgo_package'), array('tp.add_date','tp.package_id','tp.package_name','tp.price','tp.destination','tp.package_status'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tp.added_by',array('added_by_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('trvt' => "tranzgo_rental_vehicle_type"),'tp.vehicle_type_id=trvt.vehicle_type_id', array('vehicle_type_name') );
        $select->joinleft(array('tdt' => "tranzgo_driver_type"),'tp.driver_type_id=tdt.driver_type_id', array('driver_type_name') );
        $select->joinleft(array('tt' => "tranzgo_transmission"),'tp.transmission_id=tt.transmission_id', array('transmission_name' ) );
        $select->joinleft(array('tf' => "tranzgo_request_rate"),'tp.request_rate_id=tf.request_rate_id', array('request_rate_name' ) );
        $select->joinleft(array('tmc' => "tranzgo_company"),'tp.company_id=tmc.company_id', array('company_name' ) );


        $select->where("tp.is_delete =?",0);
        if($comp_id)
        {
            $select->where("tp.company_id =?",$comp_id);
        }

        if($quick_search)
        {

            $select->where("
            tp.package_name like '%$quick_search%' or
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%'");
        }

        $select->order($arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        $result = $this->DB->fetchAll($select);

        return $result;
    }


    public function get_package_list_rows_count($comp_id,$quick_search)
    {
        $select =   $this->DB->select();


        $select->from(array('tp'=>'tranzgo_package'), array('num'=>'count(tp.package_id)'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tp.added_by',array());
        $select->joinleft(array('trvt' => "tranzgo_rental_vehicle_type"),'tp.vehicle_type_id=trvt.vehicle_type_id', array() );
        $select->joinleft(array('tdt' => "tranzgo_driver_type"),'tp.driver_type_id=tdt.driver_type_id', array() );
        $select->joinleft(array('tt' => "tranzgo_transmission"),'tp.transmission_id=tt.transmission_id', array() );
        $select->joinleft(array('tf' => "tranzgo_request_rate"),'tp.request_rate_id=tf.request_rate_id', array() );
        $select->joinleft(array('tmc' => "tranzgo_company"),'tp.company_id=tmc.company_id', array() );

        $select->where("tp.is_delete =?",0);
        if($comp_id)
        {
            $select->where("tp.company_id =?",$comp_id);
        }

        if($quick_search)
        {

            $select->where("
            tp.package_name like '%$quick_search%' or
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%'");
        }

        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }

    public function get_package_detail_from_idd($idd)
    {
        $select = $this->DB->select();
        $select->from(array('tp'=>'tranzgo_package'), array('*'));
        $select->where('tp.package_id =?',$idd);
        return $result = $this->DB->fetchRow($select);

    }

    public function delete_package($del_id)
    {
        $this->DB->update('tranzgo_package',array('is_delete'=>1),array("package_id=$del_id"));
        return true;
    }

    public function CheckDuplicatePackageName($Package_name,$idd=0)
    {
        $select =   $this->DB->select();
        $select->from(array('p'=>'tranzgo_package'),array('cnt'=>'COUNT(p.package_id)'));
        $select->where('p.package_name=?',$Package_name);
        if($idd)
        {
            $select->where('p.package_id<>?',$idd);
        }

        //print $select; exit;
        $ret = $this->DB->fetchRow($select);
        return $ret['cnt'];
    }



















}

?>