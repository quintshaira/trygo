<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 4(c) - Details of successful appeals involving a reassignment from a balanced scorecard grade E to a better grade",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');
$w1=600;
$w2=4500;
$w3=4500;

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("S/N", 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Name(#7) of representative", 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Final balanced scorecard grade", 'BoldText','pS_nospaceafter');


// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4c_1", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4c_2", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4c_2", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4c_3", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4c_4", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4c_2", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4c_5", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4c_6", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4c_2", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("$A4c_7", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4c_8", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4c_2", null,'pS_nospaceafter');


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 4(c) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');



?>