<?php
class RentalController extends Zend_Controller_Action
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
        Zend_Loader::loadClass('Rental');
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
        $this->_redirect('/Rental/list');

    }

    public function listAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Rental	= new Rental();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];


        $this->sessionAuth->menu_permission('List_Rental');

        //$this->view->TRANZGO_STR=$this->sessionAuth->get_breadcrumb('List_Rental');

        $del_id=trim($this->_request->getParam('del_id',0));

        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Rental');
            $ob_Rental->delete_rental($del_id);
            $this->sessionAuth->msg_centre('Rental deleted successfully');
            $this->view->server_msg = $this->sessionAuth->msg_centre();

            $this->_redirect('/Rental/list');
        }
        $act_id=trim($this->_request->getParam('act_id',0));
        $act_type=trim($this->_request->getParam('act_type'));

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



        $this->view->rental_rows=$ob_Rental->get_rental_list_rows(0,$quick_search,$arr_limit,$arr_order);

       // echo '<pre>'; print_r($this->view->rental_rows); exit;

        $row_count=$ob_Rental->get_rental_list_rows_count(0,$quick_search);

        $arr_rows=array('company_id','assigned_vehicle_name','vehicle_type_id','transmission_id','model','year','rental_status');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows,$arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count,$page,$num_row);
        //print "<pre>"; print_r($this->view->rental_rows); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }




    public function manageAction()
    {
        $ob_Rental = new Rental();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd',''));



        $ob_Rental = new Rental();
        $ob_Signup = new Signup();
        $ob_Request = new Request();


        $this->view->transmissionList=$ob_Rental->get_transmission();
        $this->view->vehicleTypeList=$ob_Rental->get_vehicle_type();
        //$this->view->assignedVehicleList=$ob_Request->get_assigned_vehicle();


        $this->view->companyList=$ob_Signup->get_company();

        $this->view->cancel_link = '/Rental/list';



        if($idd)
        {

            $this->view->rental_detail = $ob_Rental->get_rental_detail_from_idd($idd);
            $this->view->rental_images = $ob_Rental->get_rental_images_from_idd($idd);

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
            $this->sessionAuth->menu_permission('Edit_Rental');
        }
        else
        {
            $this->sessionAuth->menu_permission('Add_Rental');
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

        $times_rented           = trim($this->_request->getParam('times_rented',''));
        $rental_status          = trim($this->_request->getParam('rental_status',''));


        $ob_Rental = new Rental();


        if($idd)
        {

            $ob_Rental->update_request($company_id,
                $assigned_vehicle_name,
                $vehicle_type_id,
                $max_passenger,
                $transmission_id,
                $make,
                $model,
                $year,
                $color,
                $times_rented,
                $rental_status,
                $idd
            );
            $image[] = $_FILES['image'];

            if(array_sum($image[0]['error']) < 16)
            {
                $all_images = $ob_Rental->get_rental_images_from_request_id($idd);

                foreach($all_images as $k=>$v)
                {
                    $this->removeimagesAction($v['rental_images_id']);
                    $ob_Rental->delete_image($v['rental_images_id']);

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
                        $ob_Rental->add_rental_images($idd,$image_name,$image_type,$image_size);
                    }
                }


            }


            $this->sessionAuth->msg_centre('Rental updated successfully');
        }else{


            $lastRequestId = $ob_Rental->add_rental($company_id,
                $assigned_vehicle_name,
                $vehicle_type_id,
                $max_passenger,
                $transmission_id,
                $make,
                $model,
                $year,
                $color,
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
                        $ob_Rental->add_rental_images($lastRequestId,$image_name,$image_type,$image_size);
                    }
                }
            }


            $this->sessionAuth->msg_centre('Rental added successfully');
        }

        $this->_redirect('/Rental/list');
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
        $ob_Rental = new Rental();
        $request = $ob_Rental->get_rental_images_from_request_image_id($idd);
        echo json_encode($request);
        exit;
    }

    public function removeimageAction()
    {

        $idd=   trim($this->_request->getParam('idd',''));
        $ob_Rental = new Rental();

        $request_images_from_request_image_id = $ob_Rental->get_rental_images_from_request_image_id($idd);
        $ob_Rental->delete_image($idd);
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

        $ob_Rental = new Rental();

        $rental_images_from_request_image_id = $ob_Rental->get_rental_images_from_request_image_id($idd);
        $ob_Rental->delete_image($idd);

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
        $this->sessionAuth->menu_permission('Request_Details');
        $ob_Rental = new Rental();
        $idd=   trim($this->_request->getParam('idd',''));
        $view=   trim($this->_request->getParam('view',''));
        $this->view->idd = $idd;
        $this->view->viewType = $view;
        $this->view->cancel_link = '/Request/list';
        if($idd)
        {

            $this->view->rental_detail = $ob_Rental->get_rental_details_by_req_id($idd);
            $this->view->rental_images = $ob_Rental->get_rental_images_from_idd($idd);

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

            $this->view->rentalSchedules = $ob_Rental->get_rental_schedule_from_idd($idd,$quick_search,$arr_limit,$arr_order);

             //echo '<pre>'; print_r($this->view->rentalSchedules); exit;

            //$row_count=$ob_Rental->get_rental_list_rows_count(0,$quick_search);

            $this->view->rentalSchedulesRows = $row_count= $ob_Rental->get_rows_rental_schedule_from_idd($idd,$quick_search);

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
        $ob_Rental	= new Rental();

        $Plate_no = trim($this->_request->getParam('Plate_no',""));
        $idd = trim($this->_request->getParam('idd',""));
        print $ob_Rental->CheckDuplicatePlateno($Plate_no,$idd);
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

        $ob_Rental = new Rental();
        $idd=   trim($this->_request->getParam('idd',''));
        $this->view->idd = $idd;

        $this->view->rentalSchedules = $ob_Rental->get_rental_schedule_from_idd($idd,$quick_search='',$arr_limit='',$arr_order='');
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
        $ob_Rental = new Rental();
        $idd=   trim($this->_request->getParam('idd',''));
        $date=   trim($this->_request->getParam('date',''));


        $this->view->idd = $idd;
        $this->view->events = $ob_Rental->get_events_by_date($idd,$date);
        echo json_encode($this->view->events);
        exit;
    }

























}

?>