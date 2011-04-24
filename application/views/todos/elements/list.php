<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if (count($todos) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>Status</th>
        <th>Due date</th>
        <th>Desc</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($todos as $todo): ?>
      <tr class="<?php echo $todo->complete ? 'Complete' : 'Incomplete'; ?>">
        <td><a href='/todos/complete/<?php echo $todo->id ?>'><?php echo $todo->complete ? 'Complete' : 'Incomplete'; ?></a></td>
        <td><?php echo $todo->due_date; ?></td>
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