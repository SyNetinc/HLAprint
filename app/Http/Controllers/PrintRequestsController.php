<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Rawilk\Printing\Facades\Printing;



class PrintRequestsController extends Controller
{
    public $printer_name = ['360'];
    public $printer_id = [0];
    public $data = [];

    public function print_request(Request $request)
    {
        echo "<pre>";
        print_r($request->all());
        return view('dashboard')->with('request', $request);
    }

    public function selectPrinter(Request $request)

    {      
        $copies = $request->copies;  
          $sides = $request->sides;
          $color = $request->color?true:false;
          $range = $request->range;
    
          if($sides)
          {
            $printJob = Printing::newPrintTask()
                ->printer($request->printer)
                ->url($request->file)
                ->option('duplex',$sides)
                ->option('color',$color)
                ->option('pages',$range)
                ->copies($copies)
                ->send();
          }
          else {
            $printJob = Printing::newPrintTask()
                ->printer($request->printer)
                ->url($request->file)
                ->option('color',$color)
                ->option('pages',$range)
                ->copies($copies)
                ->send();
          }
          echo "<pre>";
          print_r($printJob);
          echo "</pre>";
    }

   
    public function getPrinters()
    {

    }
    public function print($file){
        $printers = Printing::printers();
        $counter = 0;
        $printers_array = [];
        $printer_ids = [];
        foreach ($printers as $printer) {
            array_push($printers_array, $printer->name());
            array_push($printer_ids, $printer->id());
            echo "<pre>";
            print_r($printer);
            echo "</pre>";
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

        foreach ($this->printer_id as $printer_id) {
            echo $printer_id;
            echo "<br>";
        }

        $copies = 1;
        return view('english.printer_select', compact('file','printers'));

    //   $printJob = Printing::newPrintTask()
    //         ->printer($this->printer_id[0])
    //         ->url($file)
    //         ->copies($copies)
    //         ->send();
    //     $status = $printJob;


    }

}
