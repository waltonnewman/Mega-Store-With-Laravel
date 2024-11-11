<?php

// app/Http/View/Composers/RequestStatusComposer.php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class RequestStatusComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();

        if ($user) {
            $requestStatus = $user->latestRequest ? $user->latestRequest->status : 'pending';
        } else {
            $requestStatus = 'pending'; // Default value if user is not authenticated
        }

        $view->with('requestStatus', $requestStatus);
    }
}
