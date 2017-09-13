<?php
class AccountsController extends Zend_Controller_Action
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
        Zend_Loader::loadClass('Request');
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

    public function dupemailAction()
    {
        //action body
        $ob_Signup	= new Signup();

        $U_email = trim($this->_request->getParam('U_email',""));
        $idd = trim($this->_request->getParam('idd',""));
        print $ob_Signup->CheckDuplicateEmail($U_email,$idd);
        exit;
    }

    public function useraccountsAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->sessionAuth->menu_permission('List_User');
        $this->view->TRANZGO_STR=$this->sessionAuth->get_breadcrumb('List_User');
        $del_id=trim($this->_request->getParam('del_id',0));
        $ob_User = new Signup();
        if($ses_role!=1)
        {
            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];

        }else{
            $comp_id = 0;
        }

        if($del_id)
        {
            $ob_User	= new User();
            $this->sessionAuth->menu_permission('Delete_User');
            $user_is_deleted=$ob_User->user_is_deleted($del_id);
            if(!$user_is_deleted)
            {
				
                $ob_User->delete_user($del_id);
                $this->sessionAuth->msg_centre('User deleted successfully');
				$this->view->server_msg = $this->sessionAuth->msg_centre();
            }
			
			$this->_redirect('/accounts/useraccounts/');
        }
        $act_id=trim($this->_request->getParam('act_id',0));
        $act_type=trim($this->_request->getParam('act_type'));
        if($act_id)
        {
            $this->sessionAuth->menu_permission('Deactivate_User');
            $user_is_active_status=$ob_User->user_is_active_status($act_id);
            if($user_is_active_status!=$act_type)
            {
                $ob_User->de_act_user($act_id,$act_type);
                if($act_type)
                {
                    $this->sessionAuth->msg_centre('User account Un-locked successfully');
                }
                else
                {
                    $this->sessionAuth->msg_centre('User account Locked successfully');
                }
            }

            $this->view->server_msg = $this->sessionAuth->msg_centre();
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

        $ob_User	= new User();


        $getuserdetails = $this->view->user_rows=$ob_User->get_user_list_rows($comp_id,$quick_search,$arr_limit,$arr_order);
		
        $row_count=$ob_User->get_user_list_rows_count($comp_id,$quick_search);

        $arr_rows=array('email','user_fname','user_lname','account_name','company_name','is_active','add_date');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
		//print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function accesspermissionAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        
        $this->sessionAuth->menu_permission('Set_Access_Permission');
        $ob_User	= new User();
        $this->view->keyy=$key=   trim($this->_request->getParam('user_key',''));
        $user_id=0;
        if($key)
        {
            $user_detail=$ob_User->get_transfer_detail_from_key($key);
            $user_id=$user_detail['user_id'];
            $role_id=$user_detail['account_id'];
        }
        $this->view->user_id=$user_id;
        if($user_id)
        {
            $ob_Permission	= new Permission();
            $menu_table=$ob_Permission->get_menus();
            $this->view->role_permission_table=$ob_Permission->get_role_permission($role_id);
            $this->view->user_permission_table=$ob_Permission->get_user_permission($user_id);
            $temp_menu_arr=array();
            foreach($menu_table as $k=>$v)
            {
                if(!$v['p_menu_id'])
                {
                    $temp_menu_arr[$v['menu_id']]['menu_name']=$v['menu_name'];
                }
                else
                {
                    $temp_menu_arr[$v['p_menu_id']]['sub_menues'][$v['menu_id']]=$v['menu_name'];
                }

            }
            $this->view->menu_table=$temp_menu_arr;
        }
        else
        {
            $this->sessionAuth->menu_permission('nope');
        }
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

	public function submitaccesspermissionAction()
	{
		//print "<pre>"; print_r($_POST); print "</pre>";
		$this->view->ses_user=$ses_user=$_SESSION['bsc_session']['user_id'];
		$this->view->ses_role=$ses_role=$_SESSION['bsc_session']['account_id'];
		$user_id = trim($this->_request->getParam('user_id',""));
		$key=   trim($this->_request->getParam('keyy',''));
		$menu_id = ($this->_request->getParam('menu_id',""));
		$ob_Permission	= new Permission();
        $ob_Permission->delete_user_permission($user_id);
		$ob_Permission->set_user_permission($menu_id,$user_id);
		$this->sessionAuth->msg_centre('Access permission updated successfully');
		$this->_redirect('/Accounts/accesspermission/user_key/'.$key);
		exit;
	}

    public function accesspermission1Action()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        Zend_Loader::loadClass('Permission');
        $this->sessionAuth->menu_permission('Set_Access_Permission');
        $ob_User	= new User();
        $key=   trim($this->_request->getParam('user_key',''));
        $user_id=0;
        if($key)
        {
            $user_detail=$ob_User->get_transfer_detail_from_key($key);
            $user_id=$user_detail['user_id'];
            $role_id=$user_detail['account_id'];
        }
        $this->view->user_id=$user_id;
        if($user_id)
        {
            $ob_Permission	= new Permission();
            $menu_table=$ob_Permission->get_menus();
            $this->view->role_permission_table=$ob_Permission->get_role_permission($role_id);
            $this->view->user_permission_table=$ob_Permission->get_user_permission($user_id);
            $temp_menu_arr=array();
            foreach($menu_table as $k=>$v)
            {
                if(!$v['p_menu_id'])
                {
                    $temp_menu_arr[$v['menu_id']]['menu_name']=$v['menu_name'];
                }
                else
                {
                    $temp_menu_arr[$v['p_menu_id']]['sub_menues'][$v['menu_id']]=$v['menu_name'];
                }

            }
            //print "<pre>"; print_r($this->view->user_permission_table); print "</pre>";
            //print "<pre>"; print_r($temp_menu_arr); print "</pre>";
            $this->view->menu_table=$temp_menu_arr;

            //exit;
            /*$this->view->user_detail=$ob_User->getUserDetails($user_id);
            $ob_Credit	= new Credit();
            $user_current_balance=$ob_Credit->get_current_balance($user_id);
            $this->view->user_expiary_date=$user_current_balance[$user_id]['expiary_date'];

            $subusers=$ob_User->get_sub_user_ids($user_id,0,0);
            $this->view->subusers_count=($subusers)?count(explode(',',$subusers)):0;*/
        }
        else
        {
            $this->sessionAuth->menu_permission('nope');
        }


        /*
                $ob_User	= new User();
                $this->view->user_rows=$ob_User->get_user_list_rows(0,$quick_search,$arr_limit,$arr_order);
                $row_count=$ob_User->get_user_list_rows_count(0,$quick_search);
                $arr_rows=array('user_id','account_name','phone','email','nric');
                $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

                $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);*/
//print "<pre>"; print_r($aaaaaaa); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function manageaccountAction()
    {

        //print "<pre>"; print_r($_POST); print "</pre>";exit;

		
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd',''));
        $user_id=0;
		
        $ob_User = new Signup();
        $dataAcc = [];

        if($ses_role==1){ $dataAcc = [1,2,3,4,5] ;}
        if($ses_role==2 || $ses_role==3){ $dataAcc = [2,3,4,5] ;}




        //$dataAcc = ($ses_role=='1') ? ['1','2','3','4','5']: ($ses_role==2 || $ses_role==3) ? ['2','3','4','5'] : '';



        if($ses_role!=1)
        {

            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];

        }else{
            $this->view->companyList = $ob_User->get_company();
        }




        $this->view->accountList=$ob_User->get_account($dataAcc);
        //$this->view->companyList=$ob_User->get_company();





        $this->view->cancel_link = '/Accounts/useraccounts';

        if ($this->_request->isPost()){


            $fname = trim($this->_request->getParam('first_name',''));
            $lname = trim($this->_request->getParam('last_name',''));
            $nickname = trim($this->_request->getParam('nickname',''));
            $email = trim($this->_request->getParam('user_name',''));
            $pass = trim($this->_request->getParam('password',''));
            //$confirm_password = trim($this->_request->getParam('confirm_password',''));
            $company = trim($this->_request->getParam('company',''));
            $account = trim($this->_request->getParam('account',''));
            $status = trim($this->_request->getParam('status',''));
			  if($idd)
				{

					if($pass)
					{
						$ob_User	= new User();

							$ob_User->updateUserWithPass($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user,$idd);
					}else{
						$ob_User	= new User();
							$ob_User->updateUserWithoutPass($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user,$idd);
					}
					$this->sessionAuth->msg_centre('User updated successfully');
					//$this->view->server_msg = $this->sessionAuth->msg_centre();
				}else{
					
					$ob_User->insertUser($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user);
					$this->sessionAuth->msg_centre('User added successfully');
					//$this->view->server_msg = $this->sessionAuth->msg_centre();
				}
			

			$this->_redirect('/Accounts/useraccounts');
        }

        if($idd)
        {
			$ob_User	= new User();
            $this->view->user_detail = $user_detail=$ob_User->get_user_detail_from_idd($idd);


            //echo '<pre>';print_r($user_detail);exit;
            $get_user_id = $user_detail['user_id'];
            $this->view->get_user_active_log_details = $ob_User->get_user_active_log_by_idd($get_user_id);

            $this->view->get_user_deactive_log_details = $ob_User->get_user_deactive_log_by_idd($get_user_id);
            //echo '<pre>';print_r($get_user_deactive_log_details); echo '</pre>';

			/*$this->view->user_detail=$user_detail;
			$createdby = $user_detail['created_by'];
			$createdbydetails=$ob_User->get_user_detail_from_idd($createdby);
			$this->view->createdbydetails=$createdbydetails;*/
			
            $user_id=$user_detail['user_id'];
        }

        if($user_id)
        {
            $this->sessionAuth->menu_permission('Edit_User');
            $this->view->page_title='Edit <span class="semi-bold">User</span>';
        }
        else
        {
            $this->sessionAuth->menu_permission('Add_User');
            $this->view->page_title='Add <span class="semi-bold">User</span>';
        }
        $this->view->user_id=$user_id;

       // if($user_id)
        //{
         //   $this->view->user_detail=$ob_User->getUserDetails($user_id);
        //}

//print "<pre>"; print_r($this->view->user_detail); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function submituserAction()
    {
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd',''));

        if($idd)
        {
            $this->sessionAuth->menu_permission('Edit_User');
        }
        else
        {
            $this->sessionAuth->menu_permission('Add_User');
        }



        $fname = trim($this->_request->getParam('first_name',''));
        $lname = trim($this->_request->getParam('last_name',''));
        $nickname = trim($this->_request->getParam('nickname',''));
        $email = trim($this->_request->getParam('user_name',''));
        $pass = $this->_request->getParam('password','') ? trim($this->_request->getParam('password','')):false;
        //$confirm_password = trim($this->_request->getParam('confirm_password',''));
        $company = trim($this->_request->getParam('company',''));
        $account = trim($this->_request->getParam('account',''));
        $status = trim($this->_request->getParam('status',''));


				if($idd)
				{
                    $ob_User	= new User();
                    $ob_User->updateUser($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user,$idd);

					$this->sessionAuth->msg_centre('User updated successfully');
				}else{
					$ob_User = new User();
					$ob_User->insertUser($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user);
					$this->sessionAuth->msg_centre('User added successfully');
				}
        $this->_redirect('/Accounts/useraccounts');
        exit;
    }


	public function changeuserstatusAction()
    {
		//print_r($ob_signup);
      $a = trim($this->_request->getParam('a',""));
	  $idd = trim($this->_request->getParam('idd',""));
	  $lidd = trim($this->_request->getParam('lidd',""));
	  $ob_User=new User();
      $ob_User->change_status($a,$idd,$lidd);
      exit;
    }

    public function userdetailsAction()
    {
        $idd = trim($this->_request->getParam('idd',""));
        $ob_User	= new User();
        $ob_Request	= new Request();
        $this->view->user_detail = $user_detail=$ob_User->get_user_detail_from_idd($idd);
        if($user_detail['account_id']==4)
        {

            $this->view->request_list = $ob_Request->get_request_list($idd);
        }

        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function mutideleteaccountAction()
    {
        $ob_User = new User();
        foreach($_POST['del_ids'] as $k=>$v)
        {
                $del = true;
                $del_id = $v;
                $this->sessionAuth->menu_permission('Delete_User');
                $user_is_deleted=$ob_User->user_is_deleted($del_id);
                if(!$user_is_deleted)
                {

                    $ob_User->delete_user($del_id);

                }

        }

        if($del)
            $this->sessionAuth->msg_centre('User deleted successfully');
        else
            $this->sessionAuth->msg_centre('Please select atleast one user');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();

    }

    public function driversAction()
    {
        $this->view->count_print = $no_records = 0;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];



        //$ob_Vehicle = new Vehicles();

        $ob_Request = new Request();

        //$this->view->driver_rows = 0;
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row',LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page',1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col','user_id'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ','DESC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;
        if($_POST)
        {
            $this->view->rent_from = $rent_from=   $this->_request->getParam('rent_from','') ? trim($this->_request->getParam('rent_from','')):0;
            $this->view->rent_to = $rent_to=   $this->_request->getParam('rent_to','') ? trim($this->_request->getParam('rent_to','')): 0;
            if($rent_from && $rent_to)
            {
                $company_id = $ses_role!=1 ? $company_id : 0;
                $ret1 = $ob_Request->check_exist_drivers1($rent_from,$rent_to,$company_id,0);
            }
            if(count($ret1) > 0)
            {
                $available_divers = [];
                foreach($ret1 as $k=>$v)
                {
                    $available_divers[] = $driver_id = $v['user_id'];

                }
            }
            //echo '<pre>'; print_r($available_divers); exit;

            if(count($available_divers) > 0)
            {
                $this->view->driver_rows = $ret2 = $ob_Request->search_driver_advance($company_id,$available_divers,$arr_limit,$arr_order);
                $row_count=$ob_Request->get_driver_list_rows_count($company_id,$available_divers);
                $arr_rows=array('company_id','user_id','user_fname','user_lname');
                $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);
                $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);

                $this->view->count_print = count($this->view->driver_rows);
            }else{
                $row_count = 0;
            }

            $this->view->count_rows = $row_count ;
        }
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }




	
	



}

?>