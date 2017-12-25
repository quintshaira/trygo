<?php
class RequestController extends Zend_Controller_Action
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
        if (defined('SITEURL')) {
            $this->site_url = SITEURL;
        }
        if (defined('SITEASSET')) {
            $this->site_asset = SITEASSET;
        }
        $this->view->site_url   = $this->site_url;
        $this->view->site_asset = $this->site_asset;
        Zend_Loader::loadClass('Signup');
        Zend_Loader::loadClass('User');
        Zend_Loader::loadClass('Request');
        Zend_Loader::loadClass('Vehicles');
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
        $this->_redirect('/Request/list');
    }

    /*public function dupemailAction()
    {
        //action body
        $ob_Signup  = new Signup();

        $U_email = trim($this->_request->getParam('U_email',""));
        $idd = trim($this->_request->getParam('idd',""));
        print $ob_Signup->CheckDuplicateEmail($U_email,$idd);
        exit;
    }*/

    public function listAction()
    {

        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Request    = new Request();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];
        $this->sessionAuth->menu_permission('List_Request');
        $this->view->TRANZGO_STR=$this->sessionAuth->get_breadcrumb('List_Request');
        $del_id=trim($this->_request->getParam('del_id', 0));
        if ($del_id) {
            $this->sessionAuth->menu_permission('Delete_Request');
            $ob_Request->delete_request($del_id);
            $this->sessionAuth->msg_centre('Request deleted successfully');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();
            $this->_redirect('/Request/list');
        }

        //$ob_User = new Signup();
        $comp_id = $ses_role!=1? $company_id : 0;

        $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search', ''));
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row', LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page', 1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'requested_date'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'DESC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;

        $ses_user1 = ($ses_role==4 || $ses_role==5) ? $ses_user : 0;
        if ($ses_role==4) {
            $request_status = [2,3];
        } else {
            $request_status = [1,2,3];
        }

        $requestdetails = $this->view->request_rows=$ob_Request->get_request_list_rows($comp_id, $request_status, $ses_user1, $quick_search, $arr_limit, $arr_order);
        //echo '<pre>'; print_r($requestdetails); exit;

        $row_count=$ob_Request->get_request_list_rows_count($comp_id, $request_status, $ses_user1, $quick_search);

        $arr_rows=array('request_id','rent_from','rent_to','vehicle_id','request_status_id','driver_task_id','assigned_driver_1_id','assigned_driver_2_id','customer_name');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows, $arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count, $page, $num_row);
        //print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function listwfaAction()
    {
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Request    = new Request();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];


        $this->sessionAuth->menu_permission('List_Request_WFA');

        $this->view->TRANZGO_STR=$this->sessionAuth->get_breadcrumb('List_Request_WFA');

        $del_id=trim($this->_request->getParam('del_id', 0));

        if ($del_id) {
            $this->sessionAuth->menu_permission('Delete_Request_WFA');
            $ob_Request->delete_request($del_id);
            $this->sessionAuth->msg_centre('Request deleted successfully');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();

            $this->_redirect('/Request/listwfa');
        }
        $ob_User = new Signup();
        if ($ses_role!=1) {
            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];
        } else {
            $comp_id = 0;
        }

        $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search', ''));
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row', LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page', 1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'requested_date'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'DESC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;



        $ses_user1 = ($ses_role==4 || $ses_role==5) ? $ses_user : 0;



        $request_status = [1];

        $requestdetails = $this->view->request_rows=$ob_Request->get_request_list_rows($comp_id, $request_status, $ses_user1, $quick_search, $arr_limit, $arr_order);

        //echo '<pre>'; print_r($this->view->request_rows); exit;

        $row_count=$ob_Request->get_request_list_rows_count($comp_id, $request_status, $ses_user1, $quick_search);

        $arr_rows=array('request_id','rent_from','rent_to','vehicle_id','request_status_id','driver_task_id','assigned_driver_1_id','assigned_driver_2_id','customer_name');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows, $arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count, $page, $num_row);
        //print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }




    public function manageAction()
    {

        //print "<pre>"; print_r($_POST); print "</pre>";exit;


        $ob_User    = new Signup();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];
        $idd=   trim($this->_request->getParam('idd', ''));
        $iddDash=   trim($this->_request->getParam('iddDash', ''));
        $this->view->page= $page=   trim($this->_request->getParam('page', ''));
        $this->view->rentid = $rentid=   trim($this->_request->getParam('rentid', ''));
        $this->view->no_of_days = 0;
        $this->view->from = '';
        $this->view->to = '';


        $from=   trim($this->_request->getParam('f', ''));
        $to=   trim($this->_request->getParam('t', ''));


        $status=   trim($this->_request->getParam('status', ''));
        $driverstatus=   trim($this->_request->getParam('driverstatus', ''));

        $ob_Request = new Request();

        $this->view->requestList=$ob_Request->get_request();
        $this->view->driverTaskList=$ob_Request->get_driver_task();
        $this->view->requestRate=$ob_Request->get_request_rate();
        $this->view->paymentMethod=$ob_Request->get_payment_method();


        if ($ses_role!=1) {
            $this->view->assignedVehicleList=$ob_Request->get_assigned_vehicle_by_comp($company_id);
            $this->view->driverList=$ob_Request->get_driver_list_by_comp($company_id);
            $getCompanyBySessId = $ob_User->get_company_by_sess_id($ses_user);

            $this->view->getCompanyBySessId=$getCompanyBySessId;

            $comp_id = $getCompanyBySessId['company_id'];
        } else {
            $comp_id = 0;
            $this->view->assignedVehicleList=$ob_Request->get_assigned_vehicle();
            $this->view->companyList=$ob_User->get_company();
            $this->view->driverList=$ob_Request->get_driver_list();
        }

        if ($rentid) {
            $this->view->packageTypeList=$packageTypes=$ob_Request->get_vehicle_package_types($rentid);
            $this->view->packageList = [];
            if ($this->view->packageTypes) {
                $this->view->packageList=$ob_Request->get_package_type_packages($packageTypes[0]['package_type_id']);
            }
        } else {
            $this->view->packageTypeList=$ob_Request->get_package_type();
            $this->view->packageList=$ob_Request->get_package();
        }

        $this->view->cancel_link = '/Request/'.$page;

        if ($idd) {
            $this->view->request_detail = $ob_Request->get_request_detail_from_idd($idd);
            $this->view->request_images = $ob_Request->get_request_images_from_idd($idd);
            //print "<pre>"; print_r($this->view->request_detail); print "</pre>"; exit;
            //print "<pre>"; print_r(!isset($this->view->request_detail['assigned_driver_1_id'])); print "</pre>"; exit;
        }

        if ($from!=0) {
            $this->view->from = date('Y-m-d H:i:s', $from);
            $fromD = date('Y-m-d', strtotime($this->view->from));
        }
        if ($to!=0) {
            $this->view->to = date('Y-m-d H:i:s', $to);
            $toD = date('Y-m-d', strtotime($this->view->to));

            $datetime1 = new DateTime($fromD);
            $datetime2 = new DateTime($toD);
            $interval = $datetime1->diff($datetime2, true);
            $this->view->no_of_days =  $interval->format('%a');

            $company_id = $ses_role!=1 ? $company_id : 0;
            $ret1 = $ob_Request->check_exist_vehicle($this->view->from, $this->view->to, $company_id, $rental_id);
            if (count($ret1) > 0) {
                $available_vehicles = [];
                foreach ($ret1 as $k=>$v) {
                    $available_vehicles[] = $rental_id = $v['rental_id'];
                }
            }

            $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'add_date'));
            $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'DESC'));


            $arr_order=array();
            $arr_order['col']=$order_col;
            $arr_order['typ']=$order_typ;

            $ob_Vehicle = new Vehicles();
            $this->view->assignedVehicleList = $ret2 = $ob_Vehicle->search_vehicle_advance(
                $company_id,
                0,
                0,
                0,
                $available_vehicles,
                0,
                $arr_order
            );
        }
        if ($iddDash) {
            echo json_encode($ob_Request->get_request_detail_from_idd($iddDash));
            exit;
        }

        if ($status) {
            if (!isset($this->view->request_detail['assigned_driver_1_id']) || !isset($this->view->request_detail['vehicle_id'])) {
                $this->sessionAuth->msg_centre('Driver and vehicle are required before approval.');
                $this->_redirect('/Dashboard');
            }

            $ob_Request->update_request_status($status, $idd);
            $ob_Request->insert_request_status($ses_user, $status, $idd);


            if ($status==2) {
                $status=1;
                $ob_Request->update_driver_status($status, $idd);
                $this->sessionAuth->msg_centre('Request approved successfully');
            } elseif ($status==3) {
                $this->sessionAuth->msg_centre('Request rejected');
            } else {
                $this->sessionAuth->msg_centre('Request updated');
            }

            // Send email to coordinator of the company
            $ob_User = new User();
            $company_id = $_SESSION['tranzgo_session']['company_id'];
            $account_id = '3';
            $coordinators = $ob_User->getUsersByRole($company_id, $account_id);

            foreach ($coordinators as $coordinator) {
                $mail = new Zend_Mail('utf-8');
                $mail->setBodyHtml('Hi!<br>A request has been approved.<br>');
                $mail->setFrom('noreply.tranzgo@gmail.com', 'Tranzgo');
                $mail->addTo($coordinator['email'], $coordinator['user_fname'] . ' ' . $coordinator['user_lname']);
                $mail->setSubject('Tranzgo: Request approved');
                $mail->send();
            }

            $this->_redirect('/Request/details/idd/'.$idd);
            //print "<pre>"; print_r($this->view->request_images); print "</pre>"; exit;
        }

        if ($driverstatus) {

            //print "<pre>"; print_r($driverstatus); print "</pre>"; exit;
            $ob_Request->update_driver_status($driverstatus, $idd);
            $ob_Request->insert_driver_status($ses_user, $driverstatus, $idd);

            $this->sessionAuth->msg_centre('Driver status updated');


            if ($driverstatus==7) {
                echo '<script>alert(\'you have completed this request\'); </script>';
                echo '<script>window.location=\'/Dashboard \' </script>';
                //$this->_redirect('/Dashboard');
            } else {
                $this->_redirect('/Request/details/idd/'.$idd);
            }
        }


        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function submitrequestAction()
    {
        //echo '<pre>';print_r($_POST);exit;
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $idd=   trim($this->_request->getParam('idd', ''));


        if ($idd) {
            $this->sessionAuth->menu_permission('Edit_Request');
            $this->sessionAuth->menu_permission('Edit_Request_WFA');
        } else {
            $this->sessionAuth->menu_permission('Add_Request');
            $this->sessionAuth->menu_permission('Add_Request_WFA');
        }
        $upload_path = 'public/uploads/request/';

        $page=   trim($this->_request->getParam('page', ''));
        $request_status_id      = 1;
        $driver_task_id         = trim($this->_request->getParam('driver_task_id', ''));
        $customer_name          = trim($this->_request->getParam('customer_name', ''));
        $package_id             = trim($this->_request->getParam('package_id', ''));
        $vehicle_id             = trim($this->_request->getParam('rental_id', ''));
        $rate_id                = trim($this->_request->getParam('rate_id', ''));
        $rent_from              = trim($this->_request->getParam('rent_from', ''));
        $rent_to                = trim($this->_request->getParam('rent_to', ''));
        $delivery_address       = trim($this->_request->getParam('delivery_address', ''));
        $assigned_driver_1_id   = trim($this->_request->getParam('assigned_driver_1_id', ''));
        $pickup_address         = trim($this->_request->getParam('pickup_address', ''));
        $assigned_driver_2_id   = trim($this->_request->getParam('assigned_driver_2_id', ''));
        $payment_method_id      = trim($this->_request->getParam('payment_method_id', ''));
        $estimated_price        = trim($this->_request->getParam('estimated_price_num', ''));
        $company_id             = trim($this->_request->getParam('company', ''));
        $cust_id                = trim($this->_request->getParam('cust_id', ''));
        $contact_number         = trim($this->_request->getParam('contact_number', ''));
        $no_of_days             = trim($this->_request->getParam('no_of_days', 0));
        $no_of_passengers       = trim($this->_request->getParam('no_of_passengers', 0));

        if (!$estimated_price) {
            $this->view->error_estimated_price = 'Invalid Estimated Price';
            $error = 1;
        }

        $note                   = trim($this->_request->getParam('note', ''));
        $itinerary              = trim($this->_request->getParam('itinerary', ''));

        $ob_Request = new Request();

        if (!$error) {
            if (!$cust_id) {
                $data_customer = array('customer_name'=>$customer_name,'contact_number'=>$contact_number,'company_id'=>$company_id,'added_by'=>$ses_user,'add_date'=>CD,'mod_date'=>CD);
                $last_cust_id = $ob_Request->add_customer($data_customer);
            } else {
                $last_cust_id = $cust_id;
            }

            if ($idd) {
                $this->view->request_detail = $request_detail = $ob_Request->get_request_detail_from_idd($idd);
                if ($request_detail['request_status_id']==3) {
                    $request_status_id      = 1;
                } else {
                    $request_status_id      = 0;
                }

                // Only allow updating of request details if logged in user is not driver
                if ($ses_role != 4) {
                    $ob_Request->update_request(
                        $request_status_id,
                        $driver_task_id,
                        $last_cust_id,
                        $package_id,
                        $vehicle_id,
                        $rate_id,
                        $rent_from,
                        $no_of_days,
                        $no_of_passengers,
                        $rent_to,
                        $delivery_address,
                        $assigned_driver_1_id,
                        $pickup_address,
                        $assigned_driver_2_id,
                        $payment_method_id,
                        $estimated_price,
                        $company_id,
                        $note,
                        $itinerary,
                        $ses_user,
                        $idd
                    );
                }
                
                $image[] = $_FILES['image'];
                if (array_sum($image[0]['error']) < 16) {
                    $all_images = $ob_Request->get_request_images_from_request_id($idd);
                    foreach ($all_images as $k=>$v) {
                        $this->removeimagesAction($v['request_image_id']);
                        $ob_Request->delete_image($v['request_image_id']);
                    }
                    for ($i=0;$i<4;$i++) {
                        $image_d = explode('.', $image[0]['name'][$i]);
                        $ext = $image_d[1];
                        $image_name = $image_d[0];


                        $image_name = $this->slugifyAction($image_name).'_'.time().'.'.$ext;
                        $image_type = $image[0]['type'][$i];
                        $image_size = $image[0]['size'][$i];

                        if (!$image[0]['error'][$i]) {
                            move_uploaded_file($image[0]['tmp_name'][$i], $upload_path.$image_name);
                            $ob_Request->add_request_images($idd, $image_name, $image_type, $image_size);
                        }
                    }
                }


                $this->sessionAuth->msg_centre('Request updated successfully');
            } else {
                $lastRequestId = $ob_Request->add_request(
                    $request_status_id,
                    $driver_task_id,
                    $last_cust_id,
                    $package_id,
                    $vehicle_id,
                    $rate_id,
                    $rent_from,
                    $no_of_days,
                    $no_of_passengers,
                    $rent_to,
                    $delivery_address,
                    $assigned_driver_1_id,
                    $pickup_address,
                    $assigned_driver_2_id,
                    $payment_method_id,
                    $estimated_price,
                    $company_id,
                    $note,
                    $itinerary,
                    $ses_user
                );
                $request_generated_id =  'CE '.$lastRequestId;
                $ob_Request->add_request_generated_id($request_generated_id, $lastRequestId);

                $image[] = $_FILES['image'];
                if (count($image) > 0) {
                    for ($i=0;$i<4;$i++) {
                        $image_d = explode('.', $image[0]['name'][$i]);
                        $ext = $image_d[1];
                        $image_name = $image_d[0];
                        $image_name = $this->slugifyAction($image_name).'_'.time().'.'.$ext;
                        $image_type = $image[0]['type'][$i];
                        $image_size = $image[0]['size'][$i];
                        if (!$image[0]['error'][$i]) {
                            move_uploaded_file($image[0]['tmp_name'][$i], $upload_path.$image_name);
                            $ob_Request->add_request_images($lastRequestId, $image_name, $image_type, $image_size);
                        }
                    }
                }
                $this->sessionAuth->msg_centre('Request added successfully');
            }
        }
        $this->_redirect('/Request/'.$page);
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
        $idd=   trim($this->_request->getParam('idd', ''));
        $ob_Request = new Request();
        $request_images_from_request_image_id = $ob_Request->get_request_images_from_request_image_id($idd);
        echo json_encode($request_images_from_request_image_id);
        exit;
    }

    public function removeimageAction()
    {
        $idd=   trim($this->_request->getParam('idd', ''));
        $ob_Request = new Request();

        $request_images_from_request_image_id = $ob_Request->get_request_images_from_request_image_id($idd);
        $ob_Request->delete_image($idd);
        chmod('public/uploads/request/'.$request_images_from_request_image_id['image_name'], 0777);

        if (!unlink('public/uploads/request/'.$request_images_from_request_image_id['image_name'])) {
            $array = ['msg'=>'Error deleting File','return'=>false];
        } else {
            $array = ['msg'=>'Deleted..','return'=>true];
        }
        echo json_encode($array);
        exit;
    }

    public function removeimagesAction($idd)
    {
        //$idd=   trim($this->_request->getParam('idd',''));


        $ob_Request = new Request();

        $request_images_from_request_image_id = $ob_Request->get_request_images_from_request_image_id($idd);
        $ob_Request->delete_image($idd);

        chmod('public/uploads/request/'.$request_images_from_request_image_id['image_name'], 0777);

        if (!unlink('public/uploads/request/'.$request_images_from_request_image_id['image_name'])) {
            $array = ['msg'=>'Error deleting File','return'=>false];
        } else {
            $array = ['msg'=>'Deleted..','return'=>true];
        }
    }

    public function getallcustomersAction()
    {
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];
        $ob_Request = new Request();
        if ($ses_role!=1) {
            $all_customers = $ob_Request->get_all_customers($company_id, $ses_user);
        } else {
            $all_customers = $ob_Request->get_all_customers($company_id=false, $ses_user);
        }






        $array1 = [];
        foreach ($all_customers as $k=>$v) {
            $array1[]['name'] = $v['customer_name'].' ( '.$v['contact_number'].' ) ' ;
        }
        echo json_encode($array1);
        exit;
    }

    public function detailsAction()
    {
        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->sessionAuth->menu_permission('Request_Details');
        $ob_Request = new Request();
        $idd=   trim($this->_request->getParam('idd', ''));
        $this->view->idd = $idd;
        $this->view->cancel_link = '/Request/list';
        $all_logs = $ob_Request->driver_status_change_log($idd);
        //echo '<pre>'; print_r($all_logs); exit;
        //echo '<pre>'; print_r($idd); exit;

        //dd($all_logs);
        $undo_available = false;


        if (count($all_logs) > 0) {
            $this->view->all_logs = $all_logs;
        }

        if ($idd) {
            $this->view->request_detail = $request_detail = $ob_Request->get_request_details_by_req_id($idd);
            $this->view->request_images = $ob_Request->get_request_images_from_idd($idd);

            if ($ses_role==4) {
                $this->view->driver_task_id = $driver_task_id = $request_detail['driver_task_id'];
                $this->view->driver_status_id = $driver_status_id = $request_detail['driver_status_id'];


                if ($driver_task_id==1 || $driver_task_id==2) {
                    if ($driver_status_id==1) {
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/2';
                        $name = 'Garage Out';
                    } elseif ($driver_status_id==2) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/3';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/1';
                        $name = 'On Location';
                    } elseif ($driver_status_id==3) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/6';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/2';
                        $name = 'In Garage';
                    } elseif ($driver_status_id==6) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/7';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/3';
                        $name = 'Remitted';
                    }
                } else {

                    # driver task is driver

                    if ($driver_status_id==1) {
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/2';
                        $name = 'Acnowledge as Driver';
                    } elseif ($driver_status_id==2) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/3';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/1';
                        $name = 'Driver In Garage';
                    } elseif ($driver_status_id==3) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/4';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/2';
                        $name = 'Garage Out';
                    } elseif ($driver_status_id==4) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/5';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/3';
                        $name = 'On Location';
                    } elseif ($driver_status_id==5) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/6';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/4';
                        $name = 'Guest on Board';
                    } elseif ($driver_status_id==6) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/7';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/5';
                        $name = 'End of Trip';
                    } elseif ($driver_status_id==7) {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/8';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/6';
                        $name = 'In Garage';
                    } else {
                        $undo_available = true;
                        $link = '/Request/manage/idd/'.$idd.'/driverstatus/9';
                        $bk_link = '/Request/manage/idd/'.$idd.'/driverstatus/7';
                        $name = 'Remitted';
                    }
                }
                $this->view->link = $link;
                $this->view->name = $name;

                if ($undo_available) {
                    $this->view->back_link = $bk_link;
                }

                //$this->view->driver_task_array = $req_array;
            }
        }




        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }

    public function mutideleterequestAction()
    {
        $ob_Request = new Request();
        $del = false;
        foreach ($_POST['del_ids'] as $k=>$v) {
            $del = true;
            $del_id = $v;
            $this->sessionAuth->menu_permission('Delete_Request');
            $ob_Request->delete_request($del_id);
        }

        if ($del) {
            $this->sessionAuth->msg_centre('Request deleted successfully');
        } else {
            $this->sessionAuth->msg_centre('Please select at least one Request');
        }
        //$this->view->server_msg = $this->sessionAuth->msg_centre();
    }


    public function getestimatedcostAction()
    {
        $ob_Request = new Request();
        $rent_from  = trim($this->_request->getParam('rent_from', ''));
        $rent_to    = trim($this->_request->getParam('rent_to', ''));
        $package_id = trim($this->_request->getParam('package_', ''));

        $package_details = $ob_Request->get_package_by_id($package_id);
        $package_price = $package_details['price'];


        $dteStart = new DateTime($rent_from);
        $dteEnd   = new DateTime($rent_to);
        $dteDiff  = $dteStart->diff($dteEnd);

        $dteDiff->format("%y years, %m months, %d days, %h hours, %i mints, %s sec");


        $diffYear       =  $dteDiff->format("%y");
        $diffMonth      =  $dteDiff->format("%m");
        $diffDays       =  $dteDiff->format("%d");
        $diffHours      =  $dteDiff->format("%h");
        $diffMinute     =  $dteDiff->format("%i");
        $diffSeconds    =  $dteDiff->format("%s");



        if ($dteStart > $dteEnd) {
            echo '0';
        } else {
            if ($diffDays > 0) {
                //echo number_format(ceil($diffDays * $package_price), 2, ',', ' ');
                echo ceil($diffDays * $package_price);
            }
            if ($diffDays == 0) {
                $diffDays = 1;
                echo ceil($diffDays * $package_price);
            }
        }



        exit;
    }

    public function checkdatesAction()
    {
        $rent_from  = trim($this->_request->getParam('rent_from', ''));
        $rent_to    = trim($this->_request->getParam('rent_to', ''));

        $dteStart = new DateTime($rent_from);
        $dteEnd   = new DateTime($rent_to);
        $dteDiff  = $dteStart->diff($dteEnd);

        $dteDiff->format("%y years, %m months, %d days, %h hours, %i mints, %s sec");

        //var_dump($dteStart == $dteEnd);
        //var_dump($dteStart > $dteEnd);
        //var_dump($dteStart < $dteEnd);
        if ($dteStart <= $dteEnd) {
            echo '1';
        } else {
            echo '2';
        }



        exit;
    }

    public function checkavailabevehicleAction()
    {
        /*$rent_from  = date('Y-m-d',strtotime(trim($this->_request->getParam('rent_from',''))));
        $rent_to    = date('Y-m-d',strtotime(trim($this->_request->getParam('rent_to',''))));*/

        $rent_from  = trim($this->_request->getParam('rent_from', ''));
        $rent_to    = trim($this->_request->getParam('rent_to', ''));
        $rental_id    = $this->_request->getParam('rental_id', '') ? trim($this->_request->getParam('rental_id', '')):0;
        $ses_role=$_SESSION['tranzgo_session']['account_id'];
        $company_id=$_SESSION['tranzgo_session']['company_id'];
        $company_id  = $ses_role!=1 ? $company_id : 0;

        $ob_Request = new Request();
        echo json_encode($ob_Request->check_exist_vehicle($rent_from, $rent_to, $company_id, $rental_id));
        exit;
    }

    public function checkavailabedrivers1Action()
    {
        $rent_from  = trim($this->_request->getParam('rent_from', ''));
        $rent_to    = trim($this->_request->getParam('rent_to', ''));
        $didd    = $this->_request->getParam('didd', '') ? trim($this->_request->getParam('didd', '')) : 0;
        $ses_role=$_SESSION['tranzgo_session']['account_id'];
        $company_id=$_SESSION['tranzgo_session']['company_id'];
        $company_id  = $ses_role!=1 ? $company_id : 0;
        $ob_Request = new Request();
        $ret2 = $ob_Request->check_exist_drivers1($rent_from, $rent_to, $company_id, $didd);
        echo json_encode($ret2);
        exit;
    }

    public function checkavailabedrivers2Action()
    {
        $rent_from  = trim($this->_request->getParam('rent_from', ''));
        $rent_to    = trim($this->_request->getParam('rent_to', ''));
        $didd    = $this->_request->getParam('didd', '') ? trim($this->_request->getParam('didd', '')) : 0;
        $ses_role=$_SESSION['tranzgo_session']['account_id'];
        $company_id=$_SESSION['tranzgo_session']['company_id'];
        $company_id  = $ses_role!=1 ? $company_id : 0;
        $ob_Request = new Request();
        $ret2 = $ob_Request->check_exist_drivers1($rent_from, $rent_to, $company_id, $didd);
        echo json_encode($ret2);
        exit;
    }

    public function checkvehiclepackagetypesAction()
    {
        $rental_id = $this->_request->getParam('rental_id', '') ? trim($this->_request->getParam('rental_id', '')):0;
        $ob_Request = new Request();
        echo json_encode($ob_Request->get_vehicle_package_types($rental_id));
        exit;
    }

    public function checkpackagetypepackagesAction()
    {
        $package_type_id = $this->_request->getParam('package_type_id', '') ? trim($this->_request->getParam('package_type_id', '')):0;
        $ob_Request = new Request();
        echo json_encode($ob_Request->get_package_type_packages($package_type_id));
        exit;
    }

    public function getcustomeridAction()
    {
        $customer_name  = $this->_request->getParam('customer_name', '') ? trim($this->_request->getParam('customer_name', '')) : '';
        $ob_Request = new Request();
        $fst = explode(' ( ', $customer_name);
        $cust_name = $fst[0];
        $scnd = explode(')', $fst[1]);
        $cust_contact = $scnd[0];

        echo $ret2 = $ob_Request->get_customer_from_name($cust_name, $cust_contact);
        //echo json_encode($ret2);
        exit;
    }

    public function donelistAction()
    {

        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Request    = new Request();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];



        $this->sessionAuth->menu_permission('Done_Request');

        /*$del_id=trim($this->_request->getParam('del_id',0));

        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Request');
            $ob_Request->delete_request($del_id);
            $this->sessionAuth->msg_centre('Request deleted successfully');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();

            $this->_redirect('/Request/list');
        }*/

        //$ob_User = new Signup();
        $comp_id = $ses_role!=1? $company_id : 0;

        $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search', ''));
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row', LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page', 1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'requested_date'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'DESC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;



        $ses_user1 = ($ses_role==4 || $ses_role==5) ? $ses_user : 0;

        if ($ses_role==4) {
            $request_status = [2,3];
        } else {
            $request_status = [1,2,3];
        }

        $done = true;



        $this->view->request_rows=$ob_Request->get_request_list_rows_done_ongoing($comp_id, $request_status, $ses_user1, $quick_search, $arr_limit, $arr_order, $done);
        //echo '<pre>'; print_r($this->view->request_rows); exit;

        $row_count=$ob_Request->get_request_list_rows_done_ongoing_count($comp_id, $request_status, $ses_user1, $quick_search, $done);

        $arr_rows=array('request_id','rent_from','rent_to','vehicle_id','request_status_id','driver_task_id','assigned_driver_1_id','assigned_driver_2_id','customer_name');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows, $arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count, $page, $num_row);
        //print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }


    public function ongoinglistAction()
    {

        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        $ob_Request    = new Request();

        $this->view->ses_user=$ses_user=$_SESSION['tranzgo_session']['user_id'];
        $this->view->ses_role=$ses_role=$_SESSION['tranzgo_session']['account_id'];
        $this->view->company_id=$company_id=$_SESSION['tranzgo_session']['company_id'];



        $this->sessionAuth->menu_permission('Done_Request');

        /*$del_id=trim($this->_request->getParam('del_id',0));

        if($del_id)
        {

            $this->sessionAuth->menu_permission('Delete_Request');
            $ob_Request->delete_request($del_id);
            $this->sessionAuth->msg_centre('Request deleted successfully');
            //$this->view->server_msg = $this->sessionAuth->msg_centre();

            $this->_redirect('/Request/list');
        }*/

        //$ob_User = new Signup();
        $comp_id = $ses_role!=1? $company_id : 0;

        $this->view->quick_search=   $quick_search=   trim($this->_request->getParam('quick_search', ''));
        $this->view->num_row=   $num_row=   trim($this->_request->getParam('num_row', LIMIT));
        $this->view->page=      $page=      trim($this->_request->getParam('page', 1));
        $this->view->order_col= $order_col= trim($this->_request->getParam('order_col', 'requested_date'));
        $this->view->order_typ= $order_typ= trim($this->_request->getParam('order_typ', 'ASC'));
        $arr_limit=array();
        $arr_limit['limit']=$limit=($num_row>0)?$num_row:0;
        $arr_limit['page']=$page;
        $arr_order=array();
        $arr_order['col']=$order_col;
        $arr_order['typ']=$order_typ;



        $ses_user1 = ($ses_role==4 || $ses_role==5) ? $ses_user : 0;

        if ($ses_role==4) {
            $request_status = [2,3];
        } else {
            $request_status = [1,2,3];
        }
        $done = false;



        $this->view->request_rows=$ob_Request->get_request_list_rows_done_ongoing($comp_id, $request_status, $ses_user1, $quick_search, $arr_limit, $arr_order, $done);
        //echo '<pre>'; print_r($this->view->request_rows); exit;

        $row_count=$ob_Request->get_request_list_rows_done_ongoing_count($comp_id, $request_status, $ses_user1, $quick_search, $done);

        $arr_rows=array('request_id','rent_from','rent_to','vehicle_id','request_status_id','driver_task_id','assigned_driver_1_id','assigned_driver_2_id','customer_name');
        $this->view->page_sorting_images=$this->sessionAuth->get_sorting_html($arr_rows, $arr_order);

        $this->view->page_peginetion=$this->sessionAuth->get_peginetion($row_count, $page, $num_row);
        //print "<pre>"; print_r($this->view->page_peginetion); print "</pre>"; exit;
        $layout = $this->_helper->layout();
        $layout->setLayout('frontend/onecolumn');
    }
}
