<?php


require __DIR__ .'/vendor/autoload.php';
use Automattic\WooCommerce\Client;


$woocommerce = new Client(
    'https://bancodealimentos.org.co', 
    'ck_21b5eec5e125b35d2c6bc60ff337ead81076efdc', 
    'cs_0deb9c9cdff17e5afc25b149535a2234ec66e0e1',
    [
        'wp_api' => true,
        'version' => 'wc/v3',
        'verify_ssl' => false
    ]
);
// $orders=$woocommerce->get('orders');
$page = 1;
$orders = [];
$all_orders = [];
do{
  try {
    $orders = $woocommerce->get('orders',array('per_page' => 100, 'page' => $page,'status' =>'processing'));
  }catch(HttpClientException $e){
    die("Can't get products: $e");
  }
  $all_orders = array_merge($all_orders,$orders);
  $page++;
} while (count($orders) > 0);
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  </head>
  <body>
    <div class="container">
      <table class="table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Id order</th>
                  <th>Status</th>
                  <th>id order payu</th>
              </tr>
          </thead>
          <tbody>
          <?php
          $c=0;
            foreach ($all_orders as $order) {
                $c++;
                ?>
                <tr>
                    <td scope="row"><?php echo $c;?></td>
                    <td><?php echo $order->id;?></td>
                    <td><?php echo $order->status;?></td>
                    <td><?php
                        foreach ($order->meta_data as $md) {
                            if($md->key == 'Código de Trazabilidad'){
                                echo $md->value;
                            }
                        }
                    ?></td>
                </tr>
                <?php
            }
            ?>
          </tbody>
      </table>
      

    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>