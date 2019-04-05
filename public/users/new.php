<?php
   require_once('../../private/initialize.php');


if(is_post_request()) {

  // Create record using post parameters

	  //$args = $_POST['admin'];
	  $args = [];
    $args['first_name'] = $_POST['first_name'] ?? NULL;
	  $args['last_name'] = $_POST['last_name'] ?? NULL;
	  $args['email'] = $_POST['email'] ?? NULL;
	  $args['username'] = $_POST['username'] ?? NULL;
	  $args['password'] = $_POST['password'] ?? NULL;
	  $args['confirm_password'] = $_POST['confirm_password'] ?? NULL;

	  $user = new User ($args);
//ChromePhp::log(($user));

	  $result = $user->save();


  if($result === true) {
      $session->message('The user was created successfully.');
      redirect_to(url_for('index.php'));
  } else {
    // show errors
  }

} else {
  // display the form
  $user = new user;
}

?>

<?php $page_title = 'Create User'; ?>
<?php url_for('../../front_end/header.php'); ?>

<div id="content">

<!--  <a class="back-link" href="<?php echo url_for('/admins/index.php'); ?>">&laquo; Back to List</a> -->

  <div class="admin new">
    <h1>Create User</h1>

    <?php echo display_errors($user->errors); ?>

    <form action="<?php echo url_for('/users/new.php'); ?>" method="post">

      <?php include('form_fields.php'); ?>


      <div id="operations">
        <input type="submit" value="Create User" />
      </div>
    </form>

  </div>

</div>
<?php url_for('../front_end/footer.php'); ?>
