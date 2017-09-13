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
        $company_id=$_SESSION['tranzgo_session']['company_id'];
        $ob_Dashbord = new Dashbord();

        $TD_arr['sd']=$TD_arr['ed']=OCD;
        //$TD_arr['sd']=$TD_arr['ed']="2017-02-07";

        $this->view->TD_assignment_rows=$ob_Dashbord->get_for_assignment_rows($company_id,$TD_arr);
        $this->view->TD_duepay_rows=$ob_Dashbord->get_for_duepay_rows($company_id,$TD_arr);
        $this->view->TD_remitted_rows=$ob_Dashbord->get_for_remitted_rows($company_id,$TD_arr);

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


        $this->_redirect('/Dashboard');
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


        $this->_redirect('/Dashboard');
        exit;
    }






}

?>