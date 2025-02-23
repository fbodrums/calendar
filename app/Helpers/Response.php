<?php

namespace App\Helpers;

use Illuminate\Http\RedirectResponse;

class Response
{
    public static function redirect(string $routeName, array $params = [], bool $status = true, string $message = ''): RedirectResponse
    {
        return redirect()->route($routeName, $params)
            ->with([
                'status' => $status,
                'message' => $message
            ]);
    }
}
