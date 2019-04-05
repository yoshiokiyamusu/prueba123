<?php
require_once('../../private/initialize.php');
//require_login();
?>

<?php
// Find all users
$admins = user::find_all();

?>
<?php $page_title = 'users'; ?>
<?php include('../front_end/header.php'); ?>

<div id="content">
  <div class="">
    <h1>Administrar usuarios</h1>



  	<table class="list">
      <tr>
        <th>ID</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Username</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>

      <?php foreach($admins as $user) { ?>
        <tr>
          <td><?php echo h($user->id_user); ?></td>
          <td><?php echo h($user->first_name); ?></td>
          <td><?php echo h($user->last_name); ?></td>
          <td><?php echo h($user->email); ?></td>
          <td><?php echo h($user->username); ?></td>

          <td><a class="action" href="<?php echo url_for('users/editar.php?id=' . h(u($user->id_user))); ?>">Editar</a></td>
          <td><a class="action" href="<?php echo url_for('users/borrar.php?id=' . h(u($user->id_user))); ?>">Borrar</a></td>
    	  </tr>
      <?php } ?>
  	</table>

  </div>

</div>
&nbsp
&nbsp
&nbsp
&nbsp
&nbsp
<?php include('../front_end/footer.php'); ?>
