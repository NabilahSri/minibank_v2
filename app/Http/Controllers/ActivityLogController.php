<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $query = Activity::with('causer')->latest();

        if ($search) {
            $query->where('description', 'like', "%{$search}%")
                  ->orWhere('log_name', 'like', "%{$search}%")
                  ->orWhere('subject_type', 'like', "%{$search}%")
                  ->orWhereHas('causer', function ($q) use ($search) {
                      $q->where('username', 'like', "%{$search}%");
                  });
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('admin.activity_log.index', compact('logs', 'search'));
    }
}
