<?php
  require_once('../../private/initialize.php');
  require_login();
  $page_title = 'editar';
include('../front_end/header.php');

   if(!isset($_GET['id'])) {
     redirect_to(url_for('users/index.php'));
   }
   $id = $_GET['id'];
   $user = user::row_id("id_user",$id); //php function to pull

   if($user == false){
     redirect_to(url_for('users/index.php'));
   }


  if(is_post_request()) { //-- After submitting - - - - - -  - - - - - - - - - - - - -

      $id = $_GET['id'];

      $args = [];
      $args['first_name'] = $_POST['first_name'] ?? NULL;
      $args['last_name'] = $_POST['last_name'] ?? NULL;
      $args['email'] = $_POST['email'] ?? NULL;
      $args['username'] = $_POST['username'] ?? NULL;
      $args['password'] = $_POST['password'] ?? NULL;
      $args['confirm_password'] = $_POST['confirm_password'] ?? NULL;

      $user = new User ($args);
      $result = $user->save('id_user',$id);

      if($result === true) {
          $session->message('The user was updated successfully.');
        //  redirect_to(url_for('users/index.php'));

      } else {
        // show errors
        $session->message('error'. $result);
      }

  } else {
      // display the form
  }


 ?>

  <?php echo display_errors($user->errors); ?>
  <h2>Actualiza user informacion: <?php echo ($user->username); ?> </h2>

  <form action="<?php echo url_for('users/editar.php?id='.$id.''); ?>" method="post">
    <?php include('form_fields.php'); ?>
    <input type="submit" value="Actualizar" />
  </form>
 &nbsp;
 &nbsp;
<?php include('../front_end/footer.php'); ?>
