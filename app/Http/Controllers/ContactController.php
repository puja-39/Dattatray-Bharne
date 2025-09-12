<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Contact; 
use Gregwar\Captcha\CaptchaBuilder;

class ContactController extends Controller
{   
    public function submit(Request $request)
    {
        // dd($request->all());
        $rules = [
             'name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/'],
             'email'    => 'required|email',
             'phone_no' =>['required', 'regex:/^[6-9][0-9]{9}$/'],
             'subject'  => 'required',
             'message'  => 'required', 
             'captcha'  => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ],200);
        }
      if ($request->captcha != session('captcha_phrase')) {
         return response()->json([
        'status' => false,
        'errors' => ['captcha' => ['Invalid captcha.']],
      ],200);
    }

        $enquiry = new Contact();
        $enquiry->name = $request->input('name');
        $enquiry->subject = $request->input('subject');
        $enquiry->email = $request->input('email');
        $enquiry->message = $request->input('message');
        $enquiry->phone_no = $request->input('phone_no');
        $enquiry->created_at = now();
        $enquiry->save();

        return response()->json([
       'status' => true,
       'message' => 'Thank you! Your message has been sent',
       ]);
    }
}