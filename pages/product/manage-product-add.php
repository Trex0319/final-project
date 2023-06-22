<?php

  if ( !isUserLoggedIn() ) {
    header("Location: /");
    exit;
  }
  
        require 'parts/header.php';
    ?>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1 text-white">Add New Product</h1>
      </div>
      <div class="card mb-2 p-4">
      <form
          method="POST"
          action="/product_add"
          enctype="multipart/form-data">
          <?php require "parts/errorbox.php";?>        
          <div class="mb-3">
            <label for="product-name" class="form-label">Title</label>
            <input type="text" class="form-control" id="product-name" name="name"/>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price"/>
          </div>
          <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author"/>
          </div>
          <div class="mb-3">
            <label for="page" class="form-label">Page</label>
            <input type="text" class="form-control" id="page" name="page"/>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject"/>
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
          <div class="col">
                <label for="post-image" class="form-label">Image</label>
            <input type="file" name="image" id="post-image" />
                </div>  
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="manage-product" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Product</a
        >
      </div>
    </div>

    <?php

require 'parts/footer.php';
