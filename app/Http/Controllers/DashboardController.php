<?php

namespace App\Http\Controllers;


use App\Actions\Dashboard\GetDashboardData;



class DashboardController extends Controller
{


    /**
     * Display Dashboard.
     */
    public function index(
        GetDashboardData $getDashboardData
    ) {


        $data = $getDashboardData->handle(
            auth()->user()
        );


        return view(
            'dashboard.index',
            $data
        );

    }


}