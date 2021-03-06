<?php
set_time_limit(0);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
ob_start();
error_reporting(0);

include("connection.php");

$mq_id = $_GET['mq'];
$client_id = $_GET['client_id'];
$type = $_GET['type']; // rep/sup

if($type == 'rep'){
    $agent_field_name = 'agent_id';
} else {
    $agent_field_name = 'supervisor_id';
}

$sql_query = "select mq.measurement_quarter_on_agent_id, mq.supervisor_grade, mq.supervisor_grade_in_percentile, mq.supervisor_total_vi_of_all_agents, mq.supervisor_total_or_svi_of_all_agents, mq.supervisor_specified_variable_income_by_grade,
mq_ag.sampling_id as rep_sampling_id, mq_ag.grade as rep_grade, mq_ag.agent_grade_in_percentile as rep_percent, mq_ag.agent_specified_variable_income_by_grade as rep_svi_by_grade, mq_ag.total_variable_income as rep_gross_vi, mq_ag.total_specified_variable_income as rep_gross_svi,
a.agent_id, a.preffered_name, a.rnf_number, a.legacy_fa_rep_code, a.sales_code, a.agent_designation_id, a.supervisor, su.preffered_name as supervisor_name,
des.agent_designation_name, bmq.year, bmq.quarter, q.month_range, q.pdf_display

FROM bsc_measurement_quarter_on_agent mq
LEFT JOIN bsc_measurement_quarter_on_agent mq_ag on mq.supervisor_id = mq_ag.agent_id
LEFT JOIN bsc_agent a on mq.$agent_field_name = a.agent_id
LEFT JOIN bsc_agent su on mq.supervisor_id = su.agent_id
LEFT JOIN bsc_agent_designation des on a.agent_designation_id = des.agent_designation_id
LEFT JOIN bsc_measurement_quarter bmq on mq.measurement_quarter_id = bmq.measurement_quarter_id
LEFT JOIN bsc_quarters q on bmq.quarter = q.quarters_id
WHERE mq.measurement_quarter_id=$mq_id AND mq.$agent_field_name=$client_id limit 0,1";

//echo $sql_query; exit;

$result = mysql_fetch_assoc(mysql_query($sql_query));

$sup_grade = $result['supervisor_grade'];
$rep_grade = $result['rep_grade'];

if($result['quarter'] == 1) $display_month_year = "January " . $result['year'] . " - March " . $result['year'];
else if($result['quarter'] == 2) $display_month_year = "April " . $result['year'] . " - June " . $result['year'];
else if($result['quarter'] == 2) $display_month_year = "July " . $result['year'] . " - September " . $result['year'];
else  $display_month_year = "October " . $result['year'] . " - December " . $result['year'];



