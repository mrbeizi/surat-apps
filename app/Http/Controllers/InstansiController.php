<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instansi;
use Auth;
use Validator;
use Session;
use Response;
use DataTables;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $datas = Instansi::all();
        if($request->ajax()){
            return datatables()->of($datas)
                ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-success btn-sm edit-post"><i class="fa fa-pen"></i></a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }  
        return view('layouts.instansi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required',
        ],[
            'nama_instansi.required' => 'Anda belum menginputkan nama instansi'
        ]);

        $id     = $request->id;        
        $post   = Instansi::updateOrCreate(['id' => $id],['nama_instansi' => $request->nama_instansi,]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Instansi::where($where)->first();
     
        return response()->json($post);
    }
}
