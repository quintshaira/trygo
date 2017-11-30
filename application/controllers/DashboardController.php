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
        if (defined('SITEURL')) {
            $this->site_url = SITEURL;
        }
        if (defined('SITEASSET')) {
            $this->site_asset = SITEASSET;
        }
        $this->view->site_url   = $this->site_url;
        $this->view->site_asset = $this->site_asset;
        Zend_Loader::loadClass('User');
        Zend_Loader::loadClass('Signup');
        Zend_Loader::loadClass('Dashbord');
        Zend_Loader::loadClass('Request');
        // Zend_Loader::loadClass('Sendemails');
        // $Host = HOST;
        // $Username = Username;
        // $Password = Password;
        // $Port = Port;
        // $ob_Mail = new Sendemails();
        // $ob_Mail->send_mail('test', $Host, $Username, $Password, $Port);
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
        $this->view->role = $account_id=$_SESSION['tranzgo_session']['account_id'];
        if ($account_id == 4) {
            $this->_redirect('/Request/list');
        }

        $ob_Dashbord = new Dashbord();


        //$TD_arr['sd']=$TD_arr['ed']="2017-02-07";

        $this->view->tabshow=trim($this->_request->getParam('tabshow', '1'));

        $TD_arr['sd']=$TD_arr['ed']=OCD;

        $this->view->TD_total_car_count=$ob_Dashbord->get_for_total_car_count($company_id, $TD_arr);
        $this->view->TD_rented_car_count=$ob_Dashbord->get_for_rented_car_count($company_id, $TD_arr);
        $this->view->TD_down_car_count=$ob_Dashbord->get_for_down_car_count($company_id, $TD_arr);
        define('LIMIT', 100);


        if ($account_id==2) {
            $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search', ''));
            $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row', LIMIT));
            $this->view->page=      $page=      trim($this->_request->getParam('page', 1));
            $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'requested_date'));
            $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'ASC'));
            $arr_limit=array();
            $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
            $arr_limit['page']=$page;
            $arr_order=array();
            $arr_order['col']=$order_col;
            $arr_order['typ']=$order_typ;
            $request_status = [1];
            $this->view->TD_approved_rows=$ob_Dashbord->get_request_approval_rows_today($company_id, $request_status, $quick_search, $arr_limit, $arr_order, $TD_arr);
            $row_count_TD=$ob_Dashbord->get_request_approval_rows_count_today($company_id, $request_status, $quick_search, $TD_arr);
            $arr_rows=array('request_id','rent_from','rent_to','vehicle_id','driver_task_id','assigned_driver_1_id','assigned_driver_2_id','customer_name');
            $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows, $arr_order);
            $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count_TD, $page, $num_row);
        } else {
            $this->view->TD_assignment_rows=$ob_Dashbord->get_for_assignment_rows_today($company_id, $TD_arr);
        }

        $is_today = 1;

        $this->view->TD_duepay_rows=$ob_Dashbord->get_for_duepay_rows($company_id, $TD_arr, $is_today);
        $this->view->TD_remitted_rows=$ob_Dashbord->get_for_remitted_rows($company_id, $TD_arr, $is_today);


        //echo '<pre>'; print_r($this->view->TD_remitted_rows); exit;





        $TD_arr['sd']=date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));

        $TD_arr['ed'] = date('Y-m-d', strtotime("-1 days"));

        //$TD_arr['ed']=OCD;

        if ($account_id==2) {
            $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search', ''));
            $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row', LIMIT));
            $this->view->page=      $page=      trim($this->_request->getParam('page', 1));
            $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'requested_date'));
            $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'ASC'));
            $arr_limit=array();
            $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
            $arr_limit['page']=$page;
            $arr_order=array();
            $arr_order['col']=$order_col;
            $arr_order['typ']=$order_typ;
            $request_status = [1];
            $this->view->MTD_approved_rows=$ob_Dashbord->get_request_approval_rows($company_id, $request_status, $quick_search, $arr_limit, $arr_order, $TD_arr);
            $row_count_MTD=$ob_Dashbord->get_request_approval_rows_count($company_id, $request_status, $quick_search, $TD_arr);
            $arr_rows=array('request_id','rent_from','rent_to','vehicle_id','driver_task_id','assigned_driver_1_id','assigned_driver_2_id','customer_name');
            $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows, $arr_order);
            $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count_MTD, $page, $num_row);
        } else {
            $this->view->MTD_assignment_rows=$ob_Dashbord->get_for_assignment_rows($company_id, $TD_arr);
        }

        $is_today = 0;
        $this->view->MTD_duepay_rows=$ob_Dashbord->get_for_duepay_rows($company_id, $TD_arr, $is_today);
        $this->view->MTD_remitted_rows=$ob_Dashbord->get_for_remitted_rows($company_id, $TD_arr, $is_today);


        $TD_arr['sd']=date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));
        //$TD_arr['ed']=OCD;
        $TD_arr['ed'] = date('Y-m-d', strtotime("-1 days"));

        if ($account_id==2) {
            $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search', ''));
            $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row', LIMIT));
            $this->view->page=      $page=      trim($this->_request->getParam('page', 1));
            $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'requested_date'));
            $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'ASC'));
            $arr_limit=array();
            $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
            $arr_limit['page']=$page;
            $arr_order=array();
            $arr_order['col']=$order_col;
            $arr_order['typ']=$order_typ;
            $request_status = [1];
            $this->view->YTD_approved_rows=$ob_Dashbord->get_request_approval_rows($company_id, $request_status, $quick_search, $arr_limit, $arr_order, $TD_arr);
            $row_count_YTD=$ob_Dashbord->get_request_approval_rows_count($company_id, $request_status, $quick_search, $TD_arr);
            $arr_rows=array('request_id','rent_from','rent_to','vehicle_id','driver_task_id','assigned_driver_1_id','assigned_driver_2_id','customer_name');
            $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows, $arr_order);
            $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count_YTD, $page, $num_row);
        } else {
            $this->view->YTD_assignment_rows=$ob_Dashbord->get_for_assignment_rows($company_id, $TD_arr);
        }

        $is_today = 0;
        $this->view->YTD_duepay_rows=$ob_Dashbord->get_for_duepay_rows($company_id, $TD_arr, $is_today);
        $this->view->YTD_remitted_rows=$ob_Dashbord->get_for_remitted_rows($company_id, $TD_arr, $is_today);



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
        $company_id         = $_SESSION['tranzgo_session']['company_id'];
        $updateid           = trim($this->_request->getParam('updateid', ''));
        $recieved_amount    = trim($this->_request->getParam('recieved_amount', ''));
        $recieved_remarks   = trim($this->_request->getParam('recieved_remarks', ''));
        $tab   = trim($this->_request->getParam('tabs', ''));
        $data = array(
            'recieved_amount'=>$recieved_amount,
            'recieved_remarks'=>$recieved_remarks,
            'received_on'=>CD,
            'received_by'=>$_SESSION['tranzgo_session']['user_id'],
            'driver_status_id'=>8
        );

        $ob_Dashbord = new Dashbord();
        $ob_Dashbord->update_collected($data, $updateid);

        $TD_arr['sd']=$TD_arr['ed']=OCD;


        //$this->view->TD_assignment_rows=$ob_Dashbord->get_for_assignment_rows($company_id,$TD_arr);
        //$this->view->TD_duepay_rows=$ob_Dashbord->get_for_duepay_rows($company_id,$TD_arr);
        if ($tab) {
            $this->_redirect('/Dashboard/index/tabshow/'.$tab);
        } else {
            $this->_redirect('/Dashboard');
        }

        exit;
    }


    public function managerequestAction()
    {
        //echo '<pre>';print_r($_POST);exit;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd                    = trim($this->_request->getParam('idd', ''));
        $driver_task_id         = trim($this->_request->getParam('driver_task_id', ''));
        $vehicle_id             = trim($this->_request->getParam('rental_id', ''));
        $tab                    = trim($this->_request->getParam('tab', ''));
        $delivery_address       = $driver_task_id==1 || $driver_task_id==3 ? trim($this->_request->getParam('delivery_address', '')) : '';
        $assigned_driver_1_id   = $driver_task_id==1 || $driver_task_id==3 ? trim($this->_request->getParam('assigned_driver_1_id', '')): '';
        $pickup_address         = $driver_task_id==2 ? trim($this->_request->getParam('pickup_address', '')) : '';
        $assigned_driver_2_id   = $driver_task_id==2 ? trim($this->_request->getParam('assigned_driver_2_id', '')) : '';
        $is_assigned = 1;

        if (($driver_task_id == 1 || $driver_task_id==3) && (!$vehicle_id || !$assigned_driver_1_id)) {
            $this->sessionAuth->msg_centre('Driver and vehicle are required.');
        } else {
            $ob_Request = new Request();
            $ob_Request->update_request1(
                $idd,
                $driver_task_id,
                $vehicle_id,
                $delivery_address,
                $assigned_driver_1_id,
                $pickup_address,
                $assigned_driver_2_id,
                $is_assigned
            );
            $this->sessionAuth->msg_centre('Request updated successfully');
        }

        // Send email to booking officers of the company
        $ob_User = new User();
        $company_id = $_SESSION['tranzgo_session']['company_id'];
        $account_id = '2';
        $officers = $ob_User->getUsersByRole($company_id, $account_id);

        foreach ($officers as $officer) {
            $mail = new Zend_Mail('utf-8');
            $mail->setBodyHtml('Hi!<br>You have a pending request for approval.<br>');
            $mail->setFrom('noreply.tranzgo@gmail.com', 'Tranzgo');
            $mail->addTo($officer['email'], $officer['user_fname'] . ' ' . $officer['user_lname']);
            $mail->setSubject('Tranzgo: Request submit for Approval');
            $mail->send();
        }

        //$this->view->tabshow=trim($this->_request->getParam('tabshow','1'));
        if ($tab) {
            $this->_redirect('/Dashboard/index/tabshow/'.$tab);
        } else {
            $this->_redirect('/Dashboard');
        }
        exit;
    }
}
