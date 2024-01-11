<?php 

$url_root = $_SERVER['DOCUMENT_ROOT'];
define("APP_ROOT", $url_root); 


/* format arrays */
function formatcode($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

/* Select single statement */
function selectSingleUser($id = NULL) {
  global $conn;
  $stmt = $conn->prepare(
      "SELECT u.firstName, u.lastName
      FROM intranet_users AS u
      WHERE u.id=:id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('No rows');
      $users = $stmt->fetch(PDO::FETCH_ASSOC);
  return $users;

}

/*Logout statement */
function doLogOut(){
  // hijack then destroy

  session_destroy();
  session_commit();
  $_SESSION['message'] = array('type'=>'success', 'msg'=>'You have benn successfully logged out.');
  header('Location: ./login.php');
  exit();
}