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
$table->addCell(8000)->addText("Number of supervisors recruited who had obtained balanced scorecard grades of Satisfactory or worse in any of the last four balanced scorecard grades within the past 10 years", 'BoldText','pS_nospaceafter');
$table->addCell(1600)->addText("", null,'pS_nospaceafter');

$table = $section->addTable('myOwnTableStyle');
$w1=3000;
$w2=3000;
$w3=3600;
// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Name of supervisor" , null,'pS_nospaceafter');
$table->addCell($w2)->addText("Name of former employer(s)" , null ,'pS_nospaceafter');
$table->addCell($w3)->addText("Last four balanced scorecard grades within the past 10 years" , null ,'pS_nospaceafter');

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


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 2 (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');


?>