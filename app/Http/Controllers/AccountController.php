<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
date_default_timezone_set('Asia/Manila');

class AccountController extends Controller
{
    public function list(Request $request){
        return json_encode(Account::with(['personnel'])->get());
    }

    public function items(Request $request){
        return json_encode(Account::with(['personnel'])->find($request->id));
    }

    public function create(Request $request){
        $request->validate([
            'personnel_id' => 'required|unique:account',
            'email' => 'required|unique:account|unique:users',
            'password' => 'required',
        ]);
        $data = new Account();
        $data->personnel_id = $request->personnel_id;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    } 

    public function update(Request $request){
        $request->validate([
            'personnel_id' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $data = Account::find($request->id);
        $data->personnel_id = $request->personnel_id;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function delete(Request $request){
        $data = Account::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
    
    public function find(Request $request){
        $user_email = User::where('personnel_id',$request->personnel_id)->value('email');
        $user_password = User::where('personnel_id',$request->personnel_id)->value('password');
        $account_email = Account::where('personnel_id',$request->personnel_id)->value('email');
        $account_password = Account::where('personnel_id',$request->personnel_id)->value('password');
        return response()->json([$account_email,$account_password,$user_email,$user_password]);
    }
}
