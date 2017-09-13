<?php
/**
 * @author Eman Daryl Ycot
 * @copyright 2010
 */
class Customer extends Zend_Db_Table{

    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');

    }

    public function add_customer($add)
    {
        $this->DB->insert('tranzgo_customers',$add);
        return $this->DB->lastInsertId();
    }



    public function get_customer_list_rows($comp_id,$quick_search,$arr_limit,$arr_order)
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_customers'), array('tc.*'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tc.added_by',array('added_by_name'=>new Zend_Db_Expr("CONCAT(tu.user_fname,' ',tu.user_lname)")));
        $select->joinleft(array('tco'=>'tranzgo_company'),'tc.company_id=tco.company_id',array('tco.company_name'));

        $select->where('tc.is_delete=?',0);
        if($comp_id)
        {
            $select->where('tu.company_id=?',$comp_id);
        }

        if($quick_search)
        {

            $select->where("
            tc.customer_name like '%$quick_search%' or
            tc.contact_number like '%$quick_search%'");
        }

        $select->order('tc.'.$arr_order['col'].' '.$arr_order['typ']);
        if($arr_limit['limit'])
        {
            $select->limitPage($arr_limit['page'], $arr_limit['limit']);
        }

        //print $select; exit;
        return $this->DB->fetchAssoc($select);

    }

    public function get_customer_list_rows_count($comp_id,$quick_search)
    {
        $select =   $this->DB->select();
        $select->from(array('tc'=>'tranzgo_customers'), array('num'=>'count(tc.customer_id)'));
        $select->joinleft(array('tu'=>'tranzgo_user'),'tu.user_id=tc.added_by',array());
        $select->where('tc.is_delete=?',0);
        if($comp_id)
        {
            $select->where('tu.company_id=?',$comp_id);
        }
        if($quick_search)
        {
            $select->where("
            tc.customer_name like '%$quick_search%' or
            tc.contact_number like '%$quick_search%'");
        }
        //echo $select;exit;
        $ret=$this->DB->fetchrow($select);
        return $ret['num'];
    }









    public function get_customer_detail_from_idd($idd)
    {
        $select = $this->DB->select();
        $select->from(array('tc'=>'tranzgo_customers'), array('*'));
        $select->where('tc.customer_id= ?', $idd);
        $result = $this->DB->fetchRow($select);
        return $result;
    }




    public function delete_customer($idd)
    {
        $this->DB->update('tranzgo_customers',array("is_delete"=>1), array("customer_id=$idd"));
    }

    public function update_customer($update,$idd)
    {
        $this->DB->update('tranzgo_customers',$update,array("customer_id=$idd"));
        return true;
    }



    public function check_duplicate_customer($cust_no,$idd)
    {
        $select =   $this->DB->select();
        $select->from(array('tranzgo_customers'),array('cnt'=>'COUNT(customer_id)'));
        $select->where('contact_number=?',$cust_no);
        if($idd)
        {
            $select->where('customer_id<>?',$idd);
        }

        //print $select; exit;
        $ret = $this->DB->fetchRow($select);
        return $ret['cnt'];
    }
}

?>