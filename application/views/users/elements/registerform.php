<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="register-form">
  <form action="/users/register" method="post">
    <fieldset>
      <div class="input text">
        <label for="register_username">Username</label>
        <input type="text" name="register_username" id="register_username" value="<?php echo isset($register_username) ? $register_username : ''; ?>" />
        <?php if( isset($errors['register_username']) ): ?><div class="error"><?php echo $errors['register_username']; ?></div><?php endif; ?>
      </div>
      <div class="input text">
        <label for="register_email">Email</label>
        <input type="text" name="register_email" id="register_email" value="<?php echo isset($register_email) ? $register_email : ''; ?>" />
        <?php if( isset($errors['register_email']) ): ?><div class="error"><?php echo $errors['register_email']; ?></div><?php endif; ?>
      </div>
      <div class="input text">
        <label for="register_password">Password</label>
        <input type="password" name="register_password" id="register_password" value="<?php echo isset($register_password) ? $register_password : ''; ?>" />
        <?php if( isset($errors['register_password']) ): ?><div class="error"><?php echo $errors['register_password']; ?></div><?php endif; ?>
      </div>
      <div class="input text">
        <label for="register_confirm">Confirm Password</label>
        <input type="password" name="register_confirm" id="register_confirm" value="<?php echo isset($register_confirm) ? $register_confirm : ''; ?>" />
        <?php if( isset($errors['register_confirm']) ): ?><div class="error"><?php echo $errors['register_confirm']; ?></div><?php endif; ?>
      </div>
      <div class="buttons submit">
        <input type="submit" name="submit" id="submit" value="Register" />
      </div>
    </fieldset>
  </form>
</div>