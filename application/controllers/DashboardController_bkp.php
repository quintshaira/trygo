<?php
class DashboardController extends Zend_Controller_Action
{
    //=====================================must add in all Controller class ===================================//
    public $site_url   = "";
    public $site_asset = "";
    public $sessionAuth;
    //=====================================must add in all Controller class ===================================//


    public function init()
    {
        /* Initialize action controller here */

        //=====================================must add in all Controller class constructor ===================================//
        if(defined('SITEURL')) $this->site_url = SITEURL;
        if(defined('SITEASSET')) $this->site_asset = SITEASSET;
        $this->view->site_url   = $this->site_url;
        $this->view->site_asset = $this->site_asset;
        Zend_Loader::loadClass('User');
        Zend_Loader::loadClass('Signup');
        Zend_Loader::loadClass('Dashbord');
        Zend_Loader::loadClass('Request');
        //Zend_Loader::loadClass('Sendemails');
        //$Host = HOST;
        //$Username = Username;
        //$Password = Password;
        //$Port = Port;
        //$ob_Mail = new Sendemails();
        //$ob_Mail->send_mail('test',$Host,$Username,$Password,$Port);
        //exit;



        //-----------------------------------------------authenticate logged in user---------------------------------------------//
        Zend_Loader::loadClass('LoginAuth');

        $this->view->ob_LoginAuth = $this->sessionAuth = new LoginAuth();
        $this->sessionAuth->login_user_check();
        $this->sessionAuth->cookie_check();


        $this->view->server_msg = $this->sessionAuth->msg_centre();

        //-----------------------------------------------authenticate logged in user---------------------------------------------//
        unset($_SESSION['tranzgo_session']['export_list']);
        $this->view->ControllerName = $this->_request->getControllerName();
        $this->view->page_id = ($_SESSION['bsc_session']['role_id']==1)?'5':'7';

        //______________________________________must add in all Controller class constructor _____________________________________//

    }


