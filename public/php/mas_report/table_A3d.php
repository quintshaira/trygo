<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 3(d) - Details of successful appeals involving a reassignment from a balanced scorecard grade E to a better grade",'BoldText');

// Add table
$table = $section->addTable('myOwnTableStyle');
$w1 = 1000;
$w2 = 6500;
$w3 = 6500;

// Add row
$table->addRow(5);
// Add cells
$table->addCell($w1)->addText("S/N", 'BoldText','pS_nospaceafter');
$table->addCell($w2)->addText("Name(#7) of representative", 'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Final balanced scorecard grade", 'BoldText','pS_nospaceafter');

//echo '<pre>'; print_r($e_to_better['agent_name']); exit;

if (empty($e_to_better)) {

    for ($i=0; $i<4; $i++) {
        // Add row
        $table->addRow(5);
        // Add cells
        $table->addCell($w1)->addText("$A4c_1", null,'pS_nospaceafter');
        $table->addCell($w2)->addText("$A4c_2", null,'pS_nospaceafter');
        $table->addCell($w3)->addText("$A4c_2", null,'pS_nospaceafter');
    }

} else {

    $num = count($e_to_better['agent_name']);

    for ($i=0; $i<$num; $i++) {
        // Add row
        $table->addRow(5);
        // Add cells
        $table->addCell($w1)->addText($i+1, null,'pS_nospaceafter');
        $table->addCell($w2)->addText($e_to_better['agent_name'][$i], null,'pS_nospaceafter');
        $table->addCell($w3)->addText($e_to_better['grade'][$i], null,'pS_nospaceafter');
    }
}



$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(d) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("NIL", null, 'pS_nospaceafter');

?>