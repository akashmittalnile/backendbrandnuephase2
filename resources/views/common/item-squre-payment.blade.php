@extends('layouts.login')

@section('content')

    {{-- <script src="https://sandbox.web.squarecdn.com/v1/square.js"></script> --}}
    <script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
    {{-- <script src="https://web.squarecdn.com/v1/square.js"></script> --}}

    <script type="text/javascript">

      async function main() {

        const payments = Square.payments("{{config('constant.square_application_id')}}","{{config('constant.squareLocationId')}}");

        const card = await payments.card();

        await card.attach('#card-container1');



        async function eventHandler(event) {
          event.preventDefault();
          try {

            const result = await card.tokenize();

            if (result.status === 'OK') {

              console.log(result.token);

            }

          } catch (e) {

            console.error(e);

          }

        };



        const cardButton = document.getElementById('card-button');
        cardButton.addEventListener('click', eventHandler);

      }

      main();

    </script>

     <h2>{{ $id }}</h2>

    <div id="card-container1"></div>

    <button id="card-button" type="button" class="btn btn-secondary">Pay</button>

@endsection