<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
/*Auth::routes();


Route::group(['middleware' => ['guest']], function () {

    Route::get('/', function () {
        return view('auth.login');
    });

});*/


Route::get('/', 'HomeController@index')->name('selection');


Route::group(['namespace' => 'Auth'], function () {

    Route::get('/login/{type}','LoginController@loginForm')->middleware('guest')->name('login.show');

    Route::post('/login','LoginController@login')->name('login');
    Route::get('/logout/{type}', 'LoginController@logout')->name('logout');

});

 //==============================Translate all pages============================

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () {

     //==============================dashboard============================
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

// Calendar routes

//Route::get('calendar/index', 'CalendarController@index')->name('calendar.index');
//Route::post('calendar', [CalendarController::class, 'store'])->name('calendar.store');
//Route::patch('calendar/update/{id}', [CalendarController::class, 'update'])->name('calendar.update');
//Route::delete('calendar/destroy/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');

   //==============================dashboard============================
    Route::group(['namespace' => 'Grades'], function () {
        Route::resource('Grades', 'GradeController');
    });

    //==============================Classrooms============================
    Route::group(['namespace' => 'Classrooms'], function () {
        Route::resource('Classrooms', 'ClassroomController');
        Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');

        Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');

    });
    //==============================Sections============================
    Route::group(['namespace' => 'Sections'], function () {

        Route::resource('Sections', 'SectionController');

        Route::get('/classes/{id}', 'SectionController@getclasses');
    });
    //==============================parents============================
         Route::view('add_parent','livewire.show_Form')->name('add_parent');
    //==============================Teachers============================
    Route::group(['namespace' => 'Teachers'], function () {
        Route::resource('Teachers', 'TeacherController');
    });
    //==============================Students============================
    Route::group(['namespace' => 'Students'], function () {
        Route::resource('Students', 'StudentController');
        Route::resource('Graduated', 'GraduatedController');
        Route::resource('online_classes', 'OnlineClasseController');
        Route::get('/indirect_admin', 'OnlineClasseController@indirectCreate')->name('indirect.create.admin');
        Route::post('/indirect_admin', 'OnlineClasseController@storeIndirect')->name('indirect.store.admin');
        Route::resource('library', 'LibraryController');


        Route::get('download_file/{filename}', 'LibraryController@downloadAttachment')->name('downloadAttachment');


        Route::post('Upload_attachment', 'StudentController@Upload_attachment')->name('Upload_attachment');
        Route::get('Download_attachment/{studentsname}/{filename}', 'StudentController@Download_attachment')->name('Download_attachment');
        Route::post('Delete_attachment', 'StudentController@Delete_attachment')->name('Delete_attachment');
        Route::post('Graduated_one', 'StudentController@Graduated')->name('Graduated_one');
       //promotions routes
        Route::resource('Promotion', 'PromotionController');
       Route::post('Graduated_one_promotion', 'PromotionController@Graduated_one_promotion')->name('Graduated_one_promotion');
//fees routes
        Route::resource('Fees', 'FeesController');
        Route::resource('Fees_Invoices', 'FeesInvoicesController');
        Route::get('/Get_fees/{id}', 'FeesInvoicesController@Get_fees');
        Route::resource('receipt_students', 'ReceiptStudentsController');
        Route::resource('ProcessingFee', 'ProcessingFeeController');
        Route::resource('Payment_students', 'PaymentController');
        Route::resource('Attendance', 'AttendanceController');

    });

    //==============================subjects============================
    Route::group(['namespace' => 'Subjects'], function () {
        Route::resource('subjects', 'SubjectController');
    });

    Route::group(['namespace' => 'Quizzes'], function () {
        Route::resource('Quizzes', 'QuizzeController');
    });

    Route::group(['namespace' => 'Questions'], function () {
        Route::resource('questionss', 'QuestionController');
    });

    Route::resource('settings', 'SettingController');


});
