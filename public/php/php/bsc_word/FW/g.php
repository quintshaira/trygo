<?php
require_once 'lib/PHPWord.php';





$fname="Textrun";
// Save File
header('Content-Type: application/vnd.ms-word');
header('Content-Disposition: attachment;filename="'.$fname.'.docx"');
header('Cache-Control: max-age=0');
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
//$objWriter->save('Textrun.docx','D');
$objWriter->save('php://output');
?>