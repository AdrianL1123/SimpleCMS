<?php 

  // load the database
  $database = connectToDB();

  // get the user id from the url query
  $id = isset( $_GET["id"] ) ? $_GET["id"] : '';

  // load the user data based on the provided id
  // 1 - sql command (recipe)
  $sql = "SELECT
          posts.*,
          users.name AS user_name
          FROM posts 
          JOIN users
          ON posts.user_id = users.id
          WHERE posts.id = :id AND posts.status = :status";
  // 2 - prepare
  $query = $database->prepare($sql);
  // 3 - execute
  $query->execute([
      'id' => $id,
      'status' => 'publish'
  ]);
  // 4 - fetch 
  $post = $query->fetch(); // get only one row of data

require "parts/header.php"; ?>
    <div class="container mx-auto my-5" style="max-width: 500px;">
      <?php if ( $post ) : ?>
        <h1 class="h1 mb-4 text-center"><?= $post['title']; ?></h1>
        <h4 class="mb-4 text-center">By <?php
          // bad method:
          // $sql = "SELECT * FROM users WHERE id = :id";
          // $query = $database->prepare($sql);
          // $query->execute([
          //     'id' => $post["user_id"]
          // ]);
          // $user = $query->fetch(); // get only one row of data
          // echo $user['name'];
          // JOIN method:
          echo $post['user_name'];
        ?></h4>
        <?php if ( !empty( $post["image"] ) ) : ?>
          <img src="/<?= $post["image"]; ?>" class="img-fluid"/>
        <?php endif; ?>
        <?php 
          // long method:
          // $paragraph_array = preg_split( '/\n\s*\n/', $post['content'] );
          // foreach ( $paragraph_array as $paragraph ) {
          //   echo "<p>$paragraph</p>";
          // }
          // short method:
          echo nl2br( $post['content'] );
        ?>
      <?php else : ?>
        <p class="lead text-center">Post Not Found.</p>
      <?php endif; ?>
      <div class="text-center mt-3">
        <a href="/" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back</a
        >
      </div>
    </div>
    <?php 
    require "parts/footer.php";