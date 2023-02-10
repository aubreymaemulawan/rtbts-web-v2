<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reminder;
date_default_timezone_set('Asia/Manila');

class ReminderController extends Controller {
    
    public function list(Request $request){
        return json_encode(Reminder::all());
    }
    
    public function items(Request $request){
        return json_encode(Reminder::find($request->id));
    }

    public function create(Request $request){
        $request->validate([ 
            'company_id' => 'required',
            'subject' => 'required|max:60',
            'message' => 'required',
            'user_type' => 'required',
        ],[
            'user_type.required' => 'The audience selection is required.'
        ]);
        $data = new Reminder();
        $data->company_id = $request->company_id;
        $data->subject = $request->subject;
        $data->message = $request->message;
        $data->user_type = $request->user_type;
        $data->save();
        return json_encode(
            ['success'=>true]
        );
    }

    public function delete(Request $request){
        $data = Reminder::find($request->id);
        $data->delete();
        return json_encode(
            ['success'=>true]
        );
    }
}
