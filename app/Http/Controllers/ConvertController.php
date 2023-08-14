<?php

namespace App\Http\Controllers;

use Session;
use Aspose\Words\WordsApi;
use App\Models\PdfFilesModel;
use Illuminate\Support\Facades\Storage;
use Aspose\Words\Model\Requests\{ConvertDocumentRequest};
//use File;
use Aspose\Slides\Cloud\Sdk\Api\Configuration;
use Aspose\Slides\Cloud\Sdk\Api\SlidesApi;
use Aspose\Slides\Cloud\Sdk\Model\ExportFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ConvertController extends Controller
{
    public $data = [];
    public $pdfApi;

    public function test(){
        $file = asset('public/storage/001800.pdf');
        $phone = "0000000";
        return view('english.document', compact('file', 'phone'));
    }
    public function convert($file, $phone, $code)
    {

        $extension = explode('.', $file)[1];


        if($extension == 'pdf'){
            if (!File::isDirectory(public_path('/storage/WhatsApp_Files/' . $phone))) {
                File::makeDirectory(public_path('/storage/WhatsApp_Files/' . $phone), 0755, true, true);
            }
            //$file->move("storage/app/public/WhatsApp_Files/" . $phone, $fileName);
            $sourcePath = Storage::path('public/WhatsApp_Files/' . $phone.'/'.$file);
            $destinationPath = public_path('storage/WhatsApp_Files/' . $phone . '/' .$code.'.pdf');
            $destinationxPath = asset('public/storage/WhatsApp_Files/' . $phone . '/' .$code.'.pdf');
            // Copy the file
            File::move($sourcePath, $destinationPath);

            $pdf = new PdfFilesModel;
            $pdf->phone = $phone;
            $pdf->fileName = $code . '.pdf';
            $pdf->fileLocation = $destinationxPath;
            $pdf->status = 0;
            $pdf->save();

            // $addText = new HomeController();
            // $fileForCode = public_path('/storage/WhatsApp_Files/'.$phone.'/'.$code . '.pdf');
            // $addText->addTextToPDF($fileForCode, $code);

          /*   $data['source'] = $sourcePath;
            $data['destination'] = $destinationPath;
            $data['destinationx'] = $destinationxPath;
            $data['code'] = $code;
            $data['file'] = $file;
            $data['phone'] = $phone; */

        }else if ($extension == 'ppt' || $extension == 'pptx' ) {
            $this->powerpointToPDF($file, $phone, $code);
        }else if ($extension == 'doc' || $extension == 'docx'){
            $this->wordToPDF( $file, $phone, $code);
        }else if ($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv' || $extension == 'ods' ){
            $tkn = $this->generateToken();
            $this->excelToPDF($tkn, $file, $phone, $code);
        }else if ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' ){
            $tkn = $this->generateToken();
            $this->imageToPDF($tkn, $file, $phone, $code);
        }
    }

    public function convertToPdf()
    {
        $clientId = '2848adbb-e6c5-4263-af56-d50e6fc1b4c0';
        $secret = '64d49d9eed852f111bdf487813bc627f';
        $wordsApi = new WordsApi($clientId, $secret);

        if (Session::has('FileName')) {
            $fileName = Session::get('FileName');
            $wordFile = public_path('uploads/' . $fileName);
        }

        // $requestDocument = public_path('input.doc');
        $requestDocument = $wordFile;

        $outputFileName = 'outputFile.pdf';

        $convertRequest = new ConvertDocumentRequest(
            $requestDocument,
            "pdf",
            NULL,
            NULL,
            NULL,
            NULL,
            NULL,
            NULL,
            NULL
        );

        try {
            // Convert the document
            $response = $wordsApi->convertDocument($convertRequest);

            // Retrieve the converted document content
            $fileContent = file_get_contents($response->getPathname());

            // Save the content to a file
            file_put_contents(public_path($outputFileName), $fileContent);

            $path = public_path($outputFileName);
            return response()->download($path);

            // ... rest of the code ...
        } catch (\Exception $e) {
            // Handle the error case
            // Display an error message or perform appropriate error handling
            $error = $e->getMessage();
        }
    }

    public function wordToPDF($fileName, $phone, $code)
    {
        $this->data['fileLocation'] = "storage/app/public/WhatsApp_Files/" . $phone;
        $this->data['fileName'] = $fileName;
        $clientId = '2848adbb-e6c5-4263-af56-d50e6fc1b4c0';
        $secret = '64d49d9eed852f111bdf487813bc627f';
        $wordsApi = new WordsApi($clientId, $secret);

        $this->data['requestDocument'] = $this->data['fileLocation'] . '/' . $this->data['fileName'];
        $this->data['outputFileName'] = $code;      //explode('_', $this->data['fileName'])[4];
        $convertRequest = new ConvertDocumentRequest(
            $this->data['requestDocument'],
            "pdf",
            NULL,
            NULL,
            NULL,
            NULL,
            NULL,
            NULL,
            NULL
        );
        try {
            $response = $wordsApi->convertDocument($convertRequest);
            $fileContent = file_get_contents($response->getPathname());
            if (!File::isDirectory(public_path('/storage/WhatsApp_Files/' . explode('/', $this->data['fileLocation'])[4]))) {
                File::makeDirectory(public_path('/storage/WhatsApp_Files/' . explode('/', $this->data['fileLocation'])[4]), 0777, true, true);
            }
            file_put_contents(public_path('/storage/WhatsApp_Files/' . explode('/', $this->data['fileLocation'])[4] . '/' . $this->data['outputFileName'] . '.pdf'), $fileContent);
            $this->data['file'] = public_path($this->data['fileLocation'] . '/' . $this->data['outputFileName'] . '.pdf');

            $this->data['public_path'] = public_path('/storage/WhatsApp_Files/' . explode('/', $this->data['fileLocation'])[4] . '/' . $this->data['outputFileName'] . '.pdf');
            $this->data['public_path'] = array_slice(explode('/', $this->data['public_path']), 5);
            $this->data['public_path'] = implode('/', $this->data['public_path']);
            $this->data['public_path'] = url($this->data['public_path']);

            $pdf = new PdfFilesModel;
            $pdf->phone = $phone;
            $pdf->fileName = $this->data['outputFileName'] . '.pdf';
            $pdf->fileLocation = asset("public/storage/WhatsApp_Files/$phone/$code.pdf");
            $pdf->status = 0;
            $pdf->save();

            $addText = new HomeController();
            $fileForCode = public_path('/storage/WhatsApp_Files/'.$phone.'/'.$code . '.pdf');
            $addText->addTextToPDF($fileForCode, $code);

            $print_request = new PrintRequestsController();
            //$print_request->print($this->data['public_path']);

        } catch (\Exception $e) {
            $error = $e;
            Storage::disk('public')->put('error.txt', $error);
        }

    }

    function excelToPDF($tkn, $file, $phone, $code)
    {

        $url = 'https://api.aspose.cloud/v3.0/cells/convert?format=pdf';
        $headers = array(
            'accept: multipart/form-data',
            'Content-Type: multipart/form-data',
            'Authorization: Bearer ' . $tkn
        );

        $data = array(
            'File' => new \CURLFile("storage/app/public/WhatsApp_Files/" . $phone.'/'.$file)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            if (!File::isDirectory(public_path('/storage/WhatsApp_Files/' . $phone))) {
                File::makeDirectory(public_path('/storage/WhatsApp_Files/' . $phone), 0755, true, true);
            }
            file_put_contents(public_path('storage/WhatsApp_Files/' . $phone . '/' . $code . '.pdf'), $response);
            $pdf = new PdfFilesModel;
            $pdf->phone = $phone;
            $pdf->fileName = $code . '.pdf';
            $pdf->fileLocation = asset("public/storage/WhatsApp_Files/$phone/$code.pdf");
            $pdf->status = 0;
            $pdf->save();

            $addText = new HomeController();
            $fileForCode = public_path('/storage/WhatsApp_Files/'.$phone.'/'.$code . '.pdf');
            $addText->addTextToPDF($fileForCode, $code);
        }
    }

    public function imageToPDF($token, $file, $phone, $code)
    {

        $url = 'https://api.aspose.cloud/v3.0/imaging/convert?format=pdf';
        $headers = array(
            'accept: multipart/form-data',
            'Content-Type: multipart/form-data',
            'Authorization: Bearer ' . $token
        );

        $data = array(
            'File' => new \CURLFile("storage/app/public/WhatsApp_Files/" . $phone . "/" . $file,)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            if (!File::isDirectory(public_path('/storage/WhatsApp_Files/' . $phone))) {
                File::makeDirectory(public_path('/storage/WhatsApp_Files/' . $phone), 0755, true, true);
            }
            file_put_contents(public_path('storage/WhatsApp_Files/' . $phone . '/' . $code . '.pdf'), $response);
            $pdf = new PdfFilesModel;
            $pdf->phone = $phone;
            $pdf->fileName = $code . '.pdf';
            $pdf->fileLocation = asset("public/storage/WhatsApp_Files/$phone/$code.pdf");
            $pdf->status = 0;
            $pdf->save();

            $addText = new HomeController();
            $fileForCode = public_path('/storage/WhatsApp_Files/'.$phone.'/'.$code . '.pdf');
            $addText->addTextToPDF($fileForCode, $code);
        }
    }

    public function powerpointToPDF($file, $phone, $code)
    {

        $config = new Configuration();
        $config->setAppSid("2848adbb-e6c5-4263-af56-d50e6fc1b4c0");
        $config->setAppKey("64d49d9eed852f111bdf487813bc627f");
        //$config->setTempFolderPath(asset('public/storage/'));
        $api = new SlidesApi(null, $config);

        $result = $api->Convert(fopen("storage/app/public/WhatsApp_Files/" . $phone . "/" . $file, 'r'), ExportFormat::PDF);
        if (!File::isDirectory(public_path('/storage/WhatsApp_Files/' . $phone))) {
            File::makeDirectory(public_path('/storage/WhatsApp_Files/' . $phone), 0755, true, true);
        }
        file_put_contents(public_path('storage/WhatsApp_Files/' . $phone . '/' . $code . '.pdf'), $result->fread($result->getSize()));
        $pdf = new PdfFilesModel;
            $pdf->phone = $phone;
            $pdf->fileName = $code . '.pdf';
            $pdf->fileLocation = asset("public/storage/WhatsApp_Files/$phone/$code.pdf");
            $pdf->status = 0;
            $pdf->save();
            $addText = new HomeController();
            $fileForCode = public_path('/storage/WhatsApp_Files/'.$phone.'/'.$code . '.pdf');
            $addText->addTextToPDF($fileForCode, $code);
    }

    //---------------------------------------------------------------------- Convert
    public function convertx(Request $request, $phone, $filename)
    {
        $request->session()->put('phone', $phone);
        $request->session()->put('filename', $filename);
        return view('arabic.convert');
    }

    //---------------------------------------------------------------------- Save PDF
    public function save_pdf(Request $request)
    {
        $file = $request->file('file');
        $file->move(public_path('storage/WhatsApp_Files/') . session('phone') . '/', $file->getClientOriginalName());
        return response()->json(['success' => true]);
    }

    public function page()
    {
        $data['greyScale'] = 10;
        $data['color'] = 15;
        $data['oneSide'] = 10;
        $data['twoSide'] = 15;
        $data['allPages'] = 10;
        $data['perCopy'] = 10;
        $data['total'] = 10;
        dd($data);
        return view('english.document')->with($data);
    }

    function generateToken()
    {
        $url = 'https://api.aspose.cloud/connect/token';
        $data = 'grant_type=client_credentials&client_id=2848adbb-e6c5-4263-af56-d50e6fc1b4c0&client_secret=64d49d9eed852f111bdf487813bc627f';
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);
        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
            return false;
        } else {
            $json = json_decode($response);
            $accessToken = $json->access_token;
            return $accessToken;
        }
    }
}
