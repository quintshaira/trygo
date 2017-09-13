<?php
$section->addTextBreak();
$p1=$section->createTextRun('pS_nospaceafter');
$p1->addText("Table 3(a) - Number of supervisors, range of percentage of total specified
variable income that the supervisors are entitled to and balanced scorecard
grade assigned",'BoldText');
$p1->addText(" (e.g. If there are 10 supervisors who received 80 - 90% of the total variable income that
they were entitled to, please indicate under number of supervisors as \"10\" and range of percentage of total specified variable income
which the supervisors are entitled to as \"80-90%\")",'italic_text');

// Add table
$table = $section->addTable('myOwnTableStyle');
$w1 = 2000;
$w2 = 6000;
$w3 = 6000;
// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Balanced scorecard grade assigned", 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Number of supervisors", 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Range
of percentage of total specified
variable income which the
supervisors are entitled to under
each grade"
    , 'BoldText','pS_nospaceafter');



$sup_grade_sql = "SELECT supervisor_id, supervisor_grade
                    FROM bsc_measurement_quarter_on_agent
                    WHERE supervisor_grade!=''
                    AND measurement_quarter_id=$MQ_ID
                    GROUP BY supervisor_id";
$sup_grade_que = mysql_query($sup_grade_sql);

$good_num = 0;
$satisfactory_num = 0;
$fair_num = 0;
$unsatisfactory_num = 0;

while($sup_grade_res = mysql_fetch_array($sup_grade_que)) {
    if($sup_grade_res['supervisor_grade'] == 'Good') $good_num++;
    elseif($sup_grade_res['supervisor_grade'] == 'Satisfactory') $satisfactory_num++;
    elseif($sup_grade_res['supervisor_grade'] == 'Fair') $fair_num++;
    else $unsatisfactory_num++;
}




// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Good", null,'pS_nospaceafter');
$table->addCell($w2)->addText($good_num, null,'pS_nospaceafter');
$table->addCell($w3)->addText("75% to 100%", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Satisfactory", null,'pS_nospaceafter');
$table->addCell($w2)->addText($satisfactory_num, null,'pS_nospaceafter');
$table->addCell($w3)->addText("50% to less than 75%", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Fair", null,'pS_nospaceafter');
$table->addCell($w2)->addText($fair_num, null,'pS_nospaceafter');
$table->addCell($w3)->addText("25% to less than 50%", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Unsatisfactory", null,'pS_nospaceafter');
$table->addCell($w2)->addText($unsatisfactory_num, null,'pS_nospaceafter');
$table->addCell($w3)->addText("0% to less than 25%", null,'pS_nospaceafter');



$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(a) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("N/A", null, 'pS_nospaceafter');

?>