<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();

        if (!Auth::check() || Auth::user()->user_type !== $role) {
            abort(403, 'Unauthorized Access');
        }

        // Only apply the settings check for garage owners
        if ($role === 'Garage Owner' && !$request->is('settings*')) {

            // Assuming you have a one-to-one relation between user and garage settings
            $setting = \DB::table('tbl_settings')->where('setting_garage_id', $user->id)->first();

            if (!$setting || !$this->isSettingsComplete($setting)) {
                return redirect()->route('garage-owner.setting');
            }
        }

        return $next($request);
    }

    protected function isSettingsComplete($setting): bool
    {
        // Replace the following with your actual required fields
        return $setting->setting_garage_id
            && $setting->setting_address
            && $setting->setting_system_name
            && $setting->setting_phone_number
            && $setting->setting_countrycode
            && $setting->setting_countryisocode
            && $setting->setting_email
            && $setting->setting_logo_image
            && $setting->setting_tag_line
            && $setting->setting_currancy
            && $setting->setting_tax_1
            && $setting->setting_tax_2
            && $setting->setting_tax_3
            && $setting->setting_labor_1
            && $setting->setting_labor_2
            && $setting->setting_labor_3
            && $setting->setting_tax_number;
    }
}
