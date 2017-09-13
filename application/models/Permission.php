<?php
class Permission extends Zend_Db_Table{

    private $DB; 
	protected $_table = "bsc_contactus";

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');
    }

    public function permission_table($role_id)
    {
        $select = $this->DB->select();
        $select->from(array('r' => 'bsc_user_privilage'));
        $select->where('r.role_id= ?', $role_id);
        $select->order(array('user_privilage_id ASC'));
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

	public function get_role_permission($role_id)
	{
        $select = $this->DB->select();
        $select->from(array('r' => 'bsc_role_menu_permission'),array('menu_id'));
        $select->where('r.role_id= ?', $role_id);
        $result = $this->DB->fetchAssoc($select);
        return $result;
	}
    public function get_user_permission($user_id)
    {
        $select = $this->DB->select();
        $select->from(array('r' => 'bsc_user_menu_permission'),array('menu_id','user_permission_id'));
        $select->where('r.user_id= ?', $user_id);
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }
    public function get_menus()
    {
        $select = $this->DB->select();
        $select->from(array('m' => 'bsc_menu'),array('menu_id','menu_name','p_menu_id'));
        $select->where('m.status= ?', 'A');
        $select->order(array('p_menu_id ASC','ordr ASC'));
        $result = $this->DB->fetchAssoc($select);
        return $result;
    }

    public function delete_user_permission($user_id)
    {
        $this->DB->delete('bsc_user_menu_permission', array("user_id=$user_id"));
    }

    public function set_user_permission($arra,$user_id)
    {
		//
        if($arra!="")
		{
			//print"<pre>"; print_r($arra); print"</pre>"; exit;
			$query_pre="insert into bsc_user_menu_permission (menu_id,user_id) VALUES ";
			$date_ins=array();
			foreach ($arra as $k=>$v)
			{
				$date_ins[]="(".$v.",".$user_id.")";
			}
			$query=$query_pre.implode(',',$date_ins);			
			$this->DB->query($query);
		}
		
		//$this->DB->insert('bsc_user_menu_permission',$arra);
    }
}
?>