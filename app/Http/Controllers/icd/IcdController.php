<?php

namespace App\Http\Controllers\icd;
use App\Http\Controllers\Controller;
use App\Icd10;
use Illuminate\Http\Request;

class IcdController extends Controller
{

    public function index()
    {
        return "Hello World";
    }

    public function icdSearch(Request $request){
        $keyword = $request->icd_keyword;

        if(!$keyword)
        return "";

        $icd = Icd10::where("description","like","%$keyword%")->orWhere("code","like","%$keyword%")
            ->paginate(15);

        if($request->pagination_table == 'true') {
            return view("icd.icd_content", ["icd" => $icd, "icd_keyword" => $keyword]);
        }

        return view("icd.icd_search",["icd" => $icd, "icd_keyword" => $keyword]);
    }
}
