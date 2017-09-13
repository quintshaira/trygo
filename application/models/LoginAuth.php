<?php
/**
 * @author Eman Daryl Ycot
 * @copyright 2010
 */
class LoginAuth extends Zend_Db_Table{

    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');

    }

    public function get_breadcrumb($menu_p)
    {

        $select =   $this->DB->select();
        $select->from(array('m'=>'tranzgo_menu'),array('tr_p_menu_id','menu_name','menu_page_name'));
        $select->where('menu_permission=?',$menu_p);
        $ret_menu_details = $this->DB->fetchRow($select);
        //print "<pre>"; print_r($ret_menu_details); print "</pre>"; exit;

        $counter=1;
        $arr_bc_menu[$counter]['menu_name']=$ret_menu_details['menu_name'];
        $arr_bc_menu[$counter]['menu_page_name']=$ret_menu_details['menu_page_name'];
        $tr_p_menu_id=$ret_menu_details['tr_p_menu_id'];

        while($tr_p_menu_id)
        {
            $counter++;
            $select =   $this->DB->select();
            $select->from(array('m'=>'tranzgo_menu'),array('tr_p_menu_id','menu_name','menu_page_name'));
            $select->where('menu_id=?',$tr_p_menu_id);
            $ret_menu_details = $this->DB->fetchRow($select);
            $arr_tr_menu[$counter]['menu_name']=$ret_menu_details['menu_name'];
            $arr_tr_menu[$counter]['menu_page_name']=$ret_menu_details['menu_page_name'];
            $tr_p_menu_id=$ret_menu_details['tr_p_menu_id'];

        }

        $select =   $this->DB->select();
        $select->from(array('m'=>'tranzgo_menu'),array('menu_name','menu_page_name'));
        $select->where('menu_id=?',$_SESSION['tranzgo_session']['account_id']);
        $ret_menu_details = $this->DB->fetchRow($select);

        $counter++;
        $arr_tr_menu[$counter]['menu_name']=$ret_menu_details['menu_name'];
        $arr_tr_menu[$counter]['menu_page_name']=$ret_menu_details['menu_page_name'];


        //print "<pre>"; print_r($arr_tr_menu); print "</pre>";
        $arr_tr_menu=array_reverse($arr_tr_menu);
        $tr_str="";
         foreach($arr_tr_menu as $k=>$v)
         {
             $active_class=($k==(count($arr_tr_menu)-1))?' class="active" ':'';
             if($k==(count($arr_tr_menu)-1))
             {
                 $tr_str.='<li class="active" >'.$v['menu_name'].'</li>';
             }
             else
             {
                 $tr_str.='<li'.$active_class.'><a href="'.$v['menu_page_name'].'">'.$v['menu_name'].'</a></li>
             ';
             }

         }
        return $tr_str;
    }
    public function msg_centre($msg="")
    {

        $temp_msg="";
        $tr_session_server_msg = new Zend_Session_Namespace('tranzgo_session_server_msg');
        if($msg)
        {


            $tr_session_server_msg->server_msg=$msg;
        }
        else
        {
            $temp_msg=$tr_session_server_msg->server_msg;
            unset($_SESSION['tranzgo_session_server_msg']);
            return $temp_msg;
        }

    }
    public function cookie_check()
    {
        if((!$_SESSION['tranzgo_session']['user_id']) && ($_COOKIE['tranzgo_coocky_k'] && isset($_COOKIE['tranzgo_coocky_k'])) && ($_COOKIE['tranzgo_coocky_u'] && isset($_COOKIE['tranzgo_coocky_u'])))
        {
            $select =   $this->DB->select();
            $select->from(array('ul'=>'tranzgo_user_login_details'),array('user_id','is_delete','is_active'));
            $select->where('cookie_key=?',$_COOKIE['tranzgo_coocky_k']);
            $select->where('user_key=?',$_COOKIE['tranzgo_coocky_u']);

            $ret_login_detail = $this->DB->fetchRow($select);
            if(($ret_login_detail['user_id']) && (!$ret_login_detail['is_delete']) && ($ret_login_detail['is_active']))
            {
                Signup::set_session($ret_login_detail['user_id']);
                Signup::set_cookie($ret_login_detail['user_id'],1);
            }
        }
    }
    public function login_user_check()
    {
        if(!$_SESSION['tranzgo_session']['user_id'])
        {
            $this->msg_centre('un authenticate access');
            $redirector =Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoSimple('signin','index');
        }
    }
    public function menu_permission($menu)
    {
        if(!$_SESSION['tranzgo_session']['menu_permission'][$menu])
        {
            $this->msg_centre('un authenticate access');
            $redirector =Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoSimple('signin','index');
        }
    }
    public function chk_menu_permission($menu)
    {
        return $_SESSION['tranzgo_session']['menu_permission'][$menu];
    }
    public function id_buffer($uid,$prefix='',$pre_length=5)
    {
        $padded_str=str_pad($uid, $pre_length, '0', STR_PAD_LEFT);
        if($prefix)
        {
            $padded_str=$prefix.$padded_str;
        }
        return $padded_str;
    }

    public function get_uuid()
    {
        $select="select UUID() as uuid";
        $result = $this->DB->fetchRow($select);
        return $result['uuid'];
    }





