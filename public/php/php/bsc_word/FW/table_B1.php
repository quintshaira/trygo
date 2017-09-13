<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 1 - Number of supervisors",'BoldText');

// Add table
$table = $section->addTable('myOwnTableStyle');

$w1=8200;
$w2=1400;


$table->addRow(5);
$table->addCell($w1)->addText("Total number of supervisors"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$B1_1");

// Add more rows / cells

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$B1_2" ,null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of supervisors who have been assigned balanced
scorecard grades and are: "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$B1_3",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      i) remunerated by way of variable income only, and have
representatives under their supervision who are
remunerated by way of variable income, whether wholly
or partly."
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B1_4",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) remunerated by way of a fixed salary and variable
income component, and have representatives under their
supervision who are remunerated by way of variable
income, whether wholly or partly."
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B1_5",null,'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of supervisors who have not been assigned
balanced scorecard grades due to the following reasons: "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$B1_6",null,'pS_nospaceafter');



$table->addRow(50);
$table->addCell($w1)->addText("      i) representatives under their supervision are exempt from
the application of the balanced scorecard framework
under regulation 34A of the FAR"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B1_7",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) supervisors are not remunerated by way of variable
income"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B1_8",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iii) supervisors are remunerated by way of variable income,
whether wholly or partly, but the representatives under
their supervision are not remunerated by way of variable
income, whether wholly or partly"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B1_9",null,'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1)->addText("      iv) supervisors who cease to supervise or manage the conduct and performance of any representative during the measurement quarter and where the financial adviser has assessed and documented its assessment in writing that it is not possible for the financial adviser to comply with paragraphs 5.1.1 (a) and (b) of
the Notice, in respect of those supervisors"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B1_9",null,'pS_nospaceafter');


$table->addRow(50);
$table->addCell($w1)->addText("      v) other reasons, please state: _________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B1_10",null,'pS_nospaceafter');


$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 1 (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');

?>