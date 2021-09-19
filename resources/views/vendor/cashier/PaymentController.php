<?php

namespace Laravel\Cashier\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Http\Middleware\VerifyRedirectUrl;
use Laravel\Cashier\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\SessiongameUser;

class PaymentController extends Controller
{
    /**
     * Create a new PaymentController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(VerifyRedirectUrl::class);
    }

    /**
     * Display the form to gather additional payment verification for the given payment.
     *
     * @param  string  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id,$sessiongames)
    {
        $payment = new Payment(Cashier::stripe()->paymentIntents->retrieve(
            $id, ['expand' => ['payment_method']])
        );

        $paymentIntent = Arr::only($payment->asStripePaymentIntent()->toArray(), [
            'id', 'status', 'payment_method_types', 'client_secret', 'payment_method',
        ]);

        $paymentIntent['payment_method'] = Arr::only($paymentIntent['payment_method'] ?? [], 'id');

        return view('cashier::payment', [
            'stripeKey' => config('cashier.key'),
            'amount' => $payment->amount(),
            'payment' => $payment,
            'paymentIntent' => array_filter($paymentIntent),
            'paymentMethod' => (string) request('source_type', optional($payment->payment_method)->type),
            'errorMessage' => request('redirect_status') === 'failed'
                ? 
                "Une erreur s'est produite lors de la tentative de confirmation du paiement. Veuillez réessayer"
                : '',
            'customer' => $payment->customer(),
            'sessiongames'=>$sessiongames,
            'redirect' => url(request('redirect', '/')),
        ]);
    }
}
