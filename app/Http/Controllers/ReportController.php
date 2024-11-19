<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function user($user_id)
    {
        $right = Response::where("user_id",$user_id)->where("status",1)->count();
        $wrong = Response::where("user_id",$user_id)->where("status",0)->count();
        $attempt = Response::where("user_id",$user_id)->get();
        foreach ($attempt as $rows) {
            $rows->question;
            $rows->question->item;
            $rows->item;
        }
        $data = [
            "right"=>$right,
            "wrong"=>$wrong,
            "attempt"=>$attempt
        ];

        return response()->json($data);
    }
}
