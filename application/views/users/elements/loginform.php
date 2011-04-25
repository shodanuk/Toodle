<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<div id="login-form">
  <form action="/users/login" method="post">
    <fieldset>
      <div class="input text">
        <label for="login_username">Username</label>
        <input type="text" name="login_username" id="login_username" value="<?php echo isset($login_username) ? $login_username : ''; ?>" />
        <?php if( isset($errors['login_username']) ): ?><div class="error"><?php echo $errors['login_username']; ?></div><?php endif; ?>
      </div>
      <div class="input text">
        <label for="login_password">Password</label>
        <input type="password" name="login_password" id="login_password" />
        <?php if( isset($errors['login_password']) ): ?><div class="error"><?php echo $errors['login_password']; ?></div><?php endif; ?>
      </div>
      <div class="input checkbox">
        <label for="login_rememberme">Remember me</label>
        <input type="checkbox" name="login_rememberme" id="login_rememberme" value="1" <?php echo isset($login_rememberme) ? 'checked="checked"' : ''; ?> />
      </div>
      <div class="buttons submit">
        <input type="submit" name="submit" id="submit" value="Login" />
      </div>
    </fieldset>
  </form>
</div>