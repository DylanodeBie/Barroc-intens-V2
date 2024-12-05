<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceReport;
use Illuminate\Http\Request;

class MaintenanceReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'issue_description' => 'required|string',
            'used_parts' => 'nullable|string',
            'follow_up_notes' => 'nullable|string',
        ]);

        MaintenanceReport::create($validated);

        return redirect()->back()->with('success', 'Storingsmelding succesvol opgeslagen!');
    }

}
