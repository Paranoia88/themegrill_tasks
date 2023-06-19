jQuery(document).ready(function($) {
    $('#registrationForm').submit(function(event) {
        event.preventDefault(); // Prevent form submission
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();

        // Send registration data to the server using Ajax
        $.ajax({
            type: 'POST',
            url: ajax_registration_object.ajax_url,
            data: {
                action: 'ajax_registration',
                username: username,
                email: email,
                password: password,
            },
            success: function(response) {
                if (response === 'success') {
                    $('#message').html('Registration successful!'); // Display success message
                    $('#message').show(); // Show the message div
                    $('#registrationForm')[0].reset(); // Reset the form
                    window.location.href = ajax_registration_object.redirect_url; // Redirect to home page
                } else {
                    console.log(response); // Log any errors to the console
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Log any errors to the console
            }
        });
    });
});
