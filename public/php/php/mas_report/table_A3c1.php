<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(c)(i) - Number of appeals handled by the financial adviser in the measurement quarter",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$w1 = 12000;
$w2 = 2000;


$b_to_a = 0;

$c_to_a = 0;
$c_to_b = 0;

$d_to_a = 0;
$d_to_b = 0;
$d_to_c = 0;

$e_to_a = 0;
$e_to_b = 0;
$e_to_c = 0;
$e_to_d = 0;

$e_to_better = array();

// outstanding
$outstanding_success_unchanged_grade_and_perc = $outstanding_success_lower_perc_with_same_grade = $outstanding_success_better_perc_with_same_grade = 0;
$outstanding_success_better_grade = $outstanding_success_lower_grade = 0;
$outstanding_rejected = $outstanding_pending = 0;
$outstanding_returned_amount = 0;

$outstanding_sql = "SELECT app.*, ag.preffered_name
FROM bsc_appeals app
LEFT JOIN bsc_agent ag on app.agent_id=ag.agent_id
WHERE (app.appeal_close_date BETWEEN '$qu_start_date' AND '$qu_end_date')
AND (app.appeal_on_date NOT BETWEEN '$qu_start_date' AND '$qu_end_date')
AND app.is_deleted=0
AND app.user_type='R'";

$outstanding_query = mysql_query($outstanding_sql);

while($outstanding_results = mysql_fetch_array($outstanding_query)) {

    $out_initial_pt = agentGradeWisePoint($outstanding_results['initial_grade']);
    $out_final_pt = agentGradeWisePoint($outstanding_results['final_grade']);

    if ($outstanding_results['appeal_status'] == 'Closed') {

        if ($outstanding_results['appeal_result'] == 'Successful') {
            if ($out_final_pt == $out_initial_pt) { // unchanged

                if ($outstanding_results['final_percent'] == $outstanding_results['initial_percent']) {
                    $outstanding_success_unchanged_grade_and_perc++;  //ot
                } else if ($outstanding_results['final_percent'] > $outstanding_results['initial_percent']) {
                    $outstanding_success_better_perc_with_same_grade++; //
                } else {
                    $outstanding_success_lower_perc_with_same_grade++;
                }

            } elseif ($out_final_pt > $out_initial_pt) { // better grade
                $outstanding_success_better_grade++; //

                $out_new_amount = ($outstanding_results['total_svi'] * $outstanding_results['final_percent']) / 100;
                $ret_amt = $out_new_amount - $outstanding_results['initial_amount'];
                $outstanding_returned_amount = $outstanding_returned_amount + $ret_amt;


                if ($outstanding_results['final_grade'] == 'A') {

                    if ($outstanding_results['initial_grade'] == 'B'){
                        $b_to_a++;
                    } else if($outstanding_results['initial_grade'] == 'C') {
                        $c_to_a++;
                    } else if($outstanding_results['initial_grade'] == 'D') {
                        $d_to_a++;
                    } else if($outstanding_results['initial_grade'] == 'E') {
                        $e_to_a++;
                    }

                } else if ($outstanding_results['final_grade'] == 'B') {

                    if ($outstanding_results['initial_grade'] == 'C') {
                        $c_to_b++;
                    } else if ($outstanding_results['initial_grade'] == 'D') {
                        $d_to_b++;
                    } else if ($outstanding_results['initial_grade'] == 'E') {
                        $e_to_b++;
                    }

                } else if($outstanding_results['final_grade'] == 'C') {

                    if ($outstanding_results['initial_grade'] == 'D') {
                        $d_to_c++;
                    } else if ($outstanding_results['initial_grade'] == 'E') {
                        $e_to_c++;
                    }

                } else if($outstanding_results['final_grade'] == 'D') {

                    if ($outstanding_results['initial_grade'] == 'E') {
                        $e_to_d++;
                    }
                }


                if ($outstanding_results['initial_grade'] == 'E') {
                    $e_to_better['agent_name'][] = $outstanding_results['preffered_name'];
                    $e_to_better['grade'][] = $outstanding_results['final_grade'];
                }


            } else if ($out_final_pt < $out_initial_pt) { // lower grade
                $outstanding_success_lower_grade++;  // ot
            }

        } else { //rejected
            $outstanding_rejected++;
        }
    } else {
        $outstanding_pending++;
    }
}

