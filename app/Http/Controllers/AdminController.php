<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\AdminDashboard\UpdateAdminBasicInformationService;
use App\Http\Services\AdminDashboard\GetAdminDetailsService;
use App\Http\Services\AdminDashboard\UpdateAdminPasswordService;
use App\Http\Services\AdminDashboard\DeleteAdminAccountService;

class AdminController extends Controller
{
    public function UpdateAdminBasicInformation(Request $request)
    {
        return UpdateAdminBasicInformationService::UpdateAdminBasicInformation($request);
    }
    public function GetAdminDetails()
    {
        return GetAdminDetailsService::GetAdminDetails();
    }
    public function UpdateAdminPassword(Request $request)
    {
        return UpdateAdminPasswordService::UpdateAdminPassword($request);
    }
    public function DeleteAdminAccount()
    {
        return DeleteAdminAccountService::DeleteAdminAccount();
    }
}
