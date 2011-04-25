<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $header; ?>

<h1>Register</h1>

<?php if( $message ): ?>
  <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<?php echo $registerform; ?>

<?php echo $footer; ?>