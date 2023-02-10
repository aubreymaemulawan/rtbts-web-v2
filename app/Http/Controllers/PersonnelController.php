<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\User;
use App\Models\Account;
use App\Models\Bus;
use App\Models\Schedule;
use App\Models\PersonnelSchedule;
use DB;
use File;

date_default_timezone_set('Asia/Manila'); 

class PersonnelController extends Controller
{    
    public function list(Request $request){
        return json_encode(Personnel::with(['company'])->get());
    }

    public function items(Request $request){
        return json_encode(Personnel::with(['company'])->find($request->id));
    }

    public function create(Request $request){
        // Validation Rules
        $request->validate([
            'company_id' => 'required',
            'personnel_no' => 'required|unique:personnel',
            'name' => ['required', 'unique:personnel', Rule::unique('users','name')],
            'contact_no' => 'required',
            'age' => 'required',
            'address' => 'required',
            'user_type' => 'required',
            'profile_picture' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ],[
            'personnel_no.required' => 'The id number field is required.',
            'personnel_no.unique' => 'The id number has already been taken.',
            'contact_no.required' => 'The contact field is required.',
            'user_type.required' => 'The user type selection is required.',
            'profile_picture.max' => 'The photo must not be greater than 2048 kilobytes.'
        ]);

        // Create Data in DB (Personnel Table)
        $data = new Personnel();
        $data->company_id = $request->company_id;
        $data->personnel_no = $request->personnel_no;
        $data->name = $request->name;
        $data->contact_no = $request->contact_no;
        $data->age = $request->age;
        $data->address = $request->address;
        $data->user_type = $request->user_type;
        $data->status = 1;

        // If image is selected, store in DB (Personnel Table)
        if($request->hasFile('profile_picture')){
            $profile_name = $request->file('profile_picture')->getClientOriginalName();
            $profile_path = $request->file('profile_picture')->store('public/Profile_Images');
            $data->profile_name = $profile_name;
            $data->profile_path = $profile_path;
        }

        // Save to DB (Personnel Table)
        $data->save();

        // If checkbox is checked, create account in DB (Account & User Table)
        if($request->input("add-account")==1){
            $data1 = new User();
            $data1->personnel_id = $data->id;
            $data1->name = $request->name;
            $data1->email = $request->personnel_no;
            $data1->password = bcrypt($request->personnel_no);
            $data1->user_type = $request->user_type;
            $data1->save();
            $data2 = new Account();
            $data2->personnel_id = $data->id;
            $data2->email = $request->personnel_no;
            $data2->password = $request->personnel_no;
            $data2->save();
        }

        // Return
        return json_encode(
            ['success'=>true]
        );
    } 
 
