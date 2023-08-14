<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\UserCodes;
use App\Models\Shops;
use App\Models\ShopPrintRelation;
use App\Models\PrintJobsModel;


class UploadController extends Controller
{
    public function uploadview()
    {
        return view('english.upload');
    }

    public function uploadShop($id)
    {
        $shop = Shops::find($id);
       // dd($shop);
        return view('english.upload')->with('shop', $shop->id);
    }

    public function upload(Request $request)
    {
       // dd($request->shop);
        if($request->hasFile('file') && $request->shop)
        {
            $shop = Shops::find($request->shop);
            $file = $request->file('file');

            $code = rand(1000,9999);

            // Generate a unique name for the file
            $fileName = time() . '_' . $file->getClientOriginalName();

            session()->put('FileName', $fileName);
            session()->put('userCode', $code);
            $phone = "000000000000";
            $uc = new UserCodes();
            $uc->phone = $phone;
            $uc->code = $code;
            $uc->status = false;
            $uc->expiry = date('Y-m-d', strtotime(' +1 day'));
            $uc->save();

            if (!\File::isDirectory('storage/app/public/WhatsApp_Files/'. $phone)) {
                \File::makeDirectory('storage/app/public/WhatsApp_Files/'. $phone, 0755, true, true);
            }

            // Move the uploaded file to a desired location
            $file->move('storage/app/public/WhatsApp_Files/'. $phone, $fileName);


            //file_put_contents(public_path('storage/WhatsApp_Files/' . $phone . '/' . $code . '.pdf'), $response);

            $convert_request = new ConvertController();
            $convert_request->convert($fileName, $phone, $code);
            $print_job = new PrintJobsModel();
            $print_job->phone = $phone;
            $print_job->filename = $fileName;
            $print_job->code = $code;
            $print_job->color = false;
            $print_job->double_sided = false;
            $print_job->pages_start = 0;
            $print_job->page_end = 0;
            $print_job->status = 'Queued';
            $print_job->save();

            $shop_print_relation = new ShopPrintRelation();
            $shop_print_relation->shops_id = $shop->id;
            $shop_print_relation->print_jobs_model_id = $print_job->id;
            $shop_print_relation->save();
            return view('english.code')->with(['code' => $code, 'shopTitle' => $shop->address]);
        }
       elseif ($request->hasFile('file')) {
            $file = $request->file('file');

            $code = rand(1000,9999);

            // Generate a unique name for the file
            $fileName = time() . '_' . $file->getClientOriginalName();

            session()->put('FileName', $fileName);
            session()->put('userCode', $code);
            $phone = "000000000000";
            $uc = new UserCodes();
            $uc->phone = $phone;
            $uc->code = $code;
            $uc->status = false;
            $uc->expiry = date('Y-m-d', strtotime(' +1 day'));
            $uc->save();

            if (!\File::isDirectory('storage/app/public/WhatsApp_Files/'. $phone)) {
                \File::makeDirectory('storage/app/public/WhatsApp_Files/'. $phone, 0755, true, true);
            }

            // Move the uploaded file to a desired location
            $file->move('storage/app/public/WhatsApp_Files/'. $phone, $fileName);


            //file_put_contents(public_path('storage/WhatsApp_Files/' . $phone . '/' . $code . '.pdf'), $response);

            $convert_request = new ConvertController();
            $convert_request->convert($fileName, $phone, $code);
            return view('english.code')->with('code', $code);
        }

        return 'No file was uploaded.';
    }
}
