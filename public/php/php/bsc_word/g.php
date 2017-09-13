<?php
require_once 'PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();
$PHPWord->setDefaultFontName('Times New Roman');

// New portrait section
$section = $PHPWord->createSection();

// Add style definitions
$PHPWord->addParagraphStyle('pStyle', array('spaceAfter'=>10));
$PHPWord->addFontStyle('BoldText', array('bold'=>true));
$PHPWord->addFontStyle('ColoredText', array('color'=>'FF8080'));
$PHPWord->addLinkStyle('NLink', array('color'=>'0000FF', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));

// Add text elements
$textrun1 = $section->createTextRun('pStyle');
$textrun2 = $section->createTextRun('pStyle');

$section->addText('Each textrun can contain native text or link elements.');
$section->addText(' ');
//$textrun1->setSpaceAfter();
//new PHPWord_Section_TextBreak();
//$textrun->addTextBreak();

$section->createTextRun('pStyle')->addText(' All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style. All elements are placed inside a paragraph with the optionally given p-Style.', 'ColoredText');
$section->createTextRun('pStyle')->addText(' All elements are placed inside a paragraph with the optionally given p-Style.', 'ColoredText');
$section->createTextRun('pStyle')->addText(' All elements are placed inside a paragraph with the optionally given p-Style.', 'ColoredText');

$section->addText(' No break is placed after adding an element.No break is placed after adding an element. No break isplaced after adding an element. No break is placed after adding an element. ', 'ColoredText');
$section->addText(' All elements are placed inside a paragraph with the optionally given p-Style.', 'ColoredText');
$section->addText(' The best search engine: ');
$section->addTextBreak();
$section->addLink('http://www.google.com', null, 'NLink');
$section->addText('. Also not bad: ');
$section->addLink('http://www.bing.com', null, 'NLink');





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
",null,'pStyle');
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