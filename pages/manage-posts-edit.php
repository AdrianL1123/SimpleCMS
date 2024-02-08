<?php 

  // make sure the user is logged in
  if ( !isUserLoggedIn() ) {
    // if is not logged in, redirect to /login page
    header("Location: /login");
    exit;
  }

  // load the database
  $database = connectToDB();

  // get the user id from the url query
  $id = $_GET["id"];

  // load the user data based on the provided id
  // 1 - sql command (recipe)
  $sql = "SELECT * FROM posts WHERE id = :id";
  // 2 - prepare
  $query = $database->prepare($sql);
  // 3 - execute
  $query->execute([
      'id' => $id
  ]);
  // 4 - fetch 
  $post = $query->fetch(); // get only one row of data

require "parts/header.php" ?>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit Post</h1>
      </div>
      <div class="card mb-2 p-4">
        <form
          method="POST" 
          action="/post/edit"
          enctype="multipart/form-data"
          >
          <div class="mb-3">
            <label for="post-title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="post-title"
              name="title"
              value="<?= $post["title"]; ?>"
            />
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Content</label>
            <textarea 
              class="form-control" 
              id="post-content" 
              rows="10"
              name="content"
              ><?= $post["content"]; ?></textarea>
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Status</label>
            <select class="form-control" id="post-status" name="status">
              <option value="pending" <?= $post["status"] === 'pending' ? "selected" : "" ?>>Pending for Review</option>
              <?php if ( isAdminOrEditor() || $post["status"] === 'publish' ) : ?>
                <option value="publish" <?= $post["status"] === 'publish' ? "selected" : "" ?>>Publish</option>
              <?php endif; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Image</label>
            <div>
              <input type="file" name="image" />
              <?php if ( !empty( $post["image"] ) ) : ?>
                <div>
                  <img src="/<?= $post["image"]; ?>" width="150px" class="mt-1" />
                  <input type="hidden" name="original_image" value="<?= $post["image"]; ?>" />
                </div>
              <?php endif; ?>
             </div>
          </div>
          <div class="text-end">
            <input
              type="hidden"
              name="post_id"
              value="<?= $post["id"]; ?>"
              />
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-posts" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Posts</a
        >
      </div>
    </div>
    <?php require "parts/footer.php" ?>
   