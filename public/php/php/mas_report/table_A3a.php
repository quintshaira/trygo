<?php
$tier1_agents_designation = '2, 3, 4, 6, 9';
$tier2_agents_designation = '1, 5';
$tier3_agents_designation = '7, 8';

$tier1_agents_per_designation_array = array();
$tier2_agents_per_designation_array = array();
$tier3_agents_per_designation_array = array();

$tier1_graded_agents_array = array();
$tier2_graded_agents_array = array();
$tier3_graded_agents_array = array();


for($i=1; $i<=3; $i++){

    if($i==1) $agent_id_in = $tier1_agents_designation;
    elseif($i==2) $agent_id_in = $tier2_agents_designation;
    else $agent_id_in = $tier3_agents_designation;

    $get_agent_sql = "SELECT `a`.`agent_id`
        FROM `bsc_agent` AS `a`
        WHERE (a.agent_designation_id IN ($agent_id_in))
        AND (a.is_active=1)
        AND (a.is_delete=0)";

    $get_agent_query = mysql_query($get_agent_sql);

    while($get_agent_results = mysql_fetch_array($get_agent_query)){
        if($i==1) $tier1_agents_per_designation_array[] = $get_agent_results['agent_id'];
        elseif($i==2) $tier2_agents_per_designation_array[] = $get_agent_results['agent_id'];
        else $tier3_agents_per_designation_array[] = $get_agent_results['agent_id'];
    }
}



/*echo '<pre>'; print_r($tier1_agents_per_designation_array); echo '</pre>';
echo '<pre>'; print_r($tier2_agents_per_designation_array); echo '</pre>';
echo '<pre>'; print_r($tier3_agents_per_designation_array); echo '</pre>';

exit;*/


$tier1_agent_ids_per_designation = implode(', ', $tier1_agents_per_designation_array);
$tier2_agent_ids_per_designation = implode(', ', $tier2_agents_per_designation_array);
$tier3_agent_ids_per_designation = implode(', ', $tier3_agents_per_designation_array);





$one_case_has_cat1_and_cat2_sql = "SELECT c.agent_id
                                    FROM bsc_case c
                                    WHERE c.case_id
                                    IN (
                                        SELECT x.case_id
                                        FROM (
                                            SELECT mqi.`case_id` , count( mqi.`sampling_round_infraction_id` ) , mqi.`infraction`
                                            FROM `bsc_measurement_quarter_sampling_round_infraction` mqi
                                            WHERE mqi.`infraction` <3
                                            AND mqi.is_delete =0
                                            GROUP BY mqi.`case_id` , mqi.`infraction`
                                        ) AS x
                                        GROUP BY x.`case_id`
                                        HAVING count(x.`case_id`)=2
                                    )";

$one_case_has_cat1_and_cat2_que = mysql_query($one_case_has_cat1_and_cat2_sql);

$one_case_has_cat1_and_cat2_agent_ids = array();
while($one_case_has_cat1_and_cat2_res = mysql_fetch_array($one_case_has_cat1_and_cat2_que)){
    $one_case_has_cat1_and_cat2_agent_ids[] = $one_case_has_cat1_and_cat2_res['agent_id'];
}



$graded_agent_data = array();

