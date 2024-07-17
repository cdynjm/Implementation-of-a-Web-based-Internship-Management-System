<?php

namespace App\Http\Services;

use Hash;
use Session;
use Route;
use App\Models\Coordinators;
use App\Models\User;
use App\Models\Deans;
use App\Models\HTE;
use App\Models\Intern;
use App\Models\Requirements;
use App\Models\Documents;
use App\Models\Comments;
use App\Models\EmailVerification;
use App\Models\Termination;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Mail;
use App\Mail\SendEmail;

use App\Http\Requests\UpdateRequests;

class InternService {

    protected $Coordinators;
    protected $User;
    protected $UpdateRequests;
    protected $Deans;
    protected $HTE;
    protected $Intern;
    protected $Requirements;
    protected $Documents;
    protected $Comments;
    protected $Termination;
    protected $EmailVerification;
    protected $ResetPassword;
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(ResetPassword $ResetPassword, EmailVerification $EmailVerification, Termination $Termination, Coordinators $Coordinators, User $User, UpdateRequests $UpdateRequests, Deans $Deans, HTE $HTE, Intern $Intern, Requirements $Requirements, Documents $Documents, Comments $Comments) {
        
        $this->Coordinators = $Coordinators;
        $this->User = $User;
        $this->UpdateRequests = $UpdateRequests;
        $this->Deans = $Deans;
        $this->HTE = $HTE;
        $this->Intern = $Intern;
        $this->Requirements = $Requirements;
        $this->Documents = $Documents;
        $this->Comments = $Comments;
        $this->Termination = $Termination;
        $this->EmailVerification = $EmailVerification;
        $this->ResetPassword = $ResetPassword;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getInternService() {

        $year = Session::get('year');
        $termination = $this->Termination->get();
        $pending = $this->Intern->where(['year' => $year])->orderBy('name', 'ASC')->get();
        
        if(auth()->user()->role == 1 || auth()->user()->role == 4) {
            $interns = $this->Intern->where(['year' => $year])->orderBy('name', 'ASC')->get();
        }
        if(auth()->user()->role == 2) {
            $interns = $this->Intern->where(['year' => $year])->where(['coordinator' => auth()->user()->coordinator_id])->orderBy('name', 'ASC')->get();
        }
        if(auth()->user()->role == 3) {
            $interns = $this->Intern->where(function ($query) use($year) {
                $query->where(['year' => $year])->where(['hte' => auth()->user()->hte_id]);
            })->where(function ($query) {
              $query->where(['training_status' => 3])
              ->orWhere(['training_status' => 4])
              ->orWhere(['training_status' => 5])
              ->orderBy('name', 'ASC');
            })->get();
        }

        if(auth()->user()->role != 5) {
            if(str_contains(request()->url(), 'interns') == true) {
                return view('interns', compact('interns', 'termination', 'pending'));
            }
        }
    

        if(auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 4) {

            if(str_contains(request()->url(), 'for-checking') == true) {
                return view('for-checking', compact('interns', 'termination'));
            }
            if(str_contains(request()->url(), 'for-application') == true) {
                return view('for-application', compact('interns', 'termination'));
            }
            if(str_contains(request()->url(), 'submit-requirements') == true) {
                return view('intern.submit-requirements', compact('interns', 'termination'));
            }
            if(str_contains(request()->url(), 'to-apply') == true) {
                return view('intern.for-application-intern', compact('interns', 'termination'));
            }
            if(str_contains(request()->url(), 'on-training') == true) {
                return view('intern.on-training', compact('interns', 'termination'));
            }
            if(str_contains(request()->url(), 'completed') == true) {
                return view('intern.completed', compact('interns', 'termination'));
            }
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
    public function viewInternService($request) {

        if(auth()->user()->role != 5) {
            $intern = $this->Intern->where(['id' => $request->id])->get();
            $documents = $this->Documents->where(['intern_id' => $request->id])->orderBy('created_at', 'DESC')->get();
            return view('view-intern', compact('intern', 'documents'));
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
    public function verifyEmailService($request) {
        
        foreach($this->User->get() as $get) {
            if($get->email == $request->email) {
                return response()->json(['Error' => 1, 'Message'=> 'Email is already taken']); 
            }
        }

        $this->EmailVerification->where(['email' => $request->email])->delete();

        $email = $this->EmailVerification->create([
            'email' => $request->email,
            'code' => \Str::random(6)
        ]);

        $subject = 'Verification Code';
        $body = 'Your verification code is: '.$email->code;

        Mail::to($email->email)->send(new SendEmail($subject, $body));

        return response()->json(['Error' => 0]); 
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createInternService($request) {

        foreach($this->EmailVerification->where(['email' => $request->email])->get() as $get) {
            if($get->code != $request->code) {
                return response()->json(['Error' => 1, 'Message'=> 'Your verification code is invalid. Please try again']);
            }
        }

        $this->EmailVerification->where(['email' => $request->email])->delete();

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
        $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

        $validIDFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
        $transferfile = $request->file('validID')->storeAs('public/valid-id/', $validIDFilename);

        $intern = $this->Intern->create([
            'name' => ucwords($request->name),
            'studentid' => $request->studentid,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'course' => $request->course,
            'major' => $request->major,
            'year' => $request->year,
            'coordinator' => $request->coordinator,
            'hte' => $request->hte,
            'photo' => $photoFilename,
            'valid_id' => $validIDFilename
        ]);

        $user = $this->User->create([
            'intern_id' => $intern->id,
            'name' => ucwords($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 5,
            'avatar' => $photoFilename
        ]);
        
        Auth::login($user);

        return response()->json(['Error' => 0, 'Message'=> 'Your account created successfully']); 
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function validateInternService($request) {

        $this->Intern->where(['id' => $request->id])->update(['status' => 1]);
        return response()->json(['Error' => 0, 'Message'=> 'Account validated successfully']); 

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function declineInternService($request) {

        $user = $this->User->where(['intern_id' => $request->id])->first();

        $subject = 'Account Registration is declined.';
        $body = $request->description;

        Mail::to($user->email)->send(new SendEmail($subject, $body));

        foreach($this->Intern->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
            File::delete(public_path("storage/valid-id/{$get->valid_id}"));
        }

        $this->Intern->where(['id' => $request->id])->delete();
        $this->User->where(['intern_id' => $request->id])->delete();
        
        return response()->json(['Error' => 0, 'Message'=> 'Account declined successfully']); 

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getRequirementsService() {
        $requirements = $this->Requirements->orderBy('description', 'ASC')->get();
        return view('requirements', compact('requirements'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getRequirementsToDashboard() {
        return $this->Requirements->orderBy('description', 'ASC')->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createRequirementsService($request) {
        $this->Requirements->create(['description' => $request->description, 'type' => $request->type, 'category' => $request->category]);
        return response()->json(['Error' => 0, 'Message'=> 'Requirement added successfully']); 
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateRequirementsService($request) {
        $this->Requirements->where(['id' => $request->id])->update(['description' => $request->description, 'type' => $request->type, 'category' => $request->category]);
        return response()->json(['Error' => 0, 'Message'=> 'Requirement updated successfully']); 
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteRequirementsService($request) {
        $this->Requirements->where(['id' => $request->id])->delete();
        return response()->json(['Error' => 0, 'Message'=> 'Requirement deleted successfully']); 
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocuments() {
        return $this->Documents->where(['intern_id' => auth()->user()->Intern->id])->orderBy('created_at', 'DESC')->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function uploadPreRequirementsService($request) {
        
        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        foreach($this->Requirements->where(['id' => $request->filename])->get() as $get) {
            $filename = $get->description;
        }

        $documentFileName = \Str::slug(auth()->user()->name.'-'.$filename.'-'.$datetime).'.'.$request->document->extension(); 
        $transferfile = $request->file('document')->storeAs('public/documents/', $documentFileName);

        $this->Documents->create([
            'intern_id' => auth()->user()->Intern->id,
            'hte_id' => auth()->user()->Intern->hte,
            'coordinator_id' => auth()->user()->Intern->coordinator,
            'name' => $request->filename,
            'file' => $documentFileName,
            'date' => date('Y-m-d'),
            'type' => 1,
            'status' => 0
        ]);
    
        return response()->json(['Error' => 0, 'Message'=> 'File uploaded successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function uploadPostRequirementsService($request) {
        
        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        foreach($this->Requirements->where(['id' => $request->filename])->get() as $get) {
            $filename = $get->description;
        }

        $documentFileName = \Str::slug(auth()->user()->name.'-'.$filename.'-'.$datetime).'.'.$request->document->extension(); 
        $transferfile = $request->file('document')->storeAs('public/documents/', $documentFileName);

        $this->Documents->create([
            'intern_id' => auth()->user()->Intern->id,
            'hte_id' => auth()->user()->Intern->hte,
            'coordinator_id' => auth()->user()->Intern->coordinator,
            'name' => $request->filename,
            'file' => $documentFileName,
            'date' => date('Y-m-d'),
            'type' => 2,
            'status' => 0,
            'check_document' => 1
        ]);
    
        return response()->json(['Error' => 0, 'Message'=> 'File uploaded successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function submitPreDocumentsService($request) {

        if($request->submission == true) {

            $message = '';

            foreach($this->Requirements->where(['type' => 1])->where(['category' => 1])->get() as $req) {
                $lacking = $this->Documents->where(['name' => $req->id])->where(['intern_id' => auth()->user()->Intern->id])->where(['type' => 1])->count();
                if($lacking == 0) {
                    $message .= $req->description."<br>";
                }
            }

            if($message == '') {

                $this->Documents->where(['intern_id' => auth()->user()->Intern->id])->where(['type' => 1])->update([
                    'status' => 1
                ]);

                $this->Intern->where(['id' => auth()->user()->Intern->id])->update([
                    'training_status' => 1
                ]);

                $this->Comments->where(['intern_id' => auth()->user()->Intern->id])->delete();

                return response()->json(['Error' => 0, 'Message'=> 'Your documents submitted successfully']);
            }
            else {
                return response()->json(['Error' => 1, 'Message' => "Requirements are lacking. Please upload the following: <br><br><span class='text-sm fw-bolder'>". $message."</span>"]);
            }
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deletePreDocumentService($request) {

        foreach($this->Documents->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/documents/{$get->file}"));
        }

        $this->Documents->where(['id' => $request->id])->delete();
        return response()->json(['Error' => 0, 'Message'=> 'File deleted successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function approvePreDocumentService($request) {
        if($this->Documents->where(['intern_id' => $request->id])->where(['type' => 1])->where(['check_document' => null])->count() > 0) {
            return response()->json(['Error' => 1, 'Message'=> 'Please examine and evaluate all papers before approving.']);
        }
        $this->Documents->where(['intern_id' => $request->id])->where(['type' => 1])->update(['status' => 2]);
        $this->Intern->where(['id' => $request->id])->update(['training_status' => 2]);
        return response()->json(['Error' => 0, 'Message'=> 'Requirements approved successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function declinePreDocumentService($request) {

        if($this->Comments->where(['intern_id' => $request->id])->exists()) {
            $this->Comments->where(['intern_id' => $request->id])->update([
                'comment' => $request->comment
            ]);
        }
        else {
            $this->Comments->create([
                'intern_id' => $request->id,
                'comment' => $request->comment
            ]);
        }

        $this->Documents->where(['intern_id' => $request->id])->where(['type' => 1])->update(['status' => 0]);
        $this->Intern->where(['id' => $request->id])->update(['training_status' => null]);
        
        return response()->json(['Error' => 0, 'Message'=> 'Requirements declined successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function sendApplicationService($request)  {

        foreach($this->Intern->where(['id' => $request->id])->get() as $get) {
            if($get->hte == null) {
                if(auth()->user()->role == 2)
                    return response()->json(['Error' => 3, 'Message'=> 'Please advise the student to select HTE from their Profile']);
                if(auth()->user()->role == 5)
                    return response()->json(['Error' => 3, 'Message'=> 'Please Select HTE in your Profile']);
            }

            $hte = $get->hte;
            $countSlot =  $this->Intern->where(function ($query) use ($hte)  {
                $query->where(['hte' => $hte]);
            })->where(function ($query) {
              $query->orWhere(['training_status' => 3])
              ->orWhere(['training_status' => 4])
              ->orWhere(['training_status' => 5]);
            })->count();

            $hteSlot = $this->HTE->where(['id' => $get->hte])->first();

            if($countSlot >= $hteSlot->slot) {
                return response()->json(['Error' => 4, 'Message'=> 'The number of interns needed by the HTE has already been reached.']);
            }
        }

        $this->Comments->where(['intern_id' => $request->id])->delete();
        $this->Termination->where(['intern_id' => $request->id])->delete();

        $this->Documents->where(['intern_id' => $request->id])->where(['type' => 1])->update(['status' => 3]);
        $this->Intern->where(['id' => $request->id])->update(['training_status' => 3]);

        if($request->URL_Path == "for-application") {
            return response()->json(['Error' => 1, 'Message'=> 'Application sent successfully']);
        }
        if($request->URL_Path == "dashboard") {
            return response()->json(['Error' => 2, 'Message'=> 'Application sent successfully']);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function acceptApplicationService($request)  {
        $this->Documents->where(['intern_id' => $request->id])->where(['type' => 1])->update(['status' => 4]);
        $this->Intern->where(['id' => $request->id])->update(['training_status' => 4]);
        return response()->json(['Error' => 0, 'Message'=> 'Application accepted successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function declineApplicationService($request)  {

        if($this->Comments->where(['intern_id' => $request->id])->exists()) {
            $this->Comments->where(['intern_id' => $request->id])->update([
                'comment' => $request->comment
            ]);
        }
        else {
            $this->Comments->create([
                'intern_id' => $request->id,
                'comment' => $request->comment
            ]);
        }

        $this->Documents->where(['intern_id' => $request->id])->update(['status' => 2]);
        $this->Intern->where(['id' => $request->id])->update(['training_status' => 2]);
        return response()->json(['Error' => 0, 'Message'=> 'Application declined successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function completeTrainingService($request)  {

        $message = '';

        foreach($this->Requirements->where(['type' => 2])->where(['category' => 1])->get() as $req) {
            $lacking = $this->Documents->where(['name' => $req->id])->where(['intern_id' => $request->id])->where(['type' => 2])->count();
            if($lacking == 0) {
                $message .= $req->description."<br>";
            }
        }

        if($message == '') {
            $this->Documents->where(['intern_id' => $request->id])->update(['status' => 5]);
            $this->Intern->where(['id' => $request->id])->update(['training_status' => 5]);
            return response()->json(['Error' => 0, 'Message'=> 'Training have completed successfully']);
        }
        else {
            return response()->json(['Error' => 1, 'Message' => "Requirements are lacking. Please advise the intern that the following files must be uploaded: <br><br><span class='text-sm fw-bolder'>". $message."</span>"]);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getComments() {
        return $this->Comments->where(['intern_id' => auth()->user()->Intern->id])->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateInternService($request) {

        $this->User->where(['intern_id' => $request->id])->update(['email' => null]);
                
        foreach($this->User->get() as $get) {
            if($get->email == $request->email) {
                return response()->json(['Error' => 1, 'Message'=> 'Email is already taken']); 
            }
        }

        if(!empty($request->photo)) {
            if(!empty($request->password)) {
                
                $this->UpdateRequests->updateInternPhotoRequest($request);
                $this->UpdateRequests->updateInternInformationRequest($request);
                $this->UpdateRequests->updateInternPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
            else {
                
                $this->UpdateRequests->updateInternPhotoRequest($request);
                $this->UpdateRequests->updateInternInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
        }
        else {
            if(!empty($request->password)) {

                $this->UpdateRequests->updateInternInformationRequest($request);
                $this->UpdateRequests->updateInternPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
            else {
               
                $this->UpdateRequests->updateInternInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }   
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function searchYearService($request) {
        $request->session()->put('year', $request->year);
        return response()->json(['Error' => 0, 'Message'=> '']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function searchInternService($request) {

        $year = Session::get('year');
        $search = $request->intern;
        $termination = $this->Termination->get();

        $pending = $this->Intern->where(function ($query) use ($year)  {
            $query->where(['year' => $year]);
        })->where(function ($query) use ($search) {
          $query->where('name', 'like', '%'.$search.'%')
          ->orWhere('studentid', 'like', '%'.$search.'%');
        })->get();

        if(auth()->user()->role == 1 || auth()->user()->role == 4) {
            $interns = $this->Intern->where(function ($query) use ($year)  {
                $query->where(['year' => $year]);
            })->where(function ($query) use ($search) {
              $query->where('name', 'like', '%'.$search.'%')
              ->orWhere('studentid', 'like', '%'.$search.'%');
            })->get();
        }

        if(auth()->user()->role == 2) {
            $interns = $this->Intern->where(function ($query) use ($year)  {
                $query->where(['year' => $year])->where(['coordinator' => auth()->user()->Coordinator->id]);
            })->where(function ($query) use ($search) {
              $query->where('name', 'like', '%'.$search.'%')
              ->orWhere('studentid', 'like', '%'.$search.'%');
            })->get();
        }

        if(auth()->user()->role == 3) {
            $interns = $this->Intern->where(function ($query) use ($year)  {
                $query->where(['year' => $year])->where(['hte' => auth()->user()->HTE->id]);
            })->where(function ($query) use ($search) {
              $query->where('name', 'like', '%'.$search.'%')
              ->orWhere('studentid', 'like', '%'.$search.'%');
            })->where(function ($query) use ($search) {
                $query->orWhere(['training_status' => 3])
                ->orWhere(['training_status' => 4])
                ->orWhere(['training_status' => 5]);
            })->get();
        }

        return response()->json(['Pending' => view('table.pending-table', compact('pending', 'termination'))->render(), 'Validated' => view('table.validated-table', compact('interns', 'termination'))->render()]);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function checkDocumentService($request) {

        $this->Documents->where(['id' => $request->id])->update(['check_document' => 1]);
        return response()->json(['Error' => 0]); 
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function uncheckDocumentService($request) {

        $this->Documents->where(['id' => $request->id])->update(['check_document' => null]);
        return response()->json(['Error' => 0]); 
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnDocumentService($request) {
        $this->Documents->where(['intern_id' => $request->id])->where(['type' => 1])->update(['status' => 1]);
        $this->Intern->where(['id' => $request->id])->update(['training_status' => 1]);
        return response()->json(['Error' => 0, 'Message'=> 'Returned successfully']);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function terminateInternService($request) {

        $this->Documents->where(['intern_id' => $request->id])->where(['type' => 1])->update(['status' => 2]);
        $this->Intern->where(['id' => $request->id])->update(['training_status' => 2, 'hte' => null]);

        $this->Termination->create([
            'intern_id' => $request->id
        ]);

        return response()->json(['Error' => 0, 'Message'=> 'Intern has been terminated successfully']);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function assignInternCoordinatorService($request) {

        $year = Session::get('year');

        $coordinators = $this->Coordinators->where(['status' => 1])->orderBy('name', 'ASC')->get();
        $interns = $this->Intern->where(['status' => 1])->where(['year' => $year])->orderBy('name', 'ASC')->get();
        return view('assign-student-coordinator', compact('coordinators', 'interns'));

    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function assignInternService(Request $request) {

        foreach($request->intern as $key => $value) {

            $this->Intern->where(['id' => $value])->update(['coordinator' => $request->coordinator]);
        }

        return response()->json(['Error' => 0, 'Message'=> 'Intern has been assigned successfully']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function sendCodeService(Request $request) {

       if($this->User->where(['email' => $request->email])->count() == 0) {
            return response()->json(['Error' => 1, 'Message'=> 'We apologize, but nothing in our database matches the email address you have provided. Please try again.']);
       }

       $this->ResetPassword->where(['email' => $request->email])->delete();

       $reset = $this->ResetPassword->create([
            'email' => $request->email,
            'code' => \Str::random(6)
        ]);

        $subject = 'Reset Password.';
        $body = 'Your Reset code is: '.$reset->code;

        Mail::to($reset->email)->send(new SendEmail($subject, $body));

        return response()->json(['Error' => 0, 'Message'=> 'Reset Code has been sent successfully. Please check your gmail account inbox.']);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function verifyCodeService(Request $request) {

        if($this->ResetPassword->where(['email' => $request->email])->where(['code' => $request->code])->count() == 0) {
            return response()->json(['Error' => 1, 'Message'=> 'Your reset code is invalid. Please try again.']);
       }
       $this->ResetPassword->where(['email' => $request->email])->where(['code' => $request->code])->delete();
       return response()->json(['Error' => 0, 'Message'=> 'Your password has been resetted successfully. Please create new password.']);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function changePasswordService(Request $request) {

       $user = $this->User->where(['email' => $request->email])
                ->update(['password' => Hash::make($request->password)]);
                
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return response()->json(['Error' => 0, 'Message'=> 'Your password has been updated successfully.']);
        }  
    }
}