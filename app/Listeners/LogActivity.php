<?php
namespace App\Listeners;

use App\Events;
use Request;
use Illuminate\Auth\Events as LaravelEvents;
use Illuminate\Support\Facades\Log;

class LogActivity
{
    public function login(LaravelEvents\Login $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info($event, "User {$event->user->email} logged in from {$ip}", $event->user->only('id', 'email'));
    }

    public function logout(LaravelEvents\Logout $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info($event, "User {$event->user->email} logged out from {$ip}", $event->user->only('id', 'email'));
    }

    public function failed(LaravelEvents\Failed $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info($event, "User {$event->credentials['email']} login failed from {$ip}", ['email' => $event->credentials['email']]);
    
    }
    
    protected function info(object $event, string $message, array $context = [])
    {
        $class = get_class($event);
        Log::info("[{$class}] {$message}", $context);
    }
}