for($i=1; $i<=3; $i++) {

    if($i==1) $mq_agent_id_in = $tier1_agent_ids_per_designation;
    elseif($i==2) $mq_agent_id_in = $tier2_agent_ids_per_designation;
    else $mq_agent_id_in = $tier3_agent_ids_per_designation;

    $final_agent_sql = "SELECT a3a.*
        FROM bsc_mas_report_table_a3a_data as a3a
        WHERE (a3a.measurement_quarter_id=$MQ_ID)
        AND (a3a.agent_id IN ($mq_agent_id_in))
        ORDER BY a3a.agent_id ASC";

    $final_agent_query = mysql_query($final_agent_sql);

    while($final_agent_result = mysql_fetch_array($final_agent_query)){

        $final_agent_result['cat1_num'];
        $final_agent_result['cat2_num'];
        $final_agent_result['cat2_percentage'];
        $final_agent_result['area_of_improve_num'];
        $final_agent_result['no_infraction_num'];
        $final_agent_result['grade'];


        if($final_agent_result['grade'] == 'A'){

            if($final_agent_result['no_infraction_num'] > 0 ){
                $graded_agent_data[$i]['A']['no_infraction_num'][] = $final_agent_result['agent_id'];
            }

            if($final_agent_result['cat2_percentage'] < 5){
                $graded_agent_data[$i]['A']['cat2_percentage'][] = $final_agent_result['agent_id'];
            }

            if($final_agent_result['cat2_num'] == 1){
                $graded_agent_data[$i]['A']['cat2_num'][] = $final_agent_result['agent_id'];
            }

            if(($final_agent_result['cat2_percentage'] < 5) && ($final_agent_result['cat2_num'] == 1) ) {
                $graded_agent_data[$i]['A']['satisfies_both'][] = $final_agent_result['agent_id'];
            }


        } else if($final_agent_result['grade'] == 'B') {

            if(($final_agent_result['cat2_percentage'] >= 5) && ($final_agent_result['cat2_percentage'] < 10)) {
                $graded_agent_data[$i]['B']['cat2_percentage'][] = $final_agent_result['agent_id'];
            }

            if($final_agent_result['cat2_num'] == 2){
                $graded_agent_data[$i]['B']['cat2_num'][] = $final_agent_result['agent_id'];
            }

            if(($final_agent_result['cat2_percentage'] >= 5) && ($final_agent_result['cat2_percentage'] < 10) && ($final_agent_result['cat2_num'] == 2) ) {
                $graded_agent_data[$i]['B']['satisfies_both'][] = $final_agent_result['agent_id'];
            }


        } else if($final_agent_result['grade'] == 'C') {

            if(($final_agent_result['cat2_percentage'] >= 10) && ($final_agent_result['cat2_percentage'] < 20)) {
                $graded_agent_data[$i]['C']['cat2_percentage'][] = $final_agent_result['agent_id'];
            }

            if($final_agent_result['cat2_num'] == 3){
                $graded_agent_data[$i]['C']['cat2_num'][] = $final_agent_result['agent_id'];
            }

            if(($final_agent_result['cat2_percentage'] >= 10) && ($final_agent_result['cat2_percentage'] < 20) && ($final_agent_result['cat2_num'] == 3) ) {
                $graded_agent_data[$i]['C']['satisfies_both'][] = $final_agent_result['agent_id'];
            }

        } else if($final_agent_result['grade'] == 'D') {

            if(($final_agent_result['cat2_percentage'] >= 20) && ($final_agent_result['cat2_percentage'] < 30)) {
                $graded_agent_data[$i]['D']['cat2_percentage'][] = $final_agent_result['agent_id'];
            }

            if($final_agent_result['cat2_num'] == 4){
                $graded_agent_data[$i]['D']['cat2_num'][] = $final_agent_result['agent_id'];
            }

            if(($final_agent_result['cat2_percentage'] >= 20) && ($final_agent_result['cat2_percentage'] < 30) && ($final_agent_result['cat2_num'] == 4) ) {
                $graded_agent_data[$i]['D']['satisfies_both'][] = $final_agent_result['agent_id'];
            }

        } else if($final_agent_result['grade'] == 'E') {

            if($final_agent_result['cat2_percentage'] >= 30) {
                $graded_agent_data[$i]['E']['cat2_percentage'][] = $final_agent_result['agent_id'];
            }

            if($final_agent_result['cat2_num'] > 4){
                $graded_agent_data[$i]['E']['cat2_num'][] = $final_agent_result['agent_id'];
            }

            if(($final_agent_result['cat2_percentage'] >= 30) && ($final_agent_result['cat2_num'] > 4) ) {
                $graded_agent_data[$i]['E']['satisfies_both'][] = $final_agent_result['agent_id'];
            }

            if($final_agent_result['cat1_num'] > 1){
                $graded_agent_data[$i]['E']['cat1_num'][] = $final_agent_result['agent_id'];
            }



            if(in_array($final_agent_result['agent_id'], $one_case_has_cat1_and_cat2_agent_ids)) {

                $graded_agent_data[$i]['E']['cat1_and_cat2_num'][] = $final_agent_result['agent_id'];
            }

        }

    }
}

/*echo '<pre>'; print_r($tier1_graded_agents_array); echo '</pre>';
echo '<pre>'; print_r($tier2_graded_agents_array); echo '</pre>';
echo '<pre>'; print_r($tier3_graded_agents_array); echo '</pre>';

exit;*/


$t1_A_no_infraction_num = count($graded_agent_data[1]['A']['no_infraction_num']);
$t2_A_no_infraction_num = count($graded_agent_data[2]['A']['no_infraction_num']);
$t3_A_no_infraction_num = count($graded_agent_data[3]['A']['no_infraction_num']);

$t1_A_cat2_percentage_num = count($graded_agent_data[1]['A']['cat2_percentage']);
$t2_A_cat2_percentage_num = count($graded_agent_data[2]['A']['cat2_percentage']);
$t3_A_cat2_percentage_num = count($graded_agent_data[3]['A']['cat2_percentage']);

