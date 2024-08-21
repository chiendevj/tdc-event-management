<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    // Show config route
    public function showConfig()
    {
        return view('dashboards.admin.configs.route');
    }

    // Update config route
    public function updateConfig(Request $request)
    {
        $request->validate([
            'route' => 'required|string',
        ]);

        $route = $request->input('route');

        $setting = Setting::where('key', 'admin_url')->first();

        if ($setting) {
            $setting->update(['value' => $route]);
            // Flash message to session
            session()->flash('success', 'Cập nhật thành công');
            // Redirect to new route
            return redirect($route . '/admin/dashboard');
        }

        return redirect()->route('config.show')->with('error', 'Cập nhật thất bại');
    }
}
