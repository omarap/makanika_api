<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
        {
            return response()->json(User::with(['orders'])->get());
        }

        public function login(Request $request)
        {
            $status = 401;
            $response = ['error' => 'Unauthorised'];

            if (Auth::attempt($request->only(['email', 'password']))) {
                $status = 200;
                $response = [
                    'user' => Auth::user(),
                    'token' => Auth::user()->createToken('bigStore')->accessToken,
                ];
            }

            return response()->json($response, $status);
        }

        public function register(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'c_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $data = $request->only(['name', 'email', 'password']);
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);
            $user->is_admin = 0;

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('Store')->accessToken,
            ]);
        }

        public function show(User $user)
        {
            return response()->json($user);
        }

        public function showOrders(User $user)
        {
            return response()->json($user->orders()->with(['product'])->get());
        }

        public function resetPassword()
        {
            $user=Auth::user();
            $validation=$request->validate([
                'name'=>'required',
                'email'=>'required'
            ]);
            $user->name=$request['name'];
            $user->name=$request['email'];
            $user->save();

            if($request['password']!=""){
                if(!(Hash::check($request['password'],Auth::user()->password))){
                    return redirect()->back()->with('error','your current password  does not match with the password you provided');
                }
            }
         return back();

         //check if the cuurent password and new password are the same
         if(strcmp($request['password'],$request['new_password'])==0){
             return redirect()->back()->with('error','New password cannot be the same as your current password.');
         }

         //validation for the current password and new password fields
         $validation=$request->validate([
             'password'=>'required',
             'new_password'=>'required|string|min:6|confirmed'
         ]);
         //save the password that has been provided by the user
         $user->password=bcrypt($request['new_password']);
         $user->save();
         return redirect()->back()->with("success","password changes successfully");
        }

}
