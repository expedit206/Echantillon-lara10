<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUserLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event)
    {
        // $event->user contient l'utilisateur qui vient de se déconnecter
        $user = $event->user;
        // Déterminer le type d'utilisateur et le stocker dans la session
        if ($user->role) {
            cookie()->queue(cookie('last_logged_out_user_type', 'admin', 1));
Cache::put('last_logged_out_user_type', 'admin', 2);

        } elseif ($user->profession) {
            Cache::put('last_logged_out_user_type', 'enseignant', 1);
        } elseif ($user->filiere_id) {
            Cache::put('last_logged_out_user_type', 'etudiant', 1);
        }


        \Log::info(Cache::get('last_logged_out_user_type'));

    }
}
