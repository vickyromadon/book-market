<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $request->validate([
                'name'          => 'required|string',
                'email'         => 'required|email',
                'category'      => 'required|string',
                'description'   => 'required|string',
            ]);

            $message                = new Message();
            $message->name          = $request->name;
            $message->email         = $request->email;
            $message->category      = $request->category;
            $message->description   = $request->description;

            if ($message->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'Kirim Pesan Berhasil'
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Kirim Pesan Gagal'
                ]);
            }
        }

        return $this->view();
    }
}
