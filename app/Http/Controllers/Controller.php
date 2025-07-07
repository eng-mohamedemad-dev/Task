<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use Illuminate\Routing\Controller as RoutingController;

abstract class Controller extends RoutingController
{
    use ApiResponseTrait;
}
