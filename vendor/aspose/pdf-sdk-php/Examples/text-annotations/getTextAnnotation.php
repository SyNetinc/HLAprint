<?php
require __DIR__.'\..\vendor\autoload.php';

use Aspose\PDF\Api\PdfApi;
use Aspose\PDF\Configuration;


$appSid = 'XXXXXXX';
$appKey = 'XXXXXXX';


$tempFolder = null;

$config = new Configuration();
$config->setAppKey($appKey);
$config->setAppSid($appSid);

$pdfApi = new PdfApi(null, $config);
$name = 'PdfWithAnnotations.pdf';
$file = realpath(__DIR__ . '/../') . '/data/' . $name;
$pdfApi->PutCreate($Path=$name, $file); 

$responseAnnotations = $pdfApi->getDocumentTextAnnotations($name, null, $tempFolder);
$annotationId = $responseAnnotations->getAnnotations()->getList()[0]->getId();
$response = $pdfApi->getTextAnnotation($name, $annotationId, null, $tempFolder);

echo $response

?>