    public function indexAction()
    {

        //phpinfo();
        //echo '<pre>'; print_r($_SESSION); exit;

        $company_id=$_SESSION['tranzgo_session']['company_id'];
        $account_id=$_SESSION['tranzgo_session']['account_id'];
        if($account_id == 4)
        {
            $this->_redirect('/Request/list');
        }

        
        $ob_Dashbord = new Dashbord();


        //$TD_arr['sd']=$TD_arr['ed']="2017-02-07";

        $this->view->tabshow=trim($this->_request->getParam('tabshow','1'));



        /*-----------------TODAY-----------------------*/

        $TD_arr['sd']=$TD_arr['ed']=OCD;

        // Total Cars under this company
        $this->view->TD_total_car_count=$ob_Dashbord->get_for_total_car_count($company_id,$TD_arr);
        // Total Cars requested under this company for today (rent from and rent to is same for today)
        $this->view->TD_rented_car_count=$ob_Dashbord->get_for_rented_car_count($company_id,$TD_arr);
        // Total down cars
        $this->view->TD_down_car_count=$ob_Dashbord->get_for_down_car_count($company_id,$TD_arr);


        // Listing of request where request status is Pending and Rejected for today (rent from and rent to is same for today)
        $ret_assignment_rows = $ob_Dashbord->get_for_assignment_rows($company_id,$TD_arr);
        $arr_assignment_rows=array();
        foreach($ret_assignment_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_assignment_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'rental_id'             =>$v['rental_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
            );
        }
        $this->view->TD_assignment_rows=$arr_assignment_rows;

        // Listing of request where request is not remitted or paid for today (rent from and rent to is same for today)
        $ret_duepay_rows =  $ob_Dashbord->get_for_duepay_rows($company_id,$TD_arr);
        $arr_duepay_rows=array();
        foreach($ret_duepay_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_duepay_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'driver_status_id'      =>$v['driver_status_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
                'status_name'           =>$v['status_name']
            );
        }
        $this->view->TD_duepay_rows=$arr_duepay_rows;

       

        // Listing of request whose are remitted by today (rent from and rent to is same for today)
        $ret_remitted_rows =  $ob_Dashbord->get_for_remitted_rows($company_id,$TD_arr);
        $arr_remitted_rows=array();
        foreach($ret_remitted_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_remitted_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'driver_status_id'      =>$v['driver_status_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'received_on'           =>$v['received_on'],
                'received_by_name'      =>$v['received_by_name'],
                'customer_name'         =>$v['customer_name'],
                'status_name'           =>$v['status_name']
            );
        }

        $this->view->TD_remitted_rows=$arr_remitted_rows;

        /*-----------------TODAY-----------------------*/


        /*-----------------MTD-----------------------*/

        $TD_arr['sd']=date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));
        //print $TD_arr['ed']=date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y'))); exit;
        $TD_arr['ed']=OCD;

        // Listing of request where request status is Pending and Rejected for monthly (rent from pevious month and rent to is same as today)
        $ret_assignment_rows = $ob_Dashbord->get_for_assignment_rows($company_id,$TD_arr);
        $arr_assignment_rows=array();
        foreach($ret_assignment_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_assignment_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'rental_id'             =>$v['rental_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
            );
        }

        $this->view->MTD_assignment_rows=$arr_assignment_rows;


        // Listing of request where request is not remitted or paid from previous month to today
        $ret_duepay_rows = $ob_Dashbord->get_for_duepay_rows($company_id,$TD_arr);
        $arr_duepay_rows=array();
        foreach($ret_duepay_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_duepay_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'rental_id'             =>$v['rental_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
            );
        }
        $this->view->MTD_duepay_rows=$arr_duepay_rows;

        // Listing of request whose are remitted from prevoius month (rent from and rent to is same for today)
        $ret_remitted_rows = $ob_Dashbord->get_for_remitted_rows($company_id,$TD_arr);
        $arr_remitted_rows=array();
        foreach($ret_remitted_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_remitted_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'rental_id'             =>$v['rental_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'received_by_name'      =>$v['received_by_name'],
                'received_on'           =>$v['received_on'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
            );
        }
        $this->view->MTD_remitted_rows=$arr_remitted_rows;

        /*-----------------MTD-----------------------*/

        /*-----------------YTD----------------------*/
        $TD_arr['sd']=date('Y-m-d',mktime(0,0,0,1,1,date('Y')));
        $TD_arr['ed']=OCD;

        // Listing of request where request status is Pending and Rejected for yearly (rent from previous year and rent to is today)
        $ret_assignment_rows = $ob_Dashbord->get_for_assignment_rows($company_id,$TD_arr);
        $arr_assignment_rows=array();
        foreach($ret_assignment_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_assignment_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'rental_id'             =>$v['rental_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
            );
        }

        $this->view->YTD_assignment_rows=$arr_assignment_rows;

        // Listing of request where request is not remitted or paid from previous year to today
        $ret_duepay_rows = $ob_Dashbord->get_for_duepay_rows($company_id,$TD_arr);
        $arr_duepay_rows=array();
        foreach($ret_duepay_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_duepay_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'rental_id'             =>$v['rental_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
            );
        }
        $this->view->YTD_duepay_rows=$arr_duepay_rows;


        // Listing of request whose are remitted from previous year (rent to is today)
        $ret_remitted_rows = $ob_Dashbord->get_for_remitted_rows($company_id,$TD_arr);
        $arr_remitted_rows=array();
        foreach($ret_remitted_rows as $k=>$v)
        {
            $ret_user_details = $ob_Dashbord->get_driver_name($v['driver_id']);
            $arr_remitted_rows[$k] = array(
                'request_id'            =>$v['request_id'],
                'req_gen_id'            =>$v['req_gen_id'],
                'vehicle_id'            =>$v['vehicle_id'],
                'rental_id'             =>$v['rental_id'],
                'rent_from'             =>$v['rent_from'],
                'rent_to'               =>$v['rent_to'],
                'driver_id'             =>$v['driver_id'],
                'driver_name'           =>$ret_user_details['driver_name'],
                'customer_id'           =>$v['customer_id'],
                'estimated_price'       =>$v['estimated_price'],
                'sn'                    =>$v['sn'],
                'received_by_name'      =>$v['received_by_name'],
                'received_on'           =>$v['received_on'],
                'assigned_vehicle_name' =>$v['assigned_vehicle_name'],
                'customer_name'         =>$v['customer_name'],
            );
        }
        $this->view->YTD_remitted_rows=$arr_remitted_rows;




        /*-----------------YTD----------------------*/


        $ob_Request = new Request();
        $this->view->requestList=$ob_Request->get_request();
        $this->view->driverTaskList=$ob_Request->get_driver_task();
        $this->view->driverList=$ob_Request->get_driver_list_by_comp($company_id);

        $this->view->assignedVehicleList=$ob_Request->get_assigned_vehicle_by_comp($company_id);



        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function updatestatusAction()
    {

        //phpinfo();
        $company_id         = $_SESSION['tranzgo_session']['company_id'];
        $updateid           = trim($this->_request->getParam('updateid',''));
        $recieved_amount    = trim($this->_request->getParam('recieved_amount',''));
        $recieved_remarks   = trim($this->_request->getParam('recieved_remarks',''));
        $tab   = trim($this->_request->getParam('tabs',''));
        $data = array(
            'recieved_amount'=>$recieved_amount,
            'recieved_remarks'=>$recieved_remarks,
            'received_on'=>CD,
            'received_by'=>$_SESSION['tranzgo_session']['user_id'],
            'driver_status_id'=>8
        );

        $ob_Dashbord = new Dashbord();
        $ob_Dashbord->update_collected($data,$updateid);

        $TD_arr['sd']=$TD_arr['ed']=OCD;


        //$this->view->TD_assignment_rows=$ob_Dashbord->get_for_assignment_rows($company_id,$TD_arr);
        //$this->view->TD_duepay_rows=$ob_Dashbord->get_for_duepay_rows($company_id,$TD_arr);
        if($tab)
        {
            $this->_redirect('/Dashboard/index/tabshow/'.$tab);
        }else {
            $this->_redirect('/Dashboard');
        }

        exit;
    }


    public function managerequestAction()
    {
        //echo '<pre>';print_r($_POST);exit;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd                    = trim($this->_request->getParam('idd',''));
        $driver_task_id         = trim($this->_request->getParam('driver_task_id',''));
        $vehicle_id             = trim($this->_request->getParam('rental_id',''));
        $tab                    = trim($this->_request->getParam('tab',''));
        $delivery_address       = $driver_task_id==1 || $driver_task_id==3 ? trim($this->_request->getParam('delivery_address','')) : '';
        $assigned_driver_1_id   = $driver_task_id==1 || $driver_task_id==3 ? trim($this->_request->getParam('assigned_driver_1_id','')): '';
        $pickup_address         = $driver_task_id==2 ? trim($this->_request->getParam('pickup_address','')) : '';
        $assigned_driver_2_id   = $driver_task_id==2 ? trim($this->_request->getParam('assigned_driver_2_id','')) : '';


        $ob_Request = new Request();
        $ob_Request->update_request1(
            $idd,
            $driver_task_id,
            $vehicle_id,
            $delivery_address,
            $assigned_driver_1_id,
            $pickup_address,
            $assigned_driver_2_id
        );
        $this->sessionAuth->msg_centre('Request updated successfully');

        //$this->view->tabshow=trim($this->_request->getParam('tabshow','1'));
        if($tab)
        {
            $this->_redirect('/Dashboard/index/tabshow/'.$tab);
        }else{
            $this->_redirect('/Dashboard');
        }
        exit;
    }

}

?>