<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(b) - Amount of specified variable income that the representatives are not entitled to (#2)",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');
$w1=8200;
$w2=1400;

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("");
$table->addCell($w2)->addText("Amount (S$)"
    , 'BoldText','pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Total amount of specified variable income that representatives are not entitled to"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A3b_1");


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(b) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');

?>