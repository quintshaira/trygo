<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(c)(ii) - Number of successful appeals which involve a reassignment of balanced scorecard grades",'BoldText');

$table = $section->addTable('myOwnTableStyle');

//$table->addRow();
//$table->addCell(3600,array('gridSpan' => 2))->addText('', null, 'pS_nospaceafter');
//$table->addCell(6000, array('gridSpan' => 4))->addText('Revised balanced scorecard grades', null, 'pS_nospaceafter');

$w1=1900;
$w2=2300;
$w3=1800;
$w4=1800;
$w5=1800;

$table->addRow();

$table->addCell($w1+$w2,array('gridSpan' => 2))->addText('Revised balanced scorecard grades', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('Good', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('Satisfactory', null, 'pS_nospaceafter');
$table->addCell($w5)->addText('Fair', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell($w1, array('vMerge' => 'restart'))->addText('Original balanced scorecard grades', null, 'pS_nospaceafter');
$table->addCell($w2)->addText('Satisfactory', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('', null, 'pS_nospaceafter');
$table->addCell($w4+$w5, array('gridSpan' => 2,'bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('Fair', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('', null, 'pS_nospaceafter');
$table->addCell($w5, array('bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('Unsatisfactory', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('', null, 'pS_nospaceafter');
$table->addCell($w5)->addText('', null, 'pS_nospaceafter');


// Add more rows / cells

$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(c)(i) and 3(c)(ii) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');
?>