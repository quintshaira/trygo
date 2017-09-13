<?php
require_once 'lib/PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();
$PHPWord->setDefaultFontName('Times New Roman');
$PHPWord->setDefaultFontSize(12);

// style section

// paragraph style

$PHPWord->addParagraphStyle('pS_nospaceafter', array('spaceAfter'=>10));
$PHPWord->addParagraphStyle('pStyle', array('spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0, 'align' => 'both'));

//font style

$PHPWord->addFontStyle('BoldText', array('bold'=>true));
$PHPWord->addFontStyle('ColoredText', array('color'=>'FF8080'));
$PHPWord->addLinkStyle('NLink', array('color'=>'0000FF', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));








// New portrait section
$section = $PHPWord->createSection(array('orientation'=>'portrait','marginLeft'=>1500, 'marginRight'=>1000, 'marginTop'=>1500, 'marginBottom'=>1000));
// Add style definitions





//$section->createTextRun('pS_nospaceafter')->addText("REPORT FOR MEASUREMENT QUARTER  FROM:______to_______",'BoldText');
//$section->addTextBreak();
//$section->createTextRun('pS_nospaceafter')->addText("SECTION A: FOR REPRESENTATIVES",'BoldText');
//$section->createTextRun('pS_nospaceafter')->addText("Table 1 : Number of representatives",'BoldText');




include('table_C2.php');





$fname="Textrun";
// Save File
header('Content-Type: application/vnd.ms-word');
header('Content-Disposition: attachment;filename="'.$fname.'.docx"');
header('Cache-Control: max-age=0');
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
//$objWriter->save('Textrun.docx','D');
$objWriter->save('php://output');
?>