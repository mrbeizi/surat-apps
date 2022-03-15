<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use Auth;
use Session;
use Validator;
use DataTables;
use Response;
use App\Exceptions\InvalidOrderException;
use DB;

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
                })->addColumn('checkbox', function($data){
                    return '<input type="checkbox" name="kategori_checkbox" data-id="'.$data->id.'"><label></label>';
                })
                ->rawColumns(['action','checkbox'])
                ->addIndexColumn(true)
                ->make(true);
        }  

        return view('category.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris',
        ],[
            'nama_kategori.required' => 'Anda belum menginputkan nama kategori',
            'nama_kategori.unique' => 'Nama kategori sudah ada'
        ]);

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

    public function deleteAll(Request $request)
    {   

        //return response()->json(count($request->id));

        $g = 0;
        for ($i=0; $i < count($request->id); $i++) { 
            
            $checkTot = DB::table('kategoris')
            ->select('kategoris.nama_kategori')
            ->join('inboxes','kategoris.id','=','inboxes.id_kategori')
            ->where('kategoris.id','=',$request->input('id')[$g])
            ->first();

            $checkTot2 = DB::table('kategoris')
            ->select('kategoris.nama_kategori')
            ->join('inboxes','kategoris.id','=','inboxes.id_kategori')
            ->where('kategoris.id','=',$request->input('id')[$g])
            ->get();

            if (count($checkTot2) == 0) {
                $cek = DB::table('kategoris')->where('kategoris.id', '=', $request->input('id')[$g])->delete();
            }else{
                $cek = 0;
                $tes[] = $checkTot->nama_kategori;
            }

        $g++;
        }

        if (!empty($tes)) {
            if ($cek == 1) {
                return Response::json(array('msg' => 'info'), 200);
            }elseif($cek == 0){
                return Response::json(array('msg' => 'gagal'), 200);
            }else{
                return Response::json(array('msg' => 'gagal'), 200);
            }
        }else{
            return Response::json(array('msg' => 'berhasil'), 200);
        }
    
        return response()->json($tes);

        /*
        ----------------------
         Need Improvement 
        ----------------------
        */
        
        // $id   = $request->id;
        // $post = Kategori::whereIn('id', $id)->delete();
    
        // if ($post) {
        //     return Response::json(array('msg' => 'berhasil'), 200);
        // }else{
        //     return Response::json(array('msg' => 'gagal'), 200);
        // }
               
    }
  
}