$outstanding_total = mysql_num_rows($outstanding_query);
if($outstanding_total < 1) $outstanding_total = 0;


//a) final grade is unchanged and no change in percentile.
//b) final grade is worse than initial grade.
//this is very unlikely but if this does happen there's "OTHERS" row
$outstanding_success_other = $outstanding_success_unchanged_grade_and_perc + $outstanding_success_lower_grade + $outstanding_success_lower_perc_with_same_grade;

$outstanding_success_other_msg = '';

if($outstanding_success_unchanged_grade_and_perc > 0) {
    $outstanding_success_other_msg .= 'Same grade with no change in percentage entitlement to';
}

if($outstanding_success_unchanged_grade_and_perc > 0 && $outstanding_success_lower_grade > 0 ) {
    $outstanding_success_other_msg .= ' and ';
}

if($outstanding_success_lower_grade > 0){
    $outstanding_success_other_msg .= 'Entitled to lower grade';
}

if($outstanding_success_unchanged_grade_and_perc > 0 && $outstanding_success_lower_grade > 0 && $outstanding_success_lower_perc_with_same_grade > 0) {
    $outstanding_success_other_msg .= ' and ';
}

if ($outstanding_success_lower_perc_with_same_grade > 0){
    $outstanding_success_other_msg .= 'Same grade with lower percent entitled to';
}



$table->addRow(50);
$table->addCell($w1)->addText("Total number of outstanding appeals by representatives at the beginning of the measurement quarter"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText($outstanding_total);

// Add more rows / cells

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2, array('bgColor' => $dactivecell_color))->addText("$A3c_2", null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of successful appeals which involve: "
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2, array('bgColor' => $dactivecell_color))->addText("$A3c_3", null, 'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1)->addText("      i) a reassignment to a better balanced scorecard grade (please provide a breakdown of the reassignment of grades under table 3(c)(ii))"
    , null, 'pS_nospaceafter');
$table->addCell($w2)->addText($outstanding_success_better_grade, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) no reassignment of balanced scorecard grades but an increase in percentage entitlement to specified variable income"
    , null, 'pS_nospaceafter');
$table->addCell($w2)->addText($outstanding_success_better_perc_with_same_grade, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iii) others, please describe: " . $outstanding_success_other_msg
    , null, 'pS_nospaceafter');
