<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $stats = [];

        // Check if the user is an admin using Spatie's role check
        if ($user->hasRole('admin')) {
            $stats['total_users'] = User::where('id', '!=', $user->id)->count();
            $stats['total_tasks'] = Task::count();
        } else {
            // Regular users only get their personal task count
            $stats['total_tasks'] = Task::where('user_id', $user->id)->count();
        }
        $data = [
            "stats" => $stats
        ];
        return Inertia::render('AdminDashboard', $data);
    }
}
