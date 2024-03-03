<?php

namespace Manuskript\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class FileNotFoundHttpException extends HttpException
{
    public function __construct(string $message = 'File not found', ?\Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(404, $message, $previous, $headers, $code);
    }
}