$t1_A_cat2_num = count($graded_agent_data[1]['A']['cat2_num']);
$t2_A_cat2_num = count($graded_agent_data[2]['A']['cat2_num']);
$t3_A_cat2_num = count($graded_agent_data[3]['A']['cat2_num']);

$t1_A_satisfies_both_num = count($graded_agent_data[1]['A']['satisfies_both']);
$t2_A_satisfies_both_num = count($graded_agent_data[2]['A']['satisfies_both']);
$t3_A_satisfies_both_num = count($graded_agent_data[3]['A']['satisfies_both']);


$t1_B_cat2_percentage_num = count($graded_agent_data[1]['B']['cat2_percentage']);
$t2_B_cat2_percentage_num = count($graded_agent_data[2]['B']['cat2_percentage']);
$t3_B_cat2_percentage_num = count($graded_agent_data[3]['B']['cat2_percentage']);

$t1_B_cat2_num = count($graded_agent_data[1]['B']['cat2_num']);
$t2_B_cat2_num = count($graded_agent_data[2]['B']['cat2_num']);
$t3_B_cat2_num = count($graded_agent_data[3]['B']['cat2_num']);

$t1_B_satisfies_both_num = count($graded_agent_data[1]['B']['satisfies_both']);
$t2_B_satisfies_both_num = count($graded_agent_data[2]['B']['satisfies_both']);
$t3_B_satisfies_both_num = count($graded_agent_data[3]['B']['satisfies_both']);


$t1_C_cat2_percentage_num = count($graded_agent_data[1]['C']['cat2_percentage']);
$t2_C_cat2_percentage_num = count($graded_agent_data[2]['C']['cat2_percentage']);
$t3_C_cat2_percentage_num = count($graded_agent_data[3]['C']['cat2_percentage']);

$t1_C_cat2_num = count($graded_agent_data[1]['C']['cat2_num']);
$t2_C_cat2_num = count($graded_agent_data[2]['C']['cat2_num']);
$t3_C_cat2_num = count($graded_agent_data[3]['C']['cat2_num']);

$t1_C_satisfies_both_num = count($graded_agent_data[1]['C']['satisfies_both']);
$t2_C_satisfies_both_num = count($graded_agent_data[2]['C']['satisfies_both']);
$t3_C_satisfies_both_num = count($graded_agent_data[3]['C']['satisfies_both']);


$t1_D_cat2_percentage_num = count($graded_agent_data[1]['D']['cat2_percentage']);
$t2_D_cat2_percentage_num = count($graded_agent_data[2]['D']['cat2_percentage']);
$t3_D_cat2_percentage_num = count($graded_agent_data[3]['D']['cat2_percentage']);

$t1_D_cat2_num = count($graded_agent_data[1]['D']['cat2_num']);
$t2_D_cat2_num = count($graded_agent_data[2]['D']['cat2_num']);
$t3_D_cat2_num = count($graded_agent_data[3]['D']['cat2_num']);

$t1_D_satisfies_both_num = count($graded_agent_data[1]['D']['satisfies_both']);
$t2_D_satisfies_both_num = count($graded_agent_data[2]['D']['satisfies_both']);
$t3_D_satisfies_both_num = count($graded_agent_data[3]['D']['satisfies_both']);


$t1_E_cat2_percentage_num = count($graded_agent_data[1]['E']['cat2_percentage']);
$t2_E_cat2_percentage_num = count($graded_agent_data[2]['E']['cat2_percentage']);
$t3_E_cat2_percentage_num = count($graded_agent_data[3]['E']['cat2_percentage']);

$t1_E_cat2_num = count($graded_agent_data[1]['E']['cat2_num']);
$t2_E_cat2_num = count($graded_agent_data[2]['E']['cat2_num']);
$t3_E_cat2_num = count($graded_agent_data[3]['E']['cat2_num']);

$t1_E_satisfies_both_num = count($graded_agent_data[1]['E']['satisfies_both']);
$t2_E_satisfies_both_num = count($graded_agent_data[2]['E']['satisfies_both']);
$t3_E_satisfies_both_num = count($graded_agent_data[3]['E']['satisfies_both']);

$t1_E_cat1_num = count($graded_agent_data[1]['E']['cat1_num']);
$t2_E_cat1_num = count($graded_agent_data[2]['E']['cat1_num']);
$t3_E_cat1_num = count($graded_agent_data[3]['E']['cat1_num']);

