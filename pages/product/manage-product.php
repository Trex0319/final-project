<?php

  if ( !isUserLoggedIn() ) {
    header("Location: /");
    exit;
  }

$database = connectToDB();

    if ( ofEditorAndAdmin() ){
      // * means get all the columns from the selected table
      $sql = "SELECT * FROM products";
      $query = $database->prepare($sql);
      $query->execute();
    } else {
      $sql = "SELECT * FROM products where id = :id";
      $query = $database->prepare($sql);
      $query->execute(
      [
          'id' => $_SESSION["id"]
      ]
      );
    }
      $products = $query->fetchAll();

  require "parts/header.php";
?>

    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Manage Posts</h1>
        <div class="text-end">
          <a href="/manage-product-add" class="btn btn-primary btn-sm"
            >Add New Post</a
          >
        </div>
      </div>
      <div class="card mb-2 p-4">
      <?php require "parts/message_success.php"; ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col" style="width: 30%;">Title</th>
              <th scope="col" style="width: 30%;">Price</th>
              <th scope="col">Status</th>
              <th scope="col" style="width: 30%;" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($products as $product) : ?>
            <tr >
            <th scope="row"><?= $product['id']; ?></th>
              <td><?= $product['name']; ?></td>
              <td>$<?= $product['price']; ?></td>
              <td>
                <span class="<?php
                if($product["status"] == "pending"){
                  echo "badge bg-warning";
                } else if($product["status"] == "publish"){
                  echo "badge bg-success";
                }
                ?>">
                <?= $product['status']; ?>
              </span></td>
              <td class="text-end">
                <div class="buttons">
                  <a
                    href="post?id=<?= $product['id']; ?>"
                    target="_blank"
                    class="btn btn-primary btn-sm me-2 
                    <?php
                    if($product["status"] == "pending"){
                      echo "disabled";
                    }else if($product["status"] == "publish"){
                      echo " ";
                    }
                    ?>"
                    ><i class="bi bi-eye"></i
                  ></a>
                  <a
                    href="/manage-product-edit?id=<?= $product['id']; ?>"
                    class="btn btn-secondary btn-sm me-2"
                    ><i class="bi bi-pencil"></i
                  ></a>
                  <!-- Button trigger modal -->
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal-<?= $product['id']; ?>">
                    <i class="bi bi-trash"></i
                    >
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="delete-modal-<?= $product['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to delete this post: <?= $product['name']; ?>?</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          You're currently deleting <?= $product['name']; ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                          <!-- 
                            Delete Form 
                            1. add action
                            2. add method
                            3. add input hidden field for id
                          -->
                          <form method= "POST" action="/users/post_delete">
                            <input type="hidden" name="id" value= "<?= $product['id']; ?>" />
                            <button type="submit" class="btn btn-danger">Yes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <div class="text-center">
        <a href="dashboard" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Dashboard</a
        >
      </div>
    </div>

    <?php

require 'parts/footer.php';
