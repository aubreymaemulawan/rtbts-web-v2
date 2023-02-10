<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use ProtoneMedia\LaravelVerifyNewEmail\MustVerifyNewEmail;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Bus;
use App\Models\User;
use App\Models\Personnel;
use App\Models\Account;
use DB;
use File;

date_default_timezone_set('Asia/Manila');

class CompanyController extends Controller
{
    public function list(Request $request){
        return json_encode(Company::all());
    }

    public function items(Request $request){
        return json_encode(Company::find($request->id));
    } 

    public function create(Request $request){
        $request->validate([
            'company_name' => 'required|unique:company|unique:users',
            'address' => 'required',
            'email' => 'required|unique:company|unique:users',
            'password' => 'required',
            'description' => 'required',
            'logo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $data = new Company();
        $data->company_name = $request->company_name;
        $data->address = $request->address;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->description = $request->description;
        if($request->hasFile('logo')){
            $logo_name = $request->file('logo')->getClientOriginalName();
            $logo_path = $request->file('logo')->store('public/Images');
            $data->logo_name = $logo_name;
            $data->logo_path = $logo_path;
        }
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function update(Request $request){
        // Validation Rules
        $request->validate([
            'company_name' => ['required', Rule::unique('company','company_name')->ignore($request->id)],
            'logo_picture' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048' ,
        ],[
            'company_name.required' => 'The company name field is required.',
            'company_name.unique' => 'The company name has already been taken.',
            'logo_picture.max' => 'The photo must not be greater than 2048 kilobytes.'
        ]);

        // Update Data in DB (Company Table)
        $street1 = $request->input("street");
        $street2 = str_replace(',',' ',$street1);
        $street = trim($street2);
        $city = $request->input("city");
        $country = $request->input("country");
        $postal_code1 = $request->input("postal_code");
        $postal_code2 = str_replace(',',' ',$postal_code1);
        $postal_code = trim($postal_code2);
        $data = Company::find($request->input("id"));
        $data->company_name = $request->input("company_name");
        $data->address = $street.", ".$city.", ".$country.", ".$postal_code;
        $data->contact_no = $request->input("contact_no");
        $data->email = $request->input("email");
        $data->password = $request->input("password");
        $data->description = $request->input("description");

        $pp = Company::where('id',$request->input("id"))->value('logo_path');
        $str = ltrim($pp, 'public/');

        // If image is selected, store in DB (Company Table)
        if($request->hasFile('logo_picture')){
            $prev_path = public_path("/storage/".$str);  // prev image path
            if(File::exists($prev_path)) {
                File::delete($prev_path);
            }
            $logo_name = $request->file('logo_picture')->getClientOriginalName();
            $logo_path = $request->file('logo_picture')->store('public/Images');
            $data->logo_name = $logo_name;
            $data->logo_path = $logo_path;
        }

        // If image is reset to default, logo picture will be null
        if($request->input("edit-new_img") == '2'){
            $prev_path = public_path("/storage/".$str);  // prev image path
            if(File::exists($prev_path)) {
                File::delete($prev_path);
            }
            $data->logo_name = null;
            $data->logo_path = null;
        }

        // Save to DB (Company Table)
        $data->save();

        // Update Info In DB (User Table)
        DB::table('users')->where('company_id', $request->input("id"))->update([
            'name' => $request->input("company_name")
        ]);

        // Return
        return json_encode(
            ['success'=>true]
        ); 
    }
    
    public function delete(Request $request){
        $data = Company::find($request->id);
        $data->delete();
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
        $pass = Company::where('id', $request->id)->value('password');
        if(!password_verify($request->current_password, $pass)){
            return response()->json(1);
        }

        // Check if its an old password
        if(password_verify($request->new_password, $pass)){
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
            DB::table('company')->where('id', $request->id)->update([
                'password' => bcrypt($request->new_password)
            ]);

            // Update Password in DB (Users Table)
            DB::table('users')->where('company_id', $request->id)->update([
                'password' => bcrypt($request->new_password)
            ]);

            // Return
            return json_encode(
                ['success'=>true]
            );
        }
    }

    public function update_email(Request $request){
        // Validation Rules
        $request->validate([
            'new_email' => ['required', 'email'],
        ],[
            'new_email.email' => 'The email must be a valid email address.',
            'new_email.required' => 'The email field is required.',
        ]);

        // Check email if the same
        $email = Company::where('id', $request->id)->value('email');
        if($email == $request->new_email){
            return response()->json(1);
        }

        // Validation Rules
        $request->validate([
            'new_email' => [Rule::unique('company','email'), Rule::unique('users','email')],
        ],[
            'new_email.unique' => 'The email has already been taken.',
        ]);

        // Check password if correct
        $pass = Company::where('id', $request->id)->value('password');
        if($request->admin_password == null || $request->admin_password == ""){
            // Validation Rules
            $request->validate([
                'admin_password' => 'required',
            ],[
                'admin_password.required' => 'The password field is required.'
            ]);
        }else if(!password_verify($request->admin_password, $pass)){
            return response()->json(2);
        }

        if(password_verify($request->admin_password, $pass)){
            // Update Password in DB (Company Table)
            DB::table('company')->where('id', $request->id)->update([
                'email' => $request->new_email
            ]);

            // Update Password in DB (Users Table)
            DB::table('users')->where('company_id', $request->id)->update([
                'email' => $request->new_email
            ]);

            // Return
            return json_encode(
                ['success'=>true]
            );
        }
    }

}
