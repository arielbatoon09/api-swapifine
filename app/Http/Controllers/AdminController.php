<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\AdminDashboard\UpdateAdminBasicInformationService;

class AdminController extends Controller
{
    public function UpdateAdminBasicInformation(Request $request)
    {
        return UpdateAdminBasicInformationService::UpdateAdminBasicInformation($request);
    }
}
