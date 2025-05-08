<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\BirthdayController;
use App\Http\Controllers\Api\LocationController as PublicLocationController;
use App\Http\Controllers\Api\PackageController as PublicPackageController;
use App\Http\Controllers\Api\ActivityController as PublicActivityController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\CalendarViewController;
use App\Http\Controllers\Api\CardViewController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Api\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Api\Admin\ActivityController as AdminActivityController;

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

// Authentication Routes
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::get("/user", function (Request $request) {
        return $request->user()->load("roles"); // Load roles with user
    });

    // Reservation Routes
    Route::apiResource("trips", TripController::class);
    Route::apiResource("birthdays", BirthdayController::class);

    // Publicly accessible data for forms, etc.
    Route::get("locations/list", [PublicLocationController::class, "listAll"]); // Method to be created in controller
    Route::get("packages/list", [PublicPackageController::class, "listAll"]); // Method to be created in controller
    Route::get("activities/list", [PublicActivityController::class, "listAll"]); // Method to be created in controller

    // Attendance Tracking
    Route::get("attendees", [AttendanceController::class, "index"]);
    Route::post("attendees", [AttendanceController::class, "store"]);
    Route::get("attendees/{attendee}", [AttendanceController::class, "show"]);
    Route::put("attendees/{attendee}", [AttendanceController::class, "update"]);
    Route::delete("attendees/{attendee}", [AttendanceController::class, "destroy"]);

    // Notification Routes
    Route::get("notifications", [NotificationController::class, "index"]);
    Route::post("notifications/{notification}/mark-as-read", [NotificationController::class, "markAsRead"]);
    Route::post("notifications/mark-all-as-read", [NotificationController::class, "markAllAsRead"]);
    Route::get("notifications/{notification}", [NotificationController::class, "show"]);

    // Calendar and Card View Routes
    Route::get("calendar-view", [CalendarViewController::class, "index"]);
    Route::get("card-view", [CardViewController::class, "index"]);

    // Admin Panel Routes (Protected by admin role/permission)
    // The actual role/permission check should be implemented in controllers or via route middleware
    Route::prefix("admin")->name("admin.")->middleware(["auth:sanctum"/*, "role:admin"*/])->group(function () {
        Route::apiResource("users", AdminUserController::class);
        Route::apiResource("locations", AdminLocationController::class);
        Route::apiResource("packages", AdminPackageController::class);
        Route::apiResource("activities", AdminActivityController::class);
        // Add other admin-specific routes here, e.g., for managing all reservations
        Route::get("all-trips", [TripController::class, "index"]); // Assuming admin can see all trips
        Route::get("all-birthdays", [BirthdayController::class, "index"]); // Assuming admin can see all birthdays
    });
});


