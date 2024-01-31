<?php 

  // load the database
  $database = connectToDB();

  // get the user id from the url query
  $id = $_GET["id"];

  // load the user data based on the provided id
  // 1 - sql command (recipe)
  $sql = "SELECT * FROM users WHERE id = :id";
  // 2 - prepare
  $query = $database->prepare($sql);
  // 3 - execute
  $query->execute([
      'id' => $id
  ]);
  // 4 - fetch 
  $user = $query->fetch(); // get only one row of data

require "parts/header.php"; ?>
  <div class="container mx-auto my-5" style="max-width: 700px">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h1 class="h1">Edit User</h1>
    </div>
    <div class="card mb-2 p-4">
      <?php require "parts/message_error.php"; ?>
      <form 
        method="POST" 
        action="/user/edit"
        >
        <div class="mb-3">
          <div class="row">
            <div class="col">
              <label for="name" class="form-label">Name</label>
              <input 
                type="text"
                class="form-control"
                id="name"
                name="name"
                value="<?= $user['name']; ?>"
              />
            </div>
            <div class="col">
              <label for="email" class="form-label">Email</label>
              <input 
                type="email" 
                class="form-control" 
                id="email"
                name="email"
                value="<?= $user['email']; ?>"
              />
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select 
            class="form-control" 
            id="role"
            name="role"
          >
            <option value="">Select an option</option>
            <option value="user" <?= $user["role"] === 'user' ? "selected" : "" ?>>User</option>
            <option value="editor" <?= $user["role"] === 'editor' ? "selected" : "" ?>>Editor</option>
            <option value="admin" <?= $user["role"] === 'admin' ? "selected" : "" ?>>Admin</option>
          </select>
        </div>
        <div class="d-grid">
          <!-- put hidden input for id -->
          <input
            type="hidden"
            name="user_id"
            value="<?= $user["id"]; ?>"
            />
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
    <div class="text-center">
      <a href="/manage-users" class="btn btn-link btn-sm"
        ><i class="bi bi-arrow-left"></i> Back to Users</a
      >
    </div>
  </div>

<?php require "parts/footer.php"; ?>
   
