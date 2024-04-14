<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Session;
use Validator;
use Illuminate\Support\Facades\Auth;

class adminconttroller extends Controller
{
    public function _constract()
    {
        $this->middleware('auth')->except(['registirationform','registiration','loginform']);
    }
    public function index()
    {
       $data = User::get();
       return response()->json($data);
    }
   
    public function registiration(Request $request)
    {
     

        $request->validate([
            'name'=>'required',
            'email'=>'required |  email',
            'password'=>'required|max:16|min:6',
            
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $res = $user->save();
        if ($res) {
           return response()->json(['massege'=>'regestration successfully']);
        }
        else {
            return response()->json(['massege'=>'regestration fail']);
        }
        
          
    }

    public function loginn(Request $request)
    {
        $user = $request->only('email' ,'password' );
        $roleuser=Auth::guard('logintokin')->attempt($user);
        if ($roleuser) {
            if ( auth()->guard('logintokin')->user()->role = 'user') {
              return response()->json( ['user token'=>$roleuser ,'user data'=>auth()->guard('logintokin')->user()]); 
            }
            else {       
                 return response()->json( ['admin token'=>$roleuser ,'admin data'=>auth()->guard('logintokin')->user()]); 
            }
            $user = Auth::guard('logintokin')->user(); 
             $user->remember_token = $roleuser;
            $user->save();
        }
         
            
        
        // $token=Auth::guard('logintokin')->attempt($user) ;
        // $user = Auth::guard('logintokin')->user(); 
        // $user->remember_token = $token;
        // $user->save(); 
        // return response()->json( ['user token'=>$token ,'user data'=>auth()->guard('logintokin')->user()]); 

        }

    public function edit($id)
        {
            $item = User::findOrFail($id);
            if ($item) {
                return view('edit', compact('item'));
            }
            
        }
    public function update(Request $request ,$id)
    {
       
        $item = User::findOrFail($id);
        $item->phone = $request->phone;
        $item->name = $request->name;
        $item->email = $request->email;
        
        $res = $item->save();

        if ($res) {
           return response()->json(['massege'=>'updated successfully' , $res ]);
        }
        return response()->json(['massege'=>'fail']);

        
        
    }
public function logout()
{
    session()->flush();
    Auth::logout();
    return redirect()->route('loginform.user');;
}
public function admin()
{
    
    return view('dashboard');

}
public function logoutt(Request $request )
{
   
    $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    

}


}
