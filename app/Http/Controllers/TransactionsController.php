<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Transactions\OpenTransactionsService;
use App\Http\Services\Transactions\GetUserTransactionsService;
use App\Http\Services\Transactions\ProceedTransactionsService;
use App\Http\Services\Transactions\AdditionalInformationService;
use App\Http\Services\Transactions\GetAdditionalInformationService;
use App\Http\Services\Transactions\RateVendorService;

class TransactionsController extends Controller
{
    public function GetUserTransactions()
    {
        return GetUserTransactionsService::GetUserTransactions();
    }
    public function ProceedTransactions(Request $request)
    {
        return ProceedTransactionsService::ProceedTransactions($request);
    }
    public function GetAdditionalInformation(Request $request)
    {
        return GetAdditionalInformationService::GetAdditionalInformation($request);
    }
    public function AdditionalInformation(Request $request)
    {
        return AdditionalInformationService::AdditionalInformation($request);
    }
    public function OpenTransactions(Request $request)
    {
        return OpenTransactionsService::OpenTransactions($request);
    }
    public function RateVendor(Request $request)
    {
        return RateVendorService::RateVendor($request);
    }
}
