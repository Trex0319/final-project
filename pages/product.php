<?php

    if ( isset( $_GET['id'] ) ) {
        $database = connectToDB();

        $sql = "SELECT * FROM products WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([
        'id' => $_GET['id']
        ]);
        $products = $query->fetchAll();
    } else {
        header("Location: /");
        exit;
    }
        require 'parts/header.php';
?>

<div class="container mx-auto my-5" style="max-width: 500px;">
<?php foreach($products as $product) { ?>
    <div class="card h-100">
        <img
            src=<?php echo $product['image_url']; ?>
            class="card-img-top"
            alt="Product 1"
        />
        <div class="card-body text-center">
            <h1 class="card-title"><?php echo $product['name']; ?></h1>
            <p class="card-text"><?php echo $product['detail']; ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Author: <?php echo $product['author'];?></li>
            <li class="list-group-item">Pages: <?php echo $product['page']; ?></li>
            <li class="list-group-item">Subject: <?php echo $product['subject']; ?></li>
        </ul>
        <div class="card-body">
            <form
                method="POST"
                action="/cart"
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
                <div class="text-center">
                    <a href="/" class="btn btn-link btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
</div>

<?php
    
    require 'parts/footer.php';