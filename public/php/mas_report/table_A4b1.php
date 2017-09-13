<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 4(b)(i) - Number of appeals handled by the financial adviser in the measurement quarter",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$w1 = 12000;
$w2 = 2000;


$table->addRow(50);
$table->addCell($w1)->addText("Total number of outstanding appeals by representatives at the beginning of the measurement quarter"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_1");

// Add more rows / cells

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A4b_2" ,null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of successful appeals which involve: "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A4b_3",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      i) a reassignment to a better balanced scorecard grade (please provide a breakdown
of the reassignment of grades under table 4(b)(ii))"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_4",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) others, please describe: ______________________________________________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_6",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of rejected appeals "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_7",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    3) Number of outstanding appeals pending final outcome "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_8",null,'pS_nospaceafter');

$table->addRow(10);
$table->addCell($w1+$w2, array('gridSpan' => 2,'bgColor' => $dactivecell_color))->addText("",null,'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1)->addText("Total number of appeals submitted by representatives against the financial adviser's assignment of balanced scorecard grades during the measurement quarter"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_9",'BoldText','pS_nospaceafter');

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A4b_10",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of successful appeals which involve: "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A4b_11",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      a reassignment to a better balanced scorecard grade (please provide a breakdown
of the reassignment of grades under table 4(b)(ii))"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_12",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) others, please describe: ______________________________________________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_14",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of rejected appeals "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_15",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    3) Number of outstanding appeals pending final outcome "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A4b_16",null,'pS_nospaceafter');

?>