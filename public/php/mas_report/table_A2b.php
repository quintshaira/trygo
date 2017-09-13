<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 2(b) - Recruitment of representatives who obtained balanced scorecard grades of B or worse in any of the last four
balanced scorecard grades within the past 10 years",'BoldText');

// Add table
$table = $section->addTable('myOwnTableStyle');
$w1 = 12000;
$w2 = 2000;
// Add row
$table->addRow(5);

// Add cells
$table->addCell($w1)->addText("Number of representatives who obtained a balanced scorecard grade of B or worse in any
of the last four balanced scorecard grades within the past 10 years"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText($gen_row['num_new_recruited_representative_with_worst_grade'], 'BoldText', 'pS_nospaceafter');



$section->addTextBreak();
$table = $section->addTable('myOwnTableStyle');
$w1 = 5500;
$w2 = 5500;
$w3 = 3000;

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Name of representative"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Name of former principal(s)"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Last four balanced scorecard grades within the past 10 years"
    , 'BoldText','pS_nospaceafter');





if($gen_row['num_new_recruited_representative_with_worst_grade'] > 0) {

    $worst_grade_sql = "SELECT representative_ids FROM bsc_worst_graded_agents WHERE worst_graded_agents_id=" . $gen_row['worst_graded_agents_id'];
    $worst_grade_row = mysql_fetch_assoc(mysql_query($worst_grade_sql));

    $worst_graded_agent_sql = "SELECT a.preffered_name, p.company_name, p.grade
                               FROM bsc_agent a
                               Left Join bsc_agent_past_company_details p on a.agent_id=p.agent_id
                               WHERE agent_id in (" . $worst_grade_row['representative_ids'] . ")
                               Order By p.year DESC
                               ";

    $worst_graded_agent_que = mysql_query($worst_graded_agent_sql);
    $worst_graded_agent_num = mysql_num_rows($worst_graded_agent_que);

    if($worst_graded_agent_num > 0){
        while($worst_graded_agent_row = mysql_fetch_assoc($worst_graded_agent_que)) {

            // Add row
            $table->addRow(5);
            // Add cells
            $table->addCell($w1)->addText($worst_graded_agent_row['preffered_name'], null, 'pS_nospaceafter');
            $table->addCell($w2)->addText($worst_graded_agent_row['company_name'], null, 'pS_nospaceafter');
            $table->addCell($w3)->addText($worst_graded_agent_row['grade'], null, 'pS_nospaceafter');

        } // while
    }

} else {
    // Add row
    $table->addRow(5);
    // Add cells
    $table->addCell($w1)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w2)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w3)->addText('', null, 'pS_nospaceafter');

    // Add row
    $table->addRow(5);
    // Add cells
    $table->addCell($w1)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w2)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w3)->addText('', null, 'pS_nospaceafter');

    // Add row
    $table->addRow(5);
    // Add cells
    $table->addCell($w1)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w2)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w3)->addText('', null, 'pS_nospaceafter');

    // Add row
    $table->addRow(5);
    // Add cells
    $table->addCell($w1)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w2)->addText('', null, 'pS_nospaceafter');
    $table->addCell($w3)->addText('', null, 'pS_nospaceafter');
}


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 2(b) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("NIL", null, 'pS_nospaceafter');
?>