$t1_E_cat1_and_cat2_num = count($graded_agent_data[1]['E']['cat1_and_cat2_num']);
$t2_E_cat1_and_cat2_num = count($graded_agent_data[2]['E']['cat1_and_cat2_num']);
$t3_E_cat1_and_cat2_num = count($graded_agent_data[3]['E']['cat1_and_cat2_num']);


$t1_subtotal = $t1_A_no_infraction_num + $t1_A_cat2_percentage_num + $t1_A_cat2_num + $t1_A_satisfies_both_num
   + $t1_B_cat2_percentage_num + $t1_B_cat2_num + $t1_B_satisfies_both_num
   + $t1_C_cat2_percentage_num + $t1_C_cat2_num + $t1_C_satisfies_both_num
   + $t1_D_cat2_percentage_num + $t1_D_cat2_num + $t1_D_satisfies_both_num
   + $t1_E_cat2_percentage_num + $t1_E_cat2_num + $t1_E_satisfies_both_num + $t1_E_cat1_num + $t1_E_cat1_and_cat2_num;

$t2_subtotal = $t2_A_no_infraction_num + $t2_A_cat2_percentage_num + $t2_A_cat2_num + $t2_A_satisfies_both_num
    + $t2_B_cat2_percentage_num + $t2_B_cat2_num + $t2_B_satisfies_both_num
    + $t2_C_cat2_percentage_num + $t2_C_cat2_num + $t2_C_satisfies_both_num
    + $t2_D_cat2_percentage_num + $t2_D_cat2_num + $t2_D_satisfies_both_num
    + $t2_E_cat2_percentage_num + $t2_E_cat2_num + $t2_E_satisfies_both_num + $t2_E_cat1_num + $t2_E_cat1_and_cat2_num;


$t3_subtotal = $t3_A_no_infraction_num + $t3_A_cat2_percentage_num + $t3_A_cat2_num + $t3_A_satisfies_both_num
    + $t3_B_cat2_percentage_num + $t3_B_cat2_num + $t3_B_satisfies_both_num
    + $t3_C_cat2_percentage_num + $t3_C_cat2_num + $t3_C_satisfies_both_num
    + $t3_D_cat2_percentage_num + $t3_D_cat2_num + $t3_D_satisfies_both_num
    + $t3_E_cat2_percentage_num + $t3_E_cat2_num + $t3_E_satisfies_both_num + $t3_E_cat1_num + $t3_E_cat1_and_cat2_num;

$t1_t2_t3_total = $t1_subtotal + $t2_subtotal + $t3_subtotal;
//exit;


$section->addTextBreak();
$p1 = $section->createTextRun('pS_nospaceafter');
$p1->addText("Table 3(a) - Number of representatives based on each balanced scorecard grade
and range of percentage of specified variable income or effective percentage
specified variable income (as the case may be) that the representatives are
entitled to under each grade",'BoldText');
$p1->addText("(e.g. If there are 10 representatives who obtained a balanced scorecard grade of B, and they are entitled to 80 - 90% of
the specified variable income, please indicate under number of representatives as \"10\" and range of percentage of specified variable
income or effective percentage specified variable income as \"80 - 90%\").",'italic_text');
$section->addTextBreak();

// Add table
$table = $section->addTable('myOwnTableStyle');

//variables [width]
$h = 50;
$w1 = 1000;
$w2 = 1900;
$w3 = 1800;
$w4 = 1900;
$w5 = 1800;
$w6 = 1900;
$w7 = 1800;
$w8 = 1900;
// Add row

$table->addRow($h);
$table->addCell($w1, array('vMerge' => 'restart'))->addText("Balanced scorecard grade",'BoldText','pS_nospaceafter');
$table->addCell($w2, array('vMerge' => 'restart'))->addText("Categories",'BoldText','pS_nospaceafter');
$table->addCell($w3+$w4, array('gridSpan' => 2))->addText("Does not perform any supervisory role (i.e. Tier 1)",'BoldText','pS_nospaceafter');
$table->addCell($w5+$w6, array('gridSpan' => 2))->addText("Performs supervisory role as a Tier 2 supervisor",'BoldText','pS_nospaceafter');
$table->addCell($w7+$w8, array('gridSpan' => 2))->addText("Performs supervisory role as a Tier 3 supervisor",'BoldText','pS_nospaceafter');




$table->addRow($h);
$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w3)->addText("Number of representatives",'BoldText','pS_nospaceafter');
$table->addCell($w4)->addText("Range of percentage of specified variable income or effective percentage specified variable income",'BoldText','pS_nospaceafter');
$table->addCell($w5)->addText("Number of representatives",'BoldText','pS_nospaceafter');
$table->addCell($w6)->addText("Range of percentage of specified variable income or effective percentage specified variable income",'BoldText','pS_nospaceafter');
$table->addCell($w7)->addText("Number of representatives",'BoldText','pS_nospaceafter');
$table->addCell($w8)->addText("Range of percentage of specified variable income or effective percentage specified variable income",'BoldText','pS_nospaceafter');

