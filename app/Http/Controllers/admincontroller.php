<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;



class admincontroller extends Controller
{
    //
    public function store_register(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        $full_name = $request->get('full_name');
        $email = $request->get('email');
        $contact = $request->get('contact');
        $password = $request->get('password');
        $confirm_password = $request->get('confirm_password');
        if ($password != $confirm_password) {
            return response()->json(['status' => 'failed', 'message' => 'Password and Confirm_password Not Match']);
        }
        $input = $request->all();
        $input = bcrypt($request->get('password'));
        $user = new User([
            'name'=>$full_name,
            'email'=>$email,
            'password'=>$password,
            'user_role'=>'customer',
            'status'=>'active'
        ]);
        $user->save();
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        //$success['name'] =  $user->name;
        $data = new Register([
            'full_name' => $full_name,
            'email' => $email,
            'contact' => $contact,
            'password' => Hash::make($password),
            'confirm_password' => Hash::make($confirm_password),
        ]);

        
        if ($data->save()) {
            // Generate PDF content
            // Generate PDF file and save it temporarily
            $pdfFileName = "details" . '_mailname.pdf';
            PDF::loadView('pdf_template', ['full_name' => $full_name, 'email' => $email, 'contact' => $contact, 'password' => $password])->save(storage_path('app/' . $pdfFileName));

            Mail::send('mailsending', ['full_name' => $full_name], function ($message) use ($email, $pdfFileName) {
                $message->to($email);
                $message->subject("Congratulations🎉 Your Registration Completed");

                // Attach PDF to the email with the custom filename and content
                $message->attach(storage_path('app/' . $pdfFileName), [
                    'as' => $pdfFileName,
                    'mime' => 'application/pdf',
                ]);

                // You can also attach the PDF content if needed
                // $message->attachData($pdfContent, 'content.txt', [
                //     'mime' => 'text/plain',
                // ]);
            });

            // Delete the temporary PDF file after sending the email
            unlink(storage_path('app/' . $pdfFileName));

            // return "Email sent successfully!";
            return response()->json(['status' => 'success', 'message' => 'Register Successfully','token'=>$success]);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Register Not Completed']);
        }
    }

    // public function logincheck(Request $request)
    // {
    //     if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    //         echo "Login Please";
    //     }
    //     else{
    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
    //         $user = Auth::user(); 
    //         $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
    //         $success['name'] =  $user->name;
    //         $success['user_role']=$user->user_role;
    //         return response()->json($success);
    //     } 
    //     else{ 
    //         return response("login fail");
    //     }
    // }

   // public function login(Request $request)
   //   {
   //       $credentials = $request->only('email', 'password');

   //       $email = $request->get('email');

   //       if (Auth::attempt($credentials)) {
   //           $user = Auth::User();
   //           $token = $user->createToken('authToken')->plainTextToken;

   //           $user_details = User::where('email','=',$email)->first();

   //           return response()->json(['message' => 'success','token' => $token,'uid'=>$user_details->id,'username'=>$user_details->username],'name'=>$user_details->name,200);
   //       }

   //       return response()->json(['message' => 'failed'],401);
   //  }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $email = $request->get('email');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            $user_details = User::where('email', '=', $email)->first();

            return response()->json(['message' => 'success', 'token' => $token, 'uid' => $user_details->id, 'username' => $user_details->username, 'name' => $user_details->name,'user_role'=>$user_details->user_role],200);
        }
        else
        {
            return response()->json(['message' => 'failed'], 401);
        }
    }

    
    public function destroy(string $id)
    {
        $user=Register::find($id);
        $user->delete();
        echo "Record Deleted";
    }
}
