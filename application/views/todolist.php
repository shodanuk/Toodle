<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<h1>My ToDos</h1>

<?php echo $todoForm ?>

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
    <?php foreach($todos as $id => $todo): ?>
    <tr>
      <td><a href='/todos/complete/<?php echo $id ?>'><?php echo $todo->complete ? 'Complete' : 'Incomplete'; ?></a></td>
      <td><?php echo $todo->dueDate; ?></td>
      <td><?php echo $todo->desc; ?></td>
      <td>
        <a href="/todos/edit/<?php echo $id; ?>">Edit</a>
        <a href="/todos/delete/<?php echo $id; ?>">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>