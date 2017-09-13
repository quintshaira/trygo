<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3 -  Number of transactions effected by representatives in the measurement quarter",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$w1=7600;
$w2=2000;


$table->addRow(50);
$table->addCell($w1)->addText("(a) Number of transactions which are rollovers of any dual currency investment or structured
note relating to equities or commodities, or such other product as the Authority may
approve on an exceptional basis", 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$C2_1");

$table->addRow(50);
$table->addCell($w1)->addText("(b) Number of transactions other than transactions which are rollovers of any dual currency
investment or structured note relating to equities or commodities, or such other product as
the Authority may approve on an exceptional basis", 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$C2_1");
// Add more rows / cells



$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3 (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');


?>