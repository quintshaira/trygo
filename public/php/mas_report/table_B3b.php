<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(b) - Amount of specified variable income that the supervisors are not entitled to(#9)",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');
$w1 = 7000;
$w2 = 7000;

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText(""
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Amount (S$)"
    , 'BoldText','pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Total amount of specified variable income
that supervisors are not entitled to"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText($gen_row['sup_total_svi_penalty'], 'BoldText', 'pS_nospaceafter');




$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(b) (if any)", 'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("N/A", null, 'pS_nospaceafter');
?>