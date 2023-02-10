<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function create(Request $request){
        // Validation Rules
        $request->validate([
            'message' => 'required',
        ]);

        // Create Data in DB (Bus Table)
        $data = new Feedback();
        $data->message = $request->message;

        // Save to DB (Bus Table)
        $data->save();

        // Return
        return json_encode( 
            ['success'=>true]
        );
    }
}
