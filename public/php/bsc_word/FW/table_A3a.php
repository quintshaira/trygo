<?php
$section->addTextBreak();
$p1=$section->createTextRun('pS_nospaceafter');
$p1->addText("Table 3(a) - Number of representatives based on each balanced scorecard grade
and range of percentage of specified variable income or effective percentage
specified variable income (as the case may be) that the representatives are
entitled to under each grade",'BoldText');
$p1->addText("(e.g. If there are 10 representatives who obtained a balanced scorecard grade of B, and they are entitled to 80 - 90% of
the specified variable income, please indicate under number of representatives as \"10\" and range of percentage of specified variable
income or effective percentage specified variable income as \"80 - 90%\").",'italic_text');
$section->addTextBreak();

// Add table
$table = $section->addTable('myOwnTableStyle');

//veriables [width]
$h=50;
$w1=1000;
$w2=2000;
$w3=1100;
$w4=1100;
$w5=1100;
$w6=1100;
$w7=1100;
$w8=1100;
// Add row

$table->addRow($h);
$table->addCell($w1, array('vMerge' => 'restart'))->addText("Balanced scorecard grade",'BoldText','pS_nospaceafter');
$table->addCell($w2, array('vMerge' => 'restart'))->addText("Categories",'BoldText','pS_nospaceafter');
$table->addCell($w3+$w4,array('gridSpan' => 2))->addText("Does not perform any supervisory role (i.e. Tier 1)",'BoldText','pS_nospaceafter');
$table->addCell($w5+$w6,array('gridSpan' => 2))->addText("Performs supervisory role as a Tier 2 supervisor",'BoldText','pS_nospaceafter');
$table->addCell($w7+$w8,array('gridSpan' => 2))->addText("Performs supervisory role as a Tier 3 supervisor",'BoldText','pS_nospaceafter');






$table->addRow($h);
$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell(null, array('vMerge' => 'continue'));
$table->addCell($w3)->addText("Number of representatives",'BoldText','pS_nospaceafter');
$table->addCell($w4)->addText("Range of percentage of specified variable income or effective percentage specified variable income",'BoldText','pS_nospaceafter');
$table->addCell($w5)->addText("Number of representatives",'BoldText','pS_nospaceafter');
$table->addCell($w6)->addText("Range of percentage of specified variable income or effective percentage specified variable income",'BoldText','pS_nospaceafter');
$table->addCell($w7)->addText("Number of representatives",'BoldText','pS_nospaceafter');
$table->addCell($w8)->addText("Range of percentage of specified variable income or effective percentage specified variable income",'BoldText','pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("A",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) No infraction",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_3",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter');
$table->addCell($w2)->addText("ii) X <5% of cases with Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_4",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_5",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_6",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) One case with Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_7",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_8",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_9",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iv) Satisfies both categories (ii) and (iii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_10",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_11",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_12",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("B",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 5% <= X < 10% of cases
with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_13",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_14",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_15",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Two cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_16",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_17",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_18",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_19",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_20",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_21",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');





$table->addRow($h);
$table->addCell($w1)->addText("C",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 10% <= X < 20% of
cases with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_22",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_23",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_24",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Three cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_25",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_26",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_27",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_28",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_29",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_30",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("D",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 20% <= X < 30% of
cases with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_31",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_32",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_33",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Four cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_34",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_35",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_36",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_37",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_38",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_39",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("E",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) X >= 30% cases with
Category 2 infractions",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_40",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_41",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_42",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Five or more cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_43",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_44",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_45",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_46",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_47",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_48",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iv) One or more cases with
Category 1 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_49",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_50",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_51",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("v) One or more cases with
Category 1 infraction(s)
and Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_52",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A3a_53",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_54",null,'pS_nospaceafter');
$table->addCell($w6)->addText("$A3a_1",null,'pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8)->addText("$A3a_3",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("Sub-total",'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_55",null,'pS_nospaceafter');
$table->addCell($w4)->addText("Sub-total",'BoldText','pS_nospaceafter');
$table->addCell($w5)->addText("$A3a_57",null,'pS_nospaceafter');
$table->addCell($w6)->addText("Sub-total",'BoldText','pS_nospaceafter');
$table->addCell($w7)->addText("$A3a_2",null,'pS_nospaceafter');
$table->addCell($w8, array('bgColor' => $dactivecell_color))->addText("$A3a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("Total number of representatives (#1)",'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("$A3a_58",null,'pS_nospaceafter');
$table->addCell($w4+$w5+$w6+$w7+$w8, array('gridSpan' => 5,'bgColor' => $dactivecell_color))->addText("",null,'pS_nospaceafter');




$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 3(a) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell(9600)->addText("",null,'pS_nospaceafter');

?>