<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(c)(i) - Number of appeals handled by the financial adviser in the measurement quarter",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

$w1=8200;
$w2=1400;


$table->addRow(50);
$table->addCell($w1)->addText("Total number of outstanding appeals by supervisors at the
beginning of the measurement quarter"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_1");

// Add more rows / cells

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$B2c_2" ,null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of successful appeals which involve: "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$B2c_3",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      i) a reassignment to a better balanced scorecard grade (please provide a breakdown
of the reassignment of grades under table 3(c)(ii))",null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_4",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) no reassignment of balanced scorecard grades but an
increase in percentage entitlement to variable income"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_6",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iii) others, please describe: _________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_7",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of rejected appeals "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_8",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    3) Number of outstanding appeals pending final outcome "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_9",null,'pS_nospaceafter');

$table->addRow(10);
$table->addCell($w1+$w2, array('gridSpan' => 2,'bgColor' => $dactivecell_color))->addText("",null,'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1)->addText("Total number of appeals submitted by supervisors against the
financial adviser's assignment of balanced scorecard grades
during the measurement quarter"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_10",'BoldText','pS_nospaceafter');

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$B2c_11",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of successful appeals which involve: "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$B2c_12",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      i) a reassignment to a better balanced scorecard grade (please provide a breakdown of the reassignment of grades under table 3(c)(ii))"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_13",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) no reassignment of balanced scorecard grades but an
increase in percentage entitlement to variable income"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_15",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iii) others, please describe: _________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_16",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of rejected appeals "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_17",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    3) Number of outstanding appeals pending final outcome "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_18",null,'pS_nospaceafter');

$table->addRow(10);
$table->addCell($w1+$w2, array('gridSpan' => 2,'bgColor' => $dactivecell_color))->addText("",null,'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1)->addText("Total amount of specified variable income returned to supervisors in successful appeal cases (S$)",'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B2c_18",null,'pS_nospaceafter');

?>