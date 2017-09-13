<?php
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();
$PHPWord->setDefaultFontName('Times New Roman');
$PHPWord->setDefaultFontSize('12');

//$PHPWord->addParagraphStyle('pStyle', array('align' => 'center', 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0))

// New portrait section
$section = $PHPWord->createSection(array('orientation'=>'portrait','marginLeft'=>2000, 'marginRight'=>600, 'marginTop'=>2000, 'marginBottom'=>600));

// Add style definitions
//$PHPWord->addFontStyle('BoldText', array('name'=>'Tahoma', 'size'=>27, 'bold'=>true));

$PHPWord->addParagraphStyle('pStyle', array('spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0, 'align' => 'both'));
//$PHPWord->addFontStyle('BoldText', array('bold'=>true));
//$PHPWord->addFontStyle('ColoredText', array('color'=>'FF8080'));

$textrun = $section->createTextRun('pStyle');

//$textrun->addText('Each textrun can contain native text or link elements.');

//$fontStyle = array('bold'=>true, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0, 'margin'=>0);

// Add text elements

$textrun->addText('NAME OF FINANCIAL ADVISER:\n  ',$fontStyle);
$section->addTextBreak();
$textrun->addText('REPORT FOR MEASUREMENT QUARTER  FROM:______to_______',$fontStyle);

$textrun->addText('Each textrun can contain native text or link elements.');
$textrun->addText(' No break is placed after adding an element.', 'BoldText');
$textrun->addText(' All elements are placed inside a paragraph with the optionally given p-Style.', 'ColoredText');
$textrun->addText(' The best search engine: ');
$textrun->addLink('http://www.google.com', null, 'NLink');
$textrun->addText('. Also not bad: ');
$textrun->addLink('http://www.bing.com', null, 'NLink');


$text = "foo\nbar\nfoobar";
$textlines = explode("\n", $text);

$textrun = $section->addTextRun();
$textrun->addText(array_shift($textlines));
foreach($textlines as $line) {
    $textrun->addTextBreak();
    // maybe twice if you want to seperate the text
    // $textrun->addTextBreak(2);
    $textrun->addText($line);
}










// Define table style arrays
$styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');

// Define cell style arrays
$styleCell = array('valign'=>'center');
$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

// Add table
$table = $section->addTable('myOwnTableStyle');

// Add row
$table->addRow(900);

// Add cells
$table->addCell(8000, $styleCell)->addText('Row 1', $fontStyle);
$table->addCell(1300, $styleCell)->addText('Row 2', $fontStyle);

// Add more rows / cells

	$table->addRow(900);
	$table->addCell(8000)->addText("representative ceases to provide financial advisory services during the measurement quarter and where the financial adviser has assessed and documented its assessment in writing that it is not possible for the financial  adviser  to  comply  with  paragraphs  4.1(i)   to
(viii) of the Notice, in respect of that  representative
");
	$table->addCell(1300)->addText("Cell");  
	
	$table->addRow(900);
	$table->addCell(8000)->addText("represenng the measurement quarter\n and where the financial adviser has assessed and documented its assessment in writing that it is not possible for the financial  adviser  to  comply  with  paragraphs  4.1(i)   to
(viii) of the Notice, in respect of that  representative
");
	$table->addCell(1300)->addText("Cell");  

















$fname="Textrun";
// Save File
header('Content-Type: application/vnd.ms-word');
header('Content-Disposition: attachment;filename="'.$fname.'.docx"');
header('Cache-Control: max-age=0');
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
//$objWriter->save('Textrun.docx','D');
$objWriter->save('php://output');
?>