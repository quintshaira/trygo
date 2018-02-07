<?php
class DownloadController extends Zend_Controller_Action
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


        //-----------------------------------------------authenticate logged in user---------------------------------------------//
        Zend_Loader::loadClass('LoginAuth');
        $this->sessionAuth = new LoginAuth();
        $this->sessionAuth->login_user_check();
        $this->sessionAuth->cookie_check();
        //-----------------------------------------------authenticate logged in user---------------------------------------------//

        //______________________________________must add in all Controller class constructor _____________________________________//
        require $_SERVER['DOCUMENT_ROOT'].'/library/fpdf/fpdf.php';
        require $_SERVER['DOCUMENT_ROOT'].'/library/PHPExcel/PHPExcel.php';
        require $_SERVER['DOCUMENT_ROOT'].'/library/PHPExcel/PHPExcel/IOFactory.php';
    }


    public function indexAction()
    {
        //action body
        //print "aa";exit;
        //$this->_redirect('/Credit/purchaseshistory');
    }

    public function listexporttoexcelallAction()
    {
        //print "<pre>"; print_r($_SESSION['bsc_session']['export_list']); print "</pre>";exit;
        //print "<pre>"; print_r($_POST); print "</pre>";exit;
        //$_POST['export_id']=1;
        Zend_Loader::loadClass('Downloadexcel');
        Zend_Loader::loadClass('Dashbord');
        Zend_Loader::loadClass('Customer');
        $ob_Downloadexcel = new Downloadexcel();

        $export_id = trim($this->_request->getParam('export_id', ""));
        $tab_id = trim($this->_request->getParam('tab_id', ""));
        $user_id = trim($this->_request->getParam('user_id', ""));

        $arr_export_settings = $ob_Downloadexcel->get_header_params($export_id);

        $company_id=$_SESSION['tranzgo_session']['company_id'];
        $TD_arr['sd']=$TD_arr['ed']=OCD;
        //$TD_arr['sd']=$TD_arr['ed']="2017-02-07";

        $ob_Dashbord = new Dashbord();

        if ($tab_id==1) {
            $TD_arr['sd']=$TD_arr['ed']=OCD;
        } elseif ($tab_id==2) {
            $TD_arr['sd']=date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
            //print $TD_arr['ed']=date('Y-m-d',mktime(0,0,0,date('m'),date('t'),date('Y'))); exit;
            $TD_arr['ed']=OCD;
        } elseif ($tab_id==3) {
            $TD_arr['sd']=date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));
            $TD_arr['ed']=OCD;
        }

        if ($export_id==1) {
            if ($tab_id==1) {
                $rows=$ob_Dashbord->get_for_assignment_rows_today($company_id, $TD_arr);
            } else {
                $rows=$ob_Dashbord->get_for_assignment_rows($company_id, $TD_arr);
            }
        } elseif ($export_id==2) {
            if ($tab_id==1) {
                $rows=$ob_Dashbord->get_for_duepay_rows($company_id, $TD_arr, 1);
            } else {
                $rows=$ob_Dashbord->get_for_duepay_rows($company_id, $TD_arr, 0);
            }
        } elseif ($export_id==3) {
            if ($tab_id==1) {
                $rows=$ob_Dashbord->get_for_remitted_rows($company_id, $TD_arr, 1);
            } else {
                $rows=$ob_Dashbord->get_for_remitted_rows($company_id, $TD_arr, 0);
            }
        } elseif ($export_id==4) {
            $rows=$ob_Dashbord->get_user_driver_requests_status_change_logs($user_id);
        } elseif ($export_id==5) {
            $ob_Customer = new Customer();

            $arr_limit = array();
            $arr_limit['limit'] = 0;
            $arr_limit['page'] = 0;

            $arr_order = array();
            $arr_order['col'] ='add_date';
            $arr_order['typ'] ='DESC';

            $rows = $ob_Customer->get_customer_list_rows($company_id, '', $arr_limit, $arr_order);
        }

        $objPHPExcel = new PHPExcel();

        $CELL_ARRAY = $objPHPExcel->num_of_column(count($arr_export_settings['header']['colmn'])+5);
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $objPHPExcel->setActiveSheetIndex(0);
        foreach ($CELL_ARRAY as $k => $v) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($v)->setWidth($arr_export_settings['header']['Width'][$k]);
        }

        $row_counter = 1;
        foreach ($arr_export_settings['header']['title'] as $k => $v) {
            $objPHPExcel->getActiveSheet()->setCellValue("$CELL_ARRAY[$k]" . "$row_counter", $v);
            $objPHPExcel->getActiveSheet()->getStyle("$CELL_ARRAY[$k]" . "$row_counter")->getFont()->setBold(true);
        }
        $row_counter++;

        foreach ($rows as $k => $v) {
            $objPHPExcel->getActiveSheet()->setCellValue("$CELL_ARRAY[0]" . "$row_counter", $row_counter-1);
            foreach ($arr_export_settings['header']['colmn'] as $k1 => $v1) {
                $v[$v1]=str_replace('|SN|', $row_counter-1, $v[$v1]);
                $objPHPExcel->getActiveSheet()->setCellValue("$CELL_ARRAY[$k1]" . "$row_counter", $v[$v1]);
            }
            $row_counter++;
        }

        $objPHPExcel->getActiveSheet()->setTitle($arr_export_settings['fname']);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $arr_export_settings['fname'] . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        exit;
        //print "<pre>"; print_r($arr_export_settings); print "</pre>"; exit;

        $arr_export_data_set = array();
        if ($export_id == 1 || $export_id == 3) {
            $arr_export_data_set=$ob_excelexport->get_all_cases($quick_search, $arr_order, $MQ_id, $export_id);
        } elseif ($export_id == 2) {
            $arr_export_data_set=$ob_excelexport->get_all_MQ_record($quick_search, $arr_order, $MQ_id);
        }

        //exit;
        $objPHPExcel = new PHPExcel();

        $CELL_ARRAY = $objPHPExcel->num_of_column(count($arr_export_settings['header']['colmn']));
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        //$objPHPExcel->createSheet();

        $objPHPExcel->setActiveSheetIndex(0);
        foreach ($CELL_ARRAY as $k => $v) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($v)->setWidth($arr_export_settings['header']['Width'][$k]);
        }

        $row_counter = 1;
        foreach ($arr_export_settings['header']['title'] as $k => $v) {
            $objPHPExcel->getActiveSheet()->setCellValue("$CELL_ARRAY[$k]" . "$row_counter", $v);
            $objPHPExcel->getActiveSheet()->getStyle("$CELL_ARRAY[$k]" . "$row_counter")->getFont()->setBold(true);
        }
        $row_counter++;

        foreach ($arr_export_data_set as $k => $v) {
            //print "<br>";
            foreach ($arr_export_settings['header']['colmn'] as $k1 => $v1) {
                //print $v[$v1];print " ; ";

                $v[$v1]=str_replace('|SN|', $row_counter-1, $v[$v1]);
                $v[$v1]=str_replace('|RC|', $row_counter, $v[$v1]);
                $objPHPExcel->getActiveSheet()->setCellValue("$CELL_ARRAY[$k1]" . "$row_counter", $v[$v1]);
            }
            $row_counter++;
        }
        //exit;
        $objPHPExcel->getActiveSheet()->setTitle($arr_export_settings['fname']);

        $objPHPExcel->setActiveSheetIndex(0);
        //$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);  // Needs to be set to true in order to enable any worksheet protection!
        //$objPHPExcel->getActiveSheet()->protectCells("A1:C$row_counter", $sheet_pass);
        //exit;

        if ($export_id == 1 || $export_id == 3) {
            $objPHPExcel->getActiveSheet()->freezePane('A2');
        } elseif ($export_id == 2) {
            $last_row=($row_counter-1);
            $currencyFormat = '_($* #,##0.00_);_($* (#,##0.00);_($* "-"??_);_(@_)';
            $currencyFormat = '_($* #,##0.00_);_($* (#,##0.00);_( "-"??_);_(@_)';
            //$textFormat='@';//'General','0.00','@'
            $objPHPExcel->getActiveSheet()->getStyle("G2:G".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);
            $objPHPExcel->getActiveSheet()->getStyle("H2:H".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);
            $objPHPExcel->getActiveSheet()->getStyle("J2:J".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);
            $objPHPExcel->getActiveSheet()->getStyle("L2:L".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);

            $objPHPExcel->getActiveSheet()->getStyle("V2:V".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);
            $objPHPExcel->getActiveSheet()->getStyle("W2:W".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);
            $objPHPExcel->getActiveSheet()->getStyle("Y2:Y".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);
            $objPHPExcel->getActiveSheet()->getStyle("AA2:AA".$last_row)->getNumberFormat()->setFormatCode($currencyFormat);

            //$objPHPExcel->getActiveSheet()->getStyle('C1')->getNumberFormat()->setFormatCode($textFormat);

            $objPHPExcel->getActiveSheet()->getStyle("I2:I".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
            $objPHPExcel->getActiveSheet()->getStyle("K2:K".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);

            $objPHPExcel->getActiveSheet()->getStyle("X2:X".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
            $objPHPExcel->getActiveSheet()->getStyle("Z2:Z".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);

            $objPHPExcel->getActiveSheet()->freezePane('C2');
        }


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $arr_export_settings['fname'] . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        /*
                foreach ($CELL_ARRAY as $k => $v) {
                    //$objPHPExcel->getActiveSheet()->getColumnDimension($v)->setWidth($header_width[$k]);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($v)->setWidth($excel_export_settings['width'][$k]);
                    //print '$objPHPExcel->getActiveSheet()->getColumnDimension('.$v.')->setWidth('.$excel_export_settings['width'][$k].')';

                }
        */

        //print "<pre>"; print_r($CELL_ARRAY); print "</pre>";exit;
        exit;
    }

    public function listexporttoexcelAction()
    {
        //print "<pre>"; print_r($_SESSION['bsc_session']['export_list']); print "</pre>";exit;

        $export_id = trim($this->_request->getParam('export_id', ""));
        $excel_export_settings=$this->sessionAuth->get_excel_export_data($export_id);
        //print "<pre>"; print_r($excel_export_settings); print "</pre>";exit;




        $arr_data = $_SESSION['bsc_session']['export_list'];
        //print "<pre>"; print_r($arr_data); print "</pre>";exit;
        $fname = $excel_export_settings['menu_name'];


        $request = $this->_request;
        $mq_id = trim($request->getParam('mq'));

        if ($export_id == 27 && $mq_id == '') {
            $arr_data['values'] = '';
        }

        if ($export_id == 27 && $mq_id != '') {
            // Download Measurement Quarter Details

            Zend_Loader::loadClass('Downloadexcel');
            $download_obj = new Downloadexcel();

            $about_quarter = $download_obj->aboutQuarter($mq_id);
            $fname = 'Q' . $about_quarter['quarter'] . ' ' .$about_quarter['year'] . ' ' . date('d_m_Y_H_i_s');

            $representatives_data = $download_obj->getMQAgentsByMQId($mq_id);

            $i = 1;

            $display_array = array();

            if ($representatives_data) {
                foreach ($representatives_data as $k => $v) {
                    $display_array[$i] = array(
                        $i,
                        $v['preffered_name'],
                        $v['rnf_number'],
                        $v['agent_code'],
                        $v['agent_designation_name'],
                        $v['grade'],
                        number_format($v['total_variable_income'], 2),
                        number_format($v['total_specified_variable_income'], 2),
                        round($v['agent_grade_in_percentile']) . '%',
                        number_format($v['agent_specified_variable_income_by_grade'], 2)
                    );

                    $i++;
                }
            }

            $t2t3supervisors_data = $download_obj->getMQT2T3SupervisorsByMQId($mq_id);

            if ($t2t3supervisors_data) {
                foreach ($t2t3supervisors_data as $k => $v) {
                    $display_array[$i] = array(
                        $i,
                        $v['agent_name'],
                        $v['agent_rnf'],
                        $v['acode'],
                        $v['agent_desig'],
                        $v['agrade'],
                        number_format($v['total_vi_of_all'], 2),
                        number_format($v['total_or_svi_of_all'], 2),
                        round($v['agrade_perc']) . '%',
                        number_format($v['svi'], 2)
                    );

                    $i++;
                }
            }


            $arr_data['header'] = array(
                'Row',
                'Name of Representative',
                'MAS RNF Number',
                'LegacyFA Code',
                'Title',
                'Awarded BSC Grade',
                'Variable Income',
                'Specified Variable Income',
                'Percent Entitled',
                'Amount of SVI'
            );

            //$header_width = array('8','30','20','15','20','20','18','25','20','15');

            $arr_data['values'] = $display_array;
        }  //if ($mq_id) {

        if ($export_id == 19) {
            // Download Customer details
            Zend_Loader::loadClass('Downloadexcel');
            $download_obj = new Downloadexcel();

            $about_quarter = $download_obj->aboutQuarter($mq_id);
            $fname = 'Q' . $about_quarter['quarter'] . ' ' .$about_quarter['year'] . ' ' . date('d_m_Y_H_i_s');

            $representatives_data = $download_obj->getMQAgentsByMQId($mq_id);

            $i = 1;

            $display_array = array();

            if ($representatives_data) {
                foreach ($representatives_data as $k => $v) {
                    $display_array[$i] = array(
                        $i,
                        $v['preffered_name'],
                        $v['rnf_number'],
                        $v['agent_code'],
                        $v['agent_designation_name'],
                        $v['grade'],
                        number_format($v['total_variable_income'], 2),
                        number_format($v['total_specified_variable_income'], 2),
                        round($v['agent_grade_in_percentile']) . '%',
                        number_format($v['agent_specified_variable_income_by_grade'], 2)
                    );

                    $i++;
                }
            }

            $t2t3supervisors_data = $download_obj->getMQT2T3SupervisorsByMQId($mq_id);

            if ($t2t3supervisors_data) {
                foreach ($t2t3supervisors_data as $k => $v) {
                    $display_array[$i] = array(
                        $i,
                        $v['agent_name'],
                        $v['agent_rnf'],
                        $v['acode'],
                        $v['agent_desig'],
                        $v['agrade'],
                        number_format($v['total_vi_of_all'], 2),
                        number_format($v['total_or_svi_of_all'], 2),
                        round($v['agrade_perc']) . '%',
                        number_format($v['svi'], 2)
                    );

                    $i++;
                }
            }


            $arr_data['header'] = array(
                'Row',
                'Name of Representative',
                'MAS RNF Number',
                'LegacyFA Code',
                'Title',
                'Awarded BSC Grade',
                'Variable Income',
                'Specified Variable Income',
                'Percent Entitled',
                'Amount of SVI'
            );

            //$header_width = array('8','30','20','15','20','20','18','25','20','15');

            $arr_data['values'] = $display_array;
        }  //if ($mq_id) {




        if (!empty($arr_data['values'])) {
            $objPHPExcel = new PHPExcel();

            $CELL_ARRAY = $objPHPExcel->num_of_column(count($arr_data['header']));
            $styleThinBlackBorderOutline = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
            );
            //$objPHPExcel->createSheet();


            $objPHPExcel->setActiveSheetIndex(0);

            foreach ($CELL_ARRAY as $k => $v) {
                //$objPHPExcel->getActiveSheet()->getColumnDimension($v)->setWidth($header_width[$k]);
                $objPHPExcel->getActiveSheet()->getColumnDimension($v)->setWidth($excel_export_settings['width'][$k]);
                //print '$objPHPExcel->getActiveSheet()->getColumnDimension('.$v.')->setWidth('.$excel_export_settings['width'][$k].')';
            }

            $row_counter = 1;
            foreach ($arr_data['header'] as $k => $v) {
                $objPHPExcel->getActiveSheet()->setCellValue("$CELL_ARRAY[$k]" . "$row_counter", $v);
                $objPHPExcel->getActiveSheet()->getStyle("$CELL_ARRAY[$k]" . "$row_counter")->getFont()->setBold(true);
            }


            $row_counter = 2;
            foreach ($arr_data['values'] as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    $objPHPExcel->getActiveSheet()->setCellValue("$CELL_ARRAY[$k1]" . "$row_counter", $v1);
                }
                $row_counter++;
            }

            $objPHPExcel->getActiveSheet()->setTitle($excel_export_settings['menu_name']);

            $objPHPExcel->setActiveSheetIndex(0);
            //$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);  // Needs to be set to true in order to enable any worksheet protection!
            //$objPHPExcel->getActiveSheet()->protectCells("A1:C$row_counter", $sheet_pass);
            //exit;


            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fname . '.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } // if(!empty($arr_data['values'])) {

        exit;
    }

    public function purchasereceiptAction()
    {
        $credit_purchase_id = trim($this->_request->getParam('credit_purchase_id', ""));

        $ob_Credit    = new Credit();
        $purchase_detail=$ob_Credit->get_purchase_detail($credit_purchase_id);
        //print "<pre>"; print_r($purchase_detail); print "</pre>"; exit;

        $border=1;
        $no_border=0;
        $blank_h='10';
        $blank_t='';

        $margin_L=30;
        $margin_T=80;
        $margin_R=20;
        $margin_B=20;
        $pdf = new FPDF('P', 'pt', 'A4');
        $pdf->SetMargins($margin_L, $margin_T, $margin_R);
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(270, 40, 'LOGO', $border, 0, 'C');
        $pdf->Cell(270, 40, 'DATE', $border, 1, 'C');
        foreach ($purchase_detail as $k=>$v) {
            $pdf->Cell(270, 20, $k, $border, 0, 'C');
            $pdf->Cell(270, 20, $v, $border, 1, 'C');
        }
        $pdf->Output("purchase_receipt_$credit_purchase_id.pdf", 'D');
        exit;
    }
}
