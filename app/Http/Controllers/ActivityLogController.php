<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan semua activity log dengan filter & pagination.
     */
    public function index(Request $request): Renderable
    {
        $query = ActivityLog::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'ILIKE', '%' . $request->search . '%');
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();

        return view('admin.activity-log', compact('activities'));
    }
}