$table->addCell($w2)->addText($outstanding_success_other, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of rejected appeals "
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText($outstanding_rejected, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    3) Number of outstanding appeals pending final outcome "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText($outstanding_pending, null, 'pS_nospaceafter');



$table->addRow(10);
$table->addCell($w1+$w2, array('gridSpan' => 2, 'bgColor' => $dactivecell_color))->addText("", null, 'pS_nospaceafter');







/// during
$during_success_unchanged_grade_and_perc = $during_success_lower_perc_with_same_grade = $during_success_better_perc_with_same_grade = 0;
$during_success_better_grade = $during_success_lower_grade = 0;
$during_rejected = $during_pending = 0;

$during_returned_amount = 0;

$during_sql = "SELECT app.*, ag.preffered_name
FROM bsc_appeals app
LEFT JOIN bsc_agent ag on app.agent_id=ag.agent_id
WHERE (app.appeal_on_date BETWEEN '$qu_start_date' AND '$qu_end_date')
AND (app.appeal_close_date BETWEEN '$qu_start_date' AND '$qu_end_date')
AND app.is_deleted=0
AND app.user_type='R'";

$during_query = mysql_query($during_sql);

while($during_results = mysql_fetch_array($during_query)) {

    $initial_pt = agentGradeWisePoint($during_results['initial_grade']);
    $final_pt = agentGradeWisePoint($during_results['final_grade']);

    if ($during_results['appeal_status'] == 'Closed') {

        if ($during_results['appeal_result'] == 'Successful') {
            if ($final_pt == $initial_pt) { // unchanged

                if ($during_results['final_percent'] == $during_results['initial_percent']) {
                    $during_success_unchanged_grade_and_perc++;  //ot
                } else if ($during_results['final_percent'] > $during_results['initial_percent']) {
                    $during_success_better_perc_with_same_grade++; //
                } else {
                    $during_success_lower_perc_with_same_grade++;
                }

            } elseif ($final_pt > $initial_pt) { // better grade
                $during_success_better_grade++; //

                $during_new_amount = ($during_results['total_svi'] * $during_results['final_percent']) / 100;
                $ret_amt = $during_new_amount - $during_results['initial_amount'];
                $during_returned_amount = $during_returned_amount + $ret_amt;


                if ($during_results['final_grade'] == 'A') {

                    if ($during_results['initial_grade'] == 'B'){
                        $b_to_a++;
                    } else if($during_results['initial_grade'] == 'C') {
                        $c_to_a++;
                    } else if($during_results['initial_grade'] == 'D') {
                        $d_to_a++;
                    } else if($during_results['initial_grade'] == 'E') {
                        $e_to_a++;
                    }

                } else if ($during_results['final_grade'] == 'B') {

                    if ($during_results['initial_grade'] == 'C') {
                        $c_to_b++;
                    } else if ($during_results['initial_grade'] == 'D') {
                        $d_to_b++;
                    } else if ($during_results['initial_grade'] == 'E') {
                        $e_to_b++;
                    }

                } else if($during_results['final_grade'] == 'C') {

                    if ($during_results['initial_grade'] == 'D') {
                        $d_to_c++;
                    } else if ($during_results['initial_grade'] == 'E') {
                        $e_to_c++;
                    }

                } else if($during_results['final_grade'] == 'D') {

                    if ($during_results['initial_grade'] == 'E') {
                        $e_to_d++;
                    }
                }


                if ($during_results['initial_grade'] == 'E') {
                    $e_to_better['agent_name'][] = $during_results['preffered_name'];
                    $e_to_better['grade'][] = $during_results['final_grade'];
                }


            } else if ($final_pt < $initial_pt) { // lower grade
                $during_success_lower_grade++;  // ot
            }

        } else { //rejected
            $during_rejected++;
        }
    } else {
        $during_pending++;
    }
}

$during_total = mysql_num_rows($during_query);
if($during_total < 1) $during_total = 0;


//a) final grade is unchanged and no change in percentile.
//b) final grade is worse than initial grade.
//this is very unlikely but if this does happen there's "OTHERS" row
$during_success_other = $during_success_unchanged_grade_and_perc + $during_success_lower_grade + $during_success_lower_perc_with_same_grade;

$during_success_other_msg = '';

if($during_success_unchanged_grade_and_perc > 0) {
    $during_success_other_msg .= 'Same grade with no change in percentage entitlement to';
}

if($during_success_unchanged_grade_and_perc > 0 && $during_success_lower_grade > 0 ) {
    $during_success_other_msg .= ' and ';
}

if($during_success_lower_grade > 0){
    $during_success_other_msg .= 'Entitled to lower grade';
}

if($during_success_unchanged_grade_and_perc > 0 && $during_success_lower_grade > 0 && $during_success_lower_perc_with_same_grade > 0) {
    $during_success_other_msg .= ' and ';
}

if ($during_success_lower_perc_with_same_grade > 0){
    $during_success_other_msg .= 'Same grade with lower percent entitled to';
}


$total_return_amount = number_format(($outstanding_returned_amount + $during_returned_amount), 2);


$table->addRow(50);
$table->addCell($w1)->addText("Total number of appeals submitted by representatives against the financial adviser's assignment of balanced scorecard grades during the measurement quarter"
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText($during_total, 'BoldText', 'pS_nospaceafter');

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A3c_11", null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of successful appeals which involve: "
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2, array('bgColor' => $dactivecell_color))->addText("$A3c_12", null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      i) a reassignment to a better balanced scorecard grade (please provide a breakdown of the reassignment of grades under table 3(c)(ii))"
    , null, 'pS_nospaceafter');
$table->addCell($w2)->addText($during_success_better_grade, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) no reassignment of balanced scorecard grades but an increase in percentage entitlement to specified variable income"
    , null, 'pS_nospaceafter');
$table->addCell($w2)->addText($during_success_better_perc_with_same_grade, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iii) others, please describe: " . $during_success_other_msg
    , null, 'pS_nospaceafter');
$table->addCell($w2)->addText($during_success_other, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of rejected appeals "
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText($during_rejected, null, 'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    3) Number of outstanding appeals pending final outcome "
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText($during_pending, null, 'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1+$w2, array('gridSpan' => 2, 'bgColor' => $dactivecell_color))->addText("", 'BoldText','pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    Total amount of specified variable income returned to representatives in successful appeal cases (S$)"
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText($total_return_amount, null, 'pS_nospaceafter');
?>