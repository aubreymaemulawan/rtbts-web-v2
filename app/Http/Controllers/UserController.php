<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
date_default_timezone_set('Asia/Manila');

class UserController extends Controller
{
    public function list(Request $request){
        return json_encode(User::all());
    }
    
    public function items(Request $request){
        return json_encode(User::find($request->id));
    } 

    public function create(Request $request){
        $request->validate([
            'company_id' => 'unique:users',
            'personnel_id' => 'unique:users',
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'userType' => 'required',
        ]);
        $data = new User();
        $data->company_id = $request->company_id;
        $data->personnel_id = $request->personnel_id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->user_type = $request->user_type;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    } 

    public function update(Request $request){
        $request->validate([
            'company_id' => [Rule::unique('users','company_id')->ignore($request->id)],
            'personnel_id' => [Rule::unique('users','personnel_id')->ignore($request->id)],
            'name' => ['required', Rule::unique('users','name')->ignore($request->id)],
            'email' => ['required', Rule::unique('users','email')->ignore($request->id)],
            'password' => 'required',
            'userType' => 'required',
        ]);
        $data = User::find($request->id);
        $data->company_id = $request->company_id;
        $data->personnel_id = $request->personnel_id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->user_type = $request->user_type;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function delete(Request $request){
        $data = User::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
