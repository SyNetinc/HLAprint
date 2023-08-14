<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rawilk\Printing\Facades\Printing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use TCPDF;
use App\Models\PrintJobsModel;
use App\Models\Shops;



class HomeController extends Controller
{
    //---------------------------------------------------------------------- Submit Code
    public function arabicSubmitCode(Request $request)
    {
        $code = $request->code;
        $file = '';
        if ($code == 1234) {
            $data['file'] = asset('public/storage/001800.pdf');
            return view('arabic.document')->with($data);
        } else {
            $code_record = DB::table('user_codes')->where('code', $code)->first();
            if ($code_record != null) {
                $record = DB::table('pdf_files')->where('fileName', $code . '.pdf')->first();
                $file = $record->fileLocation;
                $phone = $record->phone;
                DB::table('user_codes')->where('code', $code)->update(['status' => 1]);
                return view('arabic.document', compact('file', 'phone'));
            } else {
                $error = "رمز التحقق غير موجود.";
                return view('arabic.code', compact('user', 'error'));
            }
        }
    }

    public function addTextToPDF($existingPdfPath, $code)
{
    $modifiedPdfPath = $existingPdfPath;
        $textToAdd = $code;

        // Set your Aspose.PDF Cloud API credentials
        $appSid = '2848adbb-e6c5-4263-af56-d50e6fc1b4c0';
        $appKey = '64d49d9eed852f111bdf487813bc627f';

        // Upload the existing PDF file to Aspose.PDF Cloud storage
        $uploadedFileName = $this->uploadFile($appSid, $appKey, $existingPdfPath);
        
        //Adding a New Page at End
        $pageNumber = $this->addPage($appSid, $appKey, $uploadedFileName);
        // Add text to the uploaded PDF file using Aspose.PDF Cloud API
        $this->addText($appSid, $appKey, $uploadedFileName, $textToAdd, $pageNumber);


        // Download the modified PDF file from Aspose.PDF Cloud storage
        $this->downloadFile($appSid, $appKey, $uploadedFileName, $modifiedPdfPath);

       // return response()->download($modifiedPdfPath)->deleteFileAfterSend(true);
}

public function getOptions($code)
{
   
    $code_record = DB::table('user_codes')->where('code', $code)->first();
    if ($code_record != null) {
        $record = DB::table('pdf_files')->where('fileName', $code . '.pdf')->first();
        $file = $record->fileLocation;
        $phone = $record->phone;
        DB::table('user_codes')->where('code', $code)->update(['status' => 1]);
        return view('english.document', compact('file', 'phone'));
    } else {
        $error = "The verification code is incorrect!";
        return view('english.code', compact('error'));
    }

}

private function uploadFile($appSid, $appKey, $filePath)
    {
        $url = 'https://api.aspose.cloud/v3.0/pdf/storage/file/' . basename($filePath);

        $headers = [
            'Authorization: Bearer ' . $this->getToken($appSid, $appKey),
        ];

        $fileData = file_get_contents($filePath);

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $fileData,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);
        

