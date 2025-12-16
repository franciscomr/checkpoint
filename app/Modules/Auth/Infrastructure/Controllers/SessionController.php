<?php

namespace App\Modules\Auth\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Application\Resources\SessionCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
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
                'logged_in_at',
                'last_activity',
            ]);

        return new SessionCollection($sessions);
    }
}
