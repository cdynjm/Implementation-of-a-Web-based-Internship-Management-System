<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\HTEController;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

//AJAX verification Requests:
Route::group(['prefix' => 'verify'], function () {
	Route::post('/email', [InternController::class, 'verifyEmail']);
});

//AJAX Reset Password Requests:
Route::group(['prefix' => 'reset'], function () {
	Route::post('/send-code', [InternController::class, 'sendCode']);
	Route::post('/verify-code', [InternController::class, 'verifyCode']);
	Route::post('/change-password', [InternController::class, 'changePassword']);
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

	//Pages:
	Route::get('/coordinators', [CoordinatorController::class, 'getCoordinator'])->name('coordinators');
	Route::get('/deans', [DeanController::class, 'getDeans'])->name('deans');
	Route::get('/host-training-establishments', [HTEController::class, 'getHTE'])->name('host-training-establishments');
	Route::get('/view-hte', [HTEController::class, 'viewHTE'])->name('view-hte');
	Route::get('/interns', [InternController::class, 'getIntern'])->name('interns');
	Route::get('/view-intern', [InternController::class, 'viewIntern'])->name('view-intern');
	Route::get('/requirements', [InternController::class, 'getRequirements'])->name('requirements');
	Route::get('/for-checking', [InternController::class, 'getIntern'])->name('for-checking');
	Route::get('/for-application', [InternController::class, 'getIntern'])->name('for-application');
	Route::get('/settings', [SettingsController::class, 'getSettings'])->name('settings');
	Route::get('/print-interns/{id}', [HTEController::class, 'printInterns'])->name('print-interns');
	Route::get('/print-all', [HTEController::class, 'printAll'])->name('print-all');

	Route::get('/submit-requirements', [InternController::class, 'getIntern'])->name('submit-requirements');
	Route::get('/to-apply', [InternController::class, 'getIntern'])->name('to-apply');
	Route::get('/on-training', [InternController::class, 'getIntern'])->name('on-training');
	Route::get('/completed', [InternController::class, 'getIntern'])->name('completed');

	Route::get('/assign-student-coordinator', [InternController::class, 'assignInternCoordinator'])->name('assign-student-coordinator');	

	//AJAX Create Requests:
	Route::group(['prefix' => 'create'], function () {
		Route::post('/coordinator', [CoordinatorController::class, 'createCoordinator']);
		Route::post('/dean', [DeanController::class, 'createDean']);
		Route::post('/hte', [HTEController::class, 'createHTE']);
		Route::post('/moa', [HTEController::class, 'createMOA']);
		Route::post('/termination', [HTEController::class, 'createTermination']);
		Route::post('/post', [HTEController::class, 'createPost']);
		Route::post('/announcements', [DeanController::class, 'createPost']);
		Route::post('/requirements', [InternController::class, 'createRequirements']);
		Route::post('/upload-pre-requirements', [InternController::class, 'uploadPreRequirements']);
		Route::post('/upload-post-requirements', [InternController::class, 'uploadPostRequirements']);
		Route::post('/decline', [InternController::class, 'declinePreDocument']);
		Route::post('/decline-application', [InternController::class, 'declineApplication']);
		Route::post('/assign-intern', [InternController::class, 'assignIntern']);
	});

	//AJAX Update Requests:
	Route::group(['prefix' => 'update'], function () {
		Route::post('/coordinator', [CoordinatorController::class, 'updateCoordinator']);
		Route::post('/dean', [DeanController::class, 'updateDean']);
		Route::post('/hte', [HTEController::class, 'updateHTE']);
		Route::post('/validate-intern', [InternController::class, 'validateIntern']);
		Route::post('/requirements', [InternController::class, 'updateRequirements']);
		Route::post('/pre-document', [InternController::class, 'approvePreDocument']);
		Route::post('/for-application', [InternController::class, 'sendApplication']);
		Route::post('/accept-application', [InternController::class, 'acceptApplication']);
		Route::post('/complete-training', [InternController::class, 'completeTraining']);
		Route::post('/admin-account', [InfoUserController::class, 'updateAdminAccount']);
		Route::post('/intern', [InternController::class, 'updateIntern']);
		Route::post('/registration', [SettingsController::class, 'updateStatus']);
		Route::post('/check-document', [InternController::class, 'checkDocument']);
		Route::post('/uncheck-document', [InternController::class, 'uncheckDocument']);
		Route::post('/return', [InternController::class, 'returnDocument']);
		Route::post('/terminate-intern', [InternController::class, 'terminateIntern']);
	});

	//AJAX Delete Requests:
	Route::group(['prefix' => 'delete'], function () {
		Route::post('/coordinator', [CoordinatorController::class, 'deleteCoordinator']);
		Route::post('/dean', [DeanController::class, 'deleteDean']);
		Route::post('/hte', [HTEController::class, 'deleteHTE']);
		Route::post('/decline-intern', [InternController::class, 'declineIntern']);
		Route::post('/requirements', [InternController::class, 'deleteRequirements']);
		Route::post('/pre-document', [InternController::class, 'deletePreDocument']);
		Route::post('/post', [HTEController::class, 'deletePost']);
		Route::post('/announcements', [DeanController::class, 'deletePost']);
		Route::post('/moa', [HTEController::class, 'deleteMOA']);
		Route::post('/termination', [HTEController::class, 'deleteTermination']);
	});

	//AJAX Submit Requests:
	Route::group(['prefix' => 'submit'], function () {
		Route::post('/pre-documents', [InternController::class, 'submitPreDocuments']);
	});

	//AJAX Search Requests:
	Route::group(['prefix' => 'search'], function () {
		Route::post('/year', [InternController::class, 'searchYear']);
		Route::post('/intern', [InternController::class, 'searchIntern']);
	});

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
	Route::post('/create-intern', [InternController::class, 'createIntern']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');