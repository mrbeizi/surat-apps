<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KopSurat;
use App\Kategori;
use Auth;
use Session;
use DataTables;

class KopSuratController extends Controller
{
    public function index(Request $request)
    {
        $list_kop_surat = KopSurat::join('kategoris','kategoris.id','=','kop_surats.id_kategori')
            ->select('kop_surats.*','kategoris.*','kop_surats.id as kop_id','kategoris.id as kategoris_id')
            ->orderBy('kop_surats.id','desc')
            ->get();        
        if($request->ajax()){
            return datatables()->of($list_kop_surat)
            ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->kop_id.'" data-original-title="Edit" class="edit btn btn-outline-success btn-sm edit-post"><i class="fa fa-pen"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->kop_id.'" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }  
        $datas = Kategori::all();
        return view('kop-surat.index', compact('datas'));
    }

    public function store(Request $request)
    {
        $id = $request->id;        
        $post   =   KopSurat::updateOrCreate(['id' => $id],
                    [
                        'id_kategori'   => $request->id_kategori,
                        'logo_surat'    => $request->logo_surat,
                        'judul'         => $request->judul,
                        'alamat'        => $request->alamat,
                        'telp'          => $request->telp,
                        'email'         => $request->email,
                        'fax'           => $request-faxl,
                        'kode_pos'      => $request->password,
                    ]); 

        return response()->json($post);
    }
}
