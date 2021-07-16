var stripe;
var orderData = {
    currency: "usd",
    description: "",    
};

var setupElements = function () {
    stripe = Stripe(baseurlObj.stripe_publishkey);
    /* ------- Set up Stripe Elements to use in checkout form ------- */
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create("card", {
        style: style
    });
    card.mount("#stripeElement");
    var submit_btn = document.getElementById('stripePayBtn');
    
    submit_btn.addEventListener('click', function (event) {
        event.preventDefault();      
        showLoader();
        var email = document.getElementById("ct-email").value;
        var name = document.getElementById("ct-first-name").value + ' ' + document.getElementById("ct-last-name").value;      
        pay(stripe, card, {
            name: name,
            email: email
        });
    });
};

var handleAction = function (clientSecret) {
    stripe.handleCardPayment(clientSecret).then(function (data) {
        if (data.error) {
            showError(data.error.message);
        } else if (data.paymentIntent.status === "requires_confirmation") {
            stripe.confirmCardPayment(clientSecret)
                .then(function (result) {
                    if (result.error) {
                        showError(result.error);
                    } else {
                        orderComplete(clientSecret);
                    }
                });
        } else if (data.paymentIntent.status == 'succeeded') {
            orderComplete(clientSecret);
        } else if (data.paymentIntent.status == "requires_capture") {
            orderComplete(clientSecret);
        }
    });
};

/*
 * Collect card details and pays for the order
 */
var pay = function (stripe, card, user) {
    changeLoadingState(true);  
        stripe
            .createPaymentMethod("card", card, {
                billing_details: user
            })
            .then(function (result) {
                if (result.error) {
                    showError(result.error.message);
                } else {
                    return createPaymentIntent(result.paymentMethod.id)
                }
            })
            .then(function (result) {
                return result.json();
            })
            .then(function (paymentData) {
                handlePaymentIntentResponse(paymentData)
            }).catch((error) => {
                console.log(error)
                changeLoadingState(false);
            });
    



};

/* ------- Post-payment helpers ------- */

/* Shows a success / error message when the payment is complete */
var orderComplete = function (clientSecret) {
    stripe.retrievePaymentIntent(clientSecret).then(function (result) {        
        var paymentIntent = result.paymentIntent;
        var paymentIntentJson = JSON.stringify(paymentIntent, null, 2);
        changeLoadingState(false);
        $("#payment_intent_id").val(paymentIntent.id);
        $("#complete_bookings").trigger("click");
        // alert("Payment completed successfully.")        
    });
};

var showError = function (errorMsgText, formError = false) {
    alert(errorMsgText)
    changeLoadingState(false);
   

};

// Show a spinner on payment submission
var changeLoadingState = function (isLoading) {    
    if (!isLoading) {
        hideLoader();
    }
};

// it will create a payment intent and return client secret id
var createPaymentIntent = function (paymentMethodId) {
    var cart_total=$(".cart_total").text();

    var net_amount = cart_total.replace(currency_symbol, "");
    if (paymentMethodId) {        
        orderData.paymentMethodId = paymentMethodId
    }
    orderData.amount = parseFloat(net_amount);
    orderData.user_id = $("#logout").attr("data-id");
    orderData.route = "getClientSecret";
    orderData.email = document.getElementById("ct-email").value;
    orderData.holder_name = document.getElementById("ct-first-name").value + ' ' + document.getElementById("ct-last-name").value;      
    var indexed_array = {};
   
    $.extend(indexed_array, orderData);
    var bodyData = JSON.stringify(indexed_array);
    bodyData.route = "getClientSecret";    
    let apiUrl = baseurlObj.base_url + 'objects/class_stripe_utils.php'
    return fetch(apiUrl, {
        method: "post",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json"
        },
        body: bodyData
    });
}


// it will create a payment intent and return client secret id
var handlePaymentIntentResponse = function (paymentData) {
    if (paymentData.status) {
        var dataObj = paymentData.data
        if (dataObj.requiresAction) {
            // Request authentication
            handleAction(dataObj.clientSecret);
        } else if (dataObj.error) {
            showError(dataObj.error);
        } else {
            orderComplete(dataObj.clientSecret);
        }
    } else {
        if (paymentData.data && paymentData.data == "error") {
            showError(paymentData.message, true);
        } else {
            showError(paymentData.message, false);
        }
    }
}

setupElements();


var hideLoader = function () {
    $(".ct-loading-main").css({
        "display": "none"
    });
}
var showLoader = function () {
    $(".ct-loading-main").css({
        "display": "block"
    });
}