<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Credits\GetAllCheckoutCreditsService;
use App\Http\Services\Credits\GetEveryCreditsHistoryService;
use App\Http\Services\Credits\CompletePaymentService;
use App\Http\Services\Credits\CancelCheckoutService;
use App\Http\Services\Credits\CheckoutCreditsService;
use App\Http\Services\Credits\DeleteCheckoutService;

class CreditsController extends Controller
{
    public function GetAllCheckoutCredits()
    {
        return GetAllCheckoutCreditsService::GetAllCheckoutCredits();
    }
    public function GetEveryCreditsHistory()
    {
        return GetEveryCreditsHistoryService::GetEveryCreditsHistory();
    }
    public function CompletePayment(Request $request)
    {
        return CompletePaymentService::CompletePayment($request);
    }
    public function CancelCheckout(Request $request)
    {
        return CancelCheckoutService::CancelCheckout($request);
    }
    public function DeleteCheckout(Request $request)
    {
        return DeleteCheckoutService::DeleteCheckout($request);
    }
    public function CheckoutCredits(Request $request)
    {
        return CheckoutCreditsService::CheckoutCredits($request);
    }
}
