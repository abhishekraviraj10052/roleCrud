<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request){

       $validator = \Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }

         if(\Auth::attempt($request->only('email','password'))){
            return redirect()->route('dashboard');
         }else{
            return back()->with('error','Invalid credentials');
         }
    }


    public function dashboard(){
        $currentUser=\Auth::user();
        $users=User::when($currentUser['role'] == 2,function($query){
                 $query->where('role',0)
                       ->orWhere('role',1);
        })->when($currentUser['role'] == 1,function($query){
            $query->where('role',0);
        })->when($currentUser['role'] == 0,function($query) use ($currentUser){
            $query->where('id',$currentUser['id']);
        })->get();
        return view('users.dashboard',compact('users'));
    }

    public function show_user_form($id=''){
        if(\Auth::user()->role == 2){
            $user=User::where('id',$id)->first();
        }
        else if(\Auth::user()->role == 0){
            if($id != \Auth::user()->id){
                return 'access denied';
            }
            $user=User::where('id',$id)->first();
        }
        return view('users.user',compact('user'));
    }

    public function insert(Request $request){
        $input=$request->all();
        $validator = \Validator::make($input,[
            'firstname'=>'required|string|min:2|max:100',
            'lastname'=>'required|string|min:2|max:100',
            'email'=>'required|string|email|unique:users,email',
            'number'=>'required|unique:users,number',
            'password'=>'required|min:4',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }

        $input['password']=\Hash::make($input['password']);
        User::create($input);
        return redirect()->route('dashboard')->with('success','User created');

    }

    public function update(Request $request){
        $input=$request->all();
        $validator = \Validator::make($input,[
            'firstname'=>'required|string|min:2|max:100',
            'lastname'=>'required|string|min:2|max:100',
            'email'=>'required|string|email|unique:users,email,'.$request['id'],
            'number'=>'required|unique:users,number,'.$request['id'],
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }

        if($input['password'] != ''){
            $validator = \Validator::make($input,[
                'password'=>'required|min:4',
            ]);
            if($validator->fails()){
                return back()->withErrors($validator->errors())->withInput();
            }
            $input['password']=\Hash::make($input['password']);
        }else{
            $input['password']=\Hash::make(User::where('id',$input['id'])->first()->password);
        }
       
        User::where('id',$input['id'])->update([
            'firstname'=>$input['firstname'],
            'lastname'=>$input['lastname'],
            'email'=>$input['email'],
            'number'=>$input['number'],
            'password'=>$input['password'],

        ]);
        return redirect()->route('dashboard')->with('success','User updated');

    }


    public function delete($id){
        User::where('id',$id)->delete();
        if(\Auth::user()->role == 0){
            \Auth::logout();
            \Session::flush();
            return redirect()->route('view-login-form')->with('success','Account deleted');
        }
        return redirect()->route('dashboard')->with('success','User deleted');
    }

    public function logout(){
        \Auth::logout();
        \Session::flush();
        return redirect()->route('view-login-form')->with('success','Logged Out');
       
    }


    public function search_sort(Request $request){
        $users=User::when($request['firstname'] != '',function($query) use ($request){
                 $query->where('firstname','like','%'.$request['firstname'].'%');
        })->when($request['lastname'] != '',function($query) use ($request){
            $query->where('lastname','like','%'.$request['lastname'].'%');
        })->when($request['email'] != '',function($query) use ($request){
            $query->where('email','like','%'.$request['email'].'%');
        })->when($request['number'] != '',function($query) use ($request){
            $query->where('number','like','%'.$request['number'].'%');
        })->get();

        return view('users.dashboard',compact('users'));
    }
}
