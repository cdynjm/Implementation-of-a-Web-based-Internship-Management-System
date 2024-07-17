<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use App\Models\Coordinators;
use App\Models\User;
use App\Models\Deans;
use App\Models\HTE;
use App\Models\News;
use App\Models\MOA;
use App\Models\Intern;
use App\Models\Requirements;
use App\Models\Documents;
use App\Models\Comments;
use App\Models\PullOut;
use App\Models\Announcements;
use App\Http\Requests\UpdateRequests;

class InfoUserController extends Controller
{
    protected $Coordinators;
    protected $User;
    protected $UpdateRequests;
    protected $Deans;
    protected $HTE;
    protected $Intern;
    protected $Requirements;
    protected $Documents;
    protected $Comments;
    protected $PullOut;
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(PullOut $PullOut, Coordinators $Coordinators, User $User, UpdateRequests $UpdateRequests, Deans $Deans, HTE $HTE, Intern $Intern, Requirements $Requirements, Documents $Documents, Comments $Comments) {
        
        $this->Coordinators = $Coordinators;
        $this->User = $User;
        $this->UpdateRequests = $UpdateRequests;
        $this->Deans = $Deans;
        $this->HTE = $HTE;
        $this->Intern = $Intern;
        $this->Requirements = $Requirements;
        $this->Documents = $Documents;
        $this->Comments = $Comments;
        $this->PullOut = $PullOut;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function create()
    {
        $coordinators = Coordinators::get();
        $hte = HTE::where(['status' => 1])->get();
        $announcements = Announcements::orderBy('created_at', 'DESC')->get();
        $intern = Intern::where(['training_status' => 3])->orWhere(['training_status' => 4])->get();
        if(auth()->user()->role == 3) {
            $moa = MOA::where(['hte_id' => auth()->user()->HTE->id])->orderBy('created_at', 'DESC')->get();
            $pull_out = PullOut::where(['hte_id' => auth()->user()->HTE->id])->orderBy('created_at', 'DESC')->get();
            $news = News::where(['hte_id' => auth()->user()->HTE->id])->orderBy('created_at', 'DESC')->get();
            return view('laravel-examples/user-profile', compact('coordinators', 'hte', 'news', 'moa', 'pull_out', 'intern'));
        }
        else {
            return view('laravel-examples/user-profile', compact('coordinators', 'hte', 'intern', 'announcements'));
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function store(Request $request)
    {

        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone'     => ['max:50'],
            'location' => ['max:70'],
            'about_me'    => ['max:150'],
        ]);
        if($request->get('email') != Auth::user()->email)
        {
            if(env('IS_DEMO') && Auth::user()->id == 1)
            {
                return redirect()->back()->withErrors(['msg2' => 'You are in a demo version, you can\'t change the email address.']);
                
            }
            
        }
        else{
            $attribute = request()->validate([
                'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            ]);
        }
        
        
        User::where('id',Auth::user()->id)
        ->update([
            'name'    => $attributes['name'],
            'email' => $attribute['email'],
            'phone'     => $attributes['phone'],
            'location' => $attributes['location'],
            'about_me'    => $attributes["about_me"],
        ]);


        return redirect('/user-profile')->with('success','Profile updated successfully');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAdminAccount(Request $request) {
    
        $this->User->where(['id' => $request->id])->update(['email' => null]);
                
        foreach($this->User->get() as $get) {
            if($get->email == $request->email) {
                return response()->json(['Error' => 1, 'Message'=> 'Email is already taken']); 
            }
        }

        if(!empty($request->photo)) {
            if(!empty($request->password)) {
                
                $this->UpdateRequests->updateAdminPhotoRequest($request);
                $this->UpdateRequests->updateAdminInformationRequest($request);
                $this->UpdateRequests->updateAdminPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
               
            }
            else {
                $this->UpdateRequests->updateAdminPhotoRequest($request);
                $this->UpdateRequests->updateAdminInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
        }
        else {
            if(!empty($request->password)) {
                $this->UpdateRequests->updateAdminInformationRequest($request);
                $this->UpdateRequests->updateAdminPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
            else {
                $this->UpdateRequests->updateAdminInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }   
        }
    }
}
