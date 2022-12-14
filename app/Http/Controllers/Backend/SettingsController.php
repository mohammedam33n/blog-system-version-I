<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{

    public function __construct()
    {
        if (\auth()->check()){
            $this->middleware('auth');
        } else {
            return view('auth.login');
        }
    }

    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_settings,show_settings')) {
            return redirect('admin');
        }

        $section = (isset(\request()->section) && \request()->section != '') ? \request()->section : 'general';
        $settings_sections = Setting::select('section')->distinct()->pluck('section');

        $settings = Setting::whereSection($section)->get();

        return view('backend.pages.settings.index', compact('section', 'settings_sections', 'settings'));

    }

    public function update(Request $request, $id)
    {
        for ($i = 0; $i < count($request->id); $i++) {
            $input['value'] = isset($request->value[$i]) ? $request->value[$i] : null;
            Setting::whereId($request->id[$i])->first()->update($input);
        }
        $this->generateCache();

        return redirect()->route('settings.index')->with([
            'message' => 'Settings updated successfully',
            'alert-type' => 'success'
        ]);
    }

    private function generateCache()
    {
        $settings = Valuestore::make(config_path('settings.json'));
        Setting::all()->each(function ($item) use ($settings) {
            $settings->put($item->key, $item->value);
        });
    }




}