///////////////////////////////////// Download common functions//////////////////////////////////////

    public function get_excel_export_data($menu_id)
    {
        /*$select =   $this->DB->select();
        $select->from(array('m'=>'bc_menu'),array('menu_name'));
        $select->where('m.menu_id=?',$menu_id);
        $ret_menu_details = $this->DB->fetchRow($select);*/
        $ret_menu_details[1]="Client due payment_TODAY";
        //$menu_name=$ret_menu_details['menu_name'];

        $width[0] = array();
        $width[13] = array(40,30,20,20);
        //$width[13] = array(40,30,20,20);
        //$width[14] = array(30,15,20,20,20,20,20,20);
        //$width[27] = array(8,30,20,15,20,20,18,25,20,15);

        //$width[19] = array(50,30,30,15,15,10,20); // user list

        //$width[14] = array(50,10,15,50,50,10,20); // agent list


        $arr_ret['menu_name'] = (array_key_exists($menu_id,$ret_menu_details)) ? $ret_menu_details[$menu_id] : "DUMMY";
        $arr_ret['width'] = (array_key_exists($menu_id,$width)) ? $width[$menu_id] : $width[0];

        return $arr_ret;
    }

//----------------------------------- Download common functions---------------------------------------

///////////////////////////////////// list page common functions//////////////////////////////////////

    public function set_excel_header($header_val)
    {
        return $_SESSION['tr_session']['export_list']['header'][]=$header_val;
    }
    public function set_excel_values($values_val,$idd)
    {
        return $_SESSION['tr_session']['export_list']['values'][$idd][]=$values_val;
    }

    public function get_peginetion($total_rows,$page,$num_row)
    {
        $show_total_no_of_rows=0;
        $show_paginetion=1;
        $show_page_dds=1;

        $adjacents=1;//constant
		
		$num_row;
		$total_rows;

        $lastpage = ($num_row>=1)?ceil($total_rows/$num_row):0;		//lastpage is = total pages / items per page, rounded up.
        $pagination= "";
        if($show_total_no_of_rows)
        {
            $pagination.= "<div class=\"col4-1 pull-left\" style=\"margin-top: 23px; color:#e17229;\">Number of rows $total_rows</div>";
            //$pagination.= "<div class=\"col4-1 pull-left\" style=\"margin-top: 18px;\">&nbsp;</div>";
        }

        if($show_paginetion)
        {
            /* Setup page vars for display. */
            if ($page == 0) $page = 1;					//if no page var is given, default to 1.
            $prev = $page - 1;							//previous page is page - 1
            $next = $page + 1;							//next page is page + 1
            $lpm1 = $lastpage - 1;						//last page minus 1

            $pagination.= "<div class=\"col4-2\" style=\"text-align:center;\"><nav class=\"pull-left\"><ul class=\"pagination\">";
            if($lastpage > 1)
            {
                //previous button
                if ($page > 1)
                    $pagination.= "<li title='Go to Previous page' ><a href=\"javascript:pagination('$prev');\" 
				aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                else
                    $pagination.= "<li class=\"disabled\" aria-label='Previous'><a><span aria-hidden='true'>&laquo;</span></a></li>";

                //pages
                if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
                {
                    for ($counter = 1; $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<li class=\"active\"><a>$counter</a></li>";
                        else
                            $pagination.= "<li><a href=\"javascript:pagination('$counter');\">$counter</a></li>";
                    }
                }
                elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
                {
                    //close to beginning; only hide later pages
                    if($page < 1 + ($adjacents * 2))
                    {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<li class=\"active\"><a>$counter</a></li>";
                            else
                                $pagination.= "<li><a href=\"javascript:pagination('$counter');\">$counter</a></li>";
                        }
                        $pagination.= "<li><a>...</a></li>";
                        ////$pagination.= "<li><a href=\"javascript:pagination('$lpm1');\">$lpm1</a></li>";
                        $pagination.= "<li><a href=\"javascript:pagination('$lastpage');\">$lastpage</a></li>";
                    }
                    //in middle; hide some front and some back
                    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                    {
                        $pagination.= "<li><a href=\"javascript:pagination('1');\">1</a></li>";
                        ////$pagination.= "<li><a href=\"javascript:pagination('2');\">2</a></li>";
                        $pagination.= "<li><a>...</a></li>";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<li class=\"active\"><a>$counter</a></li>";
                            else
                                $pagination.= "<li><a href=\"javascript:pagination('$counter');\">$counter</a></li>";
                        }
                        $pagination.= "<li><a>...</a></li>";
                        ////$pagination.= "<li><a href=\"javascript:pagination('$lpm1');\">$lpm1</a></li>";
                        $pagination.= "<li><a href=\"javascript:pagination('$lastpage');\">$lastpage</a></li>";
                    }
                    //close to end; only hide early pages
                    else
                    {
                        $pagination.= "<li><a href=\"javascript:pagination('1');\">1</a></li>";
                        ////$pagination.= "<li><a href=\"javascript:pagination('2');\">2</a></li>";
                        $pagination.= "<li><a>...</a></li>";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<li class=\"active\"><a>$counter</a></li>";
                            else
                                $pagination.= "<li><a href=\"javascript:pagination('$counter');\">$counter</a></li>";
                        }
                    }
                }

                //next button
                if ($page < $counter - 1)
                    $pagination.= "<li title='Go to Next page' >
				<a href=\"javascript:pagination('$next');\" aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
                else
                    $pagination.= "<li class=\"disabled\" aria-label='Next'><a><span aria-hidden='true'>&raquo;</span></a></li>";

            }
            $pagination.= "</ul></nav></div>";
        }

        if($show_page_dds)
        {
            $pagination.= " <div class=\"col4-1 pull-right abc\">
                                <div class=\"col3-1 pull-right abc\" style=\"margin-left: 10px;\">
                                    Row per page
                                <select id='pagination_id2' onchange='pagination_num_row(this.value)'>";
            $pagination.= "<option value='A' ";$pagination.= ($num_row=="A")?"selected":"";$pagination.= ">all</option>";
            $pagination.= "<option value='5' ";$pagination.= ($num_row=="5")?"selected":"";$pagination.= ">5</option>";
            $pagination.= "<option value='10' ";$pagination.= ($num_row=="10")?"selected":"";$pagination.= ">10</option>";
            $pagination.= "<option value='20' ";$pagination.= ($num_row=="20")?"selected":"";$pagination.= ">20</option>";
            $pagination.= "<option value='50' ";$pagination.= ($num_row=="50")?"selected":"";$pagination.= ">50</option>";
            $pagination.= "<option value='100' ";$pagination.= ($num_row=="100")?"selected":"";$pagination.= ">100</option>";

            $pagination.= "     </select>";
            $pagination.= " </div>";
            $pagination.= " <div class=\"col3-1 pull-right abc\">";
            $pagination.= "     Go to page";
            $pagination.= "      <select id='pagination_id1' onchange='pagination(this.value)'>";
            for($p=1;$p<=$lastpage;$p++)
            {
                $pagination.= "<option value='$p'";
                if ($p==$page) $pagination.= " selected ";
                $pagination.= ">$p</option>";
            }
            $pagination.="      </select>";
            $pagination.="   </div>";
            //$pagination.=" </div>";
        }


        return $pagination;


        /*
                    $pagination.= "<lable>Go to page</lable><select id='pagination_id1' onchange='pagination(this.value);'>";
                    for($p=1;$p<=$lastpage;$p++)
                    {
                        $pagination.= "<option value='$p'";
                        if ($p==$page) $pagination.= " selected ";
                        $pagination.= ">$p</option>";
                    }
                    $pagination.= "</select>";*/

        /* $pagination.= "<lable>Row per Page</lable><select id='pagination_id2' onchange='cngrow(this.value);' >";
         $pagination.= "<option value='A' ";$pagination.= ($num_row=="A")?"selected":"";$pagination.= ">all</option>";
         $pagination.= "<option value='10' ";$pagination.= ($num_row=="10")?"selected":"";$pagination.= ">10</option>";
         $pagination.= "<option value='20' ";$pagination.= ($num_row=="20")?"selected":"";$pagination.= ">20</option>";
         $pagination.= "<option value='50' ";$pagination.= ($num_row=="50")?"selected":"";$pagination.= ">50</option>";
         $pagination.= "<option value='100' ";$pagination.= ($num_row=="100")?"selected":"";$pagination.= ">100</option>";
         $pagination.= "</select></div></div></div>\n";	*/
    }

    public function get_sorting_html($arr_rows,$arr_order)
    {
        $ret_arr=array();
        //print "<pre>"; print_r($arr_rows); print "</pre>";
        foreach($arr_rows as $v)
        {
            $sstr="";
            $sstr.='<div class="sorting_arow_area arrw_area">';
            if($arr_order['col']==$v)
            {
                if($arr_order['typ']=='ASC')
                {
                    $sstr.="<a href=\"javascript:call_order('$v','DESC');\" title='click to order Descending'><i style='color: red' class=\"fa fa-caret-up\"></i></a>";
                }
                else
                {
                    $sstr.="<a href=\"javascript:call_order('$v','ASC');\" title='click to order Ascending'><i style='color: red' class=\"fa fa-caret-down\"></i></a>";
                }
            }
            else
            {
                $sstr.="<a href=\"javascript:call_order('$v','ASC');\" title='click to order Ascending'><i class=\"fa fa-sort\"></i></a>";
            }
            $sstr.="</div>";
            $ret_arr[$v]=$sstr;
        }
        return $ret_arr;
    }
//----------------------------------- list page common functions---------------------------------------
}

?>