<?php

namespace App\Actions;

use App\Models\Log;
use Illuminate\Support\Facades\Log as FacadesLog;
use Jenssegers\Agent\Agent;

class LogAction
{
    /**
     * Store a log entry in the database.
     * @param $request
     * @param $user_id
     * @param $action
     * @param $model_type
     * @param $payload
     * @return void
     */
    public static function store($request,$user_id,$action,$model_type,$payload,$description = null)
    {
        $agent = new Agent();
        $payload['ip'] = $request->ip();
        $payload['device'] = $agent->device();
        $payload['platform'] = $agent->platform();
        $payload['platform_version'] = $agent->version($agent->platform());
        $payload['browser'] = $agent->browser();
        $payload['browser_version'] = $agent->version($agent->browser());
        $payload['is_robot'] = $agent->isRobot();
        $payload['robot'] = $agent->isRobot() ? $agent->robot() : null;
        $payload['user_agent'] = $request->userAgent();
        $payload['url'] = $request->url();
        $payload['method'] = $request->method();
        $payload['description'] = $description;
        try {
            Log::create([
                'action' => $action,
                'user_id' => $user_id,
                'model_type' => $model_type,
                'payload' => json_encode($payload),
            ]);
        } catch (\Exception $e) {
            // Handle the exception
            FacadesLog::error('Error creating log entry: ' . $e->getMessage());
            // Optionally, you can also log the payload to help with debugging
            FacadesLog::error('Payload: ' . json_encode($payload));
        }
    }
}