<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityLogResource;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        return ActivityLogResource::collection($query->orderBy('id', 'desc')->get());
    }
}
