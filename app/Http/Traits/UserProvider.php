<?php

namespace App\Http\Traits;

use App\User;
use Illuminate\Http\Request;

trait UserProvider {
    public function settings(Request $request)
    {
        //dd($request->password,$request->isPublic, $request->user_id);
        $user = User::find($request->user_id);

        if($request->isPublic == 'on') {
            $user->is_public_dir = true;
            $user->password_dir = $request->password;
        }
        else {
            $user->is_public_dir = false;
            $user->password_dir = null;
        }
        $user->save();
        return redirect('/dashboard')->with('success', 'Password set successfully');;
    }

}
