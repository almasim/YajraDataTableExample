<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','name','email','birth_date','title')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                        // Delete Button
                        $editButton = "<a class='btn btn-sm btn-info mb-1 updateUser' data-id='".$row->id."'>Edit</a>";
                        
                        $deleteButton = "<a class='btn btn-sm btn-danger mb-1 deleteUser' data-id='".$row->id."'>Delete</a>";

                        $copyButton = "<a class='btn btn-sm btn-secondary mb-1 copyUser' data-id='".$row->id."' 
                            data-name='".$row->name."' 
                            data-email='".$row->email."' 
                            data-birth_date='".$row->birth_date."'
                            data-title='".$row->title."'>Copy</a>";

                        return $editButton ."  ".$deleteButton."  ".$copyButton;

                })
                ->make(true);
        }
 
        return view('users.index');
    }

    public function welcome(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','name','email','birth_date','title')->get();
            return Datatables::of($data)->addIndexColumn()
                ->make(true);
        }
 
        return view('welcome');
    }

    public function AddUser(){
        return view('users.add');
    }

    public function PdfPage(){
        $data = User::select('id','name','email','birth_date','title')->get();
        return view('users.pdf',compact('data'));
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function delete(Request $request){
        
        ## Read POST data
        $id = $request->post('id');

        User::find($id)->delete();

        return redirect()->back();
    }



    public function update(Request $request){

        ## Read POST data 
        $id = $request->post('id');

        $user = User::find($id);

        $response = array();
        if(!empty($user)){
            $response['name'] = $user->name;
            $response['email'] = $user->email;
            $response['title'] = $user->title;
            $response['birth_date'] = $user->birth_date;
            

            $response['success'] = 1;
        }else{
            $response['success'] = 0;
        }

        return response()->json($response);

    }

    public function DataById(Request $request){
        $id = $request->post('id'); 
        $data =User::findOrFail($id);
    
        return response()->json($data); 
    }

    public function store(Request $request){
        ## Read POST data
        $id = $request->post('id');

        $user = User::find($id);

        $response = array();
        if(!empty($user)){
             $updata['name'] = $request->post('name');
             $updata['email'] = $request->post('email');
             $updata['title'] = $request->post('title');
             $updata['birth_date'] = $request->post('birth_date');

             if($user->update($updata)){
                  $response['success'] = 1;
                  $response['msg'] = 'Update successfully'; 
             }else{
                  $response['success'] = 0;
                  $response['msg'] = 'Record not updated';
             }

        }else{
             $response['success'] = 0;
             $response['msg'] = 'Invalid ID.';
        }

        return response()->json($response); 
    }
    
    public function StoreUser(Request $request){
        User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'birth_date'=>$request->birth_date,
            'title'=>$request->title,
            'password'=>Hash::make(Str::random(8)),
            'created_at'=>Carbon::now(),
            
        ]);
        return redirect()->route('users.index');
    }

}
