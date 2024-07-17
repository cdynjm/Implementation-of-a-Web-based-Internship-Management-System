<?php

namespace App\Http\Requests;

use Hash;
use Session;
use App\Models\Coordinators;
use App\Models\Deans;
use App\Models\User;
use App\Models\Documents;
use App\Models\HTE;
use App\Models\Intern;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UpdateRequests {

    protected $Coordinators;
    protected $User;
    protected $Deans;
    protected $HTE;
    protected $Intern;
    protected $Documents;
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(Coordinators $Coordinators, User $User, Deans $Deans, HTE $HTE, Intern $Intern, Documents $Documents) {
        
        $this->Coordinators = $Coordinators;
        $this->User = $User;
        $this->Deans = $Deans;
        $this->HTE = $HTE;
        $this->Intern = $Intern;
        $this->Documents = $Documents;
    }

    //COORDINATOR REQUESTS:
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateCoordinatorInformationRequest($request) {

        $this->Coordinators->where(['id' => $request->id])->update([
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
        ]);

        if($request->status != null) {
            $this->Coordinators->where(['id' => $request->id])->update([
                'status' => $request->status
            ]);
        }

        $this->User->where(['coordinator_id' => $request->id])->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateCoordinatorPasswordRequest($request) {

        $this->User->where(['coordinator_id' => $request->id])->update([
            'password' => Hash::make($request->password)
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateCoordinatorPhotoRequest($request) {

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        foreach($this->Coordinators->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }

        $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
        $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

        $this->Coordinators->where(['id' => $request->id])->update([
            'photo' => $photoFilename
        ]);

        $this->User->where(['coordinator_id' => $request->id])->update([
            'avatar' => $photoFilename
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteCoordinatorPhotoRequest($request) {

        foreach($this->Coordinators->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }
    }

    //DEAN REQUESTS:
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateDeanInformationRequest($request) {

        $this->Deans->where(['id' => $request->id])->update([
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
        ]);

        $this->User->where(['dean_id' => $request->id])->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateDeanPasswordRequest($request) {

        $this->User->where(['dean_id' => $request->id])->update([
            'password' => Hash::make($request->password)
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateDeanPhotoRequest($request) {

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        foreach($this->Deans->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }

        $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
        $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

        $this->Deans->where(['id' => $request->id])->update([
            'photo' => $photoFilename
        ]);

        $this->User->where(['dean_id' => $request->id])->update([
            'avatar' => $photoFilename
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteDeanPhotoRequest($request) {

        foreach($this->Deans->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }
    }

    //HTE REQUESTS:
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateHTEInformationRequest($request) {

        $this->HTE->where(['id' => $request->id])->update([
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'slot' => $request->slot,
            'contact_person' => $request->contact_person
        ]);

        if($request->status != null) {
            $this->HTE->where(['id' => $request->id])->update([
                'status' => $request->status
            ]);
        }

        $this->User->where(['hte_id' => $request->id])->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateHTEPasswordRequest($request) {

        $this->User->where(['hte_id' => $request->id])->update([
            'password' => Hash::make($request->password)
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateHTEPhotoRequest($request) {

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        foreach($this->HTE->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }

        $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
        $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

        $this->HTE->where(['id' => $request->id])->update([
            'photo' => $photoFilename
        ]);

        $this->User->where(['hte_id' => $request->id])->update([
            'avatar' => $photoFilename
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteHTEPhotoRequest($request) {

        foreach($this->HTE->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }
    }

    //ADMIN REQUESTS:
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAdminInformationRequest($request) {

        $this->User->where(['id' => $request->id])->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAdminPasswordRequest($request) {

        $this->User->where(['id' => $request->id])->update([
            'password' => Hash::make($request->password)
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAdminPhotoRequest($request) {

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        foreach($this->User->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }

        $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
        $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

        $this->User->where(['id' => $request->id])->update([
            'photo' => $photoFilename
        ]);

        $this->User->where(['id' => $request->id])->update([
            'avatar' => $photoFilename
        ]);
    }

    //INTERN REQUESTS:
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateInternInformationRequest($request) {

        if(auth()->user()->Intern->training_status == 0 || auth()->user()->Intern->training_status == 1 || auth()->user()->Intern->training_status == 2) {
            $this->Intern->where(['id' => $request->id])->update([
                'hte' => $request->hte
            ]);
            $this->Documents->where(['intern_id' => $request->id])->update(['hte_id' => $request->hte]);
        }
     
        $this->User->where(['intern_id' => $request->id])->update([
            'email' => $request->email
        ]);
       
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateInternPasswordRequest($request) {

        $this->User->where(['intern_id' => $request->id])->update([
            'password' => Hash::make($request->password)
        ]);

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateInternPhotoRequest($request) {

        date_default_timezone_set("Asia/Singapore"); 
        $datetime = date('Ymd-His');

        foreach($this->Intern->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/photo/{$get->photo}"));
        }

        $photoFilename = \Str::slug(auth()->user()->Intern->name.'-'.$datetime).'.'.$request->photo->extension(); 
        $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

        $this->Intern->where(['id' => $request->id])->update([
            'photo' => $photoFilename
        ]);

        $this->User->where(['intern_id' => $request->id])->update([
            'avatar' => $photoFilename
        ]);
    }
}