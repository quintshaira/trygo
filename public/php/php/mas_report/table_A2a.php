<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 2(a) -",'BoldText');

$section->createTextRun('pS_nospaceafter')->addText("      (I) Number of selected representatives",'BoldText');

// Add table
$table = $section->addTable('myOwnTableStyle');
$w1 = 12000;
$w2 = 2000;
// Add row
$table->addRow(5);

// Add cells
$table->addCell($w1)->addText("Total number of selected representatives in the calendar quarter"
    , 'BoldText', 'pS_nospaceafter');
$table->addCell($w2)->addText($gen_row['num_total_selected_reps'], 'BoldText', 'pS_nospaceafter');


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("       (II) Number of representatives placed under close supervision", 'BoldText');

$table = $section->addTable('myOwnTableStyle');
$table->addRow(5);
$table->addCell($w1)->addText("Number of representatives placed under close supervision by the financial adviser based
on their performance under the balanced scorecard framework in the measurement
quarter"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText($gen_row['num_of_agents_with_grade_e'], 'BoldText', 'pS_nospaceafter');


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 2(a) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("NIL", null, 'pS_nospaceafter');

?>