<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DisciplinaryRecord;
use Illuminate\Http\Request;

class DisciplinaryRecordController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $records = DisciplinaryRecord::with('reporter')
            ->where('student_id', $student->id)
            ->latest('incident_date')
            ->paginate(12);

        $totalDemerits = DisciplinaryRecord::where('student_id', $student->id)
            ->sum('demerit_points');

        return view('student.disciplinary.index', compact('records', 'student', 'totalDemerits'));
    }

    public function show(DisciplinaryRecord $disciplinary)
    {
        // Security: only own records
        if ($disciplinary->student_id !== auth()->id()) {
            abort(404);
        }

        $disciplinary->load('reporter');

        return response()->json([
            'id'             => $disciplinary->id,
            'incident_date'  => $disciplinary->incident_date->format('d M Y'),
            'category'       => ucfirst($disciplinary->category),
            'severity'       => ucfirst($disciplinary->severity),
            'description'    => $disciplinary->description,
            'action_taken'   => $disciplinary->action_taken
                                    ? ucfirst(str_replace('_', ' ', $disciplinary->action_taken))
                                    : null,
            'demerit_points' => $disciplinary->demerit_points,
            'status'         => ucfirst(str_replace('_', ' ', $disciplinary->status)),
            'notes'          => $disciplinary->notes,
            'reported_by'    => $disciplinary->reporter?->name,
            'resolved_at'    => $disciplinary->resolved_at
                                    ? $disciplinary->resolved_at->format('d M Y, h:i A')
                                    : null,
        ]);
    }
}