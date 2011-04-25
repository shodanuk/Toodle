<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $header; ?>

<h1>Login</h1>

<?php if( $message ): ?>
  <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<h2>Already signed up? Log in here:</h2>

<?php echo $loginForm ?>

<h2>No account? No problem, just <a href="/users/register">sign up here</a></h2>

<?php echo $footer; ?>