<?php
    // Step 1: connect to the database
    $database = connectToDB();
   // Step 2: load the data from the database 
   $sql = "SELECT * FROM posts WHERE status = :status ORDER BY id DESC";
   $query = $database->prepare($sql);
    // 3. execute
    $query->execute([
      'status' => 'publish'
    ]);
    // 4. fetchAll
    $posts = $query->fetchAll();
?>    
  <?php require "parts/header.php" ?>
    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center">My Blog</h1>
      <?php foreach ( $posts as $post ) : ?>
        <div class="card mb-2">
            <div class="card-body">
            <h5 class="card-title"><?= $post['title']; ?></h5>
            <p class="card-text"><?= $post['content']; ?></p>
            <div class="text-end">
                <a href="/post?id=<?= $post['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
            </div>
            </div>
        </div>
        <?php endforeach; ?>
      <?php if ( isset( $_SESSION["user"] ) ) : ?>
        <div class="d-flex justify-content-center align-items-center flex-column">
        <span>Welcome back, <?= $_SESSION["user"]["name"]; ?></span>
      <div class="d-flex gap-2">
        <a href="/dashboard" class="btn btn-link p-0" id="dashboard">Dashboard</a>
        <a href="/logout" class="btn btn-link p-0" id="logout">Logout</a>
      </div>
      </div>
      <?php else : ?>
      <div class="mt-4 d-flex justify-content-center gap-3">
        <a href="/login" class="btn btn-link btn-sm">Login</a>
        <a href="/signup" class="btn btn-link btn-sm">Sign Up</a>
      </div>
      <?php endif; ?>
    </div>
    <?php require "parts/footer.php" ?>
   

   
