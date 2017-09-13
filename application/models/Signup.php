<?php
/** 
 * @author Eman Daryl Ycot
 * @copyright 2010
 */
class Signup extends Zend_Db_Table{

    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');

    }
    public function gen_pass()
    {
        //return substr(md5(time()),0,8);
        return 'g';
    }
    public function enc_email($p_email)
    {
        return md5(salt_email_pre.$p_email.salt_email_post);
    }
    public function enc_pass($p_pass)
    {
        return md5(salt_pass_pre.$p_pass.salt_pass_post);
    }
    public function CheckDuplicateEmail($p_email,$idd=0)
    {
        $select =   $this->DB->select();
        $select->from(array('u'=>'tranzgo_user'),array('cnt'=>'COUNT(u.user_id)'));
        $select->where('email=?',$p_email);
        if($idd)
        {
            $select->where('user_id<>?',$idd);
        }

        //print $select; exit;
        $ret = $this->DB->fetchRow($select);
        return $ret['cnt'];
    }

    public function get_account($dataAcc)
    {

        $select = $this->DB->select();
        $select->from(array('tma' => "tranzgo_account"), array('account_id','account_name' ) );
        $select->where('account_id IN (?) ',$dataAcc);
        $result = $this->DB->fetchAssoc($select);
       // echo $select;
        //exit;
        return $result;
    }

    public function get_company_by_sess_id($sess_id)
    {

        $select = $this->DB->select();
        $select->from(array('tma' => "tranzgo_user"), array('company_id') );
        $select->joinleft(array('tmc' => "tranzgo_company"),'tma.company_id=tmc.company_id',array('company_name' ) );
        $select->where('user_id =? ',$sess_id);
        $result = $this->DB->fetchRow($select);
        //echo $select; exit;
        return $result;
    }



    public function get_company()
    {
        $select = $this->DB->select();
        $select->from(array('tmc' => "tranzgo_company"), array('company_id','company_name' ) );
        $select->where('tmc.company_status =?',1);
        $result = $this->DB->fetchAssoc($select);

        return $result;
    }







    /*public function get_accesslevel($roleid)
    {
        $select = $this->DB->select();
        $select->from(array('r' => "tranzgo_role"), array('role_id','role_name') );
        $select->joinleft(array('g' => "tranzgo_role_group"),'g.role_group_id=r.role_group_id',array());
        $select->where('r.role_group_id= ?',$roleid);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }*/


    public function insertUser($F_name,$L_name,$U_email,$U_pass,$nickname,$company,$account,$status,$U_createdby)
    {
            $query = array(
                'parent_user_id'=>0,
                'created_by' => $U_createdby,
                'user_fname' => $F_name,
                'user_lname' => $L_name,
                'email' => $U_email,
                'nick_name'=>$nickname,
                'company_id'=>$company,
                'account_id'=>$account,
                'add_date' => CD,
                'mod_date' => CD
            );


        $this->DB->insert('tranzgo_user',$query);
        $user_id=$this->DB->lastInsertId();

        $gen_pass=$U_pass;
        $enc_user_email=$this->enc_email($U_email);
        $enc_user_password=$this->enc_pass($gen_pass);
        $query = array(
            'user_id' => $user_id,
            'user_key' => new Zend_Db_Expr("UUID()"),
            'enc_user_email' => $enc_user_email,
            'enc_user_password' => $enc_user_password,
            'account_id' => $account,
            'is_active' => $status
        );
        $this->DB->insert('tranzgo_user_login_details',$query);


        $select =   $this->DB->select();
        $select->from(array('ul'=>'tranzgo_user_login_details'),array('user_key'=>'user_key'));
        $select->where('user_id=?',$user_id);
        $ret = $this->DB->fetchRow($select);


        $mail_arr['to_mail']=$U_email;
        $mail_arr['to_name']=$F_name." ".$L_name;
        $mail_arr['subject']="tranzgo Login details";
        $mail_arr['body']="hello $F_name $L_name  <br> your password is $gen_pass<br><br> link ".SITEURL."index/compleateprofile/uk/".$ret['user_key']." ";
        //mailerphp::sendEmail($mail_arr);
		return $user_id;

    }

	public function check_not_activated_user($uk)
    {
        $select =   $this->DB->select();
        $select->from(array('ul'=>'tranzgo_user_login_details'),array('user_id','is_delete','is_active','is_activated'));
        $select->where('user_key=?',$uk);
		//print $select; exit;

		$ret_login_detail = $this->DB->fetchRow($select);
		$chk=0;
        if(!$ret_login_detail['is_activated'])
		{
			if($ret_login_detail['user_id'])
			{
				if(!$ret_login_detail['is_delete'])
				{
					if($ret_login_detail['is_active'])
					{
						$this->set_session($ret_login_detail['user_id']);
	
						LoginAuth::msg_centre('Please update your profile First');
						$chk=1;
					}
					else
					{
						LoginAuth::msg_centre("Your account is temporarily deactivated");
					}
				}
				else
				{
					LoginAuth::msg_centre("Your account is temporarily Deleted");
				}
	
			}
			else
			{
				LoginAuth::msg_centre("Your account Not found");
			}
		}
		else
		{
			LoginAuth::msg_centre("your account is already activated please do Login");
		}
		return $chk;
    }
	public function update_user($user_id,$arr_data)
    {
        $this->DB->update('tranzgo_user',$arr_data,array("user_id=$user_id"));
		$this->set_session($user_id);
    }
	public function activate_user($user_id)
    {
		$this->DB->update('tranzgo_user_login_details',array('is_activated'=>1),array("user_id=$user_id"));
    }
	public function update_user_pass($user_id,$pass)
    {
        $enc_user_password=$this->enc_pass($pass);
		$this->DB->update('tranzgo_user_login_details',array('enc_user_password'=>$enc_user_password,'forgot_pass_key'=>"",'forgot_pass_expire'=>""),array("user_id=$user_id"));
    }




    public function set_session($user_id)
    {
        $select =   $this->DB->select();
        $select->from(array('u'=>'tranzgo_user'),array('user_id','company_id','parent_user_id','created_by','user_fname','user_lname','email','phone','nric','address','add_date','mod_date'));
        $select->joinLeft(array('ul'=>'tranzgo_user_login_details'),'u.user_id=ul.user_id',array('user_key','enc_user_email','enc_user_password','role_id','account_id','cookie_key','forgot_pass_key','forgot_pass_expire','is_activated','is_active','is_delete'));
        $select->where('u.user_id=?',$user_id);


        $ret_user_detail = $this->DB->fetchRow($select);
        $account_id=$ret_user_detail['account_id'];

        $select =   $this->DB->select();
        $select->from(array('ump'=>'tranzgo_role_menu_permission'),array());
        $select->joinLeft(array('m'=>'tranzgo_menu'),'ump.menu_id=m.menu_id',array('menu_id','p_menu_id','menu_name','menu_page_name','menu_image','menu_permission','status','type'));
        $select->where('ump.account_id=?',$account_id);
        $select->where('m.status=?','A');
        //print $select;exit;
        $ret_menu_details = $this->DB->fetchAssoc($select);
        //print "<pre>"; print_r($ret_menu_details); print "</pre>";
        $menu_arr=array();
        $permission_arr=array();
        foreach($ret_menu_details as $k=>$v)
        {
            if($v['type']=='M')
            {
                $menu_arr[$v['p_menu_id']][$k]=array('menu_name'=>$v['menu_name'],'menu_page_name'=>$v['menu_page_name'],'menu_image'=>$v['menu_image']);
            }
            $permission_arr[$v['menu_permission']]=1;
        }
        $permission_arr['all_access']=1;

        $tranzgo_session 		= new Zend_Session_Namespace('tranzgo_session');
        $tranzgo_session->user_id=$ret_user_detail['user_id'];
        $tranzgo_session->company_id=$ret_user_detail['company_id'];
        $tranzgo_session->user_key=$ret_user_detail['user_key'];
        $tranzgo_session->account_id=$ret_user_detail['account_id'];
        $tranzgo_session->cookie_key=$ret_user_detail['cookie_key'];
        $tranzgo_session->is_activated=$ret_user_detail['is_activated'];
        $tranzgo_session->user_fname=$ret_user_detail['user_fname'];
        $tranzgo_session->user_lname=$ret_user_detail['user_lname'];
        $tranzgo_session->email=$ret_user_detail['email'];
        $tranzgo_session->job_position_id=$ret_user_detail['job_position_id'];


        $tranzgo_session->menu=$menu_arr;
        $tranzgo_session->menu_permission=$permission_arr;

        //print "<pre>"; print_r($_SESSION); print "</pre>";
        //exit;
    }
    public function set_cookie($user_id,$ul_remember)
    {
        if($ul_remember)
        {
            $cookie_keyquery = array('cookie_key' => new Zend_Db_Expr("UUID()"));
            $this->DB->update('tranzgo_user_login_details',$cookie_keyquery,array("user_id=$user_id"));
            $select =   $this->DB->select();
            $select->from(array('ul'=>'tranzgo_user_login_details'),array('cookie_key','user_key'));
            $select->where('user_id=?',$user_id);

            $ret_cookie_key = $this->DB->fetchRow($select);
            $expire=time()+60*60*24*30;
            setcookie("tranzgo_coocky_u", $ret_cookie_key['user_key'], $expire,'/');
            setcookie("tranzgo_coocky_k", $ret_cookie_key['cookie_key'], $expire,'/');
        }
        else
        {
            $cookie_keyquery = array('cookie_key' => "");
            $this->DB->update('tranzgo_user_login_details',$cookie_keyquery,array("user_id=$user_id"));

            $expire=time()-60*60;
            setcookie("tranzgo_coocky_u", "", $expire,'/');
            setcookie("tranzgo_coocky_k", "", $expire,'/');
        }
    }
    public function doLogin($ul_mail,$ul_pass,$ul_remember)
    {

        unset($_SESSION['tranzgo_session_login_error']);
        unset($_SESSION['tranzgo_session']);

        $enc_user_email=$this->enc_email($ul_mail); print "<br>";
        $enc_user_password=$this->enc_pass($ul_pass);

        $select =   $this->DB->select();
        $select->from(array('ul'=>'tranzgo_user_login_details'),array('user_id','is_delete','is_active'));
        $select->where("enc_user_email='$enc_user_email'");
        $select->where("enc_user_password='$enc_user_password'");

		//print $select; exit;
        $ret_login_detail = $this->DB->fetchRow($select);
        //print "<pre>"; print_r($ret_login_detail); print "</pre>";exit;
        $tranzgo_session_login_error 		= new Zend_Session_Namespace('tranzgo_session_login_error');

        if($ret_login_detail['user_id'])
        {
            if(!$ret_login_detail['is_delete'])
            {

                if($ret_login_detail['is_active'])
                {

                    $this->set_cookie($ret_login_detail['user_id'],$ul_remember);

                    $this->set_session($ret_login_detail['user_id']);

                    unset($_SESSION['tranzgo_session_login_error']);
                    $ob_LoginAuth = new LoginAuth();


                    $ob_LoginAuth->msg_centre('You are success fully logged in');

                }
                else
                {
                    $tranzgo_session_login_error->error_msg="Your account is temporarily deactivated";
                }
            }
            else
            {
                $tranzgo_session_login_error->error_msg="Your account is temporarily Deleted";
            }//is_active 	is_delete

        }
        else
        {
            $tranzgo_session_login_error->error_msg="<i class='fa fa-exclamation-triangle'></i> Sorry, these credentials are invalid.";
        }


    }

	public function rest_pass($ulf_email)
    {
        $enc_user_email=$this->enc_email($ulf_email);

		$query=array(
		'forgot_pass_key'=>new Zend_Db_Expr("UUID()"),
		'forgot_pass_expire'=>date('Y-m-d H:i:s',strtotime("+2 day")));
		$this->DB->update('tranzgo_user_login_details',$query,array("enc_user_email='$enc_user_email'"));

		$select =   $this->DB->select();
		$select->from(array('ul'=>'tranzgo_user_login_details'),array('user_id','forgot_pass_key','user_key','forgot_pass_expire'));
		$select->where('enc_user_email=?',$enc_user_email);
		$ret_reset_key = $this->DB->fetchRow($select);
		//print $select;
		$select =   $this->DB->select();
		$select->from(array('ul'=>'tranzgo_user'),array('user_fname','user_lname'));
		$select->where('user_id=?',$ret_reset_key['user_id']);
		//print $select;
		$ret_user = $this->DB->fetchRow($select);


		$mail_arr['to_mail']=$ulf_email;
        $mail_arr['to_name']=$ret_user['user_fname']." ".$ret_user['user_lname'];
        $mail_arr['subject']="XM RESET PASS LINK";
        $mail_arr['body']="hello ".$ret_user['user_fname']." ".$ret_user['user_lname']."
		<br> click below link for reset your password
		<br><br><br> link ".SITEURL."index/resetchengepass/uk/".$ret_reset_key['user_key']."/pk/".$ret_reset_key['forgot_pass_key']."/email/".$ulf_email." ";
        ////mailerphp::sendEmail($mail_arr);
		//exit;
    }

    public function Check_reset_pass_request($uk,$pk,$email)
    {
        $return_msg=0;
        $expire=0;
        $ret_reset_key = $this->get_user_for_change_pass($uk,$pk,$email);
        if($ret_reset_key['user_id'] && $ret_reset_key['forgot_pass_key'])
        {
            if(CD>$ret_reset_key['forgot_pass_expire'])
            {
                $return_msg="This link was expired click [Resend link] to send another link";
                $expire=1;
            }
        }
        else
        {
            $return_msg="This link is not valid";
        }

        return $return_msg."|=|".$expire;
        //exit;
    }

    public function get_user_for_change_pass($uk,$pk,$email)
    {
        $enc_user_email=$this->enc_email($email);
        $select =   $this->DB->select();
        $select->from(array('ul'=>'tranzgo_user_login_details'),array('user_id','forgot_pass_expire','forgot_pass_key'));
        $select->where('enc_user_email=?',$enc_user_email);
        $select->where('forgot_pass_key=?',$pk);
        $select->where('user_key=?',$uk);
        $ret_reset_key = $this->DB->fetchRow($select);

        return $ret_reset_key;
    }

    public function insert_menu_prmission($user_id,$role_id)
    {
        $this->DB->delete('tranzgo_user_menu_permission', "user_id = ".$user_id);


        $select =   $this->DB->select();
        $select->from(array('ul'=>'tranzgo_role_menu_permission'),array('menu_id'));
        $select->where('role_id=?',$role_id);
        $ret_reset_key = $this->DB->fetchAssoc($select);

        $query_pre="insert into tranzgo_user_menu_permission (menu_id,user_id) VALUES ";
        $date_ins=array();
        foreach ($ret_reset_key as $k=>$v)
        {
            $date_ins[]="(".$v['menu_id'].",".$user_id.")";
        }
        $query=$query_pre.implode(',',$date_ins);
        $this->DB->query($query);

        $this->set_session($user_id);
        return $ret_reset_key;
    }

    public function doSignout()
    {
        unset($_SESSION['tranzgo_session_login_error']);
        unset($_SESSION['tranzgo_session']);
        unset($_SESSION['tranzgo_session_program']);
        unset($_SESSION['bc_session']);
        unset($_SESSION['tc_session']);

        LoginAuth::msg_centre('You are successfully logged out');
        $expire=time()-60*60;
        setcookie("tranzgo_coocky_u", "", $expire,'/');
        setcookie("tranzgo_coocky_k", "", $expire,'/');
    }

    public function clean_up_User()
    {
        $cleanup_date=date('Y-m-d',strtotime("-2 day"));

        $select =   $this->DB->select();
        $select->from(array('u'=>'tranzgo_user'),array('user_id'));
        $select->joinLeft(array('ul'=>'tranzgo_user_login_details'),'u.user_id=ul.user_id',array());

        $select->where('u.add_date<?',$cleanup_date);
        $select->where('ul.is_activated=?',0);

        $ret_user = $this->DB->fetchAssoc($select);

        foreach($ret_user as $k=> $v)
        {
            $this->DB->delete('tranzgo_user_login_details', "user_id = ".$v['user_id']);
            $this->DB->delete('tranzgo_user', "user_id = ".$v['user_id']);
        }


    }
	
	public function get_designations()
    {
        $select = $this->DB->select();
        $select->from(array('g' => "tranzgo_agent_designation"), array('agent_designation_id','agent_designation_name' ) );
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
	
	public function get_tier2Sup()
    {
        $select = $this->DB->select();
        $select->from(array('g' => "tranzgo_agent"), array('agent_id','preffered_name' ));
		$select->where('g.agent_designation_id IN (?)',array(5));
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
	
	public function get_tier3Sup()
    {
        $select = $this->DB->select();
        $select->from(array('g' => "tranzgo_agent"), array('agent_id','preffered_name' ));
		$select->where('g.agent_designation_id IN (?)',array(5,7,8,10,11));
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
	
	public function registerdby($ses_user)
    {
		$select = $this->DB->select();
        $select->from(array('g' => "tranzgo_user"), array('register_by'=>'CONCAT_WS(" ",user_fname,user_lname)'));
		$select->where('g.user_id=?',$ses_user);
        $result = $this->DB->fetchRow($select);
        return $result;
    }
	



}

?>