    public function update(Request $request){
        // Validation Rules
        $request->validate([
            'edit-company_id' => 'required',
            'edit-personnel_no' => ['required', Rule::unique('personnel','personnel_no')->ignore($request->input("edit-id"))],
            'edit-name' => ['required', Rule::unique('personnel','name')->ignore($request->input("edit-id"))],
            'edit-contact_no' => 'required',
            'edit-age' => 'required',
            'edit-address' => 'required',
            'edit-user_type' => 'required',
            'edit-status' => 'required' ,
            'edit-profile_picture' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048' ,
        ],[
            'edit-personnel_no.required' => 'The id number field is required.',
            'edit-personnel_no.unique' => 'The id number has already been taken.',
            'edit-name.required' => 'The name field is required.',
            'edit-name.unique' => 'The name has already been taken.',
            'edit-contact_no.required' => 'The contact field is required.',
            'edit-age.required' => 'The age field is required.',
            'edit-address.required' => 'The address field is required.',
            'edit-user_type.required' => 'The user type selection is required.',
            'edit-status.required' => 'The status field is required.',
            'edit-profile_picture.max' => 'The photo must not be greater than 2048 kilobytes.'
        ]);

        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $find_persched_con = PersonnelSchedule::where('conductor_id',$request->input("edit-id"))->get();
        $find_persched_dis = PersonnelSchedule::where('dispatcher_id',$request->input("edit-id"))->get();
        $find_persched_ope = PersonnelSchedule::where('operator_id',$request->input("edit-id"))->get();
        foreach($find_persched_con as $val){
            if($val->status == 1){
                $count1++;
            }
        }
        foreach($find_persched_dis as $val){
            if($val->status == 1){
                $count2++;
            }
        }
        foreach($find_persched_ope as $val){
            if($val->status == 1){
                $count3++;
            }
        }
        if($request->input("edit-status") == 2 && ($count1 != 0 || $count2 != 0 || $count3 != 0)){ 
            // There is an active assigned-schedule using that bus id
            return response()->json(1);
        }else{  
            // Update Data in DB (Personnel Table)
            $data = Personnel::find($request->input("edit-id"));
            $data->company_id = $request->input("edit-company_id");
            $data->personnel_no = $request->input("edit-personnel_no");
            $data->name = $request->input("edit-name");
            $data->contact_no = $request->input("edit-contact_no");
            $data->age = $request->input("edit-age");
            $data->address = $request->input("edit-address");
            $data->user_type = $request->input("edit-user_type");
            $data->status = $request->input("edit-status");

            $pp = Personnel::where('id',$request->input("edit-id"))->value('profile_path');
            $str = ltrim($pp, 'public/');

            // If image is selected, store in DB (Personnel Table)
            if($request->hasFile('edit-profile_picture')){
                $prev_path = public_path("/storage/".$str);  // prev image path
                if(File::exists($prev_path)) {
                    File::delete($prev_path);
                }
                $edit_profile_name = $request->file('edit-profile_picture')->getClientOriginalName();
                $edit_profile_path = $request->file('edit-profile_picture')->store('public/Profile_Images');
                $data->profile_name = $edit_profile_name;
                $data->profile_path = $edit_profile_path;
            }

            // If image is reset to default, profile picture will be null
            if($request->input("edit-new_img") == '2'){
                $prev_path = public_path("/storage/".$str);  // prev image path
                if(File::exists($prev_path)) {
                    File::delete($prev_path);
                }
                $data->profile_name = null;
                $data->profile_path = null;
            }

            // Save to DB (Personnel Table)
            $data->save();

            // Update Info In DB (User Table)
            DB::table('users') ->where('personnel_id', $request->input("edit-id"))->update([
                    'name' => $request->input("edit-name"),
                    'user_type' => $request->input("edit-user_type")
            ]);

            // For no accounts, if checkbox is checked, create account in DB (Account Table)
            if($request->input("edit-account") == 1){
                $data2 = new Account();
                $data2->personnel_id = $request->input("edit-id");
                $data2->email = $request->input("edit-personnel_no");
                $data2->password = $request->input("edit-personnel_no");
                $data2->save();

                // For no accounts, if checkbox is checked and status is Active, Create Account in DB (User Table)
                if($request->input("edit-status") == 1){
                    $data3 = new User();
                    $data3->personnel_id = $request->input("edit-id");
                    $data3->name = $request->input("edit-name");
                    $data3->email = $request->input("edit-personnel_no");
                    $data3->password = bcrypt($request->input("edit-personnel_no"));
                    $data3->user_type = $request->input("edit-user_type");
                    $data3->save();
                }
            }

            // Check Account and User Table
            $acc_tbl = Account::where('personnel_id',$request->input("edit-id"))->get();
            $user_tbl = User::where('personnel_id',$request->input("edit-id"))->get();
            $email = Account::where('personnel_id',$request->input("edit-id"))->value('email');
            $password = Account::where('personnel_id',$request->input("edit-id"))->value('password');

            if($request->input("edit-status") == 1){
                // Check dispatcher & operator of Conductor if Active
                $conductor_dp_op = PersonnelSchedule::where('conductor_id', $request->input("edit-id"))->get();
                foreach($conductor_dp_op as $con){
                    $conductor_dp_status = Personnel::where('id', $con->dispatcher_id)->value('status');
                    $conductor_op_status = Personnel::where('id', $con->operator_id)->value('status');
                    $conductor_bs_status = Bus::where('id', $con->bus_id)->value('status');
                    $conductor_sc_status = Schedule::where('id', $con->schedule_id)->value('status');
                    if($conductor_dp_status == 1 && $conductor_op_status == 1 && $conductor_bs_status == 1 && $conductor_sc_status == 1){
                        DB::table('personnel_schedule')->where([
                            ['conductor_id', '=', $request->input("edit-id")],
                            ['dispatcher_id', '=', $con->dispatcher_id],
                            ['operator_id', '=', $con->operator_id],
                            ['bus_id', '=', $con->bus_id],
                            ['schedule_id', '=', $con->schedule_id],
                            ['status', '=', 4]
                        ])->update(['status' => 1]);
                    }
                }

                // Check conductor & operator of Dispatcher if Active
                $dispatcher_cn_op = PersonnelSchedule::where('dispatcher_id', $request->input("edit-id"))->get();
                foreach($dispatcher_cn_op as $dis){
                    $dispatcher_cn_status = Personnel::where('id', $dis->conductor_id)->value('status');
                    $dispatcher_op_status = Personnel::where('id', $dis->operator_id)->value('status');
                    $dispatcher_bs_status = Bus::where('id', $dis->bus_id)->value('status');
                    $dispatcher_sc_status = Schedule::where('id', $dis->schedule_id)->value('status');
                    if($dispatcher_cn_status == 1 && $dispatcher_op_status == 1 && $dispatcher_bs_status == 1 && $dispatcher_sc_status == 1){
                        DB::table('personnel_schedule')->where([
                            ['conductor_id', '=', $dis->conductor_id],
                            ['dispatcher_id', '=', $request->input("edit-id")],
                            ['operator_id', '=', $dis->operator_id],
                            ['bus_id', '=', $dis->bus_id],
                            ['schedule_id', '=', $dis->schedule_id],
                            ['status', '=', 4]
                        ])->update(['status' => 1]);
                    }
                }
                
                // Check conductor & dispatcher of Operator if Active
                $operator_cn_dp = PersonnelSchedule::where('operator_id', $request->input("edit-id"))->get();
                foreach($operator_cn_dp as $ope){
                    $operator_cn_status = Personnel::where('id', $ope->conductor_id)->value('status');
                    $operator_dp_status = Personnel::where('id', $ope->dispatcher_id)->value('status');
                    $operator_bs_status = Bus::where('id', $ope->bus_id)->value('status');
                    $operator_sc_status = Schedule::where('id', $ope->schedule_id)->value('status');
                    if($operator_cn_status == 1 && $operator_dp_status == 1 && $operator_bs_status == 1 && $operator_sc_status == 1){
                        DB::table('personnel_schedule')->where([
                            ['conductor_id', '=', $ope->conductor_id],
                            ['dispatcher_id', '=', $ope->dispatcher_id],
                            ['operator_id', '=', $request->input("edit-id")],
                            ['bus_id', '=', $ope->bus_id],
                            ['schedule_id', '=', $ope->schedule_id],
                            ['status', '=', 4]
                        ])->update(['status' => 1]);
                    }
                }

                // If status is active, there is an account, but no Authentication, create account in DB (User Table)
                if($request->input("edit-status") == 1 && count($acc_tbl) != 0 && count($user_tbl) == 0){
                    $data4 = new User();
                    $data4->personnel_id = $request->input("edit-id");
                    $data4->name = $request->input("edit-name");
                    $data4->email = $email;
                    $data4->password = bcrypt($password);
                    $data4->user_type = $request->input("edit-user_type");;
                    $data4->save();
                }
            }
            
            // If status is not active, delete Authentication in DB (User Table)
            else if($request->input("edit-status") == 2){
                $user_delete = User::where('personnel_id',$request->input("edit-id"));
                $user_delete->delete();
                // Set status in personnel_schedule tbl
                DB::table('personnel_schedule')->where([['conductor_id', '=', $request->input("edit-id")],['status', '=', 1]])->update(['status' => 4]);
                DB::table('personnel_schedule')->where([['dispatcher_id', '=', $request->input("edit-id")],['status', '=', 1]])->update(['status' => 4]);
                DB::table('personnel_schedule')->where([['operator_id', '=', $request->input("edit-id")],['status', '=', 1]])->update(['status' => 4]);
            }

            // Return 
            return json_encode(
                ['success'=>true]
            );
        }
    }

