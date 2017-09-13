<?php
$a3e_sql = "SELECT ag.agent_id, ag.preffered_name, mi.infraction_name, mqsri.infraction_detail, mqa.agent_penalty_amount_by_grade
FROM bsc_measurement_quarter_on_agent mqa
LEFT JOIN bsc_agent ag on ag.agent_id=mqa.agent_id
LEFT JOIN bsc_measurement_quarter_sampling mqs ON mqs.measurement_quarter_on_agent_id=mqa.measurement_quarter_on_agent_id
LEFT JOIN bsc_measurement_quarter_sampling_round_infraction mqsri ON mqsri.sampling_id=mqs.sampling_id
LEFT JOIN bsc_mq_infraction mi ON mi.mq_infraction_id=mqsri.infraction
WHERE mqa.measurement_quarter_id=$MQ_ID
AND mqa.grade='E'
AND mqsri.is_delete=0
ORDER BY ag.preffered_name ASC
";

$a3e_query = mysql_query($a3e_sql);

$a3e_data = array();

while($a3e_result = mysql_fetch_array($a3e_query)) {

    $infraction_desc = $a3e_result['infraction_name'];
    if ($a3e_result['infraction_detail'] != '') {
        $infraction_desc .= ' [' . $a3e_result['infraction_detail'] . ']';
    }

    $a3e_data[$a3e_result['agent_id']]['agent_id'] = $a3e_result['agent_id'];
    $a3e_data[$a3e_result['agent_id']]['preffered_name'] = $a3e_result['preffered_name'];
    $a3e_data[$a3e_result['agent_id']]['infraction_details'][] = $infraction_desc;
    //$a3e_data[$a3e_result['agent_id']]['infraction_detail'][] = $a3e_result['infraction_detail'];
    $a3e_data[$a3e_result['agent_id']]['agent_penalty_amount_by_grade'] = $a3e_result['agent_penalty_amount_by_grade'];
}



//echo '<pre>'; print_r($a3e_data); exit;

$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(e) - Details of infractions committed by representatives who have been assigned a balanced scorecard grade E",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');
$w1=3500;
$w2=3000;
$w3=3000;
$w4=2000;
$w5=2500;
// Add row
$table->addRow(5);



// Add cells
$table->addCell($w1)->addText("Name(#4) of representative"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Category of infraction(s) / brief description of infraction(s)"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Misconduct report number (if applicable)"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w4)->addText("Percentage of specified variable income that the representative is not entitled to"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w5)->addText("Amount of specified variable income that the representative is not entitled to (S$)(#5)"
    , 'BoldText','pS_nospaceafter');



if (empty($a3e_data)) {

    for ($i=1; $i<6; $i++) {
        // Add row
        $table->addRow(5);
        // Add cells
        $table->addCell($w1)->addText("", null, 'pS_nospaceafter');
        $table->addCell($w2)->addText("", null, 'pS_nospaceafter');
        $table->addCell($w3)->addText("", null, 'pS_nospaceafter');
        $table->addCell($w4)->addText("", null, 'pS_nospaceafter');
        $table->addCell($w5)->addText("", null, 'pS_nospaceafter');
    }
} else {

    foreach ($a3e_data as $k => $v) {
        $table->addRow(5);
        $table->addCell($w1)->addText($v['preffered_name'], null, 'pS_nospaceafter');
        $table->addCell($w2)->addText(implode(', ',$v['infraction_details']), null, 'pS_nospaceafter');
        $table->addCell($w3)->addText('', null, 'pS_nospaceafter');
        $table->addCell($w4)->addText('80%', null, 'pS_nospaceafter');
        $table->addCell($w5)->addText($v['agent_penalty_amount_by_grade'], null, 'pS_nospaceafter');
    }
}




$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(e) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("NIL", null, 'pS_nospaceafter');

?>