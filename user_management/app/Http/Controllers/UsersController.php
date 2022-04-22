<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    function users(){
        
        $users = User::paginate(3);
        
        return view('users',['users' => $users]);
    }

    function editInfo($id,Request $request){
        
        $user = User::findOrFail($id);
        
        return view('edit',['user' => $user]);

    }
    
    function updateInfo($id,Request $request){
        
        User::find($id)
                ->updateInfo(
                    ['username' => $request->username,
                    'tel' => $request->tel,
                    'title' => $request->title,
                    'address' => $request->address
                    ]
                );
        return redirect('/users');
            
    }

    function editAvatar($id){
        
        $user = User::findOrFail($id);
        
        return view('media',['user'=>$user]);
    
    }

    function updateAvatar($id,Request $request){
        
        User::find($id)->uploadAvatar($request);
        
        return redirect("/users");
    
    }

    function editUser(){
    
        return view('create');
    
    }

    function createUser(Request $request){
    
        User::newUser($request);
        
        return redirect('/users');
    
    }

    function editSecurity($id){
    
        $user = User::findOrFail($id);
    
        return view('security',['user'=>$user]);
    
    }

    function updateSecurity($id,Request $request){
        User::find($id)
            ->confirmData($request)
            ->update(
                ['email'=>$request->email,
                'password'=>Hash::make($request->newPassword)
                ]
            );
        return redirect('/users');

            
     
    }
    function editStatus($id){
        
        return view('status',['status'=>User::findOrFail($id)->status]); 
    
    }
    
    function updateStatus($id,Request $request){
        
        User::find($id)
            ->update([
                'status'=>$request->status
            ]);
        
        $request->session()->flash('success', 'Task was successful!');
        
        return redirect('/users');
    
    }

    function deleteUser($id,Request $request){
        
        User::find($id)->delete();
        
        $request->session()->flash('success', 'User deleted!');
        
        return redirect('/users');

    }
}
 
?>