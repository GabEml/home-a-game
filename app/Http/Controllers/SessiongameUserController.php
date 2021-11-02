<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Models\User;
use App\Models\Sessiongame;
use Illuminate\Http\Request;
use App\Models\SessiongameUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Session\Session;
use App\Notifications\Sessiongame as NotificationsSessiongame;


class SessiongameUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', SessiongameUser::class);
        $dateNow = new DateTime;
        $user = User::where('id', Auth::user()->id)->first();
        $sessionUser = $user->sessiongames->pluck('id');
        $sessionpaschoisie = Sessiongame::whereNotIn('id', $sessionUser)->where("end_date", '>', $dateNow)->where('type', 'Home a Game')->get();

        return view('sessiongameuser.create', ['sessiongames' => $sessionpaschoisie]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', SessiongameUser::class);
        $validateData = $request->validate([
            'sessiongames' => 'required|exists:sessiongames,id',
        ]);

        $test = DB::table('sessiongame_user')
            ->where('sessiongame_id', $validateData["sessiongames"])
            ->where('user_id', Auth::user()->id)
            ->get();

        if ($test->isEmpty()) {
            $sessiongames = Sessiongame::whereIn('id', $validateData["sessiongames"])->get();
            $totalPrice = Sessiongame::whereIn('id', $validateData["sessiongames"])->sum('price');

            return view('sessiongameuser.payment', ['sessiongames' => $sessiongames, 'totalPrice' => $totalPrice]);
        } else {
            return redirect()->route('sessiongameusers.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePayment(Request $request)
    {
        $fr_errors = [
            "authentication_required" => "La carte bancaire a été refusée, car la transaction nécessite une authentification.",
            "approve_with_id" => "Il n’est pas possible d’autoriser le paiement.",
            " call_issuer" => "La carte a été refusée pour une raison inconnue.",
            "card_not_supported" => "Ce type d’achat n’est pas pris en charge par cette carte bancaire.",
            "card_velocity_exceeded" => "Vous avez dépassé le solde ou la limite de crédit disponible sur sa carte bancaire.",
            "currency_not_supported" => "La devise spécifiée n’est pas prise en charge par cette carte bancaire.",
            " do_not_honor" => "La carte a été refusée pour une raison inconnue.",
            "do_not_try_again" => "La carte a été refusée pour une raison inconnue.",
            "duplicate_transaction" => "Une transaction du même montant avec les mêmes informations de carte bancaire a été soumise tout récemment.",
            "expired_card" => "La carte bancaire a expiré.	Vous devez utiliser une autre carte bancaire.",
            "fraudulent" => "Le paiement a été refusé car Stripe l’a identifié comme potentiellement frauduleux.",
            "generic_decline" => "La carte a été refusée pour une raison inconnue.",
            "incorrect_number" => "Le numéro de carte bancaire est erroné.",
            "incorrect_cvc" => "Le code CVC est erroné.",
            "incorrect_pin" => "Le code PIN saisi est erroné.",
            "incorrect_zip" => "Le code postal est erroné.",
            "insufficient_funds" => "La carte bancaire ne dispose pas de fonds suffisants pour effectuer l’achat.",
            "invalid_account" => "La carte bancaire, ou le compte auquel elle est connectée, n’est pas valide.",
            "invalid_amount" => "Le montant du paiement n’est pas valide ou dépasse le montant autorisé.",
            "invalid_cvc" => "Le code CVC est erroné.",
            "invalid_expiry_month" => "Le mois d’expiration n’est pas valide.",
            "invalid_expiry_year" => "L’année d’expiration n’est pas valide.",
            "invalid_number" => "Le numéro de carte bancaire est erroné.",
            "invalid_pin" => "Le code PIN saisi est erroné.",
            "issuer_not_available" => "Il n’est pas possible de joindre l’émetteur de la carte, donc d’autoriser le paiement.",
            "lost_card" => "Le paiement a été refusé. ",
            "merchant_blacklist" => "Le paiement a été refusé.",
            "new_account_information_available" => "La carte bancaire, ou le compte auquel elle est connectée, n’est pas valide.",
            "no_action_taken" => "La carte a été refusée pour une raison inconnue.",
            "not_permitted" => "Le paiement n’est pas autorisé.",
            "offline_pin_required" => "La carte a été refusée, car un code PIN est requis.",
            "online_or_offline_pin_required" => "La carte a été refusée, car un code PIN est requis.",
            "pickup_card" => "La carte ne peut pas être utilisée pour effectuer ce paiement.",
            "pin_try_exceeded" => "Le nombre de tentatives autorisées de saisie du code PIN a été dépassé.",
            "processing_error" => "Une erreur s’est produite lors du traitement de la carte bancaire.",
            "reenter_transaction" => "Le paiement n’a pas pu être traité par l’émetteur de la carte pour une raison inconnue.",
            "restricted_card" => "La carte ne peut pas être utilisée pour effectuer ce paiement.",
            "revocation_of_all_authorizations" => "La carte a été refusée pour une raison inconnue.",
            "revocation_of_authorization" => "La carte a été refusée pour une raison inconnue.",
            "security_violation" => "La carte a été refusée pour une raison inconnue.",
            "service_not_allowed" => "La carte a été refusée pour une raison inconnue.",
            "stolen_card" => "Le paiement a été refusé.",
            "stop_payment_order" => "La carte a été refusée pour une raison inconnue.",
            "testmode_decline" => "La carte utilisée est une carte de test Stripe.",
            "transaction_not_allowed" => "La carte a été refusée pour une raison inconnue.",
            "try_again_later" => "La carte a été refusée pour une raison inconnue.",
            "withdrawal_count_limit_exceeded" => "Vous avez dépassé le solde ou la limite de crédit disponible sur sa carte bancaire.",
        ];
        $this->authorize('create', SessiongameUser::class);

        $arrSessiongame = array();

        $validateData = $request->validate([
            'sessiongames' => 'required|exists:sessiongames,id',
            'conditions'=>'required'
        ]);

        $test = DB::table('sessiongame_user')
            ->where('sessiongame_id', $validateData["sessiongames"])
            ->where('user_id', Auth::user()->id)
            ->get();


        if ($test->isEmpty()) {
            $totalPrice = Sessiongame::whereIn('id', $validateData["sessiongames"])->sum('price');

            $user = User::where('id', Auth::user()->id)->first();
            $user->createOrGetStripeCustomer();
            $user->updateStripeCustomer(
                [
                    'address' =>
                    ['city' => $user->city, 'country' => $user->country, 'line1' => $user->address, 'postal_code' => $user->postal_code],
                    'name' => $user->firstname . " " . $user->lastname,
                    'metadata' => ['user_id' => $user->id],
                ]
            );

            try {
                $user->charge(
                    $totalPrice * 100,
                    $request->payment_method,
                    [
                        'currency' => 'eur',
                        'description' => 'Paiement session @Home a Game'
                    ]
                );

                for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
                    $sessiongame = new SessiongameUser();
                    $sessiongame->sessiongame_id = $validateData["sessiongames"][$i];
                    $sessiongame->user_id = Auth::user()->id;
                    $sessiongame->save();

                    array_push($arrSessiongame, $sessiongame->sessiongame->name . " ", "et");
                }

                array_pop($arrSessiongame);
                $user->notify(new NotificationsSessiongame($arrSessiongame, Auth::user()->email, $user->firstname . " " . $user->lastname));

                return back()->with('success', 'Merci ! Votre paiement a été accepté avec succès !');
            } catch (\Stripe\Exception\CardException $e) {
                // Since it's a decline, \Stripe\Exception\CardException will be caught

                return back()->with('errorStripe', $fr_errors[$e->getError()->decline_code]);
            } catch (\Stripe\Exception\RateLimitException $e) {

                // Too many requests made to the API too quickly
                return back()->with('errorStripe', $e->getError()->message);
            } catch (\Stripe\Exception\InvalidRequestException $e) {

                // Invalid parameters were supplied to Stripe's API
                return back()->with('errorStripe', $e->getError()->message);
            } catch (\Stripe\Exception\AuthenticationException $e) {

                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                return back()->with('errorStripe', $e->getError()->message);
            } catch (\Stripe\Exception\ApiConnectionException $e) {

                // Network communication with Stripe failed
                return back()->with('errorStripe', $e->getError()->message);
            } catch (\Stripe\Exception\ApiErrorException $e) {

                // Display a very generic error to the user, and maybe send
                // yourself an email
                return back()->with('errorStripe', $e->getError()->message);
            } catch (\Laravel\Cashier\Exceptions\IncompletePayment $e) {

                // Display a very generic error to the user, and maybe send
                // yourself an email
                $sessiongames = "";
                for ($i = 0; $i < sizeof($validateData["sessiongames"]); $i++) {
                    $sessiongames = $sessiongames . " " . $validateData["sessiongames"][$i];
                }

                return redirect()->route(
                    'payment',
                    [$e->payment->id, $sessiongames, 'redirect' => route('sessiongames.index')]
                );
            } catch (Exception $e) {

                return back()->with('errorStripe', $e);
            }
        } else {
            return back()->with('success', "Désolé ! Une erreur s'est produite avec la/les session(s) choisie(s) !");
        }
    }
}
