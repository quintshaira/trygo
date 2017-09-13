<?php
$section->addTextBreak();
$p1=$section->createTextRun('pS_nospaceafter');
$p1->addText("Table 2 - Recruitment of supervisors who obtained balanced scorecard grades \"Satisfactory\" or worse in any of the last four balanced scorecard grades within the past 10 years",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$section->addTextBreak();
// Add row
$table->addRow(5);
// Add cells
$table->addCell(12000)->addText("Number of supervisors recruited who had obtained balanced scorecard grades of Satisfactory or worse in any of the last four balanced scorecard grades within the past 10 years", 'BoldText','pS_nospaceafter');
$table->addCell(2000)->addText($gen_row['num_new_recruited_supervisor_with_worst_grade'], 'BoldText', 'pS_nospaceafter');

$table = $section->addTable('myOwnTableStyle');
$w1 = 5000;
$w2 = 5000;
$w3 = 4000;
// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Name of supervisor" , null,'pS_nospaceafter');
$table->addCell($w2)->addText("Name of former employer(s)" , null ,'pS_nospaceafter');
$table->addCell($w3)->addText("Last four balanced scorecard grades within the past 10 years" , null ,'pS_nospaceafter');




if($gen_row['num_new_recruited_supervisor_with_worst_grade'] > 0) {

    $worst_grade_sup_sql = "SELECT supervisor_ids FROM bsc_worst_graded_agents WHERE worst_graded_agents_id=" . $gen_row['worst_graded_agents_id'];
    $worst_grade_sup_row = mysql_fetch_assoc(mysql_query($worst_grade_sup_sql));

    $worst_graded_sup_sql = "SELECT a.preffered_name, p.company_name, p.grade
                               FROM bsc_agent a
                               Left Join bsc_agent_past_company_details p on a.agent_id=p.agent_id
                               WHERE agent_id in (" . $worst_grade_sup_row['supervisor_ids'] . ")
                               Order By p.year DESC
                               ";

    $worst_graded_sup_que = mysql_query($worst_graded_sup_sql);
    $worst_graded_sup_num = mysql_num_rows($worst_graded_sup_que);

    if($worst_graded_sup_num > 0){
        while($worst_graded_sup_row = mysql_fetch_assoc($worst_graded_sup_que)) {

            // Add row
            $table->addRow(5);
            // Add cells
            $table->addCell($w1)->addText($worst_graded_sup_row['preffered_name'], null, 'pS_nospaceafter');
            $table->addCell($w2)->addText($worst_graded_sup_row['company_name'], null, 'pS_nospaceafter');
            $table->addCell($w3)->addText($worst_graded_sup_row['grade'], null, 'pS_nospaceafter');

        } // while
    }
} else {

    // Add row
    $table->addRow(5);
    // Add cells
    $table->addCell($w1)->addText("$B2a_2", null,'pS_nospaceafter');
    $table->addCell($w2)->addText("$B2a_2", null,'pS_nospaceafter');
    $table->addCell($w3)->addText("$B2a_1" , null ,'pS_nospaceafter');

    /// Add row
    $table->addRow(5);
    // Add cells
    $table->addCell($w1)->addText("$B2a_2", null,'pS_nospaceafter');
    $table->addCell($w2)->addText("$B2a_2", null,'pS_nospaceafter');
    $table->addCell($w3)->addText("$B2a_1" , null ,'pS_nospaceafter');


    // Add row
    $table->addRow(5);
    // Add cells
    $table->addCell($w1)->addText("$B2a_2", null,'pS_nospaceafter');
    $table->addCell($w2)->addText("$B2a_2", null,'pS_nospaceafter');
    $table->addCell($w3)->addText("$B2a_1" , null ,'pS_nospaceafter');
}


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 2 (if any)", 'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("N/A", null, 'pS_nospaceafter');

?>