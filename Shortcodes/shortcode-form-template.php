<!-- Add your form HTML code here -->
<form method="post">
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" name="email" id="email" required>
  </div>
  
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" name="password" id="password" required>
  </div>
  
  <div class="form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" id="username" required>
  </div>
  
  <div class="form-group">
    <label for="display_name">Display Name:</label>
    <input type="text" class="form-control" name="display_name" id="display_name" required>
  </div>
  
  <div class="form-group">
    <label for="first_name">First Name:</label>
    <input type="text" class="form-control" name="first_name" id="first_name" required>
  </div>
  
  <div class="form-group">
    <label for="last_name">Last Name:</label>
    <input type="text" class="form-control" name="last_name" id="last_name" required>
  </div>
  
  <div class="form-group">
    <label for="role">Role:</label>
    <select class="form-control" name="role" id="role" required>
      <option value="subscriber">Subscriber</option>
      <option value="editor">Editor</option>
      <option value="administrator">Administrator</option>
    </select>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


<?php
    
    if (isset($_POST['submit'])) {
      echo "HEllo";
    die();
      // Process the form submission and perform registration logic here
      // Redirect after registration, if provided
      if (!empty($atts['redirect_after_registration'])) {
          
          wp_redirect($atts['redirect_after_registration']);
          exit;
      }
  }
  
?>