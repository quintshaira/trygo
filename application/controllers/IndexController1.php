<?php
class IndexController extends Zend_Controller_Action
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
        //Zend_Loader::loadClass('mailerphp');
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
        //$this->sessionAuth->login_user_check();
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
		//action body
		/*$this->view->pagetitle = "Project XM";

        //print "<pre>"; print_r($_SESSION); print "</pre>";*/



        if($_SESSION['tranzgo_session_login_error']['error_msg'])
        {
			$this->_redirect('/index/signin');
        }
        else if(!$_SESSION['tranzgo_session']['user_id'])
        {
            $this->_redirect('/index/signin');
        }
        else
        {

            $this->_redirect('/Dashboard');

                 /* $_SESSION['tranzgo_session']['account_id']==1 ? $this->_redirect('/Accounts/useraccounts')
                : $_SESSION['tranzgo_session']['account_id']==2 ? $this->_redirect('/Accounts/useraccounts')
                : $_SESSION['tranzgo_session']['account_id']==3 ? $this->_redirect('/Accounts/useraccounts')
                : $_SESSION['tranzgo_session']['account_id']==4 ? $this->_redirect('/Request')
                : $_SESSION['tranzgo_session']['account_id']==5 ? $this->_redirect('/Request')
                : $this->_redirect('/')   ;*/





            //$this->_redirect('/Accounts/useraccounts');

            //$this->_redirect('/Measurementquarter/listmq');
        }

		$layout = $this->_helper->layout();
		$layout->setLayout('frontend/onecolumn');
	}

    public function signinAction()
    {
        $this->view->server_msg = $_SESSION['tranzgo_session_login_error']['error_msg'];
        unset($_SESSION['tranzgo_session_login_error']);

        $layout = $this->_helper->layout();
        $layout->setLayout('default');
    }
    public function registerAction()
    {
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }


    public function profileAction()
    {
        $this->sessionAuth->login_user_check();
		$user = new User();
        $this->view->user_details = $user->getUserDetails($_SESSION['bsc_session']['user_id']);
        //print "<pre>"; print_r($this->view->user_details); print "</pre>"; exit;
        $this->sessionAuth->menu_permission('My_Profile');
        $this->view->cancel_link = '/Measurementquarter/listmq';

        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }
	
	public function updateprofileAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
		$this->sessionAuth->login_user_check();
        $ob_Signup = new Signup();
        $arr_data['user_fname'] = trim($this->_request->getParam('fname',""));
        $arr_data['user_lname'] = trim($this->_request->getParam('lname',""));
        $arr_data['email'] = trim($this->_request->getParam('email',""));
        $arr_data['nric'] = trim($this->_request->getParam('nric',""));
        $arr_data['phone'] = trim($this->_request->getParam('phone',""));
        $arr_data['address'] = trim($this->_request->getParam('ch_add',""));
        //$arr_data['DOB'] = trim($this->_request->getParam('dob',""));
        $this->sessionAuth->menu_permission('Update_Profile');
        $ob_User	= new User();
        $ob_User->updateprofile($arr_data,$_SESSION['bsc_session']['user_id']);

        $new_pass=   trim($this->_request->getParam('pass',''));
        $ob_Signup = new Signup();
        $ob_Signup->update_user_pass($_SESSION['bsc_session']['user_id'],$new_pass);
        $this->sessionAuth->msg_centre('Profile updated successfully');

        $ob_Signup->set_session($_SESSION['bsc_session']['user_id']);

        $this->_redirect('/index/profile');
        exit;
    }

    /*
    public function passchangeAction()
    {
        $this->sessionAuth->login_user_check();
		$old_pass=   trim($this->_request->getParam('old_pass',''));
        $new_pass=   trim($this->_request->getParam('new_pass',''));
        $ob_Signup = new Signup();

        $chk=$ob_Signup->Check_old_pass($_SESSION['bsc_session']['user_id'],$old_pass);
        if($chk)
        {
            $ob_Signup->update_user_pass($_SESSION['bsc_session']['user_id'],$new_pass);
            $this->sessionAuth->msg_centre('Profile Password updated successfully');
        }
        else
        {
            LoginAuth::msg_centre("<b>password not changed</b> old password not matched");
        }
        $this->_redirect('/index/profile');

    } */




    public function loginauthAction()
    {
        //action body
        $ob_Signup	= new Signup();
//print "<pre>"; print_r($_GET); print "</pre>";
      $ul_mail = trim($this->_request->getParam('ul_mail',""));
      $ul_pass = trim($this->_request->getParam('ul_pass',""));
      //$ul_captcha = trim($this->_request->getParam('captcha_code',""));
      $ul_remember = trim($this->_request->getParam('ul_remember',""));

        $user_id=$ob_Signup->doLogin($ul_mail,$ul_pass,$ul_remember);
        //print "<pre>"; print_r($_SESSION); print "</pre>";exit;

        $this->_redirect('/');

        exit;

    }

    public function signoutAction()
    {
        //action body
        $ob_Signup	= new Signup();
        $ob_Signup->doSignout();

        $this->_redirect('/');

        exit;

    }

    public function dupemailAction()
    {
        //action body
        $this->sessionAuth->login_user_check();
        $ob_Signup	= new Signup();

        $U_email = trim($this->_request->getParam('U_email',""));
        $idd = trim($this->_request->getParam('idd',""));
        print $ob_Signup->CheckDuplicateEmail($U_email,$idd);
        exit;
    }
    public function resetpassAction()
    {
        //action body
        $this->sessionAuth->login_user_check();
        $ob_Signup	= new Signup();

        $ulf_email = trim($this->_request->getParam('ulf_email',""));

        $is_present=$ob_Signup->CheckDuplicateEmail($ulf_email);
        if($is_present)
        {
            $ob_Signup->rest_pass($ulf_email);
        }
        print $is_present;
        exit;

    }
    public function resetchengepassAction()
    {
        //action body
        $this->sessionAuth->login_user_check();
        $this->view->server_msg = $_SESSION['bsc_session_login_error']['error_msg'];
        unset($_SESSION['bsc_session_login_error']);

        $uk = trim($this->_request->getParam('uk',""));
        $pk = trim($this->_request->getParam('pk',""));
        $email = trim($this->_request->getParam('email',""));

        $ob_Signup	= new Signup();
        $ret_msg=$ob_Signup->Check_reset_pass_request($uk,$pk,$email);
        list($ret_msg,$expire)=explode('|=|',$ret_msg);

        if($ret_msg)
        {
            $this->view->ret_msg=$ret_msg;
            $this->view->expire=$expire;
        }
        $this->view->uk=$uk;
        $this->view->pk=$pk;
        $this->view->email=$email;
        $this->view->target_url = '/index/resetchengepasssubmit';
        $this->view->site_user = 'public';
        $this->view->page_id = 'home';
        //exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('default');
    }
    public function resetchengepasssubmitAction()
    {
        //action body
        $this->sessionAuth->login_user_check();
        $uk = trim($this->_request->getParam('uk',""));
        $pk = trim($this->_request->getParam('pk',""));
        $email = trim($this->_request->getParam('email',""));
        $new_pass = trim($this->_request->getParam('ch_pass',""));
        $expire = trim($this->_request->getParam('expire',""));
        $bsc_session_login_error 		= new Zend_Session_Namespace('bsc_session_login_error');
        $ob_Signup	= new Signup();

        if($expire)
        {
            $ob_Signup->rest_pass($email);
            $bsc_session_login_error->error_msg='<i class="fa fa-envelope"></i> An email with instructions to <strong>Reset your Password</strong> has been sent to your email.';
        }
        else
        {
            $ret_reset_key=$ob_Signup->get_user_for_change_pass($uk,$pk,$email);
            if($ret_reset_key['user_id'] && $ret_reset_key['forgot_pass_key'])
            {
                $ob_Signup->update_user_pass($ret_reset_key['user_id'],$new_pass);
                $ob_Signup->set_session($ret_reset_key['user_id']);
                $this->sessionAuth->msg_centre('Password changed successfully');
            }
            else
            {
                $bsc_session_login_error->error_msg='Previous link is not valid do change request again';
            }
        }
        $this->_redirect('/');
        exit;

    }

}

?>