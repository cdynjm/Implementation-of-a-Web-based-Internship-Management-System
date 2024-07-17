<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Services\InternService;

use App\Models\User;
use App\Models\Deans;
use App\Models\HTE;
use App\Models\Intern;
use App\Models\Requirements;
use App\Models\Documents;
use App\Models\Comments;
use App\Models\Coordinators;
use App\Models\News;
use App\Models\Announcements;
use App\Models\Termination;

class HomeController extends Controller
{
    protected $InternService;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(InternService $InternService) {
        $this->InternService = $InternService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function home()
    {
        $year = Session::get('year');

        $announcements = Announcements::orderBy('created_at', 'DESC')->limit(5)->get();

        if(auth()->user()->role == 5) {
            $requirements = $this->InternService->getRequirementsToDashboard();
            $documents = $this->InternService->getDocuments();
            $comment = $this->InternService->getComments();
            $news = News::orderBy('created_at', 'DESC')->limit(20)->get();
            $termination = Termination::where(['intern_id' => auth()->user()->Intern->id])->get();
            return view('dashboard', compact('requirements', 'documents', 'comment', 'news', 'termination', 'announcements'));
        }
        else {
            
            $count_coordinators = Coordinators::where(['status' => 1])->count();
            $count_hte = HTE::where(['status' => 1])->count();
            $count_dean = Deans::count();

            $count_application = 0;
            $count_training = 0;
            $count_completed = 0;
            $count_interns = 0;

            if(auth()->user()->role == 1 || auth()->user()->role == 4) {
                $count_interns =  Intern::where(function ($query) use ($year)  {
                    $query->where(['year' => $year]);
                })->where(function ($query) {
                  $query->orWhere(['training_status' => 2])
                  ->orWhere(['training_status' => 3])
                  ->orWhere(['training_status' => 4])
                  ->orWhere(['training_status' => 5]);
                })->count();
                $news = News::orderBy('created_at', 'DESC')->limit(20)->get();
            }
            if(auth()->user()->role == 2) {
                $count_interns =  Intern::where(function ($query) use ($year)  {
                    $query->where(['coordinator' => auth()->user()->coordinator_id])->where(['year' => $year]);
                })->where(function ($query) {
                  $query->orWhere(['training_status' => 2])
                  ->orWhere(['training_status' => 3])
                  ->orWhere(['training_status' => 4])
                  ->orWhere(['training_status' => 5]);
                })->count();
                $news = News::orderBy('created_at', 'DESC')->limit(20)->get();
            }
            if(auth()->user()->role == 3) {
                $count_application =  Intern::where(function ($query) use ($year)  {
                    $query->where(['hte' => auth()->user()->hte_id])->where(['year' => $year]);
                })->where(function ($query) {
                  $query->where(['training_status' => 3]);
                })->count();
                $count_training =  Intern::where(function ($query) use ($year)  {
                    $query->where(['hte' => auth()->user()->hte_id])->where(['year' => $year]);
                })->where(function ($query) {
                  $query->where(['training_status' => 4]);
                })->count();
                $count_completed =  Intern::where(function ($query) use ($year)  {
                    $query->where(['hte' => auth()->user()->hte_id])->where(['year' => $year]);
                })->where(function ($query) {
                  $query->where(['training_status' => 5]);
                })->count();
                $news = News::where(['hte_id' => auth()->user()->HTE->id])->orderBy('created_at', 'DESC')->limit(20)->get();
            }
            $requirements = $this->InternService->getRequirementsToDashboard();
            return view('dashboard', compact('announcements', 'requirements', 'count_coordinators', 'count_hte', 'count_dean', 'count_interns', 'count_application', 'count_training', 'count_completed', 'news'));
        }
    }
}
