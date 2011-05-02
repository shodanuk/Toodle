<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $header; ?>

<section id="register-form" class="form-container">
  <h1>Sign up for an account</h1>

  <?php if( $message ): ?>
    <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
  <?php endif; ?>

  <?php echo $register_form; ?>

  <h2>Already have an account? Please <a href="/users/login">log in here</a></h2>
</section>
<?php echo $footer; ?>