<?php

  $keyword = isset( $_GET["keyword"] ) ? $_GET["keyword"] : "";

  $database = connectToDB();

  $sql = "SELECT * FROM products WHERE status = 'publish' AND name like '%$keyword%' ORDER BY id DESC";
  $query = $database->prepare($sql);
  $query->execute();
  $products = $query->fetchAll();

  require 'parts/header.php';

?>

<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand">Pobular</a>
    <form 
        action=""
        method="GET"
        class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" name="keyword" value="<?= $keyword; ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    <form class="d-flex" role="search">
        <?php if (isUserLoggedIn()) { ?>
        <a href="/logout" class="btn btn-outline-dark me-2">Logout</a>
        <a href="/dashboard" class="btn btn-outline-dark me-2">dashboard</a>
        <?php } else { ?>
          <a href="/login" class="btn btn-outline-dark me-2">Login</a>
          <a href="/signup" class="btn btn-outline-dark me-2">Sign Up</a>
          <?php } ?>
    </form>      
  </div>
</nav>

<div class="top">
    <div class="container mt-5 mb-2 mx-auto" style="max-width: 900px;">
      <div class="min-vh-100">
        <div class="d-flex justify-content-between align-items-center mb-4 text-white">
          <h1 >Books</h1>
          <div class="d-flex align-items-center justify-content-end gap-3">
            <a href="/cart" class="btn btn-dark">My Cart</a>
          </div>
        </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ( $products as $product ) : ?>
            <div class="col">
                <div class="card h-100">
                <img
                    src="uploads/<?php echo $product['image']; ?>"
                    class="card-img-top"
                    style="height:280px;"
                    alt="Product 1"
                />
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text">US$<?php echo $product['price']; ?></p>
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
                    <button class="btn btn-primary">Add to cart</button>
                    <?php endif; ?>
                    <a href="/product?id=<?php echo $product['id']; ?>" class="btn bg-info rounded-2">Details</a>
                    </form>
                </div>
                </div>
            </div>
            <?php endforeach; ?>
            </div>
            </div>
        </div>
        </div>
    </div>

<?php

    require 'parts/footer.php';