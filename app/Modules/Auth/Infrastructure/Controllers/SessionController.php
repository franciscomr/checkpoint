<?php

namespace App\Modules\Auth\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\Resources\SessionCollection;
use App\Modules\Auth\Application\Services\SessionAuditService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
        public function __construct(private SessionAuditService $sessionAudit)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->whereNull('logged_out_at')
            ->orderByDesc('last_activity')
            ->get([
                'id',
                'ip_address',
                'platform',
                'user_agent',
                'is_suspicious',
                'suspicious_reason',
                'logged_in_at',
                'last_activity',
            ]);

        return new SessionCollection($sessions);
    }

    public function destroy(Request $request, string $sessionId): JsonResponse
    {
        $user = $request->user();
        $this->sessionAudit->deleteSession($user->id, $sessionId);

        if ($request->session()->getId() === $sessionId) 
        {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->json([
            'message' => 'Session closed successfully',
        ]);
    }
}
