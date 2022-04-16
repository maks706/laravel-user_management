<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    function users(){
        $users=User::all();
        $is_admin=0;
        if(Auth::user()->role==1){
            $is_admin=1;
        }
        return view('users',['users'=>$users,'is_admin'=>$is_admin]);
    }
    function edit($id,Request $request){
        $user=User::find($id);
        if ($request->isMethod('post')){
            User::where('id',$id)->update(['username'=>$request->input('username'),
                                            'tel'=>$request->tel,
                                            'title'=>$request->title,
                                            'address'=>$request->address
                                        ]);
            return view('edit',['user'=>$user]);
        }
        return view('edit',['user'=>$user]);

    }
    function media($id,Request $request){
        $user=User::find($id);
        if ($request->isMethod('post')){
            $image=$request->file("avatar");
            $filename=$image->store('/uploads');
            
            $user->avatar=$filename;
            $user->save();
            $request->session()->flash('success', 'image edited!');
            return redirect("/users");
        }return view('media',['image'=>$user->avatar]);
    }
    function createuser(Request $request){

        if ($request->isMethod('post')){
            
            $image=$request->file("avatar");
            
            $filename=$image->store('/uploads');
            $this->validate($request,[
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'avatar'=>'required'
            ]);
            //dd($filename);
            User::create(['username'=>$request->username,
                            'tel'=>$request->tel,
                            'title'=>$request->title,
                            'address'=>$request->address,
                            'email'=>$request->email,
                            'password'=>Hash::make($request->password),
                            'status'=>$request->status,
                            'avatar'=>'/'.$filename,
                            'vkhref'=>$request->vkhref,
                            'telegramhref'=>$request->telegramhref,
                            'instahref'=>$request->instahref
                            
                            ]    
                        );
            $request->session()->flash('success', 'User created');
            return redirect('/users');
        }
        
        return view('createuser');
    }

    function security($id,Request $request){
        if ($request->isMethod('post')){

            $this->validate($request,[
                'email' => ['required', 'email', Rule::unique('users')->ignore(User::find($id))],
                'newPassword' => 'required|string|min:6',
                'newPassword2' => 'required|string|min:6',
                
            ]);
            if($request->newPassword==$request->newPassword2){
                User::where('id',$id)->update([
                    'email'=>$request->email,
                    'password'=>Hash::make($request->newPassword),
                ]);
                $request->session()->flash('success', 'email password updated!');
                return redirect('/users');
            }
            $request->session()->flash('error', 'password is not equal');
            return redirect('/security/'.$id);
        
        }return view('security',['user'=>User::find($id)]);

    }

    function status($id,Request $request){
        if($request->isMethod('post')){
            User::where('id',$id)->update([
               'status'=>$request->status
            ]);
            $request->session()->flash('success', 'Task was successful!');
            return redirect('/users');
        }return view('status',['status'=>User::find($id)->status]);
    }

    function delete($id,Request $request){
        User::where('id',$id)->delete();
        $request->session()->flash('success', 'User deleted!');
        return redirect('/users');

    }
}
 
?>