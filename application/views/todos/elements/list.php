<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<section>
  <div class="todolist-wrapper">
    <?php if (count($todos) > 0): ?>
      <table class='todo-list' cellspacing="0">
        <thead>
          <tr>
            <th>Status</th>
            <th>Due date</th>
            <th>Desc</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($todos as $todo): ?>
          <?php $status = $todo->complete ? 'Complete' : 'Incomplete'; ?>

          <tr class="<?php echo $status; ?>">
            <td><a href='/todos/complete/<?php echo $todo->id ?>' class="ir <?php echo $status; ?>"><?php echo $status; ?></a></td>
            <td><?php echo todo::display_due_date($todo->due_date); ?></td>
            <td><?php echo $todo->description; ?></td>
            <td>
              <a href="/todos/index/<?php echo $todo->id; ?>">Edit</a>
              <a href="/todos/delete/<?php echo $todo->id; ?>">Delete</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>Wow, no ToDo items?! Take the day off!!</p>
    <?php endif; ?>
  </div>
</section>