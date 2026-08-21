<?php

namespace App\Http\Controllers;


use App\Actions\AuditLog\GetAuditLogs;



class AuditLogController extends Controller
{


    public function index(
        GetAuditLogs $getAuditLogs
    )
    {


        $logs = $getAuditLogs->handle(
            auth()->user()
        );



        return view(
            'audit-logs.index',
            compact('logs')
        );


    }


}