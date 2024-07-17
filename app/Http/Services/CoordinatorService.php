<?php

namespace App\Http\Services;

use Hash;
use Session;
use App\Models\Coordinators;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Http\Requests\UpdateRequests;

class CoordinatorService {

    protected $Coordinators;
    protected $User;
    protected $UpdateRequests;
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(Coordinators $Coordinators, User $User, UpdateRequests $UpdateRequests) {
        
        $this->Coordinators = $Coordinators;
        $this->User = $User;
        $this->UpdateRequests = $UpdateRequests;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getCoordinatorService() {
        $coordinators = $this->Coordinators->orderBy('name', 'ASC')->get();
        return view('coordinators', compact('coordinators'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createCoordinatorService($request) {

        if(!$this->User->where(['email' => $request->input('email')])->exists()) {

            date_default_timezone_set("Asia/Singapore"); 
            $datetime = date('Ymd-His');

            $photoFilename = \Str::slug($request->name.'-'.$datetime).'.'.$request->photo->extension(); 
            $transferfile = $request->file('photo')->storeAs('public/photo/', $photoFilename);

            $coordinator = $this->Coordinators->create([
                'name' => $request->name,
                'address' => $request->address,
                'contact_number' => $request->contact_number,
                'photo' => $photoFilename,
            ]);

            $this->User->create([
                'coordinator_id' => $coordinator->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 2,
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
    public function updateCoordinatorService($request) {

        $this->User->where(['coordinator_id' => $request->id])->update(['email' => null]);
                
        foreach($this->User->get() as $get) {
            if($get->email == $request->email) {
                return response()->json(['Error' => 1, 'Message'=> 'Email is already taken']); 
            }
        }

        if(!empty($request->photo)) {
            if(!empty($request->password)) {
                
                $this->UpdateRequests->updateCoordinatorPhotoRequest($request);
                $this->UpdateRequests->updateCoordinatorInformationRequest($request);
                $this->UpdateRequests->updateCoordinatorPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
            else {

                $this->UpdateRequests->updateCoordinatorPhotoRequest($request);
                $this->UpdateRequests->updateCoordinatorInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
            }
        }
        else {
            if(!empty($request->password)) {
               
                $this->UpdateRequests->updateCoordinatorInformationRequest($request);
                $this->UpdateRequests->updateCoordinatorPasswordRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
                
            }
            else {
               
                $this->UpdateRequests->updateCoordinatorInformationRequest($request);
                return response()->json(['Error' => 0, 'Message'=> 'Account Updated Successfully']);
               
            }   
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteCoordinatorService($request) {

        $this->UpdateRequests->deleteCoordinatorPhotoRequest($request);
        $this->Coordinators->where(['id' => $request->id])->delete();
        $this->User->where(['coordinator_id' => $request->id])->delete();

        return response()->json(['Error' => 0, 'Message'=> 'Account Deleted Successfully']);
    }
}