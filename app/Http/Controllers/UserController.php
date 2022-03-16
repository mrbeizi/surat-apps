<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $list_user = User::all();        
        if($request->ajax()){
            return datatables()->of($list_user)
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

        return view('user.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;        
        $post   =   User::updateOrCreate(['id' => $id],
                    [
                        'name'      => $request->name,
                        'email'     => $request->email,
                        'level'     => $request->level,
                        'password'  => bcrypt($request->password),
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = User::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        if(Auth::user()->id != $id){
            $post = User::where('id',$id)->delete();     
        } else {
            Session::flash('message', 'Akun anda sendiri tidak bisa dihapus!');
            Session::flash('message_type', 'danger');
        }
        return response()->json($post);
    }

}
