<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 4(d) - Details of infractions committed by representatives who have been assigned a balanced scorecard grade E",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');
$w1 = 4500;
$w2 = 5000;
$w3 = 4500;


// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Name(#8) of representative"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Category of infraction(s) / brief
description of infraction(s)"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Misconduct report
number (if applicable)"
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
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 4(d) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("",null,'pS_nospaceafter');

?>