<?php
class User extends Zend_Db_Table{

	private $DB;
	protected $_table = "tranzgo_user";

	public function __construct()
	{
		$this->DB = Zend_Registry::get('DB');
	}

	
/*--get user details--*/
    public function get_user_detail_from_idd($idd)
    {
        $select = $this->DB->select();
        $select->from(array('u' => $this->_table), array('user_id',
            'user_fname',
            'user_lname',
            'email',
            'nick_name',
            'company_id',
            'account_id',
            'phone',
            'address',
            'add_date',
            'mod_date',
            'created_by'));
        $select->joinleft(array('u11' => $this->_table),'u.created_by=u11.user_id',array('created_by_name'=> new Zend_Db_Expr("CONCAT(u11.user_fname,' ',u11.user_lname)")));
        $select->joinleft(array('u1' => 'tranzgo_user_login_details'),'u.user_id=u1.user_id',array('role_id','is_active'));
        $select->where('u.user_id= ?', $idd);
        $result = $this->DB->fetchRow($select);

        return $result;
    }
	

    public function get_sub_user($perent_id,$is_admin=0,$is_activated=1,$is_active=1,$is_delete=0)
    {
        $select = $this->DB->select();
        $select->from(array('u' => $this->_table), array('user_id','user_fname','user_lname' ) );
        $select->joinleft(array('ul' => 'tranzgo_user_login_details'),'u.user_id=ul.user_id',array());


        $select->where('ul.is_activated= ?', $is_activated);
        $select->where('ul.is_active= ?', $is_active);
        $select->where('ul.is_delete= ?', $is_delete);
        if($is_admin)
        {
            $select->where('ul.role_id in (2,3)');
            $select->where('u.parent_user_id= ?', 0);
        }
        else
        {
            $select->where('u.parent_user_id= ?', $perent_id);
        }
        //print
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
    public function get_sub_user_ids($perent_id,$is_active=1,$is_activated=1)
    {
        $select = $this->DB->select();
        $select->from(array('u' => $this->_table), array('user_ides'=> new Zend_Db_Expr("group_concat(CAST(u.user_id AS CHAR))")));
        $select->joinleft(array('ul' => 'tranzgo_user_login_details'),'u.user_id=ul.user_id',array());

        $select->where('u.parent_user_id= ?', $perent_id);
        if($is_activated)
        {
            $select->where('ul.is_activated= ?', $is_activated);
        }
        if($is_active)
        {
            $select->where('ul.is_active= ?', $is_active);
        }
        $select->where('ul.is_delete=0');

        //print $select; exit;
        $result = $this->DB->fetchRow($select);
//print "<pre>"; print_r($result); print "</pre>"; exit;
        return $result['user_ides'];
    }

    public function get_managers($perent_id,$is_admin=0,$is_activated=1,$is_active=1,$is_delete=0)
    {
        $select = $this->DB->select();
        $select->from(array('u' => $this->_table), array('user_id','user_fname','user_lname') );
        $select->joinleft(array('ul' => 'tranzgo_user_login_details'),'u.user_id=ul.user_id',array('role_id'));
        $select->joinleft(array('cb' => 'tranzgo_credit_ballance'),'u.user_id=cb.user_id',array('current_ballance','expiary_date'=>"DATE_FORMAT(expiary_date,'%Y-%m-%d')",'date_diff'=>"DATEDIFF(expiary_date,'".OCD."')"));
        $select->where('ul.role_id= ?', '2');
        $select->where('ul.is_activated= ?', $is_activated);
        $select->where('ul.is_active= ?', $is_active);
        $select->where('ul.is_delete= ?', $is_delete);


        if($is_admin)
        {
            $select->orwhere('u.user_id= ?', $perent_id);
        }
        else
        {
            $select->where('u.user_id= ?', $perent_id);
        }

        $select->order(array('role_id asc','user_fname asc'));

//print $select; exit;
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
    public function get_managers_dd($man_id,$is_activated=1,$is_active=1,$is_delete=0)
    {
        $select = $this->DB->select();
        $select->from(array('u' => $this->_table), array('user_id','user_fname','user_lname') );
        $select->joinleft(array('ul' => 'tranzgo_user_login_details'),'u.user_id=ul.user_id',array('role_id'));
        $select->where('ul.role_id= ?', '2');
        $select->where('ul.is_activated= ?', $is_activated);
        $select->where('ul.is_active= ?', $is_active);
        $select->where('ul.is_delete= ?', $is_delete);
        $select->order(array('user_fname asc'));
        if($man_id)
        {
            $select->where('u.user_id= ?', $man_id);
        }
//print $select; exit;
        $result = $this->DB->fetchAssoc($select);
        $ret_arr=array();
        foreach($result as $k=>$v)
        {
            $ret_arr[$k]=LoginAuth::id_buffer($v['user_id']).' - '.$v['user_fname'].' '.$v['user_lname'];
        }
        return $ret_arr;
    }

    public function getUserDetails($user_id)
	{
        $select =   $this->DB->select();
        $select->from(array('ul'=>'tranzgo_user'),array('user_id','user_fname','user_lname','email'));
        $select->where('user_id=?',$user_id);
        return $this->DB->fetchRow($select);
	}


    public function insertUser($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user)
    {
        $query = array(
            'created_by' => $_SESSION['tranzgo_session']['user_id'],
            'user_fname' => $fname,
            'user_lname' => $lname,
            'email' => $email,
            //'nric' => $Data['nric'],
            //'phone' => $Data['phone'],
            'nick_name'=>$nickname,
            'company_id'=>$account!=1?$company:0,
            'account_id'=>$account,
            'add_date' => CD,
            'mod_date' => CD
        );

        $this->DB->insert('tranzgo_user',$query);
        $user_id=$this->DB->lastInsertId();

        $enc_user_email=Signup::enc_email($email);
        $enc_user_password=Signup::enc_pass($pass);
        $query = array(
            'user_id' => $user_id,
            'user_key' => new Zend_Db_Expr("UUID()"),
            'enc_user_email' => $enc_user_email,
            'enc_user_password' => $enc_user_password,
            'account_id'=>$account,
            'is_active' => $status
            //'role_id' => 2
        );
        $this->DB->insert('tranzgo_user_login_details',$query);

        $query_active_deactive = array(
            'changed_by'    => $ses_user,
            'change_to' 	=> $user_id,
            'status'		=>$status,
            'date_time' 	=> CD
        );

        $this->DB->insert('tranzgo_user_active_deactive_log',$query_active_deactive);

        return $user_id;

    }


    public function updateUser($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user,$idd)
    {

        $query = array(
            'user_fname' => $fname,
            'user_lname' => $lname,
            'email' => $email,
            'nick_name'=>$nickname,
            'company_id'=>$account!=1?$company:0,
            'account_id'=>$account,
            'mod_date' => CD
        );


        $this->DB->update('tranzgo_user',$query,array("user_id=$idd"));
		
		
		//update access level
		/*$query_access_level = array(
            'role_id' => $access_level
        );
		$query_access_level;
        $this->DB->update('tranzgo_user_login_details',$query_access_level,array("user_id=$idd"));*/
		

        //$gen_pass=Signup::gen_pass();


        if($pass)
        {
            $query = array(
                'enc_user_email' => Signup::enc_email($email),
                'enc_user_password' => Signup::enc_pass($pass),
                'account_id'=>$account,
                'is_active' => $status
            );
        }else{


            $query = array(
                'enc_user_email' => Signup::enc_email($email),
                'account_id'=>$account,
                'is_active' => $status
            );
        }

        $this->DB->update('tranzgo_user_login_details',$query,array("user_id=$idd"));


        $query_active_deactive = array(
            'changed_by'    => $ses_user,
            'change_to' 	=> $idd,
            'status'		=>$status,
            'date_time' 	=> CD
        );

        $this->DB->insert('tranzgo_user_active_deactive_log',$query_active_deactive);

        //$mail_arr['to_mail']=$Data['email'];
        //$mail_arr['to_name']=$Data['user_fname']." ".$Data['user_lname'];
        //$mail_arr['subject']="XM Login details";
        //$mail_arr['body']="hello ".$Data['user_fname']." ".$Data['user_lname']."  <br> your password is $gen_pass<br><br> link ".SITEURL."index/compleateprofile/uk/".$ret['user_key']." ";
        //mailerphp::sendEmail($mail_arr);
    }
	
	
	
	
	public function updateUserWithoutPass($fname,$lname,$email,$pass,$nickname,$company,$account,$status,$ses_user,$idd)
    {

        $query = array(
            'user_fname' => $fname,
            'user_lname' => $lname,
            'email' => $email,
            'nick_name'=>$nickname,
            'company_id'=>$company,
            'account_id'=>$account,
            'mod_date' => CD
        );
        $this->DB->update('tranzgo_user',$query,array("user_id=$idd"));
		
		
		
		//update access level
		$query_access_level = array(
            'account_id' => $account
        );

        $this->DB->update('tranzgo_user_login_details',$query_access_level,array("user_id=$idd"));

        //$gen_pass=Signup::gen_pass();
        $enc_user_email=Signup::enc_email($email);
            $query = array(
                'enc_user_email' => $enc_user_email
            );
        $this->DB->update('tranzgo_user_login_details',$query,array("user_id=$idd"));





        //$mail_arr['to_mail']=$Data['email'];
        //$mail_arr['to_name']=$Data['user_fname']." ".$Data['user_lname'];
        //$mail_arr['subject']="XM Login details";
        //$mail_arr['body']="hello ".$Data['user_fname']." ".$Data['user_lname']."  <br> your password is $gen_pass<br><br> link ".SITEURL."index/compleateprofile/uk/".$ret['user_key']." ";
        //mailerphp::sendEmail($mail_arr);
    }

    public function activeUser($Data,$user_id)
    {
        $this->DB->update('tranzgo_user_login_details',$Data,array("user_id=$user_id"));
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
    }
    public function updateprofile($Data,$user_id)
    {
        $select =   $this->DB->select();
        $select->from(array('ul'=>'tranzgo_user_login_details'),array('user_key'=>'user_key','role_id','is_activated'));
        $select->where('user_id=?',$user_id);
        $ret = $this->DB->fetchRow($select);


        $query = array(
            'user_fname' => $Data['user_fname'],
            'user_lname' => $Data['user_lname'],
            'email' => $Data['email'],
            'mod_date' => CD
        );

        $this->DB->update('tranzgo_user',$query,array("user_id=$user_id"));

        //$gen_pass=Signup::gen_pass();
        $enc_user_email=Signup::enc_email($Data['email']);

        //$enc_user_password=Signup::enc_pass($gen_pass);
        $query = array(
            'enc_user_email' => $enc_user_email,
        );
        $this->DB->update('tranzgo_user_login_details',$query,array("user_id=$user_id"));
        //mailerphp::sendEmail($mail_arr);

        //$mail_arr['to_mail']=$Data['email'];
        //$mail_arr['to_name']=$Data['user_fname']." ".$Data['user_lname'];
        //$mail_arr['subject']="XM Login details";
        //$mail_arr['body']="hello ".$Data['user_fname']." ".$Data['user_lname']."  <br> your password is $gen_pass<br><br> link ".SITEURL."index/compleateprofile/uk/".$ret['user_key']." ";
        //mailerphp::sendEmail($mail_arr);
    }
    public function get_user_list_rows($comp_id,$quick_search,$arr_limit,$arr_order)
    {
        $select =   $this->DB->select();
        $select->from(array('u'=>$this->_table),
            array(
                'user_id',
				'user_fname',
				'user_lname',
				'address',
                'email',
				'phone',
				'nric',
				'created_by',
                'add_date'
                ));
		$select->joinleft(array('ul'=>$this->_table),'u.created_by=ul.user_id',array('created_by_fname'=>'user_fname','created_by_lname'=>'user_lname'));		
        $select->joinleft(array('u1'=>'tranzgo_user_login_details'),'u.user_id=u1.user_id',array('account_id','is_activated','is_active'));
        $select->joinleft(array('u2'=>'tranzgo_account'),'u1.account_id=u2.account_id',array('account_name'));
        $select->joinleft(array('u3'=>'tranzgo_company'),'u3.company_id=u.company_id',array('company_name'));

        $select->where('u1.is_delete=?',0);

        if($comp_id) //called from manager login
        {
            $select->where("u.company_id in ($comp_id)");
        }
//A/C # 	Account Name 	Parent Account 	Account Role 	Credits 	Expiry 	Options 	Deactivate
//user_id 	account_name 	add_date 	add_date_print 	perent_id 	perent_name 	user_key 	role_id 	is_active 	current_ballance 	expiary_date 	expiary_date_print 	role_name

        if($quick_search)
        {
		
            $select->where("
            u.user_id like '%$quick_search%' or
            u.user_fname like '%$quick_search%' or
			u.email like '%$quick_search%' or
			u2.account_name like '%$quick_search%' or
			u3.company_name like '%$quick_search%' or
            u.user_lname like '%$quick_search%'");
        }

        $select->order($arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);
    }
    public function get_user_list_rows_count($comp_id,$quick_search)
    {
        $select =   $this->DB->select();
        $select->from(array('u'=>$this->_table),array('num'=>'count(u.user_id)'));
        $select->joinleft(array('uld'=>'tranzgo_user_login_details'),'u.user_id=uld.user_id',array());
		$select->joinleft(array('u2'=>'tranzgo_account'),'u.account_id=u2.account_id',array());
        $select->joinleft(array('u3'=>'tranzgo_company'),'u3.company_id=u.company_id',array('company_name'));
        $select->where('uld.is_delete=?',0);
        if($comp_id)
        {
            $select->where("u.company_id in ($comp_id)");
        }
        if($quick_search)
        {
           $select->where("
            u.user_id like '%$quick_search%' or
            u.user_fname like '%$quick_search%' or
			u.email like '%$quick_search%' or
			u2.account_name like '%$quick_search%' or
			u3.company_name like '%$quick_search%' or
            u.user_lname like '%$quick_search%'");
		
        }
        //print $select; exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }
    public function user_is_deleted($user_id)
    {
        $select = $this->DB->select();
        $select->from(array('ul' => 'tranzgo_user_login_details'), array('ul.is_delete'));
        $select->where('ul.user_id= ?', $user_id);
        $result = $this->DB->fetchRow($select);
        return $result['is_delete'];
    }
    public function delete_user($user_id)
    {

        $this->DB->update('tranzgo_user_login_details',array('is_delete'=>1),array("user_id=$user_id AND user_id!=1"));
    }
    public function user_is_active_status($user_id)
    {
        $select = $this->DB->select();
        $select->from(array('ul' => 'tranzgo_user_login_details'), array('ul.is_active'));
        $select->where('ul.user_id= ?', $user_id);
        $result = $this->DB->fetchRow($select);
        return $result['is_active'];
    }
    public function de_act_user($user_id,$tyyp)
    {
        $this->DB->update('tranzgo_user_login_details',array('is_active'=>$tyyp),array("user_id=$user_id"));
    }
	
	
	public function change_status($a,$idd,$lidd)
	{
		$query = array(
            'changed_by'    => $lidd,
            'change_to' 	=> $idd,
			'status'		=>$a,
            'date_time' 	=> CD
			);

        $this->DB->insert('tranzgo_user_active_deactive_log',$query);
		echo $this->DB->update('tranzgo_user_login_details',array('is_active'=>$a),array("user_id=$idd"));
	}

/*---User active deactive log---*/
    public function get_user_active_log_by_idd($get_user_id)
    {
        $select = $this->DB->select();
        $select->from(array('l' => 'tranzgo_user_active_deactive_log'));
        $select->joinleft(array('u'=>'tranzgo_user'),'u.user_id=l.changed_by',array('changed_by_name'=> new Zend_Db_Expr("CONCAT(u.user_fname,' ',u.user_lname)")));
        $select->where('l.change_to= ?', $get_user_id);
        $select->where('l.status= ?', 1);
        $select->order(array('l.date_time DESC'));
        $select->limit(1,0);
        $result = $this->DB->fetchRow($select);
        return $result;
    }


    public function get_user_deactive_log_by_idd($get_user_id)
    {
        $select = $this->DB->select();
        $select->from(array('l' => 'tranzgo_user_active_deactive_log'));
        $select->joinleft(array('u'=>'tranzgo_user'),'u.user_id=l.changed_by',array('changed_by_name'=> new Zend_Db_Expr("CONCAT(u.user_fname,' ',u.user_lname)")));
        $select->where('l.change_to= ?', $get_user_id);
        $select->where('l.status= ?', 0);
        $select->order(array('l.date_time DESC'));
        $select->limit(1,0);
        $result = $this->DB->fetchRow($select);
        return $result;
    }

    public function admin_details()
    {
        $select =   $this->DB->select();
        $select->from(array('ud'=>'tranzgo_user_login_details'),array('ud.user_id','ud.role_id'));
        $select->joinleft(array('u'=>'tranzgo_user'),'u.user_id=ud.user_id',array('u.email'));
        $select->where('ud.role_id=?',1);
        return $this->DB->fetchAll($select);
    }




}
?>
