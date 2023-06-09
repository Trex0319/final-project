<?php

  if ( !isUserLoggedIn() ) {
    header("Location: /");
    exit;
  }
  
        require 'parts/header.php';
    ?>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Add New Post</h1>
      </div>
      <div class="card mb-2 p-4">
      <form
          method="POST"
          action="/product_add"
          >
          <?php require "parts/errorbox.php";?>          
          <div class="mb-3">
            <label for="post-title" class="form-label">Title</label>
            <input type="text" class="form-control" id="post-title" name="name"/>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price"/>
          </div>
          <div class="mb-3">
            <label for="detail" class="form-label">Detail</label>
            <textarea
              class="form-control"
              id="detail"
              rows="10"
              name="detail"
            ></textarea>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="manage-posts" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Posts</a
        >
      </div>
    </div>

    <?php

require 'parts/footer.php';