    public function delete(Request $request){
        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $data = Personnel::find($request->id);
        $find_persched_con = PersonnelSchedule::where('conductor_id',$request->id)->get();
        $find_persched_dis = PersonnelSchedule::where('dispatcher_id',$request->id)->get();
        $find_persched_ope = PersonnelSchedule::where('operator_id',$request->id)->get();
        foreach($find_persched_con as $val){
            $count1++;
        }
        foreach($find_persched_dis as $val){
            $count2++;
        }
        foreach($find_persched_ope as $val){
            $count3++;
        }
        if($count1 == 0 && $count2 == 0 && $count3 == 0){ // There is an active assigned-schedule using that bus id
            $data->delete();
            return json_encode( 
                ['success'=>true]
            );
        }else{
            return response()->json(1);
        }
    }
     
    public function update_profile(Request $request){
        $request->validate([
            'name' => ['required', Rule::unique('personnel','name')->ignore($request->id)],
            'email' => ['required'],
            'age' => 'required',
            'contact_no' => 'required',
            'address' => 'required',
            'profile_picture' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048' ,
        ],[
            'contact_no.required' => 'The contact number field is required.',
            'email.required' => 'The username field is required.',
            'email.unique' => 'The username has already been taken.',
            'profile_picture.max' => 'The photo must not be greater than 2048 kilobytes.'
        ]);

        // Update Data in DB (Company Table)
        $data = Personnel::find($request->input("id"));
        $data->name = $request->input("name");
        $data->address = $request->input("address");
        $data->contact_no = $request->input("contact_no");
        $data->age = $request->input("age");

        $pp = Personnel::where('id',$request->input("id"))->value('profile_path');
        $str = ltrim($pp, 'public/');

        // If image is selected, store in DB (Personnel Table)
        if($request->hasFile('profile_picture')){
            $prev_path = public_path("/storage/".$str);  // prev image path
            if(File::exists($prev_path)) {
                File::delete($prev_path);
            }
            $profile_name = $request->file('profile_picture')->getClientOriginalName();
            $profile_path = $request->file('profile_picture')->store('public/Profile_Images');
            $data->profile_name = $profile_name;
            $data->profile_path = $profile_path;
        }

        // If image is reset to default, profile picture will be null
        if($request->input("edit-new_img") == '2'){
            $prev_path = public_path("/storage/".$str);  // prev image path
            if(File::exists($prev_path)) {
                File::delete($prev_path);
            }
            $data->profile_name = null;
            $data->profile_path = null;
        }

        // Save to DB (Company Table)
        $data->save();

        // Update Info In DB (User Table)
        DB::table('users')->where('personnel_id', $request->input("id"))->update([
            'name' => $request->input("name"),
            'email' => $request->input("email")
        ]);

        // Update Info In DB (User Table)
        DB::table('account')->where('personnel_id', $request->input("id"))->update([
            'email' => $request->input("email")
        ]);

        // Return
        return json_encode(
            ['success'=>true]
        ); 
    }

    public function update_password(Request $request){
        // Validation Rules
        $request->validate([
            'current_password' => 'required',
        ]);

        // Check current password if correct
        $pass = Account::where('personnel_id', $request->id)->value('password');
        if($request->current_password != $pass){
            return response()->json(1);
        }

        if($request->new_password == $pass){
            return response()->json(2);
        }
        // Validation Rules
        $request->validate([
            'new_password' => 'required|min:8',
            'retype_password' => 'required|required_with:new_password|same:new_password',
        ],[
            'retype_password.same' => 'The retype password does not match.'
        ]);

        if($request->new_password == $request->retype_password){
            // Update Password in DB (Company Table)
            DB::table('account')->where('personnel_id', $request->id)->update([
                'password' => $request->new_password
            ]);

            // Update Password in DB (Users Table)
            DB::table('users')->where('personnel_id', $request->id)->update([
                'password' => bcrypt($request->new_password)
            ]);

            // Return
            return json_encode(
                ['success'=>true]
            );
        }
    }
        
}
