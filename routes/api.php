<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecoverPassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAccountStatus;
use App\Http\Middleware\CheckUserPrivileges;
use App\Http\Middleware\VerifyStudentToken;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SummaryCalendarController;
use App\Http\Controllers\ProductController;  
use App\Http\Controllers\RegistrationController; 
use App\Http\Controllers\EnrollmentController; 
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\PaymentController;

/** Upload */
use App\Http\Controllers\UploadController;

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResponseController;

use App\Http\Middleware\SecretKeyMiddleware;
use App\Http\Controllers\CommitController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;


use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuditSettingController;


use App\Http\Controllers\FinishQuizController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\PointSettingController;

/** 
 * MODULO DE DOCUMENTO */
use App\Http\Controllers\CertificateCourseController;
use App\Http\Controllers\DocumentSettingController;

/** 
 * MODULO DE Forum */
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;


//Rotas para Iniciar Sessão
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/login/verify', [LoginController::class, 'verifyEmail']);
Route::post('/login/resend-code', [LoginController::class, 'resendEmailCode']);

// Rotas para recuperar Palavra-Passe
Route::get('/reset-pass/{email}', [RecoverPassController::class, 'recoverPassword'])->where('email', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}');
Route::get('/reset-pass/resend-code/{email}', [RecoverPassController::class, 'resendEmailCode']);
Route::get('/reset-pass/verify/{email}/{codigo}', [RecoverPassController::class, 'verifyEmail'])->where('email', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}')->where('codigo', '[0-9]+');

//Rotas Protegidas por Token
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/login/update-pass', [LoginController::class, 'newPassword']);
    Route::post('/reset-pass/update', [RecoverPassController::class, 'updatePassword']);

    //Rota para Pegar Dados do Usuário Autenticado
    Route::get('authenticated', [UserController::class, 'authenticated']);
    //Rotas de Profile
    Route::resource('profiles', ProfileController::class);
    Route::post('profile/update-password', [ProfileController::class, 'updateUserPassword']);
    Route::post('profile/update-photo', [ProfileController::class, 'updateUserPhoto']);
    Route::post('profile/update-settings', [UserSettingsController::class, 'updateUserSettings']);

    // Aplicar middleware check.status
    Route::middleware(['check.privileges'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('course-contents', CourseContentController::class);
        Route::resource('shifts', ShiftController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('products', ProductController::class);
        Route::resource('summary-calendar', SummaryCalendarController::class);
        Route::get('registrations/all', [RegistrationController::class, 'index']);
        Route::get('registrations/one/{id}', [RegistrationController::class, 'show']);
        Route::put('payments/validate/{id}', [PaymentController::class, 'update']);
        Route::resource('enrollments', EnrollmentController::class);
    });
    Route::resource('students', StudentController::class);
    Route::put('students/validate-doc/{id}', [StudentController::class, 'validateStudentStatus']);
});


//Rotas onde os Estudantes realizarão requisicões
Route::get('students/get-data/{user_id}', [StudentController::class, 'showStudentData']);
Route::post('students/store-data', [StudentController::class, 'storeDataStudent']);
Route::put('students/update/{user_id}', [StudentController::class, 'updateStudent']);
Route::post('students/update-doc', [StudentDocumentController::class, 'store']);
Route::delete('students/delete-doc/{id}', [StudentDocumentController::class, 'delete']);
//Rota para ver Cursos Disponíveis
Route::get('classes-available ', [ClassController::class, 'classesAvailable']);
//Rota para Inscrições
Route::post('registrations/store-data', [RegistrationController::class, 'store']);
Route::get('registrations/get-one/{id}', [RegistrationController::class, 'getOne']);
Route::get('registrations/get-all', [RegistrationController::class, 'getAllData']);
Route::post('registrations/payment-proof', [PaymentController::class, 'store']);


//Modulo de quiz
Route::apiResource('quiz', QuizController::class)->middleware([SecretKeyMiddleware::class]);
Route::apiResource('question', QuestionController::class)->middleware([SecretKeyMiddleware::class]);
Route::post("finish",[FinishQuizController::class,"store"])->middleware([SecretKeyMiddleware::class]);


Route::apiResource('point', PointController::class)->middleware([SecretKeyMiddleware::class]);
Route::get('point-report', [PointController::class,"report"])->middleware([SecretKeyMiddleware::class]);

Route::get('report/{user_id}', [ReportController::class,"user"])->middleware([SecretKeyMiddleware::class]);

Route::get('response', [ResponseController::class,"index"])->middleware([SecretKeyMiddleware::class]);
Route::post('response', [ResponseController::class,"store"])->middleware([SecretKeyMiddleware::class]);


Route::get('point_setting', [PointSettingController::class,"index"])->middleware([SecretKeyMiddleware::class]);
Route::post('point_setting', [PointSettingController::class,"store"])->middleware([SecretKeyMiddleware::class]);


Route::get("audit",[AuditController::class,"index"]);
Route::post("audit",[AuditController::class,"store"]);


Route::get("auditSetting",[AuditSettingController::class,"index"]);
Route::post("auditSetting",[AuditSettingController::class,"store"]);


Route::post("loginPoint",[PointController::class,"loginPoint"]);

//Modulo de quiz

Route::post("conversations",[ConversationController::class,"store"]);
Route::get("conversations",[ConversationController::class,"index"]);

Route::post("message",[MessageController::class,"store"]);
Route::get("message/{id}",[MessageController::class,"index"]);

Route::post("notification",[NotificationController::class,"store"]);
Route::put("notification",[NotificationController::class,"update"]);
Route::get("notification/{id}",[NotificationController::class,"index"]);

Route::apiResource("commit",CommitController::class);


/** Upload */
Route::apiResource('uploads', UploadController::class);

Route::get("report-file",[UploadController::class,"report"])->name("report.file");

/** 
 * MODULO DE DOCUMENTO */
Route::post("documentSetting",[DocumentSettingController::class,"store"])->name("store.file");
Route::resource("settings-document",DocumentSettingController::class);
Route::apiResource("certificate-course",CertificateCourseController::class);


// Modulo de Forum
Route::apiResource('comment', CommentController::class)->middleware([SecretKeyMiddleware::class]);
Route::apiResource('like', LikeController::class)->middleware([SecretKeyMiddleware::class]);
Route::apiResource('post', PostController::class)->middleware([SecretKeyMiddleware::class]);

