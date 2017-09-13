<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 2(b) - Recruitment of representatives who obtained balanced scorecard grades of B or worse in any of the last four
balanced scorecard grades within the past 10 years",'BoldText');

// Add table
$table = $section->addTable('myOwnTableStyle');
$w1=8200;
$w2=1400;
// Add row
$table->addRow(5);

// Add cells
$table->addCell($w1)->addText("Number of representatives who obtained a balanced scorecard grade of B or worse in any
of the last four balanced scorecard grades within the past 10 years"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A2_1",null,'pS_nospaceafter');



$section->addTextBreak();
$table = $section->addTable('myOwnTableStyle');
$w1=2500;
$w2=4500;
$w3=3200;

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Name of representative"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Name of former principal(s)"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Last four balanced scorecard grades within the past 10 years"
    , 'BoldText','pS_nospaceafter');


// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4d_1", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4d_2", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4d_3", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4d_4", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4d_5", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4d_6", null,'pS_nospaceafter');


// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4d_7", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4d_8", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4d_9", null,'pS_nospaceafter');


// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4d_10", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4d_11", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4d_12", null,'pS_nospaceafter');

$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 2(b) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');
?>