jQuery(document).ready(function($) {
    $('#registration-form').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var username = form.find('#username').val();
        var email = form.find('#email').val();
        var password = form.find('#password').val();
        var security = form.find('#security').val();

        $.ajax({
            url: registration_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'registration',
                username: username,
                email: email,
                password: password,
                security: security
            },
            beforeSend: function() {
                // Display loading spinner or disable form fields
            },
            success: function(response) {
                if (response.success) {
                    // Registration successful
                    console.log(response.data);
                } else {
                    // Registration failed
                    console.log(response.data);
                }
            },
            error: function(xhr, status, error) {
                // Display error message
                console.log(error);
            },
            complete: function() {
                // Clear form fields or hide loading spinner
            }
        });
    });
});
