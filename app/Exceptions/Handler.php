<?php

namespace App\Exceptions;

use Kwaadpepper\ExceptionHandler\Exceptions\ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $e
     * @return void
     * @ignore phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found
     */
    public function report(Throwable $e): void
    {
        parent::report($e);
    }
}
