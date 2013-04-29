Stripe.setPublishableKey('pk_test_4ZH1TOt3FonTrBXfaWkuvJNW');

jQuery(function($) {
  $('#stripe_submit').submit(function(event) {
	var $form = $(this);
	
    // Disable the submit button to prevent repeated clicks
    $form.find('button').prop('disabled', true);

    Stripe.createToken($form, stripeResponseHandler);

    // Prevent the form from submitting with the default action
    return false;
  });
});

 var stripeResponseHandler = function(status, response) {
      var $form = $('#stripe_submit');
 
      if (response.error) {
        // Show the errors on the form
		var err = '<div class="alert alert-error fade in" style="margin-bottom:0px"><button type="button" class="close" data-dismiss="alert">x</button>' + response.error.message + '</div>';
        $form.find('.payment-errors').html(err);
        $form.find('button').prop('disabled', false);
      } else {
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
        $form.get(0).submit();
      }
    };