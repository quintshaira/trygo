<?php
class CustomerController extends Zend_Controller_Action
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
        Zend_Loader::loadClass('Customer');
        Zend_Loader::loadClass('Signup');


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
        $this->_redirect('/customer/list');
    }

    public function listAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Customer	= new Customer();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];

        $this->sessionAuth->menu_permission('List_Customer');

        //$this->view->TRANZGO_STR=$this->sessionAuth->get_breadcrumb('List_Rental');

        $del_id=trim($this->_request->getParam('del_id',0));
        $idd=trim($this->_request->getParam('idd',0));


        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Customer');
            $ob_Customer->delete_customer($del_id);
            $this->sessionAuth->msg_centre('Customer deleted successfully');
            $this->_redirect('/customer/list');
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



        $this->view->customer_rows=$ob_Customer->get_customer_list_rows($company_id,$quick_search,$arr_limit,$arr_order);

        //echo '<pre>'; print_r($this->view->customer_rows); exit;

        $row_count=$ob_Customer->get_customer_list_rows_count($company_id,$quick_search);

        $arr_rows=array('customer_id','customer_name','contact_number','added_by','add_date');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
        //print "<pre>"; print_r($this->view->rental_rows); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }




    public function manageAction()
    {
        $ob_Customer = new Customer();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];
        $idd=   trim($this->_request->getParam('idd',''));
        $this->view->cancel_link = '/customer/list';
        $ob_User = new Signup();
        if($idd)
        {
            $this->view->customer_detail = $ob_Customer->get_customer_detail_from_idd($idd);
        }
        if($ses_role!=1)
        {

            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];

        }else{
            $this->view->companyList = $ob_User->get_company();
        }

        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function submitcustomerAction()
    {
        //echo '<pre>';print_r($_POST);exit;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];
        $idd=   trim($this->_request->getParam('idd',''));

        if($idd)
        {
            $this->sessionAuth->menu_permission('Edit_Customer');
        }
        else
        {
            $this->sessionAuth->menu_permission('Add_Customer');
        }


        $customer_name   = trim($this->_request->getParam('customer_name',''));
        $contact_number  = trim($this->_request->getParam('contact_number',''));
        $company         = trim($this->_request->getParam('company',''));

        $ob_Customer = new Customer();


        if($idd)
        {

            $update = array(
                'customer_name'=>$customer_name,
                'contact_number'=>$contact_number,
                'company_id'=>$company,
                'mod_date'=>CD
            );
            $ob_Customer->update_customer($update,$idd);
            $this->sessionAuth->msg_centre('Customer updated successfully');
        }else{
            $add = array(
                'customer_name'=>$customer_name,
                'contact_number'=>$contact_number,
                'company_id'=>$company,
                'added_by'=>$ses_user,
                'add_date'=>CD,
                'mod_date'=>CD
            );

            $ob_Customer->add_customer($add);
            $this->sessionAuth->msg_centre('Customer added successfully');
        }

        $this->_redirect('/customer/list');
        exit;
    }

    public function duplicatecustomerAction()
    {
        $cust_no    = trim($this->_request->getParam('cust_no',''));
        $idd        = trim($this->_request->getParam('idd',''));
        $ob_Customer = new Customer();
        echo $ob_Customer->check_duplicate_customer($cust_no,$idd);
        exit;

    }



}

?>