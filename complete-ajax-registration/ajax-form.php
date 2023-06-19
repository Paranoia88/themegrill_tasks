<form id="registration-form">
        <label for="username"><?php _e( 'Username:', 'my-registration-plugin' ); ?></label>
        <input type="text" id="username" name="username" required>

        <label for="email"><?php _e( 'Email:', 'my-registration-plugin' ); ?></label>
        <input type="email" id="email" name="email" required>

        <label for="password"><?php _e( 'Password:', 'my-registration-plugin' ); ?></label>
        <input type="password" id="password" name="password" required>
        
        <?php wp_nonce_field( 'registration_ajax_nonce', 'security' ); ?>


        <input type="submit" value="<?php _e( 'Register', 'my-registration-plugin' ); ?>">
    </form>