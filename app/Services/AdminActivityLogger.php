<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AdminActivityLogger
{
    /**
     * Log admin activity with detailed information
     *
     * @param string $action
     * @param array $data
     * @param Request|null $request
     * @param int|null $adminId
     * @return void
     */
    public static function log(string $action, array $data = [], Request $request = null, int $adminId = null)
    {
        $adminId = $adminId ?? auth('admin')->id();

        $logData = array_merge([
            'admin_id' => $adminId,
            'action' => $action,
            'timestamp' => now()->toISOString(),
            'ip_address' => $request ? $request->ip() : request()->ip(),
            'user_agent' => $request ? $request->userAgent() : request()->userAgent(),
            'session_id' => session()->getId(),
        ], $data);

        Log::channel('admin')->info('Admin activity', $logData);
    }

    /**
     * Log admin login
     *
     * @param int $adminId
     * @param string $email
     * @param Request $request
     * @return void
     */
    public static function logLogin(int $adminId, string $email, Request $request)
    {
        self::log('login', [
            'email' => $email,
        ], $request, $adminId);
    }

    /**
     * Log admin logout
     *
     * @param int $adminId
     * @param string $email
     * @param Request $request
     * @return void
     */
    public static function logLogout(int $adminId, string $email, Request $request)
    {
        self::log('logout', [
            'email' => $email,
        ], $request, $adminId);
    }

    /**
     * Log admin registration
     *
     * @param int $adminId
     * @param string $email
     * @param string $adminLevel
     * @param int|null $createdBy
     * @param Request $request
     * @return void
     */
    public static function logRegistration(int $adminId, string $email, string $adminLevel, ?int $createdBy, Request $request)
    {
        self::log('registration', [
            'email' => $email,
            'admin_level' => $adminLevel,
            'created_by' => $createdBy,
        ], $request, $adminId);
    }

    /**
     * Log admin failed login attempt
     *
     * @param string $email
     * @param string $reason
     * @param Request $request
     * @return void
     */
    public static function logFailedLogin(string $email, string $reason, Request $request)
    {
        Log::channel('admin')->warning('Admin login failed', [
            'email' => $email,
            'reason' => $reason,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Log admin access to a route
     *
     * @param string $route
     * @param array $data
     * @param Request $request
     * @return void
     */
    public static function logRouteAccess(string $route, array $data = [], Request $request = null)
    {
        $adminId = auth('admin')->id();

        self::log('route_access', array_merge([
            'route' => $route,
            'url' => $request ? $request->fullUrl() : request()->fullUrl(),
            'method' => $request ? $request->method() : request()->method(),
        ], $data), $request, $adminId);
    }
}
