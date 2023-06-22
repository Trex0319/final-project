<?php

    // call db class
    $database = connectToDB();

    // get orders from orders table
    $sql = "SELECT * FROM orders WHERE user_id = :user_id";
    $query = $database->prepare($sql);
    $query->execute([
        'user_id' => $_SESSION['user']['id']
    ]);
    $orders = $query->fetchAll();

    // require the header part
    require "parts/header.php";

?>
    <div class="container mt-5 mb-2 mx-auto" style="max-width: 900px;">
      <div class="min-vh-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h1 class="h1">My Orders</h1>
        </div>

        <!-- List of orders placed by user in table format -->
        <table
          class="table table-hover table-bordered table-striped table-light"
        >
          <thead>
            <tr>
              <th scope="col">Order ID</th>
              <th scope="col">Date</th>
              <th scope="col">Products</th>
              <th scope="col">Total Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php if ( isset( $orders ) ) : ?>
            <?php foreach( $orders as $order ) : ?>
                <tr>
                <th scope="row"><?php echo $order['id']; ?></th>
                <td><?php echo $order['created_at']; ?></td>
                <td>
                    <ul class="list-unstyled">
                    <?php
                        $sql =  "SELECT 
                            cart.*,
                            products.name,
                            products.price 
                            FROM cart
                            JOIN products
                            ON cart.product_id = products.id
                            WHERE order_id = :order_id";
                            $query = $database->prepare($sql);
                            $query->execute([
                                'order_id' => $order['id']
                            ]);

                            $products_in_cart = $query->fetchAll();

                        foreach( $products_in_cart as $product ) {
                            echo "<li>{$product['name']} ({$product['quantity']})</li>";
                        }
                    ?>
                    </ul>
                </td>
                <td>$<?php echo $order['total_amount']; ?></td>
                </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4">You have not placed any orders.</td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center my-3">
          <a href="/" class="btn btn-light btn-sm"
            >Continue Shopping</a
          >
        </div>
      </div>

      <!-- footer -->
      <div class="d-flex justify-content-between align-items-center pt-4 pb-2">
        <div class="text-muted small">
          © 2022 <a href="/" class="text-muted">My Store</a>
        </div>
        <div class="d-flex align-items-center gap-3">
          <a href="/login" class="btn btn-light btn-sm">Login</a>
          <a href="/signup" class="btn btn-light btn-sm">Sign Up</a>
          <a href="/orders" class="btn btn-light btn-sm">My Orders</a>
        </div>
      </div>
    </div>

<?php

    require "parts/footer.php";