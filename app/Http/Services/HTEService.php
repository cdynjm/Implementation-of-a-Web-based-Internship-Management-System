<?php

namespace App\Http\Services;

use Hash;
use Session;
use App\Models\Coordinators;
use App\Models\User;
use App\Models\Deans;
use App\Models\HTE;
use App\Models\News;
use App\Models\MOA;
use App\Models\PullOut;
use App\Models\Intern;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Http\Requests\UpdateRequests;

class HTEService {

    protected $Coordinators;
    protected $User;
    protected $UpdateRequests;
    protected $Deans;
    protected $HTE;
    protected $News;
    protected $MOA;
    protected $Intern;
    protected $PullOut;
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(PullOut $PullOut, MOA $MOA, Coordinators $Coordinators, User $User, UpdateRequests $UpdateRequests, Deans $Deans, HTE $HTE, News $News, Intern $Intern) {
        
        $this->Coordinators = $Coordinators;
        $this->User = $User;
        $this->UpdateRequests = $UpdateRequests;
        $this->Deans = $Deans;
        $this->HTE = $HTE;
        $this->News = $News;
        $this->MOA = $MOA;
        $this->Intern = $Intern;
        $this->PullOut = $PullOut;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getHTEService() {
        if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4) {
            $intern = $this->Intern->where(['training_status' => 3])->orWhere(['training_status' => 4])->get();
            $hte = $this->HTE->orderBy('name', 'ASC')->get();
            return view('host-training-establishments', compact('hte', 'intern'));
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
    public function viewHTEService($request) {

        $year = Session::get('year');

        if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4) {
            $moa = $this->MOA->where(['hte_id' => $request->id])->orderBy('created_at', 'DESC')->get();
            $hte = $this->HTE->where(['id' => $request->id])->get();
            $news = $this->News->where(['hte_id' => $request->id])->get();
            $pull_out = $this->PullOut->where(['hte_id' => $request->id])->get();

            $id = $request->id;

            $interns = $this->Intern->where(function ($query) use($year, $id) {
                $query->where(['year' => $year])->where(['hte' => $id]);
            })->where(function ($query) {
              $query->where(['training_status' => 3])
              ->orWhere(['training_status' => 4])
              ->orWhere(['training_status' => 5])
              ->orderBy('name', 'ASC');
            })->get();

            return view('view-hte', compact('hte', 'news', 'moa', 'pull_out', 'interns'));
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
    public function createHTEService($request) {

        if(!$this->User->where(['email' => $request->input('email')])->exists()) {

            date_default_timezone_set("Asia/Singapore"); 
            $datetime = date('Ymd-His');

            $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
            $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

            $hte = $this->HTE->create([
                'name' => $request->name,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'photo' => $photoFilename,
                'contact_person' => $request->contact_person
            ]);

            $this->User->create([
                'hte_id' => $hte->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 3,
                'avatar' => $photoFilename
            ]);
            
            return response()->json(['Error' => 0, 'Message'=> 'Account Created Successfully']);
        }
        else {
            return response()->json(['Error' => 1, 'Message'=> 'Email is already taken']);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateHTEService($request) {

        $this->User->where(['hte_id' => $request->id])->update(['email' => null]);
                
        foreach($this->User->get() as $get) {
            if($get->email == $request->email) {
                return response()->json(['Error' => 1, 'Message'=> 'Email is already taken']); 
            }
        }

        if(!empty($request->photo)) {
            if(!empty($request->password)) {
            
                $this->UpdateRequests->updateHTEPhotoRequest($request);
                $this->UpdateRequests->updateHTEInformationRequest($request);
                $this->UpdateRequests->updateHTEPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
            else {
                
                $this->UpdateRequests->updateHTEPhotoRequest($request);
                $this->UpdateRequests->updateHTEInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
        }
        else {
            if(!empty($request->password)) {

                $this->UpdateRequests->updateHTEInformationRequest($request);
                $this->UpdateRequests->updateHTEPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
            else {
               
                $this->UpdateRequests->updateHTEInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }   
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteHTEService($request) {

        $this->UpdateRequests->deleteHTEPhotoRequest($request);
        $this->HTE->where(['id' => $request->id])->delete();
        $this->User->where(['hte_id' => $request->id])->delete();

        return response()->json(['Error' => 0, 'Message'=> 'Account Deleted Successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createPostService($request) {

        if(strlen($request->news) > 500) {
            return response()->json(['Error' => 1, 'Message'=> 'Your post is more than 500 characters']);
        }

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        if(!empty($request->photo)) {
            $photoFilename = \Str::slug(auth()->user()->HTE->name.'-'.$datetime).'.'.$request->photo->extension(); 
            $transferfile = $request->file('photo')->storeAs('public/post/', $photoFilename);

            $this->News->create([
                'hte_id' => auth()->user()->HTE->id,
                'description' => $request->news,
                'photo' => $photoFilename
            ]);
        }
        else {
            $this->News->create([
                'hte_id' => auth()->user()->HTE->id,
                'description' => $request->news,
            ]);
        }
        return response()->json(['Error' => 0, 'Message'=> 'News Posted Successfully']);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deletePostService($request) {

        foreach($this->News->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/post/{$get->photo}"));
        }

        $this->News->where(['id' => $request->id])->delete();
        return response()->json(['Error' => 0, 'Message'=> 'News Deleted Successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createMOAService($request) {

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');
        $year = date('Y');

        $filename = \Str::slug('MOA-'.$datetime).'.'.$request->moa->extension(); 
        $transferfile = $request->file('moa')->storeAs('public/MOA/', $filename);

        $this->MOA->create([
            'hte_id' => $request->id,
            'description' => 'MOA - '.$year,
            'file' => $filename
        ]);
      
        return response()->json(['Error' => 0, 'Message'=> 'MOA uploaded Successfully']);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createTerminationService($request) {

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');
        $year = date('Y');

        $filename = \Str::slug('Termination-Letter-'.$datetime).'.'.$request->termination->extension(); 
        $transferfile = $request->file('termination')->storeAs('public/termination/', $filename);

        $this->PullOut->create([
            'hte_id' => $request->id,
            'description' => 'Termination Letter - '.$year,
            'file' => $filename
        ]);
      
        return response()->json(['Error' => 0, 'Message'=> 'Termination Letter uploaded Successfully']);
    }

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteMOAService($request) {

        foreach($this->MOA->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/MOA/{$get->file}"));
        }

        $this->MOA->where(['id' => $request->id])->delete();
        return response()->json(['Error' => 0, 'Message'=> 'MOA Deleted Successfully']);
    }

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteTerminationService($request) {

        foreach($this->PullOut->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/termination/{$get->file}"));
        }

        $this->PullOut->where(['id' => $request->id])->delete();
        return response()->json(['Error' => 0, 'Message'=> 'Termination Letter Deleted Successfully']);
    }

    public function printInternsService($id) {

        $year = Session::get('year');
        
        $val = 1;

        $interns = $this->Intern->where(['hte' => $id])->where(['training_status' => 5])->where(['year' => $year])->orderBy('name', 'ASC')->get();
        $hte = $this->HTE->where(['id' => $id])->first();
        $coordinators = $this->Coordinators->where(['status' => 1])->orderBy('name', 'ASC')->get();
        $deans = $this->User->where(['role' => 1])->get();

        return view('print.interns', compact('interns', 'hte', 'coordinators', 'deans', 'val'));
    }

    public function printAllService() {

        $year = Session::get('year');
        
        $val = 2;

        $interns = $this->Intern->where(['training_status' => 5])->where(['year' => $year])->orderBy('name', 'ASC')->get();
        $hte = $this->HTE->where(['status' => 1])->get();
        $coordinators = $this->Coordinators->where(['status' => 1])->orderBy('name', 'ASC')->get();
        $deans = $this->User->where(['role' => 1])->get();

        return view('print.interns', compact('interns', 'hte', 'coordinators', 'deans', 'val'));
    }
}