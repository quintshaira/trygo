<?php
class VehiclesController extends Zend_Controller_Action
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
        Zend_Loader::loadClass('Vehicles');
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
        $this->_redirect('/Vehicles/list');

    }

    public function listAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Vehicles	= new Vehicles();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];


        $this->sessionAuth->menu_permission('List_Vehicles');

        //$this->view->TRANZGO_STR=$this->sessionAuth->get_breadcrumb('List_Rental');

        $del_id=trim($this->_request->getParam('del_id',0));
        $idd=trim($this->_request->getParam('idd',0));
        $status=trim($this->_request->getParam('status',0));

        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Vehicles');
            $ob_Vehicles->delete_rental($del_id);
            $this->sessionAuth->msg_centre('Vehicles deleted successfully');
            $this->view->server_msg = $this->sessionAuth->msg_centre();

            $this->_redirect('/Vehicles/list');
        }
        if($status)
        {
            $ob_Vehicles->update_vehicle_status($idd,$status);
            $this->_redirect('/Vehicles/list');

        }

        $ob_User = new Signup();
        if($ses_role!=1)
        {
            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];

        }else{
            $comp_id = 0;
        }
        //$comp_id = 0;


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



        $this->view->rental_rows=$ob_Vehicles->get_rental_list_rows($comp_id,$quick_search,$arr_limit,$arr_order);

       //echo '<pre>'; print_r($this->view->rental_rows); exit;

        $row_count=$ob_Vehicles->get_rental_list_rows_count($comp_id,$quick_search);

        $arr_rows=array('company_id','assigned_vehicle_name','vehicle_type_id','transmission_id','model','year','rental_status');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
        //print "<pre>"; print_r($this->view->rental_rows); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }




    public function manageAction()
    {
        $ob_Vehicles = new Vehicles();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd',''));

        $ob_Signup = new Signup();
        $ob_Request = new Request();


        $this->view->transmissionList=$ob_Vehicles->get_transmission();
        $this->view->vehicleTypeList=$ob_Vehicles->get_vehicle_type();
        $this->view->vehicle_max_passenger=$ob_Vehicles->get_vehicle_max_passenger();
        $this->view->garage_types=$ob_Vehicles->get_garage_types();

        //$this->view->assignedVehicleList=$ob_Request->get_assigned_vehicle();


        $this->view->companyList=$ob_Signup->get_company();

        $this->view->cancel_link = '/Vehicles/list';


        if($ses_role!=1)
        {
            $getCompanyBySessId = $ob_Signup->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];

        }else{
            $this->view->companyList = $ob_Signup->get_company();
        }



        if($idd)
        {

            $this->view->rental_detail = $ob_Vehicles->get_rental_detail_from_idd($idd);
            $this->view->rental_images = $ob_Vehicles->get_rental_images_from_idd($idd);

           //print "<pre>"; print_r($this->view->rental_detail); print "</pre>"; exit;
        }

        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function submitrequestAction()
    {
        //echo '<pre>';print_r($_POST);exit;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd',''));

        if($idd)
        {
            $this->sessionAuth->menu_permission('Edit_Vehicles');
        }
        else
        {
            $this->sessionAuth->menu_permission('Add_Vehicles');
        }
        $upload_path = 'public/uploads/rental/';



        $company_id             = trim($this->_request->getParam('company_id',''));
        $assigned_vehicle_name  = trim($this->_request->getParam('assigned_vehicle_name',''));
        $vehicle_type_id        = trim($this->_request->getParam('vehicle_type_id',''));
        $max_passenger          = trim($this->_request->getParam('max_passenger',''));
        $transmission_id        = trim($this->_request->getParam('transmission_id',''));
        $make                   = trim($this->_request->getParam('make',''));
        $model                  = trim($this->_request->getParam('model',''));
        $year                   = trim($this->_request->getParam('year',''));
        $color                  = trim($this->_request->getParam('color',''));
        $garage_type_id         = trim($this->_request->getParam('garage_type_id',0));
        $times_rented           = trim($this->_request->getParam('times_rented',''));
        $rental_status          = trim($this->_request->getParam('rental_status',''));


        $ob_Vehicles = new Vehicles();


        if($idd)
        {

            $ob_Vehicles->update_request($company_id,
                $assigned_vehicle_name,
                $vehicle_type_id,
                $max_passenger,
                $transmission_id,
                $make,
                $model,
                $year,
                $color,
                $garage_type_id,
                $times_rented,
                $rental_status,
                $idd
            );
            $image[] = $_FILES['image'];

            if(array_sum($image[0]['error']) < 16)
            {
                $all_images = $ob_Vehicles->get_rental_images_from_request_id($idd);

                foreach($all_images as $k=>$v)
                {
                    $this->removeimagesAction($v['rental_images_id']);
                    $ob_Vehicles->delete_image($v['rental_images_id']);

                }

                for($i=0;$i<4;$i++)
                {
                    $image_d = explode('.',$image[0]['name'][$i]);
                    $ext = $image_d[1];
                    $image_name = $image_d[0];


                    $image_name = $this->slugifyAction($image_name).'_'.time().'.'.$ext;
                    $image_type = $image[0]['type'][$i];
                    $image_size = $image[0]['size'][$i];

                    if(!$image[0]['error'][$i])
                    {
                        move_uploaded_file($image[0]['tmp_name'][$i], $upload_path.$image_name);
                        $ob_Vehicles->add_rental_images($idd,$image_name,$image_type,$image_size);
                    }
                }


            }


            $this->sessionAuth->msg_centre('Vehicle updated successfully');
        }else{


            $lastRequestId = $ob_Vehicles->add_rental($company_id,
                $assigned_vehicle_name,
                $vehicle_type_id,
                $max_passenger,
                $transmission_id,
                $make,
                $model,
                $year,
                $color,
                $garage_type_id,
                $times_rented,
                $rental_status,
                $ses_user
            );


            $image[] = $_FILES['image'];
            if(count($image) > 0)
            {
                for($i=0;$i<4;$i++)
                {
                    $image_d = explode('.',$image[0]['name'][$i]);
                    $ext = $image_d[1];
                    $image_name = $image_d[0];


                    $image_name = $this->slugifyAction($image_name).'_'.time().'.'.$ext;
                    $image_type = $image[0]['type'][$i];
                    $image_size = $image[0]['size'][$i];

                    if(!$image[0]['error'][$i])
                    {
                        move_uploaded_file($image[0]['tmp_name'][$i], $upload_path.$image_name);
                        $ob_Vehicles->add_rental_images($lastRequestId,$image_name,$image_type,$image_size);
                    }
                }
            }


            $this->sessionAuth->msg_centre('Vehicle added successfully');
        }

        $this->_redirect('/Vehicles/list');
        exit;
    }


    public function slugifyAction($text)
    {

        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function viewimageAction()
    {
        $idd=   trim($this->_request->getParam('idd',''));

        $ob_Vehicle = new Vehicles();
        $request = $ob_Vehicle->get_rental_images_from_request_image_id($idd);
        echo json_encode($request);
        exit;
    }

    public function removeimageAction()
    {

        $idd=   trim($this->_request->getParam('rental_images_id',''));
        $ob_Vehicle = new Vehicles();

        $request_images_from_request_image_id = $ob_Vehicle->get_rental_images_from_request_image_id($idd);
        $ob_Vehicle->delete_image($idd);
        chmod('public/uploads/rental/'.$request_images_from_request_image_id['image_name'], 0777);

        if (!unlink('public/uploads/rental/'.$request_images_from_request_image_id['image_name']))
        {
            $array = ['msg'=>'Error deleting File','return'=>false];

        }
        else
        {
            $array = ['msg'=>'Deleted..','return'=>true];
        }
        echo json_encode($array);
        exit;
    }

    public function removeimagesAction($idd)
    {

        $ob_Vehicles = new Vehicles();

        $rental_images_from_request_image_id = $ob_Vehicles->get_rental_images_from_request_image_id($idd);
        $ob_Vehicles->delete_image($idd);

        chmod('public/uploads/rental/'.$rental_images_from_request_image_id['image_name'], 0777);

        if (!unlink('public/uploads/rental/'.$rental_images_from_request_image_id['image_name']))
        {
            $array = ['msg'=>'Error deleting File','return'=>false];


        }
        else
        {
            $array = ['msg'=>'Deleted..','return'=>true];

        }

    }



    public function detailsAction()
    {
        $this->sessionAuth->menu_permission('Vehicle_Details');
        $ob_Vehicles = new Vehicles();
        $idd=   trim($this->_request->getParam('idd',''));
        $view=   trim($this->_request->getParam('view',''));
        $this->view->idd = $idd;
        $this->view->viewType = $view;
        $this->view->cancel_link = '/Request/list';
        if($idd)
        {

            $this->view->rental_detail = $ob_Vehicles->get_rental_details_by_req_id($idd);
            $this->view->rental_images = $ob_Vehicles->get_rental_images_from_idd($idd);

            $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search',''));
            $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row',LIMIT));
            $this->view->page=      $page=      trim($this->_request->getParam('page',1));
            $this->view->order_col= $order_col= trim($this->_request->getParam('order_col','rent_from'));
            $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ','DESC'));
            $arr_limit=array();
            $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
            $arr_limit['page']=$page;
            $arr_order=array();
            $arr_order['col']=$order_col;
            $arr_order['typ']=$order_typ;



            //$this->view->rental_rows=$ob_Rental->get_rental_list_rows(0,$quick_search,$arr_limit,$arr_order);

            $this->view->rentalSchedules = $ob_Vehicles->get_rental_schedule_from_idd($idd,$quick_search,$arr_limit,$arr_order);

             //echo '<pre>'; print_r($this->view->rentalSchedules); exit;

            //$row_count=$ob_Rental->get_rental_list_rows_count(0,$quick_search);

            $this->view->rentalSchedulesRows = $row_count= $ob_Vehicles->get_rows_rental_schedule_from_idd($idd,$quick_search);

            $arr_rows=array('rent_from','request_status_id','assigned_driver_1_id','delivery_address','request_status_id');
            $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

            $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);

            //print "<pre>"; print_r($this->view->rentalSchedules); print "</pre>"; exit;
        }
        $view=   trim($this->_request->getParam('view',''));

        if($view=='calendar')
        {
            $this->getcalendarAction();
        }

        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function checkplatenoAction()
    {
        //action body
        $ob_Vehicles	= new Vehicles();

        $Plate_no = trim($this->_request->getParam('Plate_no',""));
        $idd = trim($this->_request->getParam('idd',""));
        print $ob_Vehicles->CheckDuplicatePlateno($Plate_no,$idd);
        exit;
    }

    public function calendarAction()
    {
        //$idd=   trim($this->_request->getParam('idd',''));
        //$view=   trim($this->_request->getParam('view',''));

        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
        exit;

        if(isset($_GET['func'])){
            switch($_GET['func']){
                case 'getCalender':

                    $this->detailsAction($_GET['year'],$_GET['month']);
                    //getCalender($_GET['year'],$_GET['month']);
                    break;
                case 'getEvents':
                    getEvents($_GET['date']);
                    break;
                default:
                    break;
            }
        }
        exit;


    }


    public function getcalendarAction()
    {

        $this->view->year = $year=   trim($this->_request->getParam('year',''));

        $this->view->month = $month=   trim($this->_request->getParam('month',''));
        $this->view->dateYear = $dateYear = ($year != '')?$year:date("Y");
        $this->view->dateMonth = $dateMonth = ($month != '')?$month:date("m");
        $this->view->date = $date = $dateYear.'-'.$dateMonth.'-01';
        $this->view->currentMonthFirstDay = $currentMonthFirstDay = date("N",strtotime($date));
        $this->view->totalDaysOfMonth = $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
        $this->view->totalDaysOfMonthDisplay = $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
        $this->view->boxDisplay = $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;

    }




    public function getcalendar1Action()
    {

        $ob_Vehicles = new Vehicles();
        $idd=   trim($this->_request->getParam('idd',''));
        $this->view->idd = $idd;

        $this->view->rentalSchedules = $ob_Vehicles->get_rental_schedule_from_idd($idd,$quick_search='',$arr_limit='',$arr_order='');
        //print_r($this->view->rentalSchedules);



        $this->view->year = $year=   trim($this->_request->getParam('year',''));
        $this->view->month = $month=   trim($this->_request->getParam('month',''));
        $this->view->dateYear = $dateYear = ($year != '')?$year:date("Y");
        $this->view->dateMonth = $dateMonth = ($month != '')?$month:date("m");
        $this->view->date = $date = $dateYear.'-'.$dateMonth.'-01';
        $this->view->currentMonthFirstDay = $currentMonthFirstDay = date("N",strtotime($date));
        $this->view->totalDaysOfMonth = $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
        $this->view->totalDaysOfMonthDisplay = $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
        $this->view->boxDisplay = $boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
        $this->_helper->layout()->disableLayout();
       // $layout = $this->_helper->layout();
        //$layout->setLayout('');

    }


    public function getAllMonthsAction($selected = '')
    {

        $options = '';
        for($i=1;$i<=12;$i++)
        {
            $value = ($i < 10)?'0'.$i:$i;
            $selectedOpt = ($value == $selected)?'selected':'';
            $options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
        }
        return $options;

    }


    public function getYearListAction($selected = '')
    {
        $options = '';
        for($i=2015;$i<=2025;$i++)
        {
            $selectedOpt = ($i == $selected)?'selected':'';
            $options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>';
        }
        return $options;
    }

    public function geteventsAction()
    {
        $ob_Vehicles = new Vehicles();
        $idd=   trim($this->_request->getParam('idd',''));
        $date=   trim($this->_request->getParam('date',''));


        $this->view->idd = $idd;
        $this->view->events = $ob_Vehicles->get_events_by_date($idd,$date);
        echo json_encode($this->view->events);
        exit;
    }



    public function advancesearchAction()
    {
        $this->view->count_print = $no_records = 1;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];




        $ob_Vehicle = new Vehicles();
        $ob_Request = new Request();
        $this->view->vehicle_max_passenger = $ob_Vehicle->get_vehicle_max_passenger();
        $this->view->transmissionList=$ob_Vehicle->get_transmission();
        $this->view->vehicleTypeList=$ob_Vehicle->get_vehicle_type();
        $this->view->rental_rows = 0;

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

        $this->view->rent_from_str = 0;
        $this->view->rent_to_str = 0;
        if($_POST)
        {
            $this->view->max_passenger = $max_passenger=   $this->_request->getParam('max_passenger','') ? trim($this->_request->getParam('max_passenger','')):0;
            $this->view->vehicle_type_id = $vehicle_type_id=   $this->_request->getParam('vehicle_type_id','') ? trim($this->_request->getParam('vehicle_type_id','')):0;
            $this->view->transmission_id = $transmission_id=   $this->_request->getParam('transmission_id','') ? trim($this->_request->getParam('transmission_id','')):0;

            $this->view->rent_from = $rent_from=   $this->_request->getParam('rent_from','') ? trim($this->_request->getParam('rent_from','')):0;
            $this->view->rent_to = $rent_to=   $this->_request->getParam('rent_to','') ? trim($this->_request->getParam('rent_to','')): 0;
            if($rent_from && $rent_to)
            {
                $company_id = $ses_role!=1 ? $company_id : 0;
                $ret1 = $ob_Request->check_exist_vehicle($rent_from,$rent_to,$company_id,$rental_id);
            }
            if(count($ret1) > 0)
            {
                $available_vehicles = [];
                foreach($ret1 as $k=>$v)
                {
                    $available_vehicles[] = $rental_id = $v['rental_id'];

                }
            }




            $this->view->rental_rows = $ret2 = $ob_Vehicle->search_vehicle_advance(
                $company_id,
                $max_passenger,
                $vehicle_type_id,
                $transmission_id,
                $available_vehicles,
                $arr_limit,
                $arr_order);

            $row_count=$ob_Vehicle->get_rental_list_rows_count1($company_id,
                $max_passenger,
                $vehicle_type_id,
                $transmission_id,
                $available_vehicles);
            $arr_rows=array('company_id','assigned_vehicle_name','vehicle_type_id','transmission_id','model','year','rental_status');
            $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);
            $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);

            $this->view->count_print = count($this->view->rental_rows);
            $this->view->count_rows = $row_count ;

            $this->view->rent_from_str = $this->_request->getParam('rent_from','') ? strtotime(trim($this->_request->getParam('rent_from',''))): 0;
            $this->view->rent_to_str = $this->_request->getParam('rent_to','') ? strtotime(trim($this->_request->getParam('rent_to',''))): 0;
        }else{


            $this->view->rental_rows=$ob_Vehicle->search_vehicle_advance( $company_id,
                0,
                0,
                0,
                0,
                $arr_limit,
                $arr_order);

            //echo '<pre>'; print_r($this->view->rental_rows); exit;

            $row_count=$ob_Vehicle->get_rental_list_rows_count1($company_id,
                0,
                0,
                0,
                0);


            $arr_rows=array('company_id','assigned_vehicle_name','vehicle_type_id','transmission_id','model','year','rental_status');
            $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

            $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
            $this->view->count_print = count($this->view->rental_rows);
            $this->view->count_rows = $row_count ;
        }
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

























}

?>