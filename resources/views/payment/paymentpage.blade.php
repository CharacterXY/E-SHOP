
@extends('layouts.index')



@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
       
       
       
       
       
            <div class="shopper-informations">
                <div class="row">
            
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p> Shipping/Bill To</p>
                            <div class="form-one">
                                
                                          
                                           <div class="total_area">
                                                    <ul>
                                
                                                        <li>Payment Status:
                                                        @if($payment_info['status'] == 'waiting')

                                                         <span>Not paid yet</span>

                                                        @endif

                                                        </li>
                                                        <li>Shipping Cost <span>Free</span></li>
                                                        <li>Total <span>{{$payment_info['price']}} Kn</span></li>
                                                    </ul>
                                                    <a class="btn btn-default update" href="">Update</a>
                                                    <a class="btn btn-default check_out" id="paypal-button">Pay Now</a>
                                                </div>
                 
                                          
                            </div>
                            <div class="form-two">
                                
                            </div>
                        </div>
                    </div>
                           
                </div>
            </div>
       
    </div>
</section> <!--/#payment-->



@endsection



<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Button.render({
        //configure enviroment
        env: 'sandbox',
        client: {
            sandbox: 'AZkBwvqc7SQbHTcK_PfeH6uEjbfget8QjM3XFT2PHBrx-rYGfwOe0DzEdZJjlWwQ7jCHfFCeyHv-5CaD',
            production: 'demo_production_client_id'
        },
        // customize button (optional)
        locale: 'en_US',
        style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
        },

        // enable Pay now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions){
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: "{{$payment_info['price']}}",
                        currency: 'EUR'
                    }
                }]
            });

        },
        // Execute Payment
        onAuthorize: function(data, actions){
            return actions.payment.execute().then(function(){
                // Show a confirmation message to the buyer
                window.alert('Thank you for purchase');
                //console.log(data);
                window.location = './paymentreceipt/'+ data.paymentID+'/'+ data.payerID;
                //window.location = "{{url('payment/paymentreceipt')}}" + "/" + data.paymentID + "/" + data.payerID;
                
            });
        }

    }, '#paypal-button');

</script>
