<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $reportFee = Setting::get('report_fee', '20.00');

        return view('admin.settings.index', compact('reportFee'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'report_fee' => 'required|numeric|min:0|max:1000',
        ]);

        Setting::set('report_fee', number_format($request->report_fee, 2, '.', ''));

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}