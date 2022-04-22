<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','avatar','tel','title','address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function is_admin(){
        if($this->role==1){
            return true;
        }
        
        return false;
    }
    
    function updateInfo($data){
        
        $this->update([
            'username' => $data['username'],
            'tel'=>$data['tel'],
            'title'=>$data['title'],
            'address'=>$data['address']
        ]);

    }

    function uploadAvatar($request){
        
        $image = $request->file("avatar");
        
        $filename = $image->store('/uploads');
        
        $this->avatar=$filename;
        
        $this->save();
        
        $request->session()->flash('success', 'image edited!');
        
    }
    
    function newUser($request){
        Validator::make($request,[
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'avatar'=>'required'
        ]);

        $image=$request->file("avatar");
        $filename=$image->store('/uploads');
        $this::create(['username'=>$request->username,
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
        
    }
    
    function confirmData($request){
        
        $validator = $request->validate([

            'email' => ['required', 'email', Rule::unique('users')->ignore($this::find($request->id))],
            'newPassword' => 'required|string|min:6',
            'newPassword2' => 'required|string|min:6',
            
        ]);
        
        if($request->newPassword!=$request->newPassword2){
        
            $request->session()->flash('error', 'password is not equal');
        
            return redirect('/users/security/edit/'.$request->id);

        }   
        
        $request->session()->flash('success', 'email password updated!');

        return $this;
    
    }

}
