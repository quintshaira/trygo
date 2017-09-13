<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 2 - Method used to determine the population for sampling during the measurement quarter",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$w1 = 12000;
$w2 = 2000;


$table->addRow(50);
$table->addCell($w1)->addText("Method used to determine the population for sampling"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$C2_1");

// Add more rows / cells





?>