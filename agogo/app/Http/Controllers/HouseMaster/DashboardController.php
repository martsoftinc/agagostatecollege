<?php

namespace App\Http\Controllers\HouseMaster;

use App\Http\Controllers\Controller;
use App\Models\DisciplinaryRecord;
use App\Models\Exeat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $maleCount     = User::where('role', 'student')->where('gender', 'Male')->count();
        $femaleCount   = User::where('role', 'student')->where('gender', 'Female')->count();

        $onExeat = Exeat::whereIn('status', ['approved', 'out'])
            ->whereNull('actual_return_at')
            ->count();

        $overdueExeat = Exeat::whereIn('status', ['approved', 'out'])
            ->whereNull('actual_return_at')
            ->where('expected_return_at', '<', now())
            ->count();

        $openDisciplinary = DisciplinaryRecord::where('status', '!=', 'resolved')->count();

        $recentExeats = Exeat::with('student')->latest()->take(5)->get();
        $recentDisciplinary = DisciplinaryRecord::with('student')->latest()->take(5)->get();

        return view('housemaster.dashboard', compact(
            'totalStudents', 'maleCount', 'femaleCount',
            'onExeat', 'overdueExeat', 'openDisciplinary',
            'recentExeats', 'recentDisciplinary'
        ));
    }
}