if($sup_grade != ''){

    $template = '';

    if($rep_grade == '') {

        $template = 'no_infractions';

    } else if($rep_grade == 'A') {
        $sampling_id = $result['rep_sampling_id'];

        $sampling_sql = "SELECT i.sampling_round_infraction_id as sampling_round_infraction_id, i.case_id as case_id, i.infraction as infraction, mi.infraction_name as infraction_name

            FROM bsc_measurement_quarter_sampling_round_infraction i
            LEFT JOIN bsc_mq_infraction mi on mi.mq_infraction_id = i.infraction

            WHERE i.sampling_id = $sampling_id AND i.is_delete=0
            order by i.sampling_round_infraction_id";

        //echo $sampling_sql; //exit;
        $sampling_q = mysql_query($sampling_sql);
        $row_num = mysql_num_rows($sampling_q);

        $infraction_array = array();
        while($sampling_result = mysql_fetch_assoc($sampling_q)){
            $infraction_array[] = $sampling_result['infraction'];
        }

        $infraction_array = array_unique($infraction_array);

        if(in_array(1, $infraction_array) || in_array(2, $infraction_array)){
            $template = 'with_infractions';
        } else if(in_array(3, $infraction_array)) {
            $template = 'area_infractions';
        } else {
            $template = 'no_infractions';
        }

    } else {
        $template = 'with_infractions';
    }


    //echo '<br/><br/>' . $template; exit;



    // PDF Starts

    if( ($result['quarter'] == 1) && ($result['year'] == '2016')){
        $date = '3 June 2016';
    } else {
        $date = date('d F Y');
    }



    if($rep_grade == '') {
        $repre_grade = 'N/A';
        $repre_gross_vi = '';
        $repre_gross_svi = '';
        $repre_percentage = '';
        $repre_amount = '';
    } else {
        $repre_grade = $result['rep_grade'];
        $repre_gross_vi = '$' . number_format($result['rep_gross_vi'], 2);
        $repre_gross_svi = '$' . number_format($result['rep_gross_svi'], 2);
        $repre_percentage = $result['rep_percent'] . '%';
        $repre_amount = '$' . number_format($result['rep_svi_by_grade'], 2);
    }


    $sup_grade = $result['supervisor_grade'];
    $sup_gross_var_income = '$' . number_format($result['supervisor_total_vi_of_all_agents'], 2);
    $sup_gross_spec_var_income = '$' . number_format($result['supervisor_total_or_svi_of_all_agents'], 2);
    $sup_percentage = $result['supervisor_grade_in_percentile'] . '%';
    $sup_amount = '$' . number_format($result['supervisor_specified_variable_income_by_grade'], 2);




    $file_name = $result['preffered_name'] . '_(sup)_' . $result['year'] . '_' . $result['month_range'] . '.pdf';




    require('fpdf/fpdf.php');

    $pdf = new FPDF();

    $no_border = 0;
    $common_width = 170;
    $height = 5;
    $left_margin = $right_margin = 20;
    $top_margin = 20;

    $font_size = 10;

    $logo = "images/logo.png";
    $background = "images/background.png";


    $pdf->SetMargins($left_margin, $top_margin, $right_margin);
    $pdf->SetAutoPageBreak(0, 1);

    $pdf->AddPage();

    $pdf->Image($logo, $left_margin, $top_margin, -300);
    $pdf->Image($background, -30, 185, -300);


    $logo_text_width = 32;
    $logo_text_position = 158;
    $logo_text_line_break_height = 3;


    // logo text block starts; position right
    $pdf->SetTextColor(0, 119, 204);
    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetX($logo_text_position);
    $pdf->Cell($logo_text_width, 5, 'Legacy FA Pte Ltd', $no_border, 0, 'L');
    $pdf->Ln($logo_text_line_break_height);
    $pdf->SetX($logo_text_position);
    $pdf->Cell($logo_text_width, 5, '1 Kay Siang Rd #01-02', $no_border, 0, 'L');
    $pdf->Ln($logo_text_line_break_height);
    $pdf->SetX($logo_text_position);
    $pdf->Cell($logo_text_width, 5, 'Singapore 248922', $no_border, 0, 'L');
    $pdf->Ln($logo_text_line_break_height+1);

    $pdf->SetFont('Arial', '', 6);
    $pdf->SetX($logo_text_position);
    $pdf->Cell($logo_text_width, 5, 'Company Reg No:  201408230R', $no_border, 0, 'L');

    // logo text block ends; position right


    $pdf->Ln(4);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetXY($left_margin, $pdf->GetY());

    $pdf->SetFont('Arial', 'B', $font_size);
    $pdf->Cell($common_width, '10', 'PRIVATE AND CONFIDENTIAL', $no_border, 1, 'L');


    $pdf->SetFont('Arial', '', $font_size);

    $pdf->Cell($common_width, '6', $date, $no_border, 1, 'L');

    $info_top_margin = 45;
    $pdf->Ln(4);


    $pdf->Cell($common_width, $height, "Name of Representative: " . $result['preffered_name'], $no_border, 1, 'L');
    $pdf->Cell($common_width, $height, "MAS RNF Number: " . $result['rnf_number'], $no_border, 1, 'L');
    $pdf->Cell($common_width, $height, "Legacy FA Code: " . $result['legacy_fa_rep_code'], $no_border, 1, 'L');
    $pdf->Cell($common_width, $height, "Title: " . $result['agent_designation_name'], $no_border, 1, 'L');


    // body starts
    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'BU', $font_size);
    $pdf->Cell($common_width, 8, 'BALANCE SCORECARD (BSC) PERFORMANCE RECORD', $no_border, 1, 'L');


    $first_paragraph  = "As you are aware, the BSC framework commenced in " . $result['pdf_display'] . " " . $result['year'] . ". ";
    $first_paragraph .= "The purpose of the BSC framework is to assess the performance and improve the quality of Representatives and Supervisors. Representatives and Supervisors will need to meet key performance indicators that are not related to sales, such as providing suitable product recommendations and making proper disclosure of material information to customers. Failure to do so may affect your variable income. ";
    $first_paragraph .= "You can refer to the Notice  and Guideline  for more information.";

    $pdf->SetFont('Arial', '', $font_size);
    $pdf->MultiCell($common_width, $height, $first_paragraph);

    $getx = $pdf->GetX();
    $gety = $pdf->GetY();

    $pdf->SetFont('Arial', '', 6);
    $pdf->Text($getx+143.25, $gety-8, 1);
    $pdf->Text($getx+167.75, $gety-8, 2);

    $pdf->Cell($common_width, $height, '', $no_border, 1, 'L');


    $pdf->SetFont('Arial', '', $font_size);

    if ($template == 'with_infractions') {

        $second_paragraph1 = "From the random selection of sales transaction(s), below is the assessment of your BSC performance for the period of ";
        $second_paragraph2 = ". Based on our audit findings, infraction(s) were discovered. The infraction(s) listed below are to be rectified with ";
        $second_paragraph3 = "immediate effect";
        $second_paragraph4 = ". You may refer to the following page for the review findings.";

        $third_paragraph1 = "Should you disagree with the assessment, you may submit an appeal with further documentation or evidences in writing through your supervisor within ";
        $third_paragraph2 = "ten (10) working days";
        $third_paragraph3 = " from the date hereof.";



        $pdf->Write($height, $second_paragraph1);

        $pdf->SetFont('Arial', 'U', $font_size);
        $pdf->Write($height, $display_month_year);

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Write($height, $second_paragraph2);

        $pdf->SetFont('Arial', 'U', $font_size);
        $pdf->Write($height, $second_paragraph3);

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Write($height, $second_paragraph4);


        $pdf->Ln(8);
        $pdf->SetLeftMargin($left_margin + 10);
        $pdf->SetFont('Arial', 'U', $font_size);

        $perform_title = "Q" . $result['quarter'] . ' ' . $result['year'] . ' BSC Performance - Representative';
        $pdf->Cell($common_width, 10, $perform_title, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('35', $height, 'Awarded BSC Grade: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('15', $height, $repre_grade, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('38', $height, 'Gross Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('55', $height, $repre_gross_vi, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('53', $height, 'Gross Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $repre_gross_svi, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('84.5', $height, 'Percentage Entitlement to Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('30', $height, $repre_percentage, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('76', $height, 'Amount of Specified Variable Income entitled to: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $repre_amount, $no_border, 1, 'L');





        $pdf->Cell($common_width, $height, '', $no_border, 1, 'L');

        $pdf->SetFont('Arial', 'U', $font_size);

        $perform_title = "Q" . $result['quarter'] . ' ' . $result['year'] . ' BSC Performance - Supervisor';
        $pdf->Cell($common_width, 10, $perform_title, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('35', $height, 'Awarded BSC Grade: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('15', $height, $sup_grade, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('38', $height, 'Gross Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('55', $height, $sup_gross_var_income, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('53', $height, 'Gross Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $sup_gross_spec_var_income, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('84.5', $height, 'Percentage Entitlement to Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('30', $height, $sup_percentage, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('76', $height, 'Amount of Specified Variable Income entitled to: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $sup_amount, $no_border, 1, 'L');




        $pdf->SetLeftMargin($left_margin);
        $pdf->SetFont('Arial', '', $font_size);

        $pdf->Cell($common_width, $height, '', $no_border, 1, 'L');


        $pdf->Write($height, $third_paragraph1);
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Write($height, $third_paragraph2);
        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Write($height, $third_paragraph3);

        $pdf->Ln(10);

    } else if ($template == 'area_infractions') {

        $second_paragraph1 = "From the random selection of sales transaction(s), below is the assessment of your BSC performance for the period of ";
        $second_paragraph2 = ". Based on our audit findings, minor lapses in documentations were noted. The lapses listed below are to be rectified with ";
        $second_paragraph3 = "immediate effect";
        $second_paragraph4 = ". Please note your grading may be affected, if repeated lapses in documentation are surfaced in future BSC Audits. You may refer to the following page for the review findings.";


        $pdf->Write($height, $second_paragraph1);

        $pdf->SetFont('Arial', 'U', $font_size);
        $pdf->Write($height, $display_month_year);

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Write($height, $second_paragraph2);

        $pdf->SetFont('Arial', 'U', $font_size);
        $pdf->Write($height, $second_paragraph3);

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Write($height, $second_paragraph4);


        $pdf->Ln(8);
        $pdf->SetLeftMargin($left_margin + 10);
        $pdf->SetFont('Arial', 'U', $font_size);

        $perform_title = "Q" . $result['quarter'] . ' ' . $result['year'] . ' BSC Performance - Representative';
        $pdf->Cell($common_width, 10, $perform_title, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('35', $height, 'Awarded BSC Grade: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('15', $height, $repre_grade, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('38', $height, 'Gross Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('55', $height, $repre_gross_vi, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('53', $height, 'Gross Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $repre_gross_svi, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('84.5', $height, 'Percentage Entitlement to Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('30', $height, $repre_percentage, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('76', $height, 'Amount of Specified Variable Income entitled to: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $repre_amount, $no_border, 1, 'L');





        $pdf->Cell($common_width, $height, '', $no_border, 1, 'L');

        $pdf->SetFont('Arial', 'U', $font_size);

        $perform_title = "Q" . $result['quarter'] . ' ' . $result['year'] . ' BSC Performance - Supervisor';
        $pdf->Cell($common_width, 10, $perform_title, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('35', $height, 'Awarded BSC Grade: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('15', $height, $sup_grade, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('38', $height, 'Gross Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('55', $height, $sup_gross_var_income, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('53', $height, 'Gross Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $sup_gross_spec_var_income, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('84.5', $height, 'Percentage Entitlement to Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('30', $height, $sup_percentage, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('76', $height, 'Amount of Specified Variable Income entitled to: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $sup_amount, $no_border, 1, 'L');

        $pdf->SetLeftMargin($left_margin);
        $pdf->SetFont('Arial', '', $font_size);

        $pdf->Ln(10);


    } else {

        $second_paragraph1 = "Based on the random selection of sales transaction(s), below is the assessment of your BSC performance for the period of ";
        $second_paragraph2 = ".";

        $pdf->Write($height, $second_paragraph1);

        $pdf->SetFont('Arial', 'U', $font_size);
        $pdf->Write($height, $display_month_year);

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Write($height, $second_paragraph2);


        $pdf->Ln(8);
        $pdf->SetLeftMargin($left_margin + 10);
        $pdf->SetFont('Arial', 'U', $font_size);

        $perform_title = "Q" . $result['quarter'] . ' ' . $result['year'] . ' BSC Performance - Representative';
        $pdf->Cell($common_width, 10, $perform_title, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('35', $height, 'Awarded BSC Grade: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('15', $height, $repre_grade, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('38', $height, 'Gross Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('55', $height, $repre_gross_vi, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('53', $height, 'Gross Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $repre_gross_svi, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('84.5', $height, 'Percentage Entitlement to Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('30', $height, $repre_percentage, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('76', $height, 'Amount of Specified Variable Income entitled to: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $repre_amount, $no_border, 1, 'L');





        $pdf->Cell($common_width, $height, '', $no_border, 1, 'L');

        $pdf->SetFont('Arial', 'U', $font_size);

        $perform_title = "Q" . $result['quarter'] . ' ' . $result['year'] . ' BSC Performance - Supervisor';
        $pdf->Cell($common_width, 10, $perform_title, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('35', $height, 'Awarded BSC Grade: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('15', $height, $sup_grade, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('38', $height, 'Gross Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('55', $height, $sup_gross_var_income, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('53', $height, 'Gross Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $sup_gross_spec_var_income, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('84.5', $height, 'Percentage Entitlement to Specified Variable Income: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', $font_size);
        $pdf->Cell('30', $height, $sup_percentage, $no_border, 1, 'L');

        $pdf->SetFont('Arial', '', $font_size);
        $pdf->Cell('76', $height, 'Amount of Specified Variable Income entitled to: ', $no_border, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell('55', $height, $sup_amount, $no_border, 1, 'L');

        $pdf->SetLeftMargin($left_margin);
        $pdf->SetFont('Arial', '', $font_size);

        $pdf->Ln(10);
    }




    // body ends


    // Thanking part
    $pdf->SetFont('Arial', '', $font_size);
    $pdf->Cell($common_width, $height, 'Yours sincerely', $no_border, 1, 'L');

    $pdf->Cell($common_width, $height+3, '', $no_border, 1, 'L');

    $pdf->Cell($common_width, $height, 'Aiilena Das', $no_border, 1, 'L');
    $pdf->Cell($common_width, $height, 'Director, Risk and Compliance', $no_border, 1, 'L');

    $pdf->Cell($common_width, $height, '', $no_border, 1, 'L');
    $pdf->Cell($common_width, $height, 'cc. '. $result['supervisor_name'], $no_border, 1, 'L');




    //page bottom part / footer

    $pdf->SetY(-15);
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    $pdf->Line($x, $y, $x+37, $y);
    $pdf->Ln(1);
    $pdf->SetFont('Arial', '', 5);

    $footer_text1 = 'FAA-N20 NOTICE ON REQUIREMENTS FOR THE REMUNERATION FRAMEWORK FOR REPRESENTATIVES AND SUPERVISORS ("BALANCED SCORECARD FRAMEWORK") AND INDEPENDENT SALES AUDIT UNIT';
    $pdf->MultiCell($common_width, 2, $footer_text1);
    $pdf->Ln(2);

    $footer_text2 = 'FAA-G14 GUIDELINES ON THE REMUNERATION FRAMEWORK FOR REPRESENTATIVES AND SUPERVISORS ("BALANCED SCORECARD FRAMEWORK"), REFERENCE CHECKS AND PRE-TRANSACTION CHECKS';
    $pdf->MultiCell($common_width, 2, $footer_text2);

    $x1 = $pdf->GetX();
    $y1 = $pdf->GetY();
    $pdf->SetFont('Arial', '', 5);
    $pdf->Text($x1, $y1-9, 1);
    $pdf->Text($x1, $y1-3, 2);



    $pdf->Output($file_name, 'D');
}

exit;
?>