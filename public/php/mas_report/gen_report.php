<?php
include("connection.php");
include("comm_func.php");
require_once 'lib/PHPWord.php';

$MQ_ID=$_GET['MQ_id'];
//exit;
if($MQ_ID)
{
    $gen_sql = "select * from bsc_measurement_quarter where measurement_quarter_id=$MQ_ID";
    $gen_row = mysql_fetch_assoc(mysql_query($gen_sql));
    $dats_arr = Get_quarter_dates($gen_row['year'], $gen_row['quarter']);

    //extract($rrow);
}


if($_GET['row_id'])
{
    $sql1="select * from report_dummy where id=".$_GET['row_id'];
    //$rrow=mysql_fetch_assoc(mysql_query($sql1));
    //extract($rrow);
}

$qu_start_date = convertDateInDBFormat($dats_arr['sd'], '/', 'dmy');
$qu_end_date = convertDateInDBFormat($dats_arr['nd'], '/', 'dmy');


$fname = "MAS Report - Q" . $gen_row['quarter'] . '_' . $gen_row['year'];


// New Word Document
$PHPWord = new PHPWord();
$PHPWord->setDefaultFontName('Times New Roman');
$PHPWord->setDefaultFontSize(12);

// style section

// paragraph style

$PHPWord->addParagraphStyle('pS_nospaceafter', array('spaceAfter'=>10));
$PHPWord->addParagraphStyle('pS_nospaceafter_centre', array('spaceAfter'=>10,'align' => 'center','align' => 'center'));
$PHPWord->addParagraphStyle('pStyle', array('spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0, 'align' => 'both'));

//font style

$PHPWord->addFontStyle('BoldText', array('bold'=>true));
$PHPWord->addFontStyle('BoldText', array('bold'=>true));
$PHPWord->addFontStyle('italic_text', array('italic'=>true));
$PHPWord->addFontStyle('ColoredText', array('color'=>'FF8080'));
$PHPWord->addLinkStyle('NLink', array('color'=>'0000FF', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));
// Define table style arrays
$styleTable = array('borderSize'=>6, 'borderColor'=>'000', 'cellMargin'=>80);
//$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF');

// Define cell style arrays
$styleCell = array('valign'=>'center');
$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);





$dactivecell_color='AAAAAA';




// New portrait section
//$section = $PHPWord->createSection(array('orientation'=>'portrait','marginLeft'=>1500, 'marginRight'=>1000, 'marginTop'=>1500, 'marginBottom'=>1000));
$section = $PHPWord->createSection(array('orientation'=>'landscape','marginLeft'=>1500, 'marginRight'=>1500, 'marginTop'=>1250, 'marginBottom'=>1250));

// Add style definitions


$single_cell_width = 14000;



/**/
$section->createTextRun('pS_nospaceafter')->addText("NAME OF FINANCIAL ADVISER:  LEGACY ASIA",'BoldText');
$section->createTextRun('pS_nospaceafter')->addText("REPORT FOR MEASUREMENT QUARTER  FROM: ".$dats_arr['sd']." to ".$dats_arr['nd']." ",'BoldText');


$section->addTextBreak(2);
$section->createTextRun('pS_nospaceafter')->addText("SECTION A: FOR REPRESENTATIVES",'BoldText');
include('table_A1.php');
include('table_A2a.php');
include('table_A2b.php');
$section->addTextBreak(2);
$section->createTextRun('pS_nospaceafter')->addText("Tables 3(a), (b), (c), (d), and (e) are only applicable to representatives who are remunerated by way of variable income, whether wholly or partly",'BoldText');
include('table_A3a.php');
include('table_A3b.php');
include('table_A3c1.php');
include('table_A3c2.php');
include('table_A3d.php');
include('table_A3e.php');
$section->addTextBreak(2);
$section->createTextRun('pS_nospaceafter')->addText("Tables 4(a), (b), (c) and (d) are only applicable to representatives who are not remunerated by way of any variable income",'BoldText');
include('table_A4a.php');
include('table_A4b1.php');
include('table_A4b2.php');
include('table_A4c.php');
include('table_A4d.php');
$section->addPageBreak();
$section->createTextRun('pS_nospaceafter')->addText("SECTION B: FOR SUPERVISORS",'BoldText');
include('table_B1.php');
include('table_B2.php');
include('table_B3a.php');
include('table_B3b.php');
include('table_B3c1.php');
include('table_B3c2.php');
$section->addPageBreak();
$section->createTextRun('pS_nospaceafter')->addText("SECTION C: GENERAL",'BoldText');
include('table_C1.php');
include('table_C2.php');
include('table_C3.php');
include('table_C4.php');


// Save File
header('Content-Type: application/vnd.ms-word');
header('Content-Disposition: attachment;filename="' . $fname . '.docx"');
header('Cache-Control: max-age=0');
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
//$objWriter->save('Textrun.docx','D');
$objWriter->save('php://output');
?>