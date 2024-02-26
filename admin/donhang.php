<?php require_once "includes/header.php"; ?>

<style>
  .editButton {}
</style>

<div class="col-md-9">
  <h2>Đơn hàng</h2>
  <?php
  if (isset($_GET["stat"])) {
    if ($_GET["stat"] == 'thanhcong')
      echo '<div class="alert alert-success text-center" role="alert">Thành Công!</div>';
    if ($_GET["stat"] == 'loi')
      echo '<div class="alert alert-danger text-center" role="alert">Lỗi</div>';
  }
  ?>
  <div class="card">
    <div class="card-header">
      Tất cả đơn hàng
    </div>
    <div class="card-body">
      <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addOrderModal"><i class="fas fa-plus"></i> Tạo đơn hàng</a> -->
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Người đặt</th>
            <th>Sản phẩm</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once "config.php";

          $stmt = $pdo->query("SELECT orders.*, user.fullname
                                FROM orders
                                INNER JOIN user ON orders.user_id = user.id
                                ");
          $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($orders as $order) {
            echo '<tr>';
            echo '<td>' . $order['id'] . '</td>';
            echo '<td>' . $order['fullname'] . '</td>';
            echo '<td>';
            $stmt = $pdo->prepare("SELECT product.name, order_details.count 
              FROM order_details
              INNER JOIN product ON order_details.product_id = product.id
              WHERE order_details.orders_id = :order_id");
            $stmt->bindParam(':order_id', $order['id']);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $productsStr = "";
            foreach ($products as $product) {
              $productsStr .= $product['name'] . ': ' . $product['count'] . ', ';
            }
            echo strlen($productsStr) > 30 ? substr($productsStr, 0, 30) . '...' : $productsStr;
            echo '</td>';

            echo '<td>$' . number_format($order['total'], 2) . '</td>';

            //Tình trạng đơn hàng
            echo '<td>';
            $status = $order['status'];
            if ($status == '0') {
              echo '<span class="badge badge-warning">Đã tạo</span>';
            } elseif ($status == '1') {
              echo '<span class="badge badge-success">Đã giao</span>';
            } else {
              echo '<span class="badge badge-secondary">Đã huỷ</span>';
            }
            echo "</td>";

            //Button
            echo "<td>";
            echo '<a href="#" class="btn btn-sm btn-info editButton" data-toggle="modal" data-target="#editOrderModal" data-order-id="' . $order['id'] . '"><i class="fas fa-edit"></i> Edit</a>';
            echo "&nbsp;";
            echo '<a href="subsites/xoadh.php?id_donhang=' . $order['id'] . '" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>';
            echo "</td>";

            echo '</tr>';
          }
          ?>
        </tbody>
      </table>

    </div>
  </div>
</div>



<!-- Modal cho nút Sửa -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOrderModalLabel">Sửa Đơn hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form để sửa đơn hàng -->
        <form method="POST" action="subsites/suadh.php" enctype="multipart/form-data">
          <div class="form-group">
            <input type="hidden" class="form-control" id="orderId" name="id_donhang" value="" required>
          </div>
          <div class="form-group">
            <label for="orderNguoiDat">Người đặt</label>
            <input type="text" class="form-control" id="orderNguoiDat" name="fullname" placeholder="Tên người đặt" value="" required disabled>
          </div>

          <div class="form-group">
            <label for="orderSanPham">Sản phẩm và số lượng</label>
            <textarea class="form-control" id="orderSanPham" name="product_quantity" placeholder="Sản phẩm và số lượng" rows="4" required disabled></textarea>
            <!-- You can use a textarea to display the products and quantities here -->
          </div>

          <div class="form-group">
            <label for="orderTongTien">Tổng tiền</label>
            <input type="text" class="form-control" id="orderTongTien" name="tong_tien" placeholder="Tổng tiền" value="" required>
          </div>

          <div class="form-group">
            <label for="orderStatus">Chọn Trạng Thái</label>
            <select class="form-control" id="orderStatus" name="status">
              <option value="0">Đã tạo</option>
              <option value="1">Đã giao</option>
              <option value="2">Đã huỷ</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary" name="btnEdit">Sửa</button>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
  const editButtons = document.querySelectorAll('.editButton');
  editButtons.forEach(button => {
    button.addEventListener('click', async function(event) {
      event.preventDefault();
      const orderId = this.dataset.orderId;
      console.log('Clicked button. Order ID:', orderId);

      const response = await fetch(`subsites/getdh.php?id_donhang=${orderId}`);
      if (!response.ok) {
        alert("Load Đơn hàng thất bại.");
        return;
      }

      const orderData = await response.json();
      console.log('Received order data:', orderData);

      document.getElementById('orderId').value = orderData.order_info.id;
      document.getElementById('orderNguoiDat').value = orderData.order_info.fullname;

      const orderProducts = orderData.product_details.map(product => {
        return `${product.name}: ${product.count}`;
      }).join('\n');
      document.getElementById('orderSanPham').value = orderProducts;

      document.getElementById('orderTongTien').value = orderData.order_info.total;

      const statusSelect = document.getElementById('orderStatus');
      statusSelect.value = orderData.order_info.status;
    });
  });
});


</script>



<?php require_once "includes/footer.php"; ?>