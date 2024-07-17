<?php

namespace App\Http\Services;

use Hash;
use Session;
use App\Models\Coordinators;
use App\Models\User;
use App\Models\Deans;
use App\Models\Announcements;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Http\Requests\UpdateRequests;

class DeanService {

    protected $Coordinators;
    protected $User;
    protected $UpdateRequests;
    protected $Deans;
    protected $Announcements;
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(Coordinators $Coordinators, User $User, UpdateRequests $UpdateRequests, Deans $Deans, Announcements $Announcements) {
        
        $this->Coordinators = $Coordinators;
        $this->User = $User;
        $this->UpdateRequests = $UpdateRequests;
        $this->Deans = $Deans;
        $this->Announcements = $Announcements;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDeanService() {
        if(auth()->user()->role == 2) {
            $deans = $this->User->where(['role' => 1])->orderBy('name', 'ASC')->get();
            return view('deans', compact('deans'));
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
    public function createDeanService($request) {

        if(!$this->User->where(['email' => $request->input('email')])->exists()) {

            date_default_timezone_set("Asia/Singapore"); 
            $datetime = date('Ymd-His');

            $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
            $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

            $dean = $this->Deans->create([
                'name' => $request->name,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'photo' => $photoFilename
            ]);

            $this->User->create([
                'dean_id' => $dean->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 4,
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
    public function updateDeanService($request) {

        $this->User->where(['dean_id' => $request->id])->update(['email' => null]);
                
        foreach($this->User->get() as $get) {
            if($get->email == $request->email) {
                return response()->json(['Error' => 1, 'Message'=> 'Email is already taken']); 
            }
        }

        if(!empty($request->photo)) {
            if(!empty($request->password)) {

                $this->UpdateRequests->updateDeanPhotoRequest($request);
                $this->UpdateRequests->updateDeanInformationRequest($request);
                $this->UpdateRequests->updateDeanPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
               
            }
            else {
                
                $this->UpdateRequests->updateDeanPhotoRequest($request);
                $this->UpdateRequests->updateDeanInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
        }
        else {
            if(!empty($request->password)) {

                $this->UpdateRequests->updateDeanInformationRequest($request);
                $this->UpdateRequests->updateDeanPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
                
            }
            else {
                  
                $this->UpdateRequests->updateDeanInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
                
            }   
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteDeanService($request) {

        $this->UpdateRequests->deleteDeanPhotoRequest($request);
        $this->Deans->where(['id' => $request->id])->delete();
        $this->User->where(['dean_id' => $request->id])->delete();

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
            $photoFilename = \Str::slug(auth()->user()->name.'-'.$datetime).'.'.$request->photo->extension(); 
            $transferfile = $request->file('photo')->storeAs('public/announcements/', $photoFilename);

            $this->Announcements->create([
                'userid' => auth()->user()->id,
                'description' => $request->news,
                'photo' => $photoFilename
            ]);
        }
        else {
            $this->Announcements->create([
                'userid' => auth()->user()->id,
                'description' => $request->news,
            ]);
        }
        return response()->json(['Error' => 0, 'Message'=> 'Announcement Posted Successfully']);
    }

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deletePostService($request) {

        foreach($this->Announcements->where(['id' => $request->id])->get() as $get) {
            File::delete(public_path("storage/announcements/{$get->photo}"));
        }

        $this->Announcements->where(['id' => $request->id])->delete();
        return response()->json(['Error' => 0, 'Message'=> 'Announcement Deleted Successfully']);
    }
}