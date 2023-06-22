<?php

    if ( isset( $_GET['id'] ) ) 
        $database = connectToDB();

        $sql = "SELECT * FROM products WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([
        'id' => $_GET['id']
        ]);
        $product = $query->fetch();
    
        require 'parts/header.php';
?>

<div class="container mx-auto my-5" style="max-width: 1000px;">
    <div class="row">
    <div class="col-lg-6">
    <div class="card h-100">
        <?php if($product['image']) : ?>
            <img
            src="uploads/<?=$product['image']; ?>"
            class="card-img-top"
            alt="Product 1"
            />
        <?php endif; ?>
        <div class="card-body text-center">
            <h1 class="card-title"><?php echo $product['name']; ?></h1>
            <p class="card-text"><?php echo nl2br( $product['detail'] ); ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Author: <?php echo $product['author'];?></li>
            <li class="list-group-item">Pages: <?php echo $product['page']; ?></li>
            <li class="list-group-item">Subject: <?php echo $product['subject']; ?></li>
        </ul>
        <div class="card-body">
            <form
                method="POST"
                action="/cart_add"
                >
                <input
                    type="hidden"
                    name="product_id"
                    value="<?php echo $product['id']; ?>"
                />
                <?php if (isUserLoggedIn()) : ?>
                <div class="text-center">
                    <button class="btn btn-primary">Add to cart</button>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="mt-3">
            <h4 class="text-white">Comments</h4>
            <?php                
                $sql = "SELECT
                    comments.*,
                    users.name
                    FROM comments
                    JOIN users
                    ON comments.user_id = users.id
                    WHERE product_id = :product_id ORDER BY id DESC";
                $query = $database->prepare($sql);
                $query->execute([
                    "product_id" => $product['id']
                ]);

                $comments = $query->fetchAll();

                foreach ($comments as $comment) :
            ?>
            
            <div class="card mt-2">
                <div class="card-body">
                    <p class="card-text"><?= $comment['comments']; ?></p>
                    <p class="card-text"><small class="text-muted">Commented By <?= $comment['name']; ?></small></p>

                    <?php if (isUserLoggedIn()) : ?>
                    <?php if ( ofEditorAndAdmin() OR $_SESSION["user"]["id"] === $comment['user_id'] ) : ?>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-modal-<?= $comment['id']; ?>">
                    <i class="bi bi-trash"></i
                    >
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="delete-modal-<?= $comment['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to delete this comment: <?= $comment['name']; ?>?</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          You're currently deleting <?= $comment['name']; ?>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                          <form method= "POST" action="/comments/delete">
                            <input type="hidden" name="id" value= "<?= $comment['id']; ?>" />
                            <input type="hidden" name="user_id" value= "<?= $comment['user_id']; ?>" />
                            <input type="hidden" name="product_id" value= "<?= $comment['product_id']; ?>" />
                            <button type="submit" class="btn btn-danger">Yes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                  <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
            </div>

            <?php if ( isUserLoggedIn() ) : ?>
                <?php require "parts/errorbox.php"; ?>
            <form
                action="/comments/add"
                method="POST"    
                >
                <div class="mt-3">
                    <label for="comments" class="form-label text-white">Enter your comment below:</label>
                    <textarea class="form-control" id="comments" rows="3" name="comments"></textarea>
                </div>
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>" />
                <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id']; ?>" />
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <?php endif; ?>
        </div>

        <div class="text-center mt-3">
            <a href="/" class="btn btn-link btn-sm"
            ><i class="bi bi-arrow-left"></i> Back</a
            >
        </div>
            </div>
            </div>
</div>

<?php
    
    require 'parts/footer.php';