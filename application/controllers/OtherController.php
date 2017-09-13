<?php
class OtherController extends Zend_Controller_Action
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
        $this->_redirect('/Accounts/useraccounts');
    }
    public function submitAction()
    {
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];

        $othertypes = trim($this->_request->getParam('othertypes',''));
        $txt_value = trim($this->_request->getParam('txt_value',''));
        $ob_Others = new Others();

        $idd=   trim($this->_request->getParam('idd',''));


        if($othertypes=='CO')
        {

            $ob_Others->add_company($txt_value,$ses_user);
            $this->sessionAuth->msg_centre('Company Added Successfully');
            $this->_redirect('/Package/manage');

        }elseif($othertypes=='CT')
        {
            $ob_Others->add_car_type($txt_value,$ses_user);
            $this->sessionAuth->msg_centre('Car Type Added Successfully');
            $this->_redirect('/Package/manage');

        }elseif($othertypes=='DT')
        {
            $ob_Others->add_driver_type($txt_value,$ses_user);
            $this->sessionAuth->msg_centre('Driver Type Added Successfully');
            $this->_redirect('/Package/manage');

        }elseif($othertypes=='IT')
        {

            $ob_Others->add_item_type($txt_value,$ses_user);
            $this->sessionAuth->msg_centre('Item Type Added Successfully');
            $this->_redirect('/Package/manage');
        }elseif($othertypes=='TR')
        {
            $ob_Others->add_transmission($txt_value,$ses_user);
            $this->sessionAuth->msg_centre('Transmission Added Successfully');
            $this->_redirect('/Package/manage');
        }elseif($othertypes=='FR')
        {
            $ob_Others->add_frequesncy($txt_value,$ses_user);
            $this->sessionAuth->msg_centre('Frequency Added Successfully');
            $this->_redirect('/Package/manage');
        }else{

            $this->_redirect('/Package/list');

        }

        $this->_redirect('/Accounts/useraccounts');
    }

    public function listAction()
    {
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];

        $othertypes = trim($this->_request->getParam('Pname',''));
        //$txt_value = trim($this->_request->getParam('txt_value',''));
        $ob_Others = new Others();

        //$idd=   trim($this->_request->getParam('idd',''));


        if($othertypes=='CO')
        {

           $company_list = $ob_Others->list_company();
           echo json_encode($company_list);
            //$this->sessionAuth->msg_centre('Company Added Successfully');
            //$this->_redirect('/Package/manage');

        }
        exit;
    }

    public function companyAction()
    {
        $ob_Others	= new Others();
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->sessionAuth->menu_permission('List_Company');
        $del_id=trim($this->_request->getParam('del_id',0));

        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Company');
            $ob_Others->delete_company($del_id);
            $this->sessionAuth->msg_centre('Company deleted successfully');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();
            $this->_redirect('/Other/company');
        }

        $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search',''));
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row',LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page',1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col','company_created_at'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ','DESC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;



        $this->view->company_rows=$ob_Others->get_company_list_rows($quick_search,$arr_limit,$arr_order);
        //print "<pre>"; print_r($this->view->company_rows); print "</pre>"; exit;
        $row_count=$ob_Others->get_company_list_rows_count($quick_search);

        $arr_rows=array('company_name','added_by','company_created_at');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
        //print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');

    }

    public function carAction()
    {
        $ob_Others	= new Others();
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->sessionAuth->menu_permission('List_Car_Type');
        $del_id=trim($this->_request->getParam('del_id',0));

        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Car_Type');
            $ob_Others->delete_car_type($del_id);
            $this->sessionAuth->msg_centre('Car deleted successfully');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();
            $this->_redirect('/Other/car');
        }

        $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search',''));
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row',LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page',1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col','vehicle_type_id'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ','ASC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;



        $this->view->car_rows=$ob_Others->get_car_list_rows($quick_search,$arr_limit,$arr_order);
        //print "<pre>"; print_r($this->view->company_rows); print "</pre>"; exit;
        $row_count=$ob_Others->get_car_list_rows_count($quick_search);

        $arr_rows=array('vehicle_type_name','added_by');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
        //print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');

    }

    public function getcompanybyidAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Others	= new Others();
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->sessionAuth->menu_permission('Edit_Company');
        $edit_comp=trim($this->_request->getParam('edit_comp',0));
        $row = $ob_Others->get_company_name_byid($edit_comp);
        echo json_encode($row);
        exit;


    }
























}

?>