<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $header; ?>

<h1>My Profile</h1>

<?php if( $message ): ?>
  <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<?php echo $profile_form ?>

<?php echo $footer; ?>