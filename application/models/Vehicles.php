<?php
/**
 * @author Eman Daryl Ycot
 * @copyright 2010
 */
class Vehicles extends Zend_Db_Table{

    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');

    }

    public function add_rental($company_id,
                               $assigned_vehicle_name,
                               $vehicle_type_id,
                               $max_passenger,
                               $transmission_id,
                               $make,
                               $model,
                               $year,
                               $color,
                               $garage_type_id,
                               $times_rented,
                               $rental_status,
                               $ses_user)
    {
        $query = array(
            'company_id' =>$company_id,
            'assigned_vehicle_name' => $assigned_vehicle_name,
            'vehicle_type_id' => $vehicle_type_id,
            'max_passenger' => $max_passenger,
            'transmission_id' => $transmission_id,
            'make' => $make,
            'model'=>$model,
            'year'=>$year,
            'color'=>$color,
            'garage_type_id'=>$garage_type_id,
            'times_rented'=>$times_rented,
            'added_by'=>$ses_user,
            'add_date' => CD,
            'mod_date' => CD,
            'rental_status'=>$rental_status,
            'is_active'=>1
        );

        $this->DB->insert('tranzgo_rental',$query);
        return $this->DB->lastInsertId();
    }

    public function add_rental_images($lastRentalId,$image_name,$image_type,$image_size)
    {
        $query = array(
            'rental_id' =>$lastRentalId,
            'image_name' => $image_name,
            'image_extension' => $image_type,
            'image_size' => $image_size
        );

        $this->DB->insert('tranzgo_rental_images',$query);
        return $this->DB->lastInsertId();
    }

    public function get_rental_list_rows($comp_id,$quick_search,$arr_limit,$arr_order)
    {

        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),
            array(
                'rental_id',
                'added_by',
                'company_id',
                'assigned_vehicle_name',
                'vehicle_type_id',
                'transmission_id',
                'garage_type_id',
                'model',
                'year',
                'rental_status',
                'is_active'
            ));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.added_by',array('added_by_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tc'=>'tranzgo_company'),'tc.company_id=tr.company_id',array('company_name'));
        $select->joinleft(array('trvt'=>'tranzgo_rental_vehicle_type'),'trvt.vehicle_type_id=tr.vehicle_type_id',array('vehicle_type_name'));
        $select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array('transmission_name'));
        $select->joinleft(array('tgt'=>'tranzgo_garage_type'),'tgt.garage_type_id=tr.garage_type_id',array('garage_type_name'));


        //$select->where('tr.rental_status=?',1);
        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }



        if($quick_search)
        {

            $select->where("
            trm.transmission_name like '%$quick_search%' or
            trvt.vehicle_type_name like '%$quick_search%' or
            tc.company_name like '%$quick_search%' or
            tr.model like '%$quick_search%' or
            tr.assigned_vehicle_name like '%$quick_search%' or
            tr.year like '%$quick_search%'");
        }

        $select->order('tr.'.$arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }

    public function get_rental_list_rows_count($comp_id,$quick_search)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),array('num'=>'count(tr.rental_id)'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.added_by',array());
        $select->joinleft(array('tc'=>'tranzgo_company'),'tc.company_id=tr.company_id',array());
        $select->joinleft(array('trvt'=>'tranzgo_rental_vehicle_type'),'trvt.vehicle_type_id=tr.vehicle_type_id',array());
        $select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array());
        $select->joinleft(array('tgt'=>'tranzgo_garage_type'),'tgt.garage_type_id=tr.garage_type_id',array());

        if($comp_id)
        {
            $select->where('tr.company_id=?',$comp_id);
        }

        if($quick_search)
        {

            $select->where("
            trm.transmission_name like '%$quick_search%' or
            trvt.vehicle_type_name like '%$quick_search%' or
            tc.company_name like '%$quick_search%' or
            tr.model like '%$quick_search%' or
            tr.assigned_vehicle_name like '%$quick_search%' or
            tr.year like '%$quick_search%'");
        }
        //print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }


    public function get_rental_list_rows_count1($company_id,
                                                $max_passenger,
                                                $vehicle_type_id,
                                                $transmission_id,
                                                $available_vehicles)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),array('num'=>'count(tr.rental_id)'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.added_by',array());
        $select->joinleft(array('tc'=>'tranzgo_company'),'tc.company_id=tr.company_id',array());
        $select->joinleft(array('trvt'=>'tranzgo_rental_vehicle_type'),'trvt.vehicle_type_id=tr.vehicle_type_id',array());
        $select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array());
        $select->where('tr.rental_status=?',1);
        if($max_passenger)
            $select->where('tr.max_passenger =?',$max_passenger);
        if($vehicle_type_id)
            $select->where('tr.vehicle_type_id =?',$vehicle_type_id);
        if($transmission_id)
            $select->where('tr.transmission_id =?',$transmission_id);
        if($available_vehicles)
        $select->where('tr.rental_id IN (?)',$available_vehicles);
        if($company_id)
            $select->where('tr.company_id=?',$company_id);

        //print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }







    public function get_rental_detail_from_idd($idd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'), array('*'));
        $select->where('tr.rental_id= ?', $idd);
        $result = $this->DB->fetchRow($select);

        return $result;
    }

    public function get_rental_images_from_idd($idd)
    {
        $select = $this->DB->select();
        $select->from(array('trimg'=>'tranzgo_rental_images'), array('*'));
        $select->where('trimg.rental_id= ?', $idd);

        $result = $this->DB->fetchAssoc($select);

        return $result;
    }

    public function get_rental_images_from_request_image_id($idd)
    {
        $select = $this->DB->select();
        $select->from(array('trimg'=>'tranzgo_rental_images'), array('rental_images_id','image_name'));
        $select->where('trimg.rental_images_id= ?', $idd);
        $result = $this->DB->fetchRow($select);
        return $result;
    }

    public function get_rental_images_from_request_id($idd)
    {
        $select = $this->DB->select();
        $select->from(array('trimg'=>'tranzgo_rental_images'), array('rental_images_id','image_name'));
        $select->where('trimg.rental_id= ?', $idd);
        //echo $select;exit;
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function delete_image($idd)
    {
        $this->DB->delete('tranzgo_rental_images', array( 'rental_images_id = ?' => $idd));
    }

    public function update_request($company_id,
                                   $assigned_vehicle_name,
                                   $vehicle_type_id,
                                   $max_passenger,
                                   $transmission_id,
                                   $make,
                                   $model,
                                   $year,
                                   $color,
                                   $garage_type_id,
                                   $times_rented,
                                   $rental_status,
                                   $idd)
    {

        $query = array(
            'company_id' =>$company_id,
            'assigned_vehicle_name' => $assigned_vehicle_name,
            'vehicle_type_id' => $vehicle_type_id,
            'max_passenger' => $max_passenger,
            'transmission_id' => $transmission_id,
            'make' => $make,
            'model'=>$model,
            'year'=>$year,
            'color'=>$color,
            'garage_type_id'=>$garage_type_id,
            'times_rented'=>$times_rented,
            'mod_date' => CD,
            'rental_status'=>$rental_status
        );

        $this->DB->update('tranzgo_rental',$query,array("rental_id=$idd"));
        return true;

    }

    public function add_request_images($lastRequestId,$image_name,$image_type,$image_size)
    {
        $query = array(
            'request_id' =>$lastRequestId,
            'image_name' => $image_name,
            'image_extension' => $image_type,
            'image_size' => $image_size
        );

        $this->DB->insert('tranzgo_request_images',$query);
        return $this->DB->lastInsertId();
    }

    public function get_transmission()
    {
        $select = $this->DB->select();
        $select->from(array('tt' => "tranzgo_transmission"), array('transmission_id','transmission_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_vehicle_type()
    {
        $select = $this->DB->select();
        $select->from(array('tvt' => "tranzgo_rental_vehicle_type"), array('vehicle_type_id','vehicle_type_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_rental_details_by_req_id($idd)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),array('*'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.added_by',array('added_by_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tc'=>'tranzgo_company'),'tc.company_id=tr.company_id',array('company_name'));
        $select->joinleft(array('trvt'=>'tranzgo_rental_vehicle_type'),'trvt.vehicle_type_id=tr.vehicle_type_id',array('vehicle_type_name'));
        $select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array('transmission_name'));
        $select->where("tr.rental_id =?",$idd);


        return $this->DB->fetchRow($select);
    }

    public function delete_rental($rental_id)
    {
        $this->DB->update('tranzgo_rental',array('is_delete'=>1),array("rental_id=$rental_id"));
    }

    public function CheckDuplicatePlateno($Plate_no,$idd)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),array('cnt'=>'COUNT(tr.rental_id)'));
        $select->where('assigned_vehicle_name=?',$Plate_no);
        if($idd)
        {
            $select->where('rental_id<>?',$idd);
        }

        //print $select; exit;
        $ret = $this->DB->fetchRow($select);
        return $ret['cnt'];
    }

    public function get_rental_schedule_from_idd($idd,$quick_search,$arr_limit,$arr_order)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array(
            'request_id',
            'rent_from',
            'rent_to',
            'delivery_address',
            'driver_task_id',
            'assigned_driver_1_id',
            'assigned_driver_2_id',
            'request_status_id'
        ));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.assigned_driver_1_id',array('assigned_driver_1_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.assigned_driver_2_id',array('assigned_driver_2_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('trs'=>'tranzgo_request_status'),'trs.request_status_id=tr.request_status_id',array('trs.request_status_name'));
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'),'tdt.driver_task_id=tr.driver_task_id',array('tdt.driver_task_name'));



        $select->where('tr.vehicle_id= ?', $idd);
        //echo $select;exit;

        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tr.delivery_address like '%$quick_search%' or
            trs.request_status_name like '%$quick_search%'");
        }
        if($arr_order)
        {
            $select->order('tr.'.$arr_order['col'].' '.$arr_order['typ']);
            if($arr_limit['limit'])
            {
                $select->limitPage($arr_limit['page'], $arr_limit['limit']);
            }
        }



        //echo $select;exit;



        $result = $this->DB->fetchAssoc($select);
        return $result;
    }



    public function get_rows_rental_schedule_from_idd($idd,$quick_search)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('num'=>'count(tr.request_id)'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.assigned_driver_1_id',array());
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.assigned_driver_2_id',array());
        $select->joinleft(array('trs'=>'tranzgo_request_status'),'trs.request_status_id=tr.request_status_id',array());

        $select->where('tr.vehicle_id= ?', $idd);
        //echo $select;exit;
        if($quick_search)
        {

            $select->where("
            tu.user_fname like '%$quick_search%' or
            tu.user_lname like '%$quick_search%' or
            tr.delivery_address like '%$quick_search%' or
            trs.request_status_name like '%$quick_search%'");
        }
        //print $select; exit;
        $result = $this->DB->fetchrow($select);
        return $result['num'];
    }

    public function get_events_by_date($idd,$date)
    {
        $rent_from = new Zend_Db_Expr("tr.rent_from_date = '$date'");
        $rent_to = new Zend_Db_Expr("tr.rent_to_date = '$date'");
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array(
            'request_id',
            'rent_from_str'=> new Zend_Db_Expr("DATE_FORMAT(tr.rent_from,'%b-%d-%Y %h:%i %p')"),
            'rent_to_str'=> new Zend_Db_Expr("DATE_FORMAT(tr.rent_to,'%b-%d-%Y %h:%i %p')"),
            'delivery_address',
            'pickup_address',
            'driver_task_id',
            'assigned_driver_1_id',
            'assigned_driver_2_id',
            'request_status_id'
        ));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.assigned_driver_1_id',array('assigned_driver_1_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'),'tu1.user_id=tr.assigned_driver_2_id',array('assigned_driver_2_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('trs'=>'tranzgo_request_status'),'trs.request_status_id=tr.request_status_id',array('trs.request_status_name'));
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'),'tdt.driver_task_id=tr.driver_task_id',array('tdt.driver_task_name'));



        $select->where('tr.vehicle_id= ?', $idd);
        $select->where("{$rent_from} OR {$rent_to}");
        //print $select; exit;

        $result = $this->DB->fetchRow($select);
        return $result;
    }

    function update_vehicle_status($idd,$status)
    {
        if($status==1)
        {
            $status=0;
        }else{
            $status=1;
        }
        $query = array(
            'rental_status'=>$status
        );

        $this->DB->update('tranzgo_rental',$query,array("rental_id=$idd"));
        return true;
    }


    public function get_vehicle_max_passenger()
    {
        $select = $this->DB->select();
        $select->from(array('tvmp'=>'tranzgo_vehicle_max_passenger'), array('*'));
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_garage_types()
    {
        $select = $this->DB->select();
        $select->from(array('gt'=>'tranzgo_garage_type'), array('*'));
        $select->where('gt.status =?',1);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }






    public function search_vehicle_advance($company_id,
                                           $max_passenger,
                                           $vehicle_type_id,
                                           $transmission_id,
                                           $available_vehicles,
                                           $arr_limit,
                                           $arr_order)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_rental'),
            array(
                'rental_id',
                'added_by',
                'company_id',
                'assigned_vehicle_name',
                'vehicle_type_id',
                'transmission_id',
                'model',
                'year',
                'rental_status',
                'is_active'
            ));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tr.added_by',array('added_by_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tc'=>'tranzgo_company'),'tc.company_id=tr.company_id',array('company_name'));
        $select->joinleft(array('trvt'=>'tranzgo_rental_vehicle_type'),'trvt.vehicle_type_id=tr.vehicle_type_id',array('vehicle_type_name'));
        $select->joinleft(array('trm'=>'tranzgo_transmission'),'trm.transmission_id=tr.transmission_id',array('transmission_name'));
        $select->where('tr.rental_status=?',1);
        if($max_passenger)
            $select->where('tr.max_passenger =?',$max_passenger);
        if($vehicle_type_id)
            $select->where('tr.vehicle_type_id =?',$vehicle_type_id);
        if($transmission_id)
            $select->where('tr.transmission_id =?',$transmission_id);
        if($available_vehicles)
        $select->where('tr.rental_id IN (?)',$available_vehicles);
        if($company_id)
        {
            $select->where('tr.company_id=?',$company_id);
        }
        if($arr_order['col'] || $arr_order['typ'])
        {
            $select->order('tr.'.$arr_order['col'].' '.$arr_order['typ']);
        }
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }
        //echo $select; exit;


        return $this->DB->fetchAssoc($select);

    }











































}

?>