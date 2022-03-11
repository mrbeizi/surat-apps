<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\KopSurat;
use App\Kategori;
use Validator;
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
            ->addColumn('view_logo', function($data){
                $button = '<button type="button" name="view" id="'.$data->kop_id.'" class="view btn btn-outline-primary btn-sm"><a href="'.asset('/images/uploads/'.$data->logo_surat.'').'" target="_blank"><img height="25px;" src="'.asset('/images/uploads/'.$data->logo_surat.'').'" /> <i class="fa fa-eye"></i> View</a></button>';
                return $button;                                                        
            })->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->kop_id.'" data-original-title="Edit" class="edit btn btn-outline-success btn-sm edit-post"><i class="fa fa-pen"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->kop_id.'" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>';
                return $button;
            })
            ->rawColumns(['view_logo','action'])
            ->addIndexColumn(true)
            ->make(true);
        }  
        $datas = Kategori::all();
        return view('kop-surat.index', compact('datas'));
    }

    public function store(Request $request)
    {    
        $request->validate([
            'logo_surat' => 'required|mimes:jpeg,bmp,png',
            'judul'      => 'required',
            'alamat'     => 'required',
            'telp'       => 'required',
            'email'      => 'required|email|unique:kop_surats',
            'fax'        => 'required',
        ],[
            'logo_surat.required' => 'Anda belum mengunggah gambar',
            'logo_surat.mimes'    => 'file harus berekstensi .jpg .jpeg .bmp .png',
            'judul.required'      => 'Anda belum menginputkan judul surat',
            'alamat.required'     => 'Anda belum menginputkan alamat',
            'telp.required'       => 'Anda belum menginputkan telp',
            'email.required'      => 'Anda belum menginputkan email',
            'email.unique'        => 'Email Anda sudah terdaftar',
            'fax.required'        => 'Anda belum menginputkan nomor fax'
        ]);

        $id = $request->id;
        if($request->has('logo_surat'))
        {
            $image   = $request->file('logo_surat');
            $reImage = time().'.'.$image->getClientOriginalExtension();
            $dest    = public_path('/images/uploads');
            $image->move($dest,$reImage);
            
            // save Data
            $post = KopSurat::updateOrCreate(['id' => $id],
                [
                    'id_kategori'   => $request->id_kategori,
                    'logo_surat'    => $reImage,
                    'judul'         => $request->judul,
                    'alamat'        => $request->alamat,
                    'telp'          => $request->telp,
                    'email'         => $request->email,
                    'fax'           => $request->fax,
                    'kode_pos'      => $request->kode_pos,
                ]); 

                return response()->json($post);
            
        }         
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = KopSurat::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = KopSurat::where('id',$id)->delete();     
        return response()->json($post);
    }
}
