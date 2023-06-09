<?php

    if ( !isUserLoggedIn() ) {
      header("Location: /");
      exit;
    }
    // make sure the id parameter is available in the url
    if ( isset( $_GET['id'] ) ) {
      // load database
      $database = connectToDB();

      // load the user data based on the id
      $sql = "SELECT * FROM posts WHERE id = :id";
      $query = $database->prepare( $sql );
      $query->execute([
        'id' => $_GET['id']
      ]);

      // fetch
      $post = $query->fetch();

    } else {
      header("Location: /manage-product");
      exit;
    }

        require 'parts/header.php';
    ?>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit Post</h1>
      </div>
      <div class="card mb-2 p-4">
      <form
          method="POST"
          action="users/product_edit"
          >
          <?php require "parts/errorbox.php";?>               
          <div class="mb-3">
            <label for="post-title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="post-title"
              name="title"
              value="<?= $post['title']; ?>"
            />
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Content</label>
            <textarea class="form-control" id="post-content" rows="10" name="content"><?=$post['content']; ?></textarea>
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Status</label>
            <select class="form-control" id="post-status" name="status">
              <option value="pending" <?= ( $post['status'] == 'pending' ? 'selected' : '' ); ?>>Pending for Review</option>
              <option value="publish" <?= ( $post['status'] == 'publish' ? 'selected' : '' ); ?>>Publish</option>
            </select>
          </div>
          <div class="text-end">
            <input type="hidden" name="id" value="<?= $post['id']; ?>" />
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-product" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Posts</a
        >
      </div>
    </div>

    <?php

require 'parts/footer.php';
