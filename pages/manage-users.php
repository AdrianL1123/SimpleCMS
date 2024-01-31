<?php

  // make sure the user is logged in
  if ( !isUserLoggedIn() ) {
    // if is not logged in, redirect to /login page
    header("Location: /login");
    exit;
  }

  // make sure only admin can see this page
  if ( !isAdmin() ) {
    // if is not admin, then redirect the user back to /dashboard
    header("Location: /dashboard");
    exit;
  }

  // load database
  $database = connectToDB();

  // get all the users
  // 1. sql command
  $sql = "SELECT * from users ORDER BY id DESC"; // order by ID DESC
  // 2. prepare
  $query = $database->prepare( $sql );
  // 3. execute
  $query->execute();
  // 4. fetchAll
  $users = $query->fetchAll();

  require "parts/header.php"; ?>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Manage Users</h1>
        <div class="text-end">
          <a href="/manage-users-add" class="btn btn-primary btn-sm"
            >Add New User</a
          >
        </div>
      </div>
      <div class="card mb-2 p-4">
        <?php require "parts/message_success.php"; ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Role</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach( $users as $user ) : ?>
            <tr>
              <th scope="row"><?= $user["id"]; ?></th>
              <td><?= $user["name"]; ?></td>
              <td><?= $user["email"]; ?></td>
              <td>
                
                <?php if ( $user["role"] === 'admin' ) : ?>
                  <span class="badge bg-primary">Admin</span>
                <?php endif; ?>

                <?php if ( $user["role"] === 'editor' ) : ?>
                  <span class="badge bg-info">Editor</span>
                <?php endif; ?>

                <?php if ( $user["role"] === 'user' ) : ?>
                  <span class="badge bg-success">User</span>
                <?php endif; ?>

              </td>
              <td class="text-end">
                <div class="buttons">
                  <a
                    href="/manage-users-edit?id=<?= $user["id"]; ?>"
                    class="btn btn-success btn-sm me-2"
                    ><i class="bi bi-pencil"></i
                  ></a>
                  <a
                    href="/manage-users-changepwd?id=<?= $user["id"]; ?>"
                    class="btn btn-warning btn-sm me-2"
                    ><i class="bi bi-key"></i
                  ></a>
                  <!-- delete button -->
                  <button 
                    type="button" 
                    class="btn btn-danger btn-sm"
                    <?= ( $user["id"] == $_SESSION["user"]['id'] ? "disabled" : "" ); ?>
                    data-bs-toggle="modal" 
                    data-bs-target="#delete-user-model-<?= $user["id"]; ?>">
                    <i class="bi bi-trash"></i>
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="delete-user-model-<?= $user["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5 text-start" id="exampleModalLabel">Are you sure you want to delete this user (<?= $user["email"]; ?>)?</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          This action cannot be reversed.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form
                            class="d-inline-block"
                            method="POST"
                            action="/user/delete"> 
                            <!-- put hidden input for user's id -->
                            <input 
                              type="hidden"
                              name="user_id"
                              value="<?= $user["id"]; ?>"
                              />
                              <button type="submit" class="btn btn-danger">Yes, Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="text-center">
        <a href="/dashboard" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Dashboard</a
        >
      </div>
    </div>
    <?php require "parts/footer.php"; ?>