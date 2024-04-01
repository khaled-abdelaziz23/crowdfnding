<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;

class adminconttroller extends Controller
{
    public function _constract()
    {
        $this->middleware('auth')->except(['registirationform','registiration','loginform']);
    }
    public function registirationform()
    {
          return view('registerform');
    }
    public function registiration(Request $request)
    {
        $fileexetintion = $request->photo->getClientOriginalExtension();
        $filename = date('Y-m-d ... h-i-s').'.'.$fileexetintion;
        $path = 'images/usersphotos';
        $request->photo->move($path,$filename);

        $request->validate([
            'name'=>'required',
            'email'=>'required |  email',
            'password'=>'required|max:16|min:6',
            
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->profile_photo = $request->photo;
        $res = $user->save();
        if ($res) {
            return back()->with('success' , 'ok');
        }
        else {
            return back()->with('fail' , ' not ok');
        }
        
          
    }

    public function loginform()
    {
        return view('loginform');
    }

    public function loginn(Request $request)
    {
        
        $user = $request->only('email' ,'password' );
     
        if (Auth::attempt($user) && Auth::user()->role=='admin'  ) {
            
                 return redirect()->route('admin.only');
            }
          else {
            return view('welcome');
          }
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
        $res = $item->save();

        if ($res) {
            return view('welcome');
        }
        return 'fail';
        
        
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
  


}
