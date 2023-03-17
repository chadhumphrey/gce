<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NulirtPatientPortalAPIController;
use App\Http\Controllers\AuthAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login",[AuthAPIController::class,'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Event infomation
    Route::get("getEventDates/{id?}", [NulirtPatientPortalAPIController::class,'getEventDates']);
    Route::get("getEventData/{id?}", [NulirtPatientPortalAPIController::class,'getEventData']);
    Route::get("getEvent/{id?}", [NulirtPatientPortalAPIController::class,'getEvent']);
    Route::get("getEventDays/{id?}", [NulirtPatientPortalAPIController::class,'getEventDays']);
    Route::get("getEventByDayTime", [NulirtPatientPortalAPIController::class,'getEventByDayTime']);
    Route::post("getEvent/{data?}", [NulirtPatientPortalAPIController::class,'getEvent']);
    Route::post("getAllEvents/{data?}", [NulirtPatientPortalAPIController::class,'getAllEvents']);
    Route::post("getEventDays/{data?}", [NulirtPatientPortalAPIController::class,'getEventDays']);
    Route::post("getEmailDomainsForEvents/{data?}", [NulirtPatientPortalAPIController::class,'getEmailDomainsForEvents']);

    // Appoinments information
    Route::post("check_appointment_time/{data?}", [NulirtPatientPortalAPIController::class,'check_appointment_time']);
    Route::post("makeAppointment/{data?}", [NulirtPatientPortalAPIController::class,'makeAppointment']);
    Route::post("updateAppointmentWithNPPPatientId/{data?}", [NulirtPatientPortalAPIController::class,'updateAppointmentWithNPPPatientId']);
    Route::post("getAllAppointmentsForUser/{data?}", [NulirtPatientPortalAPIController::class,'getAllAppointmentsForUser']);

    // Patient information
    Route::post("userCancelAppointment/{data?}", [NulirtPatientPortalAPIController::class,'userCancelAppointment']);

    //Search account information
    Route::post("getSearchAccount/{data?}", [NulirtPatientPortalAPIController::class,'getSearchAccount']);
    Route::post("getAccountConsents/{data?}", [NulirtPatientPortalAPIController::class,'getAccountConsents']);
    Route::post("getAOEQuestions/{data?}", [NulirtPatientPortalAPIController::class,'getAOEQuestions']);
    Route::post("getAccountWithConsentsForValidiation/{data?}", [NulirtPatientPortalAPIController::class,'getAccountWithConsentsForValidiation']);

    // Zip to get State and Counties
    Route::post("getZipDataFromNulirt/{data?}", [NulirtPatientPortalAPIController::class,'getZipValidiation']);

    // Mock results, incoming from RPS
    if(env('APP_ENV') == 'test' || env('APP_ENV') == 'local' || env('APP_ENV') == 'dev') {
      Route::post('test-mockups/rps-patient-result/{data?}', [\App\Http\Controllers\MockRpsResultController::class, 'create']);
    }


    //API user
    Route::post("/logout",  [\App\Http\Controllers\AuthAPIController::class,'logout']);

});
