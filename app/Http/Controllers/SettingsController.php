<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getSettings() {
        if(auth()->user()->role == 1) {
            $status = Settings::get();
            return view('settings', compact('status'));
        }
        else {
            abort(404);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateStatus(Request $request) {

        if($request->value == 1) {
            Settings::where(['id' => 1])->update(['enable_registration' => 1]);
        }
        if($request->value == 0) {
            Settings::where(['id' => 1])->update(['enable_registration' => 0]);
        }
    }
}
