<?php
$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Table 4(a) - Number of representatives by balanced scorecard grade",'BoldText');


// Add table
$table = $section->addTable('myOwnTableStyle');

//veriables [width]
$h=50;
$w1=1000;
$w2=3100;
$w3=3300;
$w4=3300;
$w5=3300;

// Add row

$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("",null,'pS_nospaceafter');
$table->addCell($w3+$w4+$w5,array('align' => 'center','gridSpan' => 3))->addText("Number of representatives",'BoldText','pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("Balanced scorecard grade",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("Categories",'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("Does not perform any supervisory role (i.e. Tier1)",'BoldText','pS_nospaceafter');
$table->addCell($w4)->addText("Performs supervisory role as a Tier 2 supervisor",'BoldText','pS_nospaceafter');
$table->addCell($w5)->addText("Performs supervisory role as a Tier 3 supervisor",'BoldText','pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("A",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) No infraction",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_1",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_2",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_3",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("ii) X <5% of cases with Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_4",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_5",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_6",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) One case with Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_7",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_8",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_9",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iv) Satisfies both categories (ii) and (iii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_10",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_11",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_12",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("B",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 5% <= X < 10% of cases
with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_13",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_14",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_15",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Two cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_16",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_17",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_18",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_19",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_20",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_21",null,'pS_nospaceafter');





$table->addRow($h);
$table->addCell($w1)->addText("C",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 10% <= X < 20% of
cases with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_22",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_23",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_24",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Three cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_25",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_26",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_27",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_28",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_29",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_30",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("D",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) 20% <= X < 30% of
cases with Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_31",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_32",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_33",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Four cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_34",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_35",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_36",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_37",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_38",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_39",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("E",'BoldText','pS_nospaceafter'); 
$table->addCell($w2)->addText("i) X >= 30% cases with
Category 2 infractions",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_40",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_41",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_42",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText(""); 
$table->addCell($w2)->addText("ii) Five or more cases with
Category 2 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_43",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_44",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_45",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iii) Satisfies both categories
(i) and (ii)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_46",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_47",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_48",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("iv) One or more cases with
Category 1 infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_49",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_50",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_51",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("v) One or more cases with
Category 1 infraction(s)
and Category 2
infraction(s)",null,'pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_52",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_53",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_54",null,'pS_nospaceafter');


$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("Sub-total",'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_55",null,'pS_nospaceafter');
$table->addCell($w4)->addText("$A4a_56",null,'pS_nospaceafter');
$table->addCell($w5)->addText("$A4a_57",null,'pS_nospaceafter');



$table->addRow($h);
$table->addCell($w1)->addText("",null,'pS_nospaceafter'); 
$table->addCell($w2)->addText("Total number of representatives (#6)",'BoldText','pS_nospaceafter');
$table->addCell($w3)->addText("$A4a_58",null,'pS_nospaceafter');
$table->addCell($w4)->addText("",null,'pS_nospaceafter');
$table->addCell($w5)->addText("",null,'pS_nospaceafter');

$section->addTextBreak();
$section->createTextRun('pS_nospaceafter')->addText("Comments for Table 4(a) (if any)",'BoldText');
$table = $section->addTable('myOwnTableStyle');
$table->addRow($h);
$table->addCell($single_cell_width)->addText("",null,'pS_nospaceafter');


?>