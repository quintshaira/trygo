<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 1 - Statistics for client surveys conducted by the ISA Unit on sampled transactions in the measurement quarter",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$w1=7600;
$w2=2000;


$table->addRow(50);
$table->addCell($w1)->addText("Number of client surveys conducted using the following methods:"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$C1_1");

// Add more rows / cells


$table->addRow(50);
$table->addCell($w1)->addText(" i) Phone surveys"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_2",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" ii) Face-to-face interactions"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_3",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" iii) Written surveys"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_4",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" iv) Electronic surveys"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_5",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" v) others, please describe: _________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_6",null,'pS_nospaceafter');




$table->addRow(50);
$table->addCell($w1)->addText("Number of responses from clients for client surveys conducted
using the following methods"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$C1_7");

// Add more rows / cells


$table->addRow(50);
$table->addCell($w1)->addText(" i) Phone surveys"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_8",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" ii) Face-to-face interactions"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_9",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" iii) Written surveys"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_10",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" iv) Electronic surveys"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_11",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText(" v) others, please describe: _________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C1_12",null,'pS_nospaceafter');


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 1 (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');

?>