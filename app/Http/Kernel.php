<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Other middleware...
        'employee' => \App\Http\Middleware\EmployeeMiddleware::class,
        'supervisor' => \App\Http\Middleware\SupervisorMiddleware::class,
        'management' => \App\Http\Middleware\ManagementMiddleware::class,
    ];

    // Other properties and methods...
}
