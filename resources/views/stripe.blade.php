<!DOCTYPE html>

<html>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <div style="clear:both; margin-top:0em; margin-bottom:1em;"><a href="https://www.w3adda.com/blog/insert-data-using-database-seeder-in-laravel" target="_blank" rel="nofollow" class="u6398e75330d2818aa61d9b993e1a248e"><style> .u6398e75330d2818aa61d9b993e1a248e { padding:0px; margin: 0; padding-top:1em!important; padding-bottom:1em!important; width:100%; display: block; font-weight:bold; background-color:#eaeaea; border:0!important; border-left:4px solid #2980B9!important; text-decoration:none; } .u6398e75330d2818aa61d9b993e1a248e:active, .u6398e75330d2818aa61d9b993e1a248e:hover { opacity: 1; transition: opacity 250ms; webkit-transition: opacity 250ms; text-decoration:none; } .u6398e75330d2818aa61d9b993e1a248e { transition: background-color 250ms; webkit-transition: background-color 250ms; opacity: 1; transition: opacity 250ms; webkit-transition: opacity 250ms; } .u6398e75330d2818aa61d9b993e1a248e .ctaText { font-weight:bold; color:#2980B9; text-decoration:none; font-size: 16px; } .u6398e75330d2818aa61d9b993e1a248e .postTitle { color:#2980B9; text-decoration: underline!important; font-size: 16px; } .u6398e75330d2818aa61d9b993e1a248e:hover .postTitle { text-decoration: underline!important; } </style><div style="padding-left:1em; padding-right:1em;"><span class="ctaText">Recommended:-</span>  <span class="postTitle">Insert data using Database Seeder in Laravel</span></div></a></div> -->
    <style type="text/css">

        .panel-title {

        display: inline;

        font-weight: bold;

        }

        .display-table {

            display: table;

        }

        .display-tr {

            display: table-row;

        }

        .display-td {

            display: table-cell;

            vertical-align: middle;

            width: 61%;

        }

    </style>

</head>

<body>

  

<div class="container">

      <div class="row">
        

        <div class="col-md-6 col-md-offset-3">
            <ul class="list-group shadow">
                <li class="list-group-item">
                    <div class="media align-items-lg-center flex-column flex-lg-row p-3">
                        <input class="form-control" name="" id="user_id" placeholder="put the user Id for check"/>
                        <br>
                        <a onClick="checkOnUser()" class="btn btn-primary btn-lg btn-block">Check</a>
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <span id="userAlert"></span>
                        <ul class="list-group shadow text-center">
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="50.00">
                                    <strong class="mt-0 font-weight-bold mb-2">15000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$50.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="15000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="100.00">
                                    <strong class="mt-0 font-weight-bold mb-2">30000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$100.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="30000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="200.00">
                                    <strong class="mt-0 font-weight-bold mb-2">70000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$200.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="70000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="300.00">
                                    <strong class="mt-0 font-weight-bold mb-2">105000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$300.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="105000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="400.00">
                                    <strong class="mt-0 font-weight-bold mb-2">140000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$400.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="140000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="500.00">
                                    <strong class="mt-0 font-weight-bold mb-2">187500</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$500.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="187500" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="600.00">
                                    <strong class="mt-0 font-weight-bold mb-2">225000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$600.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="225000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="700.00">
                                    <strong class="mt-0 font-weight-bold mb-2">262500</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$700.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="262500" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="800.00">
                                    <strong class="mt-0 font-weight-bold mb-2">300000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$800.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="300000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="900.00">
                                    <strong class="mt-0 font-weight-bold mb-2">337500</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$900.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="337500" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="1000.00">
                                    <strong class="mt-0 font-weight-bold mb-2">530000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$1000.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="530000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="2000.00">
                                    <strong class="mt-0 font-weight-bold mb-2">110000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$2000.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="110000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="3000.00">
                                    <strong class="mt-0 font-weight-bold mb-2">1850000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$3000.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="1850000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="4000.00">
                                    <strong class="mt-0 font-weight-bold mb-2">260000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$4000.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="260000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="7000.00">
                                    <strong class="mt-0 font-weight-bold mb-2">350000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$7000.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="350000" id="flexRadioDefault1">
                                </div>
                            </li>
                            <li>
                                <div class="media-body order-2 order-lg-1">
                                    <img src="{{ url('/images/star.png') }}" class="rounded" alt="Cinque Terre">
                                    <input style="display:none" type="radio" name="amount" value="10000.00">
                                    <strong class="mt-0 font-weight-bold mb-2">750000</strong> <small>Coins</small> ~ <strong class="font-weight-bold my-2">$10000.00</strong>  <input class="form-check-input" type="radio" name="amountVal" value="750000" id="flexRadioDefault1">
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-md-6 col-md-offset-3">

            <div class="panel panel-default credit-card-box">

                <div class="panel-heading display-table" >

                    <div class="row display-tr" >

                        <h3 class="panel-title display-td" >Payment Details</h3>

                        <div class="display-td" >                            

                            <img class="img-responsive pull-right" src="https://i76.imgup.net/accepted_c22e0.png">

                        </div>

                    </div>                    

                </div>

                <div class="panel-body">

                    @if (Session::has('success'))

                        <div class="alert alert-success text-center">

                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                            <p>{{ Session::get('success') }}</p>

                        </div>

                    @endif

                 <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation"

                                                     data-cc-on-file="false"

                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"

                                                    id="payment-form">

                        @csrf

  

                        <div class='form-row row'>

                            <div class='col-xs-12 form-group required'>

                                <label class='control-label'>Name on Card</label> <input

                                    class='form-control' size='4' type='text'>

                            </div>

                        </div>

  

                        <div class='form-row row'>

                            <div class='col-xs-12 form-group card required'>

                                <label class='control-label'>Card Number</label> <input

                                    autocomplete='off' class='form-control card-number' size='20'

                                    type='text'>

                            </div>

                        </div>

  

                        <div class='form-row row'>

                            <div class='col-xs-12 col-md-4 form-group cvc required'>

                                <label class='control-label'>CVC</label> <input autocomplete='off'

                                    class='form-control card-cvc' placeholder='ex. 311' size='4'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Month</label> <input

                                    class='form-control card-expiry-month' placeholder='MM' size='2'

                                    type='text'>

                            </div>

                            <div class='col-xs-12 col-md-4 form-group expiration required'>

                                <label class='control-label'>Expiration Year</label> <input

                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'

                                    type='text'>

                            </div>

                        </div>

  

                        <div class='form-row row'>

                            <div class='col-md-12 error form-group hide'>

                                <div class='alert-danger alert'>Please correct the errors and try

                                    again.</div>

                            </div>

                        </div>

  

                        <div class="row">

                            <div class="col-xs-12">

                                <button id="buttonBuy" disabled class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>

                            </div>

                        </div>

                          

                    </form>

                </div>

            </div>        

        </div>

    </div>

      

</div>

  


  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

  
<script type="text/javascript">
    var responseUserId = null
    function checkOnUser(){
        var user_id = $("#user_id").val();
        var data = {
            "user_id": user_id,
            "_token": $('#token').val()
        }
        console.log(data)
        var request = $.ajax({
        url: "/userCheck",
        type: "GET",
        data: data
        });

        request.done(function(response) {
        // $("#log").html( msg );
        // console.log(msg)
        $("#userAlert").addClass("alert alert-success");
        $("#buttonBuy").removeAttr('disabled');
        responseUserId = response.data.id
        });

        request.fail(function(jqXHR, textStatus) {
        // alert( "Request failed: " + textStatus );
        $("#userAlert").addClass("alert alert-danget")
        $("#buttonBuy").attr("disabled", true)
        });
    }

$(function () {

    var $form         = $(".require-validation");

  $('form.require-validation').bind('submit', function(e) {

    var $form         = $(".require-validation"),

        inputSelector = ['input[type=email]', 'input[type=password]',

                         'input[type=text]', 'input[type=file]',

                         'textarea'].join(', '),

        $inputs       = $form.find('.required').find(inputSelector),

        $errorMessage = $form.find('div.error'),

        valid         = true;

        $errorMessage.addClass('hide');

 

        $('.has-error').removeClass('has-error');

    $inputs.each(function(i, el) {

      var $input = $(el);

      if ($input.val() === '') {

        $input.parent().addClass('has-error');

        $errorMessage.removeClass('hide');

        e.preventDefault();

      }

    });

  

    if (!$form.data('cc-on-file')) {

      e.preventDefault();

      Stripe.setPublishableKey($form.data('stripe-publishable-key'));

      Stripe.createToken({

        number: $('.card-number').val(),

        cvc: $('.card-cvc').val(),

        exp_month: $('.card-expiry-month').val(),

        exp_year: $('.card-expiry-year').val()

      }, stripeResponseHandler);

    }

  

  });

  

  function stripeResponseHandler(status, response) {
    var coins = $("input[name='amountVal']:checked").val();
    // var amount = $("input[name='amount']:checked").val();
    var amount = null

    if (coins == 15000) {
        amount = 50.00
    }
    else if (coins == 30000) {
        amount = 100.00
    }
    else if (coins == 70000) {
        amount = 200.00
    }
    
    else if (coins == 105000) {
        amount = 300.00
    }

    else if (coins == 140000) {
        amount = 400.00
    }

    else if (coins == 187500) {
        amount = 500.00
    }

    else if (coins == 225000) {
        amount = 600.00
    }

    else if (coins == 262500) {
        amount = 700.00
    }

    else if (coins == 300000) {
        amount = 800.00
    }

    else if (coins == 337500) {
        amount = 900.00
    }

    else if (coins == 530000) {
        amount = 1000.00
    }

    else if (coins == 110000) {
        amount = 2000.00
    }

        if (response.error) {

            $('.error')

                .removeClass('hide')

                .find('.alert')

                .text(response.error.message);

        } else {

            var token = response['id'];

            $form.find('input[type=text]').empty();

            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

            $form.append("<input type='hidden' name='user_id' value='" + responseUserId + "'/>");

            $form.append("<input type='hidden' name='coins' value='" + coins + "'/>");

            $form.append("<input type='hidden' name='amount' value='" + amount + "'/>");

            $form.get(0).submit();

        }

    }

  

});

</script>
</body>

</html>