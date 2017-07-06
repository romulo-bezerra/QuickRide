<?php
  function open_database() {
      try {
          $conn = mysqli_connect('localhost', 'root','', 'republics');
          return $conn;
      } catch (Exception $e) {
          echo $e->getMessage();
          return null;
      }
  }
  function close_database($conn) {
      try {
          mysqli_close($conn);
      } catch (Exception $e) {
          echo $e->getMessage();
      }
  }
?>
