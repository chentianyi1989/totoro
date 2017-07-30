<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ValidationTrait;
use Auth;
class WebBaseController extends Controller
{
    use ValidationTrait;

    public function getMember()
    {
        return auth('member')->user();
    }
}
