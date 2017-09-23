<?php
/**
 * @author Eman Daryl Ycot
 * @copyright 2010
 */
class Request extends Zend_Db_Table
{
    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');
    }

    public function get_request()
    {
        $select = $this->DB->select();
        $select->from(array('trs' => "tranzgo_request_status"), array('request_status_id','request_status_name' ));
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_driver_task()
    {
        $select = $this->DB->select();
        $select->from(array('tdt' => "tranzgo_driver_tasks"), array('driver_task_id','driver_task_name' ));
        $select->where('tdt.driver_task_status =?', 1);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
    public function get_package()
    {
        $select = $this->DB->select();
        $select->from(array('tp' => "tranzgo_package"), array('package_id','package_name' ));
        $select->where('tp.package_status =?', 1);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
    public function get_assigned_vehicle()
    {
        $select = $this->DB->select();
        $select->from(array('tr' => "tranzgo_rental"), array('rental_id','assigned_vehicle_name' ));
        $select->where('tr.is_delete =?', 0);
        $select->where('tr.rental_status =?', 1);

        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_assigned_vehicle_by_comp($company_id)
    {
        $select = $this->DB->select();
        $select->from(array('tr' => "tranzgo_rental"), array('rental_id','assigned_vehicle_name' ));
        $select->where('tr.is_delete =?', 0);
        $select->where('tr.company_id =?', $company_id);
        $select->where('tr.rental_status =?', 1);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_request_rate()
    {
        $select = $this->DB->select();
        $select->from(array('trr' => "tranzgo_request_rate"), array('request_rate_id','request_rate_name' ));
        $select->where('trr.request_rate_status =?', 1);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
    public function get_payment_method()
    {
        $select = $this->DB->select();
        $select->from(array('tpm' => "tranzgo_payment_method"), array('payment_method_id','payment_method_name' ));
        $select->where('tpm.payment_method_status =?', 1);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_driver_list()
    {
        $select =   $this->DB->select();
        $select->from(
            array('tu'=>'tranzgo_user'),
            array(
                'user_id',
                'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                'account_id'
            )
        );
        $select->joinleft(array('ta'=>'tranzgo_account'), 'ta.account_id=tu.account_id', array());
        $select->joinleft(array('tuld'=>'tranzgo_user_login_details'), 'tuld.user_id=tu.user_id', array('is_delete'));
        $select->where('ta.account_id=?', 4);
        $select->where('tuld.is_delete =?', 0);
        $select->where('tuld.is_active =?', 1);

        return $this->DB->fetchAssoc($select);
    }

    public function get_driver_list_by_comp($company_id)
    {
        $select =   $this->DB->select();
        $select->from(
            array('tu'=>'tranzgo_user'),
            array(
                'user_id',
                'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                'account_id'
            )
        );
        $select->joinleft(array('ta'=>'tranzgo_account'), 'ta.account_id=tu.account_id', array());
        $select->joinleft(array('tuld'=>'tranzgo_user_login_details'), 'tuld.user_id=tu.user_id', array('is_delete'));
        $select->where('ta.account_id=?', 4);
        $select->where('tuld.is_delete =?', 0);
        $select->where('tuld.is_active =?', 1);
        $select->where('tu.company_id =?', $company_id);
        return $this->DB->fetchAssoc($select);
    }







    public function add_request(
        $request_status_id,
                                $driver_task_id,
                                $last_cust_id,
                                $package_id,
                                $vehicle_id,
                                $rate_id,
                                $rent_from,
                                $no_of_days,
                                $rent_to,
                                $delivery_address,
                                $assigned_driver_1_id,
                                $pickup_address,
                                $assigned_driver_2_id,
                                $payment_method_id,
                                $estimated_price,
                                $company_id,
                                $note,
                                $ses_user
    ) {
        $query = array(
            'request_status_id' =>$request_status_id,
            'driver_task_id' => $driver_task_id,
            'customer_id' => $last_cust_id,
            'package_id' => $package_id,
            'vehicle_id' => $vehicle_id,
            'rate_id' => $rate_id,
            'rent_from'=>$rent_from,
            'no_of_days'=>$no_of_days,
            'rent_to'=>$rent_to,
            'rent_from_date'=>date('Y-m-d', strtotime($rent_from)),
            'rent_to_date'=>date('Y-m-d', strtotime($rent_to)),
            'delivery_address'=>$delivery_address,
            'assigned_driver_1_id'=>$assigned_driver_1_id,
            'pickup_address'=>$pickup_address,
            'assigned_driver_2_id'=>$assigned_driver_2_id,
            'payment_method_id'=>$payment_method_id,
            'estimated_price'=>$estimated_price,
            'note'=>$note,
            'requested_by'=>$ses_user,
            'company_id'=>$company_id,
            'requested_date' => CD,
            'add_date' => CD,
            'mod_date' => CD,
            'is_active'=>1
        );


        $this->DB->insert('tranzgo_request', $query);
        return $this->DB->lastInsertId();
    }

    public function add_request_generated_id($request_generated_id, $lastRequestId)
    {
        $query = array(
            'req_gen_id' =>$request_generated_id
        );
        $this->DB->update('tranzgo_request', $query, array("request_id=$lastRequestId"));
    }




    public function update_request(
        $request_status_id,
                                $driver_task_id,
                                $last_cust_id,
                                $package_id,
                                $vehicle_id,
                                $rate_id,
                                $rent_from,
                                $no_of_days,
                                $rent_to,
                                $delivery_address,
                                $assigned_driver_1_id,
                                $pickup_address,
                                $assigned_driver_2_id,
                                $payment_method_id,
                                $estimated_price,
                                $company_id,
                                $note,
                                $ses_user,
                                $idd
    ) {
        if ($request_status_id) {
            $query = array(
                'request_status_id' =>$request_status_id,
                'driver_task_id' => $driver_task_id,
                'customer_id' => $last_cust_id,
                'package_id' => $package_id,
                'vehicle_id' => $vehicle_id,
                'rate_id' => $rate_id,
                'rent_from'=>$rent_from,
                'no_of_days'=>$no_of_days,
                'rent_to'=>$rent_to,
                'rent_from_date'=>date('Y-m-d', strtotime($rent_from)),
                'rent_to_date'=>date('Y-m-d', strtotime($rent_to)),
                'delivery_address'=>$delivery_address,
                'assigned_driver_1_id'=>$assigned_driver_1_id,
                'pickup_address'=>$pickup_address,
                'assigned_driver_2_id'=>$assigned_driver_2_id,
                'payment_method_id'=>$payment_method_id,
                'estimated_price'=>$estimated_price,
                'note'=>$note,
                'company_id'=>$company_id,
                'requested_by'=>$ses_user,
                'mod_date' => CD,
            );
        } else {
            $query = array(
                'driver_task_id' => $driver_task_id,
                'customer_id' => $last_cust_id,
                'package_id' => $package_id,
                'vehicle_id' => $vehicle_id,
                'rate_id' => $rate_id,
                'rent_from'=>$rent_from,
                'no_of_days'=>$no_of_days,
                'rent_to'=>$rent_to,
                'rent_from_date'=>date('Y-m-d', strtotime($rent_from)),
                'rent_to_date'=>date('Y-m-d', strtotime($rent_to)),
                'delivery_address'=>$delivery_address,
                'assigned_driver_1_id'=>$assigned_driver_1_id,
                'pickup_address'=>$pickup_address,
                'assigned_driver_2_id'=>$assigned_driver_2_id,
                'payment_method_id'=>$payment_method_id,
                'estimated_price'=>$estimated_price,
                'note'=>$note,
                'company_id'=>$company_id,
                'requested_by'=>$ses_user,
                'mod_date' => CD,
            );
        }



        $this->DB->update('tranzgo_request', $query, array("request_id=$idd"));
        return true;
    }

    public function update_request1(
        $idd,
                                    $driver_task_id,
                                    $vehicle_id,
                                    $delivery_address,
                                    $assigned_driver_1_id,
                                    $pickup_address,
                                    $assigned_driver_2_id,
                                    $is_assigned
    ) {
        $query = array(
                'driver_task_id' => $driver_task_id,
                'vehicle_id' => $vehicle_id,
                'delivery_address'=>$delivery_address,
                'assigned_driver_1_id'=>$assigned_driver_1_id,
                'pickup_address'=>$pickup_address,
                'assigned_driver_2_id'=>$assigned_driver_2_id,
                'is_assigned'=>$is_assigned,
                'mod_date' => CD,
            );
        $this->DB->update('tranzgo_request', $query, array("request_id=$idd"));
        return true;
    }






    public function add_request_images($lastRequestId, $image_name, $image_type, $image_size)
    {
        $query = array(
            'request_id' =>$lastRequestId,
            'image_name' => $image_name,
            'image_extension' => $image_type,
            'image_size' => $image_size
        );

        $this->DB->insert('tranzgo_request_images', $query);
        return $this->DB->lastInsertId();
    }

    public function get_request_list_rows($comp_id, $request_status, $ses_user1, $quick_search, $arr_limit, $arr_order)
    {
        $select =   $this->DB->select();
        $select->from(
            array('tr'=>'tranzgo_request'),
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
                'driver_status_id',
                'delivery_address',
                'pickup_address'

            )
        );
        $select->joinleft(array('trs'=>'tranzgo_request_status'), 'tr.request_status_id=trs.request_status_id', array('request_status_name'));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'), 'tr.driver_status_id=tds.driver_status_id', array('status_name'));
        $select->joinleft(array('tu'=>'tranzgo_user'), 'tu.user_id=tr.assigned_driver_1_id', array('tu.user_fname','tu.user_lname', 'assigned_driver_1_id_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tr.assigned_driver_2_id', array('tu1.user_fname','tu1.user_lname','assigned_driver_2_id_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('tu11'=>'tranzgo_user'), 'tu11.user_id=tr.requested_by', array('requested_by_name'=>new Zend_Db_Expr("CONCAT(tu11.user_fname,' ',tu11.user_lname)")));
        $select->joinleft(array('tcu'=>'tranzgo_customers'), 'tcu.customer_id=tr.customer_id', array('tcu.customer_name','tcu.contact_number'));
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'), 'tr.driver_task_id=tdt.driver_task_id', array('driver_task_name','driver_task_status'));
        $select->joinleft(array('trl'=>'tranzgo_rental'), 'trl.rental_id=tr.vehicle_id', array('assigned_vehicle_name','rental_id','garage'));
        $select->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tr.company_id', array('company_name'));
        //$select->joinleft(array('tgt'=>'tranzgo_garage_type'), 'tgt.garage_type_id=trl.garage_type_id', array('garage_type_name'));


        $select->where('tr.is_delete=?', 0);
        $select->where('tr.request_status_id IN(?)', $request_status);
        if ($comp_id) {
            $select->where('tr.company_id=?', $comp_id);
        }


        /*  if($ses_user1)
          {
              $select->where('tr.requested_by=?',$ses_user1);
          }*/

        if ($ses_user1) {
            $select->where("tr.assigned_driver_1_id=$ses_user1 OR tr.assigned_driver_2_id=$ses_user1");
        }

        if ($quick_search) {
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
        if ($arr_limit['limit']) {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }
    public function get_request_list_rows_count($comp_id, $request_status, $ses_user1, $quick_search)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('num'=>'count(tr.request_id)'));
        $select->joinleft(array('trs'=>'tranzgo_request_status'), 'tr.request_status_id=trs.request_status_id', array());
        $select->joinleft(array('tds'=>'tranzgo_driver_status'), 'tr.driver_status_id=tds.driver_status_id', array());
        $select->joinleft(array('tu'=>'tranzgo_user'), 'tu.user_id=tr.assigned_driver_1_id', array());
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tr.assigned_driver_2_id', array());
        $select->joinleft(array('tcu'=>'tranzgo_customers'), 'tcu.customer_id=tr.customer_id', array());
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'), 'tr.driver_task_id=tdt.driver_task_id', array());
        $select->joinleft(array('trl'=>'tranzgo_rental'), 'trl.rental_id=tr.vehicle_id', array());
        $select->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tr.company_id', array());
        //$select->joinleft(array('tgt'=>'tranzgo_garage_type'), 'tgt.garage_type_id=trl.garage_type_id', array());
        $select->where('tr.is_delete=?', 0);
        $select->where('tr.request_status_id IN(?)', $request_status);
        if ($comp_id) {
            $select->where('tr.company_id=?', $comp_id);
        }

        /* if($ses_user1)
         {
             $select->where('tr.requested_by=?',$ses_user1);
         }*/
        if ($ses_user1) {
            $select->where("tr.assigned_driver_1_id=$ses_user1 OR tr.assigned_driver_2_id=$ses_user1");
        }
        if ($quick_search) {
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


    public function get_request_detail_from_idd($idd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array(
            'request_id',
            'requested_by',
            'request_status_id',
            'driver_task_id',
            'rent_from',
            'no_of_days',
            'rent_to',
            'customer_id',
            'package_id',
            'vehicle_id',
            'rate_id',
            'delivery_address',
            'assigned_driver_1_id',
            'assigned_driver_2_id',
            'pickup_address',
            'note',
            'estimated_price',
            'payment_method_id',
            'company_id'
        ));
        $select->joinleft(array('tcu'=>'tranzgo_customers'), 'tr.customer_id=tcu.customer_id', array('customer_name'=>new Zend_Db_Expr("CONCAT(tcu.customer_name,' ( ',tcu.contact_number,' ) ' )")));
        $select->where('tr.request_id= ?', $idd);
        $result = $this->DB->fetchRow($select);
        return $result;
    }






    public function get_request_images_from_idd($idd)
    {
        $select = $this->DB->select();
        $select->from(array('trimg'=>'tranzgo_request_images'), array(
            'request_image_id',
            'request_id',
            'image_name',
            'image_extension',
            'image_size'
        ));
        $select->where('trimg.request_id= ?', $idd);

        $result = $this->DB->fetchAssoc($select);

        return $result;
    }

    public function get_request_images_from_request_image_id($idd)
    {
        $select = $this->DB->select();
        $select->from(array('trimg'=>'tranzgo_request_images'), array('request_image_id','image_name'));
        $select->where('trimg.request_image_id= ?', $idd);
        $result = $this->DB->fetchRow($select);
        return $result;
    }

    public function get_request_images_from_request_id($idd)
    {
        $select = $this->DB->select();
        $select->from(array('trimg'=>'tranzgo_request_images'), array('request_image_id','image_name'));
        $select->where('trimg.request_id= ?', $idd);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }




    public function delete_image($idd)
    {
        $this->DB->delete('tranzgo_request_images', array( 'request_image_id = ?' => $idd));
    }
    public function delete_all_image_by_req_id($idd)
    {
        $this->DB->delete('tranzgo_request_images', array( 'request_id = ?' => $idd));
    }

    public function delete_request($request_id)
    {
        $this->DB->update('tranzgo_request', array('is_delete'=>1), array("request_id=$request_id"));
    }

    public function get_all_customers($company_id, $ses_user)
    {
        $select = $this->DB->select();
        $select->distinct();
        $select->from(array('tr'=>'tranzgo_customers'), array('customer_id','customer_name','contact_number'));
        if ($company_id) {
            $select->where('tr.company_id=?', $company_id);
            $select->where('tr.added_by=?', $ses_user);
        }

        $result = $this->DB->fetchAssoc($select);
        return $result;
    }


    public function get_request_details_by_req_id($idd)
    {
        $select =   $this->DB->select();
        $select->from(
            array('tr'=>'tranzgo_request'),
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
                'payment_method_id',
                'package_id',
                'rate_id',
                'note',
                'delivery_address',
                'mod_date',
                'pickup_address',
                'req_gen_id',
                'estimated_price',
                'company_id',
                'driver_status_id',
            )
        );
        $select->joinleft(array('trs'=>'tranzgo_request_status'), 'tr.request_status_id=trs.request_status_id', array('request_status_name'));
        $select->joinleft(array('tu'=>'tranzgo_user'), 'tu.user_id=tr.assigned_driver_1_id', array('assigned_driver_1_id_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tr.assigned_driver_2_id', array('assigned_driver_2_id_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('tu11'=>'tranzgo_user'), 'tu11.user_id=tr.requested_by', array('requested_by_name'=>new Zend_Db_Expr("CONCAT(tu11.user_fname,' ',tu11.user_lname)")));
        $select->joinleft(array('tp'=>'tranzgo_package'), 'tp.package_id=tr.package_id', array('package_name','package_status'));
        $select->joinleft(array('trt'=>'tranzgo_request_rate'), 'trt.request_rate_id=tr.rate_id', array('request_rate_name','request_rate_status'));
        $select->joinleft(array('tpm'=>'tranzgo_payment_method'), 'tr.payment_method_id=tpm.payment_method_id', array('payment_method_name','payment_method_status'));
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'), 'tr.driver_task_id=tdt.driver_task_id', array('driver_task_name','driver_task_status'));
        $select->joinleft(array('tav'=>'tranzgo_assigned_vehicle'), 'tr.vehicle_id=tav.assigned_vehicle_id', array('assigned_vehicle_name','assigned_vehicle_status'));
        $select->joinleft(array('tc'=>'tranzgo_company'), 'tr.company_id=tc.company_id', array('company_name'));
        $select->joinleft(array('tcu'=>'tranzgo_customers'), 'tr.customer_id=tcu.customer_id', array('customer_name','contact_number'));



        $select->where('tr.is_delete=?', 0);
        $select->where('tr.request_id=?', $idd);


        //print $select; exit;
        return $this->DB->fetchRow($select);
    }

    public function update_request_status($status, $request_id)
    {
        $query = array('request_status_id' =>$status);
        $this->DB->update('tranzgo_request', $query, array("request_id=$request_id"));
    }

    public function update_driver_status($status, $request_id)
    {
        $query = array('driver_status_id' =>$status);
        $this->DB->update('tranzgo_request', $query, array("request_id=$request_id"));
    }






    public function insert_request_status($ses_user, $status, $request_id)
    {
        $query = array(
            'change_by' =>$ses_user,
            'request_id' => $request_id,
            'request_status_id' => $status,
            'date_time' => CD
        );

        $this->DB->insert('tranzgo_request_status_change_log', $query);
        return $this->DB->lastInsertId();
    }

    public function insert_driver_status($ses_user, $status, $request_id)
    {
        $query = array(
            'driver_id' =>$ses_user,
            'request_id' => $request_id,
            'driver_status_id' => $status,
            'date_time' => CD
        );

        $this->DB->insert('tranzgo_driver_status_change_log', $query);
        return $this->DB->lastInsertId();
    }



    public function get_package_by_id($package_id)
    {
        $select = $this->DB->select();
        $select->from(array('tp' => "tranzgo_package"), array('price'));
        $select->where('tp.package_status =?', 1);
        $select->where('tp.package_id =?', $package_id);
        $result = $this->DB->fetchRow($select);
        return $result;
    }

    public function check_exist_vehicle($rent_from, $rent_to, $company_id, $rental_id)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('request_id','company_id','vehicle_id'));
        $select->where("'$rent_from'<>tr.rent_from");
        $select->where("'$rent_from'<>tr.rent_to");
        $select->where("'$rent_to'<>tr.rent_from");
        $select->where("'$rent_to'<>tr.rent_to");
        $select->where("'$rent_from' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_to' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_from' < tr.rent_from AND '$rent_to'< tr.rent_from OR '$rent_from' > tr.rent_to AND '$rent_to' > tr.rent_to");
        $select->where("tr.is_delete=?", 0);
        //echo $select;exit;
        if ($company_id) {
            $select->where("tr.company_id=?", $company_id);
        }
        $result = $this->DB->fetchAll($select);
        $available  =array();
        $not_available  =array();

        foreach ($result as $k1=>$v) {
            $available[] = $v['request_id'];
        }
        if (count($available) > 0) {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','company_id','vehicle_id'));
            $select1->where("tr.request_id NOT IN (?)", $available);
            if ($company_id) {
                $select->where("tr.company_id=?", $company_id);
            }
            $result1 =  $this->DB->fetchAll($select1);
        } else {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','company_id','vehicle_id'));
            if ($company_id) {
                $select->where("tr.company_id=?", $company_id);
            }
            //echo $select1;exit;
            $result1 =  $this->DB->fetchAll($select1);
        }

        if (count($result1) > 0) {
            foreach ($result1 as $k1=>$v) {
                $not_available[] = $v['vehicle_id'];
            }

            if (in_array($rental_id, $not_available)) {
                $key = array_search($rental_id, $not_available);
                unset($not_available[$key]);
            }

            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_rental'), array('rental_id','assigned_vehicle_name'));
            if (count($not_available) > 0) {
                $select1->where("tr.rental_id NOT IN (?)", $not_available);
            }
            $select1->where("tr.is_delete=0");
            $select1->where("tr.rental_status=1");

            if ($company_id) {
                $select1->where("tr.company_id=?", $company_id);
            }
            //echo $select1;exit;
        } else {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_rental'), array('rental_id','assigned_vehicle_name'));
            $select1->where("tr.is_delete=0");
            $select1->where("tr.rental_status=1");
            if ($company_id) {
                $select1->where("tr.company_id=?", $company_id);
            }
        }
        return $this->DB->fetchAll($select1);
    }
    public function check_exist_drivers1($rent_from, $rent_to, $company_id, $didd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('request_id','assigned_driver_1_id','assigned_driver_2_id'));
        $select->where("'$rent_from'<>tr.rent_from");
        $select->where("'$rent_from'<>tr.rent_to");
        $select->where("'$rent_to'<>tr.rent_from");
        $select->where("'$rent_to'<>tr.rent_to");
        $select->where("'$rent_from' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_to' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_from' < tr.rent_from AND '$rent_to'< tr.rent_from OR '$rent_from' > tr.rent_to AND '$rent_to' > tr.rent_to");
        $select->where("tr.is_delete=?", 0);


        $result = $this->DB->fetchAll($select);
        $available  =array();
        $not_available  =array();

        foreach ($result as $k1=>$v) {
            $available[] = $v['request_id'];
            //$available[] = $v['assigned_driver_1_id'] ? $v['assigned_driver_1_id'] : $v['assigned_driver_2_id'];
        }
        //echo '<pre>'; print_r($available); exit;
        if (count($available) > 0) {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','assigned_driver_1_id','assigned_driver_2_id'));
            $select1->where("tr.request_id NOT IN (?)", $available);
            $result1 =  $this->DB->fetchAll($select1);
        } else {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','assigned_driver_1_id','assigned_driver_2_id'));
            //$select1->where("tr.assigned_driver_1_id !=? ",0);
            $result1 =  $this->DB->fetchAll($select1);
        }
        //echo '<pre>'; print_r($result1); exit;
        if (count($result1) > 0) {
            foreach ($result1 as $k1=>$v) {
                $not_available[] = $v['assigned_driver_1_id'] ? $v['assigned_driver_1_id'] : $v['assigned_driver_2_id'];
            }
            //echo '<pre>'; print_r($not_available); exit;
            if ($didd) {
                if (in_array($didd, $not_available)) {
                    $key = array_search($didd, $not_available);
                    unset($not_available[$key]);
                }
            }

            //echo '<pre>'; print_r($not_available); exit;
            $select1 =   $this->DB->select();
            $select1->from(
                array('tu'=>'tranzgo_user'),
                array(
                    'user_id',
                    'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                    'account_id'
                )
            );
            $select1->joinleft(array('ta'=>'tranzgo_account'), 'ta.account_id=tu.account_id', array());
            $select1->joinleft(array('tuld'=>'tranzgo_user_login_details'), 'tuld.user_id=tu.user_id', array());
            $select1->where('ta.account_id=?', 4);
            if (count($not_available) > 0) {
                $select1->where("tu.user_id NOT IN (?)", $not_available);
            }
            $select1->where('tuld.is_delete =?', 0);
            $select1->where('tuld.is_active =?', 1);
            if ($company_id) {
                $select1->where("tu.company_id=?", $company_id);
            }
        } else {
            $select1 =   $this->DB->select();
            $select1->from(
                array('tu'=>'tranzgo_user'),
                array(
                    'user_id',
                    'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                    'account_id'
                )
            );
            $select1->joinleft(array('ta'=>'tranzgo_account'), 'ta.account_id=tu.account_id', array());
            $select1->joinleft(array('tuld'=>'tranzgo_user_login_details'), 'tuld.user_id=tu.user_id', array());
            $select1->where('ta.account_id=?', 4);
            $select1->where('tuld.is_delete =?', 0);
            $select1->where('tuld.is_active =?', 1);
            if ($company_id) {
                $select1->where("tu.company_id=?", $company_id);
            }
        }
        return $this->DB->fetchAll($select1);
    }

    public function check_exist_drivers2($rent_from, $rent_to, $company_id, $didd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('request_id','assigned_driver_2_id'));
        $select->where("'$rent_from'<>tr.rent_from");
        $select->where("'$rent_from'<>tr.rent_to");
        $select->where("'$rent_to'<>tr.rent_from");
        $select->where("'$rent_to'<>tr.rent_to");
        $select->where("'$rent_from' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_to' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_from' < tr.rent_from AND '$rent_to'< tr.rent_from OR '$rent_from' > tr.rent_to AND '$rent_to' > tr.rent_to");
        $select->where("tr.is_delete=?", 0);

        $result = $this->DB->fetchAll($select);
        $available  =array();
        $not_available  =array();

        foreach ($result as $k1=>$v) {
            $available[] = $v['request_id'];
        }

        if (count($available) > 0) {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','assigned_driver_2_id'));
            $select1->where("tr.request_id NOT IN (?)", $available);

            $result1 =  $this->DB->fetchAll($select1);
        } else {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','assigned_driver_2_id'));
            $select1->where("tr.assigned_driver_2_id !=? ", 0);
            $result1 =  $this->DB->fetchAll($select1);
        }
        // exit;


        if (count($result1) > 0) {
            foreach ($result1 as $k1=>$v) {
                $not_available[] = $v['assigned_driver_2_id'];
            }
            if (in_array($didd, $not_available)) {
                $key = array_search($didd, $not_available);
                unset($not_available[$key]);
            }
            $select1 =   $this->DB->select();
            $select1->from(
                array('tu'=>'tranzgo_user'),
                array(
                    'user_id',
                    'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                    'account_id'
                )
            );
            $select1->joinleft(array('ta'=>'tranzgo_account'), 'ta.account_id=tu.account_id', array());
            $select1->joinleft(array('tuld'=>'tranzgo_user_login_details'), 'tuld.user_id=tu.user_id', array());
            $select1->where('ta.account_id=?', 4);
            if (count($not_available) > 0) {
                $select1->where("tu.user_id NOT IN (?)", $not_available);
            }
            $select1->where('tuld.is_delete =?', 0);
            $select1->where('tuld.is_active =?', 1);

            if ($company_id) {
                $select1->where("tu.company_id=?", $company_id);
            }

            echo $select1;
            exit;
        } else {
            $select1 =   $this->DB->select();
            $select1->from(
                array('tu'=>'tranzgo_user'),
                array(
                    'user_id',
                    'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                    'account_id'
                )
            );
            $select1->joinleft(array('ta'=>'tranzgo_account'), 'ta.account_id=tu.account_id', array());
            $select1->joinleft(array('tuld'=>'tranzgo_user_login_details'), 'tuld.user_id=tu.user_id', array());
            $select1->where('ta.account_id=?', 4);
            $select1->where('tuld.is_delete =?', 0);
            $select1->where('tuld.is_active =?', 1);
            if ($company_id) {
                $select1->where("tu.company_id=?", $company_id);
            }
        }
        return $this->DB->fetchAll($select1);
    }

    public function get_request_list($idd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('request_id',
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
            'pickup_address',
            'delivery_address',
            'company_id'));
        $select->joinleft(array('trs'=>'tranzgo_request_status'), 'tr.request_status_id=trs.request_status_id', array('request_status_name'));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'), 'tr.driver_status_id=tds.driver_status_id', array('status_name'));
        $select->joinleft(array('tu'=>'tranzgo_user'), 'tu.user_id=tr.assigned_driver_1_id', array('tu.user_fname','tu.user_lname', 'assigned_driver_1_id_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tr.assigned_driver_2_id', array('tu1.user_fname','tu1.user_lname','assigned_driver_2_id_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('tu11'=>'tranzgo_user'), 'tu11.user_id=tr.requested_by', array('requested_by_name'=>new Zend_Db_Expr("CONCAT(tu11.user_fname,' ',tu11.user_lname)")));

        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'), 'tr.driver_task_id=tdt.driver_task_id', array('driver_task_name','driver_task_status'));
        $select->joinleft(array('trl'=>'tranzgo_rental'), 'trl.rental_id=tr.vehicle_id', array('assigned_vehicle_name','rental_id'));
        $select->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tr.company_id', array('company_name'));
        $select->joinleft(array('tcus'=>'tranzgo_customers'), 'tcus.customer_id=tr.customer_id', array('customer_name','contact_number'));

        $select->where('tr.is_delete=?', 0);
        $select->where("tr.assigned_driver_1_id=$idd OR tr.assigned_driver_2_id=$idd");


        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function get_the_driver1($req_idd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array());
        $select->joinleft(
            array('tu'=>'tranzgo_user'),
            array('user_id',
                'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                'account_id'
                )
        );
        $select->where('tr.is_delete=?', 0);
        $select->where('tr.request_id=?', $req_idd);
        $result = $this->DB->fetchRow($select);
        return $result;
    }

    public function get_the_driver2($req_idd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array());
        $select->joinleft(
            array('tu'=>'tranzgo_user'),
            array('user_id',
                'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                'account_id'
            )
        );
        $select->where('tr.is_delete=?', 0);
        $select->where('tr.request_id=?', $req_idd);
        $result = $this->DB->fetchRow($select);
        return $result;
    }

    public function get_customer_id($req_idd)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array());
        $select->joinleft(
            array('tu'=>'tranzgo_user'),
            array('user_id',
                'user_full_name'=>new Zend_Db_Expr("CONCAT(user_fname,' ',user_lname)"),
                'account_id'
            )
        );
        $select->where('tr.is_delete=?', 0);
        $select->where('tr.request_id=?', $req_idd);
        $result = $this->DB->fetchRow($select);
        return $result;
    }

    public function get_customer_from_name($cust_name, $cust_contact)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_customers'), array('customer_id'));
        $select->where('tr.customer_name=?', $cust_name);
        $select->where('tr.contact_number=?', $cust_contact);
        $result = $this->DB->fetchRow($select);
        return $result['customer_id'];
    }

    public function add_customer($data_customer)
    {
        $this->DB->insert('tranzgo_customers', $data_customer);
        return $this->DB->lastInsertId();
    }

    public function driver_status_change_log($idd)
    {
        $select = $this->DB->select();
        $select->from(array('a'=>'tranzgo_driver_status_change_log'), array('*'));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'), 'tds.driver_status_id=a.driver_status_id', array('status_name'));
        $select->joinleft(array('u'=>'tranzgo_user'), 'u.user_id=a.driver_id', array('user_fname','user_lname'));
        $select->where('a.request_id=?', $idd);
        $select->order('log_id DESC');

        // $sql = $select->__toString();
        // echo "$sql\n";
        return $this->DB->fetchAssoc($select);
    }





    public function check_exist_drivers($rent_from, $rent_to, $company_id, $rental_id)
    {
        $select = $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('request_id','company_id','driver_id'=>new Zend_Db_Expr("CASE WHEN assigned_driver_1_id<>'' THEN assigned_driver_1_id ELSE assigned_driver_2_id END")));
        $select->where("'$rent_from'<>tr.rent_from");
        $select->where("'$rent_from'<>tr.rent_to");
        $select->where("'$rent_to'<>tr.rent_from");
        $select->where("'$rent_to'<>tr.rent_to");
        $select->where("'$rent_from' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_to' NOT BETWEEN tr.rent_from AND tr.rent_to");
        $select->where("'$rent_from' < tr.rent_from AND '$rent_to'< tr.rent_from OR '$rent_from' > tr.rent_to AND '$rent_to' > tr.rent_to");
        $select->where("tr.is_delete=?", 0);
        //echo $select;exit;
        if ($company_id) {
            $select->where("tr.company_id=?", $company_id);
        }
        $result = $this->DB->fetchAll($select);
        $available  =array();
        $not_available  =array();

        foreach ($result as $k1=>$v) {
            $available[] = $v['request_id'];
        }

        //echo '<pre>'; print_r($available); exit;

        if (count($available) > 0) {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','company_id','vehicle_id','driver_id'=>new Zend_Db_Expr("CASE WHEN assigned_driver_1_id<>'' THEN assigned_driver_1_id ELSE assigned_driver_2_id END")));
            $select1->where("tr.request_id NOT IN (?)", $available);
            if ($company_id) {
                $select->where("tr.company_id=?", $company_id);
            }
            $result1 =  $this->DB->fetchAll($select1);
        } else {
            $select1 = $this->DB->select();
            $select1->from(array('tr'=>'tranzgo_request'), array('request_id','company_id','vehicle_id','driver_id'=>new Zend_Db_Expr("CASE WHEN assigned_driver_1_id<>'' THEN assigned_driver_1_id ELSE assigned_driver_2_id END")));
            if ($company_id) {
                $select->where("tr.company_id=?", $company_id);
            }
            //echo $select1;exit;
            $result1 =  $this->DB->fetchAll($select1);
        }

        if (count($result1) > 0) {
            foreach ($result1 as $k1=>$v) {
                $not_available[] = $v['driver_id'];
            }

            /*if(in_array($rental_id,$not_available))
            {
                $key = array_search ($rental_id, $not_available);
                unset($not_available[$key]);
            }*/



            $select1 = $this->DB->select();
            $select1->from(array('tu'=>'tranzgo_user'), array('user_id','user_fname','user_lname','email','account_id'));
            $select1->joinleft(array('u1'=>'tranzgo_user_login_details'), 'u1.user_id=tu.user_id', array('is_active','is_delete'));
            $select1->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tu.company_id', array('company_name'));
            if (count($not_available) > 0) {
                $select1->where("tu.user_id NOT IN (?)", $not_available);
            }
            $select1->where("u1.is_active=1");
            $select1->where("u1.is_delete=0");
            $select1->where("tu.account_id=4");

            if ($company_id) {
                $select1->where("tr.company_id=?", $company_id);
            }
            //echo $select1;exit;
        } else {
            $select1 = $this->DB->select();
            $select1->from(array('tu'=>'tranzgo_user'), array('user_id','user_fname','user_lname','email','account_id'));
            $select1->joinleft(array('u1'=>'tranzgo_user_login_details'), 'u1.user_id=tu.user_id', array('is_active','is_delete'));
            $select1->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tu.company_id', array('company_name'));
            $select1->where("u1.is_active=1");
            $select1->where("u1.is_delete=0");
            $select1->where("tu.account_id=4");
            if ($company_id) {
                $select1->where("tr.company_id=?", $company_id);
            }
        }
        return $this->DB->fetchAll($select1);
    }









    public function search_driver_advance($company_id, $available_divers, $arr_limit, $arr_order)
    {
        $select =   $this->DB->select();
        $select->from(
            array('tu'=>'tranzgo_user'),
            array(
                'user_id',
                'created_by',
                'driver_name'=> new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)"),
                'email',
                'company_id'
            )
        );
        $select->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tu.company_id', array('company_name'));
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tu.created_by', array('added_by_name'=> new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_fname)")));

        if ($available_divers) {
            $select->where('tu.user_id IN (?)', $available_divers);
        }
        if ($company_id) {
            $select->where('tu.company_id=?', $company_id);
        }
        $select->order('tu.'.$arr_order['col'].' '.$arr_order['typ']);
        if ($arr_limit['limit']) {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }
        //echo $select; exit;


        return $this->DB->fetchAssoc($select);
    }








    public function get_driver_list_rows_count($company_id, $available_divers)
    {
        $select = $this->DB->select();
        $select->from(array('tu'=>'tranzgo_user'), array('num'=>'count(tu.user_id)'));
        $select->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tu.company_id', array());
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tu.created_by', array());
        if ($available_divers) {
            $select->where('tu.user_id IN (?)', $available_divers);
        }
        if ($company_id) {
            $select->where('tu.company_id=?', $company_id);
        }

        //print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }


    public function get_request_list_rows_done_ongoing($comp_id, $request_status, $ses_user1, $quick_search, $arr_limit, $arr_order, $done)
    {
        $select =   $this->DB->select();
        $select->from(
            array('tr'=>'tranzgo_request'),
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

            )
        );
        $select->joinleft(array('trs'=>'tranzgo_request_status'), 'tr.request_status_id=trs.request_status_id', array('request_status_name'));
        $select->joinleft(array('tds'=>'tranzgo_driver_status'), 'tr.driver_status_id=tds.driver_status_id', array('status_name'));
        $select->joinleft(array('tu'=>'tranzgo_user'), 'tu.user_id=tr.assigned_driver_1_id', array('tu.user_fname','tu.user_lname', 'assigned_driver_1_id_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tr.assigned_driver_2_id', array('tu1.user_fname','tu1.user_lname','assigned_driver_2_id_name'=>new Zend_Db_Expr("CONCAT(tu1.user_fname,' ',tu1.user_lname)")));
        $select->joinleft(array('tu11'=>'tranzgo_user'), 'tu11.user_id=tr.requested_by', array('requested_by_name'=>new Zend_Db_Expr("CONCAT(tu11.user_fname,' ',tu11.user_lname)")));
        $select->joinleft(array('tcu'=>'tranzgo_customers'), 'tcu.customer_id=tr.customer_id', array('tcu.customer_name'));
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'), 'tr.driver_task_id=tdt.driver_task_id', array('driver_task_name','driver_task_status'));
        $select->joinleft(array('trl'=>'tranzgo_rental'), 'trl.rental_id=tr.vehicle_id', array('assigned_vehicle_name','rental_id'));
        $select->joinleft(array('tc'=>'tranzgo_company'), 'tc.company_id=tr.company_id', array('company_name'));

        $select->where('tr.is_delete=?', 0);
        if ($done) {
            $select->where('tr.driver_status_id =?', 8);
        } else {
            $select->where('tr.driver_status_id !=?', 8);
        }

        $select->where('tr.request_status_id IN(?)', $request_status);
        if ($comp_id) {
            $select->where('tr.company_id=?', $comp_id);
        }


        /*  if($ses_user1)
          {
              $select->where('tr.requested_by=?',$ses_user1);
          }*/

        if ($ses_user1) {
            $select->where("tr.assigned_driver_1_id=$ses_user1 OR tr.assigned_driver_2_id=$ses_user1");
        }

        if ($quick_search) {
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
        if ($arr_limit['limit']) {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }


    public function get_request_list_rows_done_ongoing_count($comp_id, $request_status, $ses_user1, $quick_search, $done)
    {
        $select =   $this->DB->select();
        $select->from(array('tr'=>'tranzgo_request'), array('num'=>'count(tr.request_id)'));
        $select->joinleft(array('trs'=>'tranzgo_request_status'), 'tr.request_status_id=trs.request_status_id', array());
        $select->joinleft(array('tds'=>'tranzgo_driver_status'), 'tr.driver_status_id=tds.driver_status_id', array());
        $select->joinleft(array('tu'=>'tranzgo_user'), 'tu.user_id=tr.assigned_driver_1_id', array());
        $select->joinleft(array('tu1'=>'tranzgo_user'), 'tu1.user_id=tr.assigned_driver_2_id', array());
        $select->joinleft(array('tcu'=>'tranzgo_customers'), 'tcu.customer_id=tr.customer_id', array());
        $select->joinleft(array('tdt'=>'tranzgo_driver_tasks'), 'tr.driver_task_id=tdt.driver_task_id', array());
        $select->joinleft(array('trl'=>'tranzgo_rental'), 'trl.rental_id=tr.vehicle_id', array('assigned_vehicle_name','rental_id'));
        $select->where('tr.is_delete=?', 0);
        $select->where('tr.request_status_id IN(?)', $request_status);
        if ($done) {
            $select->where('tr.driver_status_id =?', 8);
        } else {
            $select->where('tr.driver_status_id !=?', 8);
        }
        if ($comp_id) {
            $select->where('tr.company_id=?', $comp_id);
        }

        /* if($ses_user1)
         {
             $select->where('tr.requested_by=?',$ses_user1);
         }*/
        if ($ses_user1) {
            $select->where("tr.assigned_driver_1_id=$ses_user1 OR tr.assigned_driver_2_id=$ses_user1");
        }
        if ($quick_search) {
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
