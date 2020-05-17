<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
// use Mail;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_email_exits = User::where(['email'=>$request->email,'isDeleted'=>0])
                            ->get();

        $cnt_user_email_exits = count($user_email_exits);

        if ($cnt_user_email_exits != 0 ) {
            $msg = 'User email Already exists.'; 
        return response()->json($msg);
        }
        else{
            $msg = ' '; 
        return response()->json($msg);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeuser(Request $request)
    {
        $user = $request->user;
        $email = $request->email;
        $password = $request->password;
        $otp = rand(100000,999999);

        // dd($user . " " . $email . " ". $password . " " . $otp);

        $user_id = DB::table('users')->insertGetId(
                    ['name' => $user,
                     'email' => $email,
                     'password' => $password,
                     'otp' => $otp,]
        );
        if ($user_id) {

            $this->sendmail($user_id, $user, $email, $otp);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkotp(Request $request)
    {
        $user_otp = User::where(['email'=>$request->email,'isDeleted'=>0])
                            ->get();

        $cnt_user_otp = count($user_otp);

        if ($cnt_user_otp != 0 ) {
            $checked = DB::table('users')
                ->where(['otp'=>$request->otp,'email'=>$request->email,'isDeleted'=>'0'])
                ->update(array('otp_status' => '1'));
                if ($checked) {
                    $msg = "success"; 
        return response()->json($msg);
                }
                else{
            $msg = "false";
            return response()->json($msg);
        }
            
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendmail($user_id, $user, $email, $otp)
    {
        $user_data = User::where(['id'=>$user_id, 'isDeleted'=>0])
                ->get();
        $cnt = count($user_data);
        if ($cnt !=0 ) {
            Mail::to($email)->send(new WelcomeMail($user,$otp));
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
