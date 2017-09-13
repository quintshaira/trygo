<?php
class PackageController extends Zend_Controller_Action
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
        Zend_Loader::loadClass('Signup');
        Zend_Loader::loadClass('User');
        //Zend_Loader::loadClass('Request');
        Zend_Loader::loadClass('Package');
        Zend_Loader::loadClass('Others');
        //Zend_Loader::loadClass('mailerphp');
        //Zend_Loader::loadClass('Permission');


        //-----------------------------------------------authenticate logged in user---------------------------------------------//
        Zend_Loader::loadClass('LoginAuth');
        $this->view->ob_LoginAuth = $this->sessionAuth = new LoginAuth();

        $this->sessionAuth->login_user_check();

        $this->sessionAuth->cookie_check();
        $this->view->server_msg = $this->sessionAuth->msg_centre();

        //-----------------------------------------------authenticate logged in user---------------------------------------------//
        unset($_SESSION['tranzgo_session']['export_list']);
        $this->view->ControllerName = $this->_request->getControllerName();
        $this->view->page_id = ($_SESSION['tranzgo_session']['role_id']==1)?'5':'7';
        //______________________________________must add in all Controller class constructor _____________________________________//


    }

    public function indexAction()
    {
        //action body
        //print "aa";exit;
        $this->_redirect('/Package/list');

    }

    /*public function dupemailAction()
    {
        //action body
        $ob_Signup	= new Signup();

        $U_email = trim($this->_request->getParam('U_email',""));
        $idd = trim($this->_request->getParam('idd',""));
        print $ob_Signup->CheckDuplicateEmail($U_email,$idd);
        exit;
    }*/

    public function listAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Package	= new Package();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];


        $ob_User = new Signup();


        if($ses_role!=1)
        {
            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];

        }else{
            $comp_id = 0;
        }







        $this->sessionAuth->menu_permission('List_Package');


        $del_id=trim($this->_request->getParam('del_id',0));




        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Package');
            $ob_Package->delete_package($del_id);
            $this->sessionAuth->msg_centre('Package deleted successfully');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();

            $this->_redirect('/Package/list');
        }

        $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search',''));
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row',LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page',1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col','add_date'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ','DESC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;



        $this->view->package_rows=$ob_Package->get_package_list_rows($comp_id,$quick_search,$arr_limit,$arr_order);
        //print "<pre>"; print_r($this->view->package_rows); print "</pre>"; exit;
        $row_count=$ob_Package->get_package_list_rows_count($comp_id,$quick_search);

        $arr_rows=array('package_name','added_by_name','add_date','package_status');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
        //print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }




    public function manageAction()
    {

        //print "<pre>"; print_r($_POST); print "</pre>";exit;

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd',''));
        //$this->view->rentid = $rentid=   trim($this->_request->getParam('rentid',''));
        //$status=   trim($this->_request->getParam('status',''));



        $ob_Package = new Package();
        $ob_Others = new Others();


        $ob_User = new Signup();


        if($ses_role!=1)
        {
            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];

        }else{
            $this->view->companyList = $ob_User->get_company();
        }





        $this->view->carTypeList            =   $ob_Others->get_cartype();
        $this->view->carTransmissionList    =   $ob_Others->get_transmissions();
        $this->view->driverTypeList         =   $ob_Others->get_driver_type();
        $this->view->itemTypeList           =   $ob_Others->get_item_type();
        $this->view->frequencyList          =   $ob_Others->get_frequency();


        $this->view->cancel_link = '/Package/list';



        if($idd)
        {

            $this->view->package_detail = $ob_Package->get_package_detail_from_idd($idd);
            //print "<pre>"; print_r($this->view->package_detail); print "</pre>"; exit;
        }




//print "<pre>"; print_r($this->view->user_detail); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function submitpackageAction()
    {
        //echo '<pre>';print_r($_POST);exit;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd',''));
        $status=   trim($this->_request->getParam('package_status',''));

        if($idd)
        {
            $this->sessionAuth->menu_permission('Edit_Package');
        }
        else
        {
            $this->sessionAuth->menu_permission('Add_Package');
        }



        $package_name       = trim($this->_request->getParam('package_name',''));
        $company_id         = trim($this->_request->getParam('company_id',''));
        $vehicle_type_id    = trim($this->_request->getParam('vehicle_type_id',''));
        $driver_type_id     = trim($this->_request->getParam('driver_type_id',''));
        $item_type_id       = trim($this->_request->getParam('item_type_id',''));
        $transmission_id    = trim($this->_request->getParam('transmission_id',''));
        $request_rate_id    = trim($this->_request->getParam('request_rate_id',''));
        $price              = trim($this->_request->getParam('price',''));
        $destination        = trim($this->_request->getParam('destination',''));
        $package_status     = trim($this->_request->getParam('package_status',''));


        $data = array(
            'added_by'=>$ses_user,
            'package_name'=>$package_name,
            'company_id'=>$company_id,
            'vehicle_type_id'=>$vehicle_type_id,
            'driver_type_id'=>$driver_type_id,
            'item_type_id'=>$item_type_id,
            'transmission_id'=>$transmission_id,
            'request_rate_id'=>$request_rate_id,
            'price'=>$price,
            'destination'=>$destination,
            'package_status'=>$package_status,
            'add_date'=>CD,
            'mod_date'=>CD
        );

        $dataWhere = array(
            'package_name'=>$package_name,
            'company_id'=>$company_id,
            'vehicle_type_id'=>$vehicle_type_id,
            'driver_type_id'=>$driver_type_id,
            'item_type_id'=>$item_type_id,
            'transmission_id'=>$transmission_id,
            'request_rate_id'=>$request_rate_id,
            'price'=>$price,
            'destination'=>$destination,
            'package_status'=>$package_status,
            'mod_date'=>CD
        );

        $ob_Package = new Package();


        if($idd)
        {

            $ob_Package->update_package($dataWhere,$idd);

            $this->sessionAuth->msg_centre('Package updated successfully');
        }else{

            $lastPackageId = $ob_Package->add_package($data);
            $this->sessionAuth->msg_centre('Package added successfully');
        }


        //$this->view->server_msg = $this->sessionAuth->msg_centre();

        $this->_redirect('/Package/list');
        exit;
    }




    public function detailsAction()
    {
        $this->sessionAuth->menu_permission('Request_Details');
        $ob_Request = new Request();
        $idd=   trim($this->_request->getParam('idd',''));
        $this->view->idd = $idd;
        $this->view->cancel_link = '/Request/list';
        if($idd)
        {

            $this->view->request_detail = $ob_Request->get_request_details_by_req_id($idd);
            $this->view->request_images = $ob_Request->get_request_images_from_idd($idd);

            //print "<pre>"; print_r($this->view->request_detail); print "</pre>"; exit;
        }


        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function checkpackagenameAction()
    {
        //print_r($ob_signup);
        $idd = trim($this->_request->getParam('idd',""));
        $Package_name = trim($this->_request->getParam('Package_name',""));
        $ob_Package = new Package();
        echo $ob_Package->CheckDuplicatePackageName($Package_name,$idd);
        exit;
    }



















}

?>