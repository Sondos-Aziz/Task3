<?php

namespace App\Http\Controllers;
use App\Batches;
use App\Beneficiary;
use App\Imports\BatchesImport;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class uploadExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//       $files = ExcelFiles::all();

        return response()->json([
//            'files'=>$files,

        ],200);
    }

    public function excelUpload(Request $request){

        $this->validate($request,[
            'uploadFile' => 'required|mimes:xls,xlsx,csv'
        ]);

        $msg = null;
//        $excelFile = null;
        if($request->hasFile('uploadFile')) {
//            $excelFile = $request->file('uploadFile');
//            $fileName = time() . '.' . $excelFile->getClientOriginalExtension();
//            $location = public_path('files/' . $fileName);
//            Excel::create($excelFile)->save($location);
//
//

            $path = $request->file('uploadFile');
//            $data = Excel::toArray(new Batches(),$path);
            $data = Excel::toArray(new Beneficiary(),$path);


            $batchesArray =array();
            $beneficiaryArray =array();

            if(!empty($data))
            {
                $i =0;
                foreach($data as $k => $v) { // 0 => [4]

                    foreach ($v as $key => $value) {    //0 => [6]
                        if ($i ==0){
                            $i++;
                            continue;
                        }
                        $batches = new Batches();
                        $beneficiary = new Beneficiary();
                        //add the dataExcel to a temporary model
                        $batches->BatchNo = $value[0];
                        $batches->dateOfPayment= \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[5]));
                        $batches->sponsorNo = $value[1];
                        $date = Carbon::now();
                        $batches->created_at=$date->toDateTimeString();
                        $batchesArray [] = $batches;

                        $beneficiary->beneficiaryNo = $value[2];
                        $beneficiary->currency = $value[3];
                        $beneficiary->amount = $value[4];
                        $beneficiary->batch_No = $value[0];
//                        $beneficiaryArray [] = $beneficiary;

                        if ($batches->BatchNo != $value[0]) {
                            $batches->sponsorNo = $value[1];
                            $batches->BatchNo = $value[0];
                            $batches->dateOfPayment= \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value[5]));
                            $batchesArray [] = $batches;

                            $beneficiary->beneficiaryNo = $value[2];
                            $beneficiary->currency = $value[3];
                            $beneficiary->amount = $value[4];
                            $beneficiary->batch_No = $value[0];
                            $beneficiaryArray [] = $beneficiary;

                        } elseif($batches->batchNo == $value[0] and
                            $batches->sponsorNo == $value[1]) {
                            $beneficiary->beneficiaryNo = $value[2];
                            $beneficiary->currency = $value[3];
                            $beneficiary->amount = $value[4];
                            $beneficiary->batch_No = $value[0];
                            $beneficiary->created_at=$date->toDateTimeString();
                            $beneficiaryArray [] = $beneficiary;
//dd('fgggg');
                        } elseif($batches->batchNo == $value[0] and
                            $batches->sponsorNo != $value[1]) {
                            $msg = "تنبيه رقم الكفيل مختلف عن قيمته في ملف الاكسل";
//                            echo $msg;
                        }
                    }
                }

                foreach ($batchesArray as  $value ){

                    DB::table('batches')->insert($value->toArray() );

                }
                foreach ($beneficiaryArray as $value ){
//                    dd('dvxfgr');
                    DB::table('beneficiaries')->insert($value->toArray() );
                }

        }
    }

        return response()->json([
            'sucess' => 'Sucess',
            'msg' => $msg,

        ],200);
    }


}
