<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class LogViewerController extends \Illuminate\Routing\Controller
{

    public function __construct()
    {
        // Apply middleware for roles and permissions management
        $this->middleware('auth');
        $this->middleware('role:admin|superadmin'); // Ensure only admin and superadmin can access
    }

    public function index()
    {
        // Retrieve the activity logs, paginated for better display
        $logs = Activity::latest()->paginate(10);

        // Pass the logs to the view
        return view('logs.index', compact('logs'));
    }
}
