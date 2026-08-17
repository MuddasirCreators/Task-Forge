<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Home
Route::get('/', function () {

    return redirect()
        ->route('dashboard');

});





/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])->group(function () {



    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */


    Route::post(
        '/notifications/read-all',
        function () {

            auth()
                ->user()
                ->unreadNotifications
                ->markAsRead();


            return back();

        }
    )
    ->name('notifications.readAll');




    Route::post(
        '/notifications/{id}/read',
        function ($id) {


            $notification = auth()
                ->user()
                ->notifications()
                ->findOrFail($id);


            $notification->markAsRead();


            return response()->json([
                'success'=>true
            ]);

        }
    )
    ->name('notifications.read');






    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/dashboard',
        [DashboardController::class,'index']
    )
    ->name('dashboard');







    /*
    |--------------------------------------------------------------------------
    | Clients
    | Admin + Manager
    |--------------------------------------------------------------------------
    */


    Route::middleware([
        'role:Admin,Manager'
    ])
    ->group(function(){


        Route::resource(
            'clients',
            ClientController::class
        );


    });









    /*
    |--------------------------------------------------------------------------
    | Projects
    | Admin + Manager
    |--------------------------------------------------------------------------
    */


    Route::middleware([
        'role:Admin,Manager'
    ])
    ->group(function(){



        Route::patch(
            '/projects/{project}/archive',
            [ProjectController::class,'archive']
        )
        ->name('projects.archive');



        Route::patch(
            '/projects/{project}/restore',
            [ProjectController::class,'restore']
        )
        ->name('projects.restore');



        Route::resource(
            'projects',
            ProjectController::class
        );



    });








    /*
    |--------------------------------------------------------------------------
    | Tasks
    | Admin + Manager + Member
    |--------------------------------------------------------------------------
    */


    Route::middleware([
        'role:Admin,Manager,Member'
    ])
    ->group(function(){



        Route::get(
            '/tasks',
            [TaskController::class,'allTasks']
        )
        ->name('tasks.index');



        Route::resource(
            'projects.tasks',
            TaskController::class
        );



    });








    /*
    |--------------------------------------------------------------------------
    | Time Logs
    | Admin + Manager + Member
    |--------------------------------------------------------------------------
    */


    Route::middleware([
        'role:Admin,Manager,Member'
    ])
    ->group(function(){



        Route::resource(
            'tasks.time-logs',
            TimeLogController::class
        )
        ->only([
            'index',
            'create',
            'store'
        ]);



        Route::resource(
            'time-logs',
            TimeLogController::class
        )
        ->only([
            'edit',
            'update',
            'destroy'
        ]);



    });









    /*
    |--------------------------------------------------------------------------
    | Team Management
    | Admin Only
    |--------------------------------------------------------------------------
    */
/*
|--------------------------------------------------------------------------
| Team Management
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:Admin'
])->group(function(){


    Route::get(
        '/team',
        [TeamController::class,'index']
    )
    ->name('team.index');



    Route::get(
        '/team/create',
        [TeamController::class,'create']
    )
    ->name('team.create');



    Route::post(
        '/team',
        [TeamController::class,'store']
    )
    ->name('team.store');



    Route::get(
        '/team/{user}',
        [TeamController::class,'show']
    )
    ->name('team.show');



    Route::get(
        '/team/{user}/edit',
        [TeamController::class,'edit']
    )
    ->name('team.edit');



    Route::put(
        '/team/{user}',
        [TeamController::class,'update']
    )
    ->name('team.update');



    Route::patch(
        '/team/{user}/deactivate',
        [TeamController::class,'deactivate']
    )
    ->name('team.deactivate');



    Route::patch(
        '/team/{user}/activate',
        [TeamController::class,'activate']
    )
    ->name('team.activate');


});








  /*
|--------------------------------------------------------------------------
| Profile / Settings
| All Logged In Users
|--------------------------------------------------------------------------
*/


Route::get(
    '/profile',
    [ProfileController::class,'edit']
)
->name('profile.index');



Route::patch(
    '/profile',
    [ProfileController::class,'update']
)
->name('profile.update');



Route::patch(
    '/profile/phone',
    [ProfileController::class,'updatePhone']
)
->name('profile.phone.update');



Route::put(
    '/profile/password',
    [ProfileController::class,'updatePassword']
)
->name('profile.password.update');



Route::delete(
    '/profile',
    [ProfileController::class,'destroy']
)
->name('profile.destroy');
});





/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/


require __DIR__.'/auth.php';