<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ValidationTrait;
class AdminBaseController extends Controller
{
    use ValidationTrait;
}
