@extends('layouts.main')

@section('title', "Paiement")

@section('titlePage',"Paiement")

@section ('content')
@if($sessiongames ==null)
    <p>ERROR</p>
{{$sessiongames}}
@else

<div class=" contourForm col-12 col-md-6 offset-md-3">
    <form action="{{ route('sessiongameusers.storePayment') }}" method="post" class="" id="form">
        <!-- Add CSRF Token -->
        @csrf
       <fieldset>
        <div class=" col-12 table-responsive">
            <table class="table-bordered table-striped table-hover align-middle table tableGoodie">
                <thead>
                    <tr>
                        <th class="lead font-weight-bold" scope="col">
                            Votre panier
                        </th>
                        <th scope="col" class="h5 font-weight-bold text-center">
                            Prix (€)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessiongames as $sessiongame)
                        
                            <tr>
                                <td>
                                    <input class="form-check-input" type="hidden" value="{{$sessiongame->id}}" name="sessiongames[]" class=@error('session') is-invalid @enderror>
                                    <label class="form-check-label" for="flexCheckDefault">
                                    {{$sessiongame->name}} du {{$sessiongame->start_date}} au {{$sessiongame->end_date}}
                                    </label>
                                </td>
                                <td class="text-right">
                                    {{$sessiongame->price}} €
                                </td>
                            </tr>
                        
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right lead"> Total : {{$totalPrice}} €</td>
                        <td>{{ env('STRIPE_KEY') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <br/>
        <input type="hidden" name="payment_method" id="payment_method" />
                <!-- Stripe Elements Placeholder -->
                <div class="form-group" id="card-element"></div>
               
        
       </fieldset>
       @error('session')
        <div class="alert alert-danger"> {{$message}} </div>
        @enderror 
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
       <br/>
       <div class="row">
            <div class="col-12 text-center">
                <button id="submit-button" type="submit" class="btn btn-info ">Payer</button>
            </div>
       </div>
        

       </div>
    </form>
</div>
@endif


<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe(" {{ env('STRIPE_KEY') }} ", {
  locale: 'fr'
});
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        classes: {
            base: 'StripeElement bg-white'
        },
        style: {
            base: {
            fontSize: '18px'
            },
        }
    });
    cardElement.mount('#card-element');
    const cardButton = document.getElementById('submit-button');
    cardButton.addEventListener('click', async(e) => {
        e.preventDefault();
        const { paymentMethod, error } = await stripe.createPaymentMethod(
            'card', cardElement
        );
        if (error) {
            alert(error.message)
        } else {
            document.getElementById('payment_method').value = paymentMethod.id;
            document.getElementById('form').submit();
        }
        
    });
</script>

@endsection