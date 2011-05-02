<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $header; ?>

<?php if( $message ): ?>
  <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<?php echo $todo_form ?>

<?php echo $todo_list ?>

<?php echo $footer; ?>