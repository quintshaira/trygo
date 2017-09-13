<?php
$section->addTextBreak();
$p1=$section->createTextRun('pS_nospaceafter');
$p1->addText("Table 3(a) - Number of supervisors, range of percentage of total specified
variable income that the supervisors are entitled to and balanced scorecard
grade assigned",'BoldText');
$p1->addText(" (e.g. If there are 10 supervisors who received 80 - 90% of the total variable income that
they were entitled to, please indicate under number of supervisors as \"10\" and range of percentage of total specified variable income
which the supervisors are entitled to as \"80-90%\")",'italic_text');

// Add table
$table = $section->addTable('myOwnTableStyle');
$w1=2000;
$w2=2000;
$w3=5600;
// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Balanced scorecard grade assigned", 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Number of supervisors", 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Range
of percentage of total specified
variable income which the
supervisors are entitled to under
each grade"
    , 'BoldText','pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Good", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2a_1", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$B2a_1", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Satisfactory", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2a_2", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$B2a_2", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Fair", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2a_3", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$B2a_3", null,'pS_nospaceafter');

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("Unsatisfactory", null,'pS_nospaceafter');
$table->addCell($w2)->addText("$B2a_4", null,'pS_nospaceafter');
$table->addCell($w3)->addText("$B2a_4", null,'pS_nospaceafter');



$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(a) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');

?>