<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
   public function __invoke(Request $request) {

        if ($request->isMethod('get')) {
            return view('profile.index');
        } elseif ($request->isMethod('post')) {
            $request->validate([
                'current_password' => 'required',
                'new_password' =>'required|min:8|confirmed',
            ]);
    
            $user = Auth::user();
    
            if(!Hash::check($request->current_password, $user->password)){
                return back()->withErrors(['current_password' => 'Password Saat Ini Tidak Sama']);
            }
    
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return redirect()->route('profile.index')->with('status', 'Password Berhasil Di Update');     
        }
   }
}
