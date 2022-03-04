<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inbox;
use App\Kategori;
use Auth;
use Session;
use DataTables;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $list_inbox = Inbox::join('kategoris','kategoris.id','=','inboxes.id_kategori')
            ->select('inboxes.*','kategoris.*','inboxes.id as inbox_id','kategoris.id as kategoris_id')
            ->orderBy('inboxes.id','desc')
            ->get();        
        if($request->ajax()){
            return datatables()->of($list_inbox)
            ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->inbox_id.'" data-original-title="Edit" class="edit btn btn-outline-success btn-sm edit-post"><i class="fa fa-pen"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->inbox_id.'" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }  
        $datas = Kategori::all();
        return view('inbox.index', compact('datas'));
    }

    public function store(Request $request)
    {
        $id     = $request->id;        
        $post   =   Inbox::updateOrCreate(['id' => $id],
                [
                    'tgl_surat'     => $request->tgl_surat,
                    'title'         => $request->title,
                    'no_surat'      => $request->no_surat,
                    'id_kategori'   => $request->id_kategori,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Inbox::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Inbox::where('id',$id)->delete();     
        return response()->json($post);
    }
}
