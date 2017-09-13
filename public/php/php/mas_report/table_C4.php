<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 4 - Number of cases with infractions uncovered through various processes and methods",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$w1 = 12000;
$w2 = 2000;


$table->addRow(5);
$table->addCell($w1)->addText("Number of cases with infractions uncovered through:", 'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$C2_1");

$table->addRow(5);
$table->addCell($w1)->addText("(a) Post-transaction documentation reviews", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C2_1");
$table->addRow(5);
$table->addCell($w1)->addText("(b) Post-transaction client surveys", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C2_1");
$table->addRow(5);
$table->addCell($w1)->addText("(c) Findings from mystery shopping exercises (if any)", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C2_1");
$table->addRow(5);
$table->addCell($w1)->addText("(d) Substantiated complaints (if any)", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$C2_1");






// Add more rows / cells


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 4 (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("",null,'pS_nospaceafter');


?>