<?php

$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 4(b)(ii) - Number of successful appeals which involve a reassignment of balanced scorecard grades",'BoldText');

$table = $section->addTable('myOwnTableStyle');

//$table->addRow();
//$table->addCell(3600,array('gridSpan' => 2))->addText('', null, 'pS_nospaceafter');
//$table->addCell(6000, array('gridSpan' => 4))->addText('Revised balanced scorecard grades', null, 'pS_nospaceafter');

$w1=1600;
$w2=2000;
$w3=1500;
$w4=1500;
$w5=1500;
$w6=1500;

$table->addRow();

$table->addCell($w1+$w2,array('gridSpan' => 2))->addText('Revised balanced scorecard grades', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('A', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('B', null, 'pS_nospaceafter');
$table->addCell($w5)->addText('C', null, 'pS_nospaceafter');
$table->addCell($w6)->addText('D', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell($w1, array('vMerge' => 'restart'))->addText('Original balanced scorecard grades', null, 'pS_nospaceafter');
$table->addCell($w2)->addText('B', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('', null, 'pS_nospaceafter');
$table->addCell($w4+$w5+$w6, array('gridSpan' => 3,'bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('C', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('', null, 'pS_nospaceafter');
$table->addCell($w5+$w6, array('gridSpan' => 2,'bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('D', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('', null, 'pS_nospaceafter');
$table->addCell($w5)->addText('', null, 'pS_nospaceafter');
$table->addCell($w6, array('bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('E', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('', null, 'pS_nospaceafter');
$table->addCell($w5)->addText('', null, 'pS_nospaceafter');
$table->addCell($w6)->addText('', null, 'pS_nospaceafter');


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 4(b)(i) and 4(b)(ii) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');
?>