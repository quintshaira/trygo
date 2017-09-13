<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(c)(ii) - Number of successful appeals which involve a reassignment of balanced scorecard grades",'BoldText');

$table = $section->addTable('myOwnTableStyle');

//$table->addRow();
//$table->addCell(3600,array('gridSpan' => 2))->addText('', null, 'pS_nospaceafter');
//$table->addCell(6000, array('gridSpan' => 4))->addText('Revised balanced scorecard grades', null, 'pS_nospaceafter');

$w1=2000;
$w2=2000;
$w3=2500;
$w4=2500;
$w5=2500;
$w6=2500;

$table->addRow();

$table->addCell($w1+$w2,array('gridSpan' => 2))->addText('Revised balanced scorecard grades', null, 'pS_nospaceafter');
$table->addCell($w3)->addText('A', null, 'pS_nospaceafter');
$table->addCell($w4)->addText('B', null, 'pS_nospaceafter');
$table->addCell($w5)->addText('C', null, 'pS_nospaceafter');
$table->addCell($w6)->addText('D', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell($w1, array('vMerge' => 'restart'))->addText('Original balanced scorecard grades', null, 'pS_nospaceafter');
$table->addCell($w2)->addText('B', null, 'pS_nospaceafter');
$table->addCell($w3)->addText($b_to_a, null, 'pS_nospaceafter');
$table->addCell($w4+$w5+$w6, array('gridSpan' => 3,'bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('C', null, 'pS_nospaceafter');
$table->addCell($w3)->addText($c_to_a, null, 'pS_nospaceafter');
$table->addCell($w4)->addText($c_to_b, null, 'pS_nospaceafter');
$table->addCell($w5+$w6, array('gridSpan' => 2,'bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('D', null, 'pS_nospaceafter');
$table->addCell($w3)->addText($d_to_a, null, 'pS_nospaceafter');
$table->addCell($w4)->addText($d_to_b, null, 'pS_nospaceafter');
$table->addCell($w5)->addText($d_to_c, null, 'pS_nospaceafter');
$table->addCell($w6, array('bgColor' => $dactivecell_color))->addText('', null, 'pS_nospaceafter');

$table->addRow();

$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w2)->addText('E', null, 'pS_nospaceafter');
$table->addCell($w3)->addText($e_to_a, null, 'pS_nospaceafter');
$table->addCell($w4)->addText($e_to_b, null, 'pS_nospaceafter');
$table->addCell($w5)->addText($e_to_c, null, 'pS_nospaceafter');
$table->addCell($w6)->addText($e_to_d, null, 'pS_nospaceafter');


// Add more rows / cells

$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(c)(i) and 3(c)(ii) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("NIL", null, 'pS_nospaceafter');
?>