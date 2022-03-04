<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use Auth;
use Session;
use DataTables;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $list_kategori = Kategori::all();        
        if($request->ajax()){
            return datatables()->of($list_kategori)
            ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-success btn-sm edit-post"><i class="fa fa-pen"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }  

        return view('category.index');
    }

    public function store(Request $request)
    {
        $id     = $request->id;        
        $post   =   Kategori::updateOrCreate(['id' => $id],
                    [
                        'nama_kategori' => $request->nama_kategori,
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Kategori::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Kategori::where('id',$id)->delete();     
        return response()->json($post);
    }
}