        return json_decode($response, true)['Uploaded'][0];
    }

    public function englishQrCode (request $request)
    {
        if($request->shop)
        {
            $shop = Shops::find($request->shop);
            return view('english.qrCode')->with('shop',$shop);
        }
        else
        {
            $shops = Shops::all();
            return view('english.qrCode')->with('shops',$shops);
        }
    }

    public function shop ($id)
    {
        if($id)
        {
            $shop = Shops::find($id);
            return view('english.qrCode')->with('shop',$shop);
        }
        else{
            return 404;
        }
       
    }

    private function addText($appSid, $appKey, $fileName, $text, $page)
    {

        $headers = [
            'Authorization: Bearer ' . $this->getToken($appSid, $appKey),
            'Content-Type: application/json',
        ];

        $data = '{
            "LeftMargin": 0,
            "RightMargin": 0,
            "TopMargin": 0,
            "BottomMargin": 0,
            "Rectangle": {
                "LLX": 0,
                "LLY": 0,
                "URX": 100,
                "URY": 10
            },
            "Rotation": 0,
            "SubsequentLinesIndent": 0,
            "Lines": [
                {
                    "HorizontalAlignment": "Left",
                    "Segments": [
                        {
                            "Value": "'.$text.'",
                            "TextState": {
                                "FontSize": 12,
                                "ForegroundColor": {
                                    "A": 1,
                                    "R": 250,
                                    "G": 250,
                                    "B": 250
                                },
                                "BackgroundColor": {
                                    "A": 0,
                                    "R": 0,
                                    "G": 0,
                                    "B": 0
                                }
                            }
                        }
                    ]
                }
            ]
        }';
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.aspose.cloud/v3.0/pdf/'.$fileName.'/pages/'.$page.'/text',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        
        $response = curl_exec($curl);
       // dd(json_decode($response, true));

        curl_close($curl);

        
    }

    private function addPage($appSid, $appKey, $fileName)
    {


        $url = 'https://api.aspose.cloud/v3.0/pdf/'.$fileName.'/pages';
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getToken($appSid, $appKey),
        ])->get($url);
        
        $pages = $response->json();
        $pageNumber = $pages['Pages']['List'];
        if(!((count($pageNumber)%2)==0))
        {
            $url = 'https://api.aspose.cloud/v3.0/pdf/'.$fileName.'/pages';
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getToken($appSid, $appKey),
        ])->put($url);
        
        $pages = $response->json();
        $pageNumber = $pages['Pages']['List'];
        }
        return count($pageNumber);
      
    }

    private function downloadFile($appSid, $appKey, $fileName,$savePath)
    {
        $url = 'https://api.aspose.cloud/v3.0/pdf/storage/file/' . $fileName;

        $headers = [
            'Authorization: Bearer ' . $this->getToken($appSid, $appKey),
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);

        file_put_contents($savePath, $response);
    }

    private function getToken($appSid, $appKey)
{
    $url = 'https://api.aspose.cloud/connect/token';

    $postData = [
        'grant_type' => 'client_credentials',
        'client_id' => $appSid,
        'client_secret' => $appKey
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($postData),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        ]
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    curl_close($curl);

    $tokenData = json_decode($response, true);

    return $tokenData['access_token'];
}

    public function englishSubmitCode(Request $request)
    {
        $code = $request->code;
        $file = '';
        if ($code == 1234) {
            $data['file'] = asset('public/storage/001800.pdf');
            return view('english.document')->with($data);
        } elseif($code == 4321)
        {
            $data['file'] = public_path('/storage/001800.pdf');
           return $this->addTextToPDF($data['file'], $code);
            //return view('english.document')->with($data);
        } 
        else{
            $code_record = DB::table('user_codes')->where('code', $code)->first();
            if ($code_record != null) {
                $record = DB::table('pdf_files')->where('fileName', $code . '.pdf')->first();
                $file = $record->fileLocation;
                $phone = $record->phone;
                $fileForCode = public_path('/storage/WhatsApp_Files/'.$phone.'/'.$code . '.pdf');
               // $this->addTextToPDF($fileForCode, $code);
                DB::table('user_codes')->where('code', $code)->update(['status' => 1]);
                return view('english.document', compact('file', 'phone'));
            } else {
                $error = "The verification code is incorrect!";
                return view('english.code', compact('error'));
            }
        }
    }

    //---------------------------------------------------------------------- Submit Document
    public function englishSubmitDocument(Request $request)
    {
        
        $sides = $request->sides=='two'?'long-edge':false;
        $color = $request->color;
        $copies = $request->copies;
        $file =  $request->file;
        $pages = $request->range=="all"?false:true;
        $range = '-';
        $printers = Printing::printers();
        if($pages)
        {
            $from = $request->from;
            $to = $request->to;

            $range = $from.",".$to;
           
        }
        
            return view('english.printer_select',compact('file','printers','sides','color','copies','range'));
        
        
    }
    public function arabicSubmitDocument(Request $request)
    {
        $file =  $request->file;
        $printers = Printing::printers();

        return view('english.printer_select',compact('file','printers'));
        /*  $printers = Printing::printers();

        $counter = 0;
        $printers_array = [];
        $printer_ids = [];
        foreach ($printers as $printer) {
            array_push($printers_array, $printer->name());
            array_push($printer_ids, $printer->id());
        }

        $counter = 0;
        for($i = 0; $i < count($printers_array); $i++){
            foreach($this->printer_name as $printer_name){
                if(stristr($printers_array[$i], $printer_name)){
                    $this->printer_id[$counter] = $printer_ids[$i];
                    $counter++;
                }
            }
        }

       $file =  $request->file;
       $uc = $request->code;

        DB::table('user_codes')->where('code', $uc)->update(['status' => 0]);

      $printJob = Printing::newPrintTask()
            ->printer($this->printer_id[0])
            ->url($file)
            ->send();
        return view("user.pay"); */
    }


    //---------------------------------------------------------------------- Static Pages
    //---------------------------------------------------------------------- Index
    public function index()
    {
        return view('index');
    }

    public function test()
    {
        $model = PrintJobsModel::where('phone','=','923339039585')->where('code','=',3081)->first();
        dd($model->filename);
    }

    //---------------------------------------------------------------------- Share
    public function arabicShare()
    {
        return view('arabic.share');
    }

    public function englishShare()
    {
        return view('english.share');
    }


    //---------------------------------------------------------------------- Code
    public function arabicCode()
    {
        return view('arabic.code');
    }

    public function englishCode()
    {

        return view('english.code');
    }

    //---------------------------------------------------------------------- Document
    public function arabicDocument($file)
    {
        $data['file'] = $file;
        return view('arabic.document')->with($data);
    }

    public function englishDocument()
    {
        return view('english.document');
    }

    //---------------------------------------------------------------------- Processing
    public function arabicProcessing()
    {
        return view('arabic.processing');
    }

    public function englishProcessing()
    {
        return view('english.processing');
    }

    //---------------------------------------------------------------------- Pay
    public function arabicPay()
    {
        return view('arabic.pay');
    }


    public function englishPay()
    {
       $token = $this->generateToken();
       $this->convertImg($token);
    }

    //---------------------------------------------------------------------- Success

    public function arabicSuccess()
    {
        return view('arabic.success');
    }

    public function englishSuccess()
    {
        return view('english.success');
    }
}
