<?php

namespace Manuskript\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected array $messages = [
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '419' => 'Page expired',
        '503' => 'Service Unavailable',
    ];

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if (!app()->environment(['local', 'testing'])) {

            if ($response->status() === 500) {
                return back()->with(['error' => sprintf("Server Error (%s)", $e->getCode())]);
            }

            if (array_key_exists($status = $response->status(), $this->messages)) {
                return back()->with(['error' => $this->messages[$status]]);
            }
        }

        return $response;
    }
}
