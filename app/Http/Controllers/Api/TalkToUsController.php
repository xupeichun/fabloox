<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TalkToUsController extends Controller
{
    //
    public function talkToUs(Request $request)
    {

        $validator = validator($request->all(), [
            'subject' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);




        ///chane


        if ($validator->fails()) {
            return $this->prepareResult(401, null, $validator->errors()->first(), '');
        }


        $data = $request->all();

//        \Mail::send('emails.talk-to-us', ['data' => $data],
//            function ($m) {
//                $m->from('test@sprintart.com', 'Talk to us');
//                $m->to('adnanmumtazmayo@gmail.com', 'Adnan Mumtaz')
//                    ->subject('Inquiry recieved');
//            });
//
//
//        \Mail::send('emails.talk-to-us', ['data' => $data],
//            function ($m) {
//                $m->from('test@sprintart.com', 'Talk to us');
//                $m->to('17110122@lums.edu.pk', 'Nayum gora')
//                    ->subject('Inquiry recieved');
//            });

        \Mail::send('emails.talk-to-us', ['data' => $data],
            function ($m) {
                $m->from('test@sprintart.com', 'Talk to us');
                $m->to('info@fabloox.com', 'Fabloox')
                    ->subject('Inquiry received');
            });


        return $this->prepareResult(200, null, 'Message sent successfully', '');

    }
}
