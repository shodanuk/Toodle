<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<section id="todo-form" class="form-container">
  <h1>Add a Todo item</h1>

  <form action="/todos/index" method="post">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>" />
    <fieldset>
      <div class="input text">
        <input type="text" name="description" id="description" placeholder="Enter your todo item text here" value="<?php echo isset($description) ? $description : ''; ?>" />
        <?php if( isset($errors['description']) ): ?><div class="error"><?php echo $errors['description']; ?></div><?php endif; ?>
      </div>
      <!-- <div class="input text">
        <input type="text" name="due_date" id="due_date" placeholder="<?php //echo Date('Y-m-d H:i:s'); ?>" value="<?php //echo isset($due_date) ? $due_date : ''; ?>" />
        <?php //if( isset($errors['due_date']) ): ?><div class="error"><?php //echo $errors['due_date']; ?></div><?php //endif; ?>
      </div> -->
      <div class="buttons submit">
        <button type="submit" name="submit" id="submit">Save</button>
      </div>
    </fieldset>
  </form>
</section>