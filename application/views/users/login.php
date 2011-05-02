<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $header; ?>

<section id="login-form" class="form-container">
  <h1>Already signed up? Log in here:</h1>

  <?php if( $message ): ?>
    <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
  <?php endif; ?>


  <?php echo $login_form ?>

  <h2>No account? No problem, just <a href="/users/register">sign up here</a></h2>
</section>

<?php echo $footer; ?>