//A
$table->addRow($h);
$table->addCell($w1)->addText("A",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) No infraction",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_A_no_infraction_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_A_no_infraction_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_A_no_infraction_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("100%", null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("ii) X <5% of cases with Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_A_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_A_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_A_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("100%", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("iii) One case with Category 2 infraction(s)", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_A_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_A_cat2_num, null,'pS_nospaceafter');
$table->addCell($w6)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_A_cat2_num, null,'pS_nospaceafter');
$table->addCell($w8)->addText("100%", null, 'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("iv) Satisfies both categories (ii) and (iii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_A_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_A_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("100%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_A_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("100%", null, 'pS_nospaceafter');


//B
$table->addRow($h);
$table->addCell($w1)->addText("B", 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText("i) 5% <= X < 10% of cases
with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_B_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("90%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_B_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("90%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_B_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("90%", null, 'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Two cases with
Category 2 infraction(s)", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_B_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("90%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_B_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("90%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_B_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("90%", null, 'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_B_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("90%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_B_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("90%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_B_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("90%", null, 'pS_nospaceafter');




//C
$table->addRow($h);
$table->addCell($w1)->addText("C",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 10% <= X < 20% of
cases with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_C_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("70%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_C_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("70%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_C_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("70%", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Three cases with
Category 2 infraction(s)", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_C_cat2_num, null,'pS_nospaceafter');
$table->addCell($w4)->addText("70%", null,'pS_nospaceafter');
$table->addCell($w5)->addText($t2_C_cat2_num, null,'pS_nospaceafter');
$table->addCell($w6)->addText("70%", null,'pS_nospaceafter');
$table->addCell($w7)->addText($t3_C_cat2_num, null,'pS_nospaceafter');
$table->addCell($w8)->addText("70%", null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_C_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("70%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_C_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("70%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_C_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("70%", null, 'pS_nospaceafter');


//D
$table->addRow($h);
$table->addCell($w1)->addText("D",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 20% <= X < 30% of
cases with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_D_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("45%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_D_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("45%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_D_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("45%", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Four cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_D_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("45%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_D_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("45%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_D_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("45%", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText($t1_D_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("45%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_D_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("45%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_D_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("45%", null, 'pS_nospaceafter');


//E
$table->addRow($h);
$table->addCell($w1)->addText("E", 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText("i) X >= 30% cases with
Category 2 infractions", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_E_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_E_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_E_cat2_percentage_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("20%", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Five or more cases with
Category 2 infraction(s)", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_E_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_E_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_E_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("20%", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_E_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_E_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_E_satisfies_both_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("20%", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("iv) One or more cases with
Category 1 infraction(s)", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_E_cat1_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_E_cat1_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_E_cat1_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("20%", null, 'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("v) One or more cases with
Category 1 infraction(s)
and Category 2
infraction(s)", null, 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_E_cat1_and_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w4)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_E_cat1_and_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w6)->addText("20%", null, 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_E_cat1_and_cat2_num, null, 'pS_nospaceafter');
$table->addCell($w8)->addText("20%", null, 'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("Sub-total", 'BoldText', 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_subtotal, 'BoldText', 'pS_nospaceafter');
$table->addCell($w4)->addText("Sub-total", 'BoldText', 'pS_nospaceafter');
$table->addCell($w5)->addText($t2_subtotal, 'BoldText', 'pS_nospaceafter');
$table->addCell($w6)->addText("Sub-total", 'BoldText', 'pS_nospaceafter');
$table->addCell($w7)->addText($t3_subtotal, 'BoldText', 'pS_nospaceafter');
$table->addCell($w8, array('bgColor' => $dactivecell_color))->addText("$A3a_3", null, 'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("", null, 'pS_nospaceafter');
$table->addCell($w2)->addText("Total number of representatives (#1)", 'BoldText', 'pS_nospaceafter');
$table->addCell($w3)->addText($t1_t2_t3_total, 'BoldText', 'pS_nospaceafter');
$table->addCell($w4+$w5+$w6+$w7+$w8, array('gridSpan' => 5, 'bgColor' => $dactivecell_color))->addText("", null, 'pS_nospaceafter');




$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(a) (if any)", 'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("NIL", null, 'pS_nospaceafter');

?>