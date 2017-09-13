<?php
$section->createTextRun('pS_nospaceafter')->addText("Table 1 : Number of representatives",'BoldText');
// Add table
$table = $section->addTable('myOwnTableStyle');

$w1=8200;
$w2=1400;
// Add row
$table->addRow(200);

// Add cells
$table->addCell($w1)->addText("Total number of appointed representatives and provisional representatives (collectively referred to as \"representatives\")"
    , 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("$A1_1",null,'pS_nospaceafter');

// Add more rows / cells

$table->addRow(5);
$table->addCell($w1)->addText("Breakdown:"
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A1_2",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    1) Number of representatives who have been assigned balanced scorecard grades and are: "
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A1_3",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      i) remunerated by way of variable income only"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A1_4",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) remunerated by way of a fixed salary and variable income component"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A1_5",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iii) not remunerated by way of variable income"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A1_6",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("    2) Number of representatives who have not been assigned balanced scorecard grades due to the following reasons:"
    ,'BoldText','pS_nospaceafter');
$table->addCell($w2,array('bgColor' => $dactivecell_color))->addText("$A1_7",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      i) representative is exempt from the application of the
balanced scorecard framework under regulation 34A of
the FAR"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A1_8",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      ii) representative ceases to provide financial advisory services during the
measurement quarter and where the financial adviser has assessed and
documented its assessment in writing that it is not possible for the financial
adviser to comply with paragraphs 4.1.1(i) to (vii) of the Notice, in respect of that representative"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A1_9",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iii) representative did not effect any transaction and did not have any case with
infractions referred to under footnote 2 of the Representatives' Grading Table
arising from findings from mystery shopping exercises, if any, or substantiated
complaints, if any, during the measurement quarter"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A1_10",null,'pS_nospaceafter');

$table->addRow(50);
$table->addCell($w1)->addText("      iv) other reasons, please state:
_________________________________"
    ,null,'pS_nospaceafter');
$table->addCell($w2)->addText("$A1_11",null,'pS_nospaceafter');



$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 1 (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');
?>