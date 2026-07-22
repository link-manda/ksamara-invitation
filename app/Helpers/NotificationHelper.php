<?php

namespace App\Helpers;

use Illuminate\Http\RedirectResponse;

class NotificationHelper
{
    public static function redirectSuccess(string $route_name, string $message): RedirectResponse
    {
        return redirect()->route($route_name)->with('success', $message);
    }

    public static function redirectWithError(string $route_name, string $message): RedirectResponse
    {
        return redirect()->route($route_name)->with('error', $message);
    }

    public static function backWithSuccess(string $message): RedirectResponse
    {
        return back()->with('success', $message);
    }

    public static function backWithError(string $message): RedirectResponse
    {
        return back()->with('error', $message)->withInput();
    }

    public static function backWithWarning(string $message): RedirectResponse
    {
        return back()->with('warning', $message)->withInput();
    }
}
