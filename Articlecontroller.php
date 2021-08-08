<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\articlemodel;
use App\reportmodel;
use App\User;
use Session;
use DB;
use Importer;
use Excel;
use Cookie;
use Carbon\Carbon;

class Articlecontroller extends Controller
{
    public function article(){
        $time = strtotime(date("Y/m/d"));
        $final = date("Y-m-d", strtotime("-1 month", $time));
        echo $final;
    	$all4 = DB::table('users')->select(

    		DB::raw('country as country'),
    		DB::raw('count(*) as number'))->groupBy('country')->get();

    	$array[] = ['Country', 'Number'];
    	foreach ($all4 as $key => $value) {
    		
    		$array[++$key] = [$value->country, $value->number];
    	}


    	$type = DB::table('users')->select(

    		DB::raw('user_type as user_type'),
    		DB::raw('count(*) as number'))->groupBy('user_type')->get();

    	$array1[] = ['User Type', 'Number'];
    	foreach ($type as $key => $value) {
    		
    		$array1[++$key] = [$value->user_type, $value->number];
    	}

    	$subtype = DB::table('users')->select(

    		DB::raw('sub_user_type as sub_user_type'),
    		DB::raw('count(*) as number'))->groupBy('sub_user_type')->get();

    	$array2[] = ['SubUser Type', 'Number'];
    	foreach ($subtype as $key => $value) {
    		
    		$array2[++$key] = [$value->sub_user_type, $value->number];
    	}

        $countries = User::select('country as country')->groupBy('country')->get()->toArray();

        $user_type = User::select('user_type as user_type')->groupBy('user_type')->get()->toArray();

        $sub_user_type = User::select('sub_user_type as sub_user_type')->groupBy('sub_user_type')->get()->toArray();
     //    echo "<pre>";
    	// print_r($countries);die();
    	return view('welcome')->with('all',json_encode($array))->with('type1',json_encode($array1))->with('sub_type',json_encode($array2))->with('countries',$countries)->with('user_type',$user_type)->with('sub_user_type',$sub_user_type);;
    }

    public function article_save(Request $request){
    	$file = $request->file('file1');
    	$filename =  $file->getClientOriginalName();
    	$save = public_path($filename);
    	// $excel = Importer::make('Excel');
    	$data1 = Excel::import($save,$file);
    	// $set = 10;
    	// $excel->setSheet($set);
    	$data = $data1->toArray($save,$file);
    	// echo "<pre>";
    	// print_r($data);die;
    	$ar = array();
    	foreach ($data as $key => $all) {
    		foreach ($all as $key1 => $all1) {
    			$csv_data = new User;
                print_r($all1[8]);
		        $csv_data->fname = $all1[0];
		        $csv_data->lname = $all1[1];
		        $csv_data->phone = $all1[2];
		        $csv_data->country = $all1[3];
		        $csv_data->user_type = $all1[4];
                $csv_data->date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($all1[8]));
		        $csv_data->sub_user_type = $all1[5];
		        $csv_data->email = $all1[6];
		        $ar[$key] = $all;
                // echo "<pre>";
                // print_r($csv_data);die();
		         $csv_data->save();
		       
		       $all4 = DB::table('users')->select('*')->get()->toArray();
		       foreach ($all4 as $key3 => $value) {
    		       	$report = new reportmodel;
                    $report->user_id = $value->id;
                    $report->performance = $all1[7];
                    $report->save();
		       }
    		}	
    	} 


		return redirect()->back()->with('message', 'Inserted Successfully');
    }


    public function chart_data(Request $request){

            Cookie::queue('country', $request->country, 1);
            Cookie::queue('user_type', $request->user_type, 1);
            Cookie::queue('sub_user_type', $request->sub_user_type, 1);
             $day = "";
             $time = "";
             $final = "";
            // print_r($request->radio);die();
            if($request->radio == "1month"){
                $day = date('Y-m-d');
                $time = strtotime(date("Y-m-d"));
                $final = date("Y-m-d", strtotime("-1 month", $time));
                }elseif ($request->radio == "3month") {
                    $day = date('Y-m-d');
                        $time = strtotime(date("Y-m-d"));
                        $final = date("Y-m-d", strtotime("-3 month", $time));
                }elseif ($request->radio == "6month") {
                    $day = date('Y-m-d');
                        $time = strtotime(date("Y-m-d"));
                        $final = date("Y-m-d", strtotime("-6 month", $time));
                }else{
                    $day = date('Y-m-d');
                        $time = strtotime(date("Y-m-d"));
                        $final = date("Y-m-d", strtotime("-12 month", $time));
            }
        $dat = DB::table('users')->select(
            DB::raw('country as country'),
            DB::raw('user_type as user_type'),
            DB::raw('sub_user_type as sub_user_type'),
            DB::raw('date as date'),
            DB::raw('count(*) as number'))->where('date', '>=', $final)->where('date', '<=', $day)->where('country',$request->country)->where('user_type',$request->user_type)->where('sub_user_type',$request->sub_user_type)->groupBy('sub_user_type')->groupBy('country')->groupBy('user_type')->groupBy('date')->get()->toArray();
        // print_r($dat);die();
        // $array2[] = ["Element", "Density" ];
        $output[] = array();
        foreach ($dat as $key => $value) {
            
            $output[++$key] = array(
               'country'   => $value->country,
               'number'  => floatval($value->number),
               'user_type'   => $value->user_type,
               'sub_user_type'   => $value->sub_user_type,
               'date'   => $value->date
            );
        }

        // return response()->json(['users' => $dat], 200);
        echo json_encode($output);
        // print_r($dat);
    }

    public function mapdata(Request $request){

        $all="";
        if($request->better != ""){
            $all = reportmodel::with(['reports'])->where('performance',$request->better)->get()->toArray();
        }
        if($request->same != ""){
            $all = reportmodel::with(['reports'])->where('performance',$request->same)->get()->toArray();
        }

        if($request->worse != ""){
            $all = reportmodel::with(['reports'])->where('performance',$request->worse)->get()->toArray();
        }

        return back()->with('all',json_encode($all));
        // echo "<pre>";
        // print_r($all);die();
    }
}
