<?php require_once "includes/header.php" ?>

<!-- <style>
  .editButton {}
</style> -->

<div class="col-md-9">
  <h2>Quản lý sản phẩm</h2>
  <?php
  if (isset($_GET["stat"])) {
    if ($_GET["stat"] == 'thanhcong')
      echo '<div class="alert alert-success text-center" role="alert">Thành Công!</div>';
    if ($_GET["stat"] == 'loi')
      echo '<div class="alert alert-danger text-center" role="alert">Lỗi</div>';
  }
  ?>
  <div class="card">
    <div class="card-body">

      <form action="" method="get">
      <div class="d-flex justify-content-between">
        <div class="input-group" style="max-width: 300px;">
          <input type="text"  placeholder="Tìm kiếm sản phẩm"  name="search">
          <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
        </div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">Thêm sản phẩm</button>
      </div>
      </form>

      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tên SP</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hình</th>
            <th>NSX</th>
            <th>Cat</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $sql = "SELECT product.id, product.name, product.price, product.image, product.description, 
          manufacturer.name as manufacturer_name, categories.name as category_name
          FROM product 
          JOIN manufacturer ON product.manufacturer_id = manufacturer.id 
          JOIN categories ON product.categories_id = categories.id";

          if(isset($_GET['search'])){
            $sql.=" WHERE product.name LIKE '%".$_GET['search']."%'";
          };

          $stmt = $pdo->query($sql);
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>" . (strlen($row['description']) > 50 ? substr($row['description'], 0, 50) . '...' : $row['description']) . "</td>";
            $base_url = BASE_URL;
            echo "<td><img src='$base_url/img/{$row['image']}' style='width: 50px; height: 50px;'></td>";
            echo "<td>{$row['manufacturer_name']}</td>";
            echo "<td>{$row['category_name']}</td>";
            echo "<td>";

          ?>
            <div class="d-flex">
              <a href="#" class="btn btn-sm btn-info editButton me-2" data-toggle="modal" data-target="#editProductModal" data-product-id="<?= $row['id'] ?>"><i class="fas fa-edit"></i> Edit</a>
              &nbsp;
              <a href="subsites/xoasp.php?id_sanpham=<?= $row['id'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
            </div>
          <?php
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>


    </div>
  </div>
</div>


<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Thêm Sản Phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="subsites/themsp.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="productName">Tên Sản Phẩm</label>
            <input type="text" class="form-control" name="productName" placeholder="Nhập tên sản phẩm" value="Sản phẩm mẫu" required>
          </div>
          <div class="form-group">
            <label for="productPrice">Giá</label>
            <input type="number" class="form-control" name="productPrice" placeholder="Nhập giá sản phẩm" value="10000" required>
          </div>
          <div class="form-group">
            <label for="productStocks">Số Lượng</label>
            <input type="number" class="form-control" name="productStocks" placeholder="Nhập số lượng sản phẩm" value="10" required>
          </div>
          <div class="form-group">
            <label for="productReview">Đánh Giá</label>
            <input type="number" class="form-control" name="productReview" placeholder="Nhập đánh giá sản phẩm" value="4" required>
          </div>
          <div class="form-group">
            <label for="category">Chọn Danh Mục</label>
            <select class="form-control" id="category" name="category">
              <?php
              $stmt = $pdo->prepare("SELECT id, name FROM categories");
              $stmt->execute();
              $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($categories as $category) {
                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="manufacturer">Chọn Nhà Sản Xuất</label>
            <select class="form-control" id="manufacturer" name="manufacturer">
              <?php
              $stmt = $pdo->prepare("SELECT id, name FROM manufacturer");
              $stmt->execute();
              $manufacturers = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($manufacturers as $manufacturer) {
                echo "<option value='" . $manufacturer['id'] . "'>" . $manufacturer['name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="productImage">Ảnh Sản Phẩm</label>
            <input type="file" class="form-control-file" name="productImage">
          </div>
          <div class="form-group">
            <label for="productDescription">Mô Tả</label>
            <textarea class="form-control" name="productDescription" rows="4" required>Sản phẩm mẫu - Mô tả sản phẩm mẫu</textarea>
          </div>
          <button type="submit" class="btn btn-primary" name="btnAdd">Thêm</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Sửa Sản Phẩm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="subsites/suasp.php" enctype="multipart/form-data">
          <input type="hidden" name="editProductId" id="editProductId" value="">
          <div class="form-group">
            <label for="editProductName">Tên Sản Phẩm</label>
            <input type="text" class="form-control" name="editProductName" id="editProductName" required>
          </div>
          <div class="form-group">
            <label for="editProductPrice">Giá</label>
            <input type="number" class="form-control" name="editProductPrice" id="editProductPrice" required>
          </div>
          <div class="form-group">
            <label for="editProductStocks">Số Lượng</label>
            <input type="number" class="form-control" name="editProductStocks" id="editProductStocks" required>
          </div>
          <div class="form-group">
            <label for="editProductReview">Đánh Giá</label>
            <input type="number" class="form-control" name="editProductReview" id="editProductReview" required>
          </div>
          <div class="form-group">
            <label for="editCategory">Chọn Danh Mục</label>
            <select class="form-control" id="editCategory" name="editCategory">
              <?php
              $stmt = $pdo->prepare("SELECT id, name FROM categories");
              $stmt->execute();
              $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($categories as $category) {
                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="editManufacturer">Chọn Nhà Sản Xuất</label>
            <select class="form-control" id="editManufacturer" name="editManufacturer">
              <?php
              $stmt = $pdo->prepare("SELECT id, name FROM manufacturer");
              $stmt->execute();
              $manufacturers = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($manufacturers as $manufacturer) {
                echo "<option value='" . $manufacturer['id'] . "'>" . $manufacturer['name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="editProductImage">Ảnh Sản Phẩm</label>
            <input type="file" class="form-control-file" name="editProductImage">
          </div>
          <div class="form-group">
            <label for="editProductDescription">Mô Tả</label>
            <textarea class="form-control" name="editProductDescription" id="editProductDescription" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary" name="btnEdit">Lưu Thay Đổi</button>
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
        const productId = this.dataset.productId;

        const response = await fetch(`subsites/getsp.php?id_sanpham=${productId}`);
        if (!response.ok) {
          alert("Failed to load product.");
          return;
        }

        const productData = await response.json();

        document.getElementById('editProductId').value = productData.id;
        document.getElementById('editProductName').value = productData.name;
        document.getElementById('editProductPrice').value = productData.price;
        document.getElementById('editProductStocks').value = productData.stocks;
        document.getElementById('editProductReview').value = productData.review;
        document.getElementById('editProductDescription').value = productData.description;
        document.getElementById('editProductManufacturerId').value = productData.manufacturer_id;
        document.getElementById('editProductCategoryId').value = productData.categories_id;
        document.getElementById('editProductImage').value = productData.image;

      });
    });
  });
</script>






<?php require_once "includes/footer.php" ?>