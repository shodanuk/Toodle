<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $header; ?>

<h1>My ToDos</h1>

<?php if( $message ): ?>
  <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<?php echo $todoForm ?>
<?php echo $todoList ?>


<?php echo $footer; ?>