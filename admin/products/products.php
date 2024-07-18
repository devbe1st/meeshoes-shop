<button class="add"><a href="?room=add-product">Thêm sản phẩm</a></button>
<!-- /* ----------------------------------- NEW ---------------------------------- */ -->
<form class="search-new" action="" method="POST">
    <input type="text" name="keyword" placeholder="Tìm kiếm">
    <button name="search">Tìm kiếm</button>
</form>
<br>
<?php 
include '../config/database.php';
if(isset($_POST["search"])){
    $keyword = "%" . $_POST["keyword"] . "%";
    $sql = "SELECT * FROM products WHERE productName LIKE ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!-- /* ----------------------------------- NEW ---------------------------------- */ -->
<table>
    <?php 
    if(isset($result)){
        ?>
        <tr>
            <th>ID</th>
            <th>Mã danh mục</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Giảm giá(%)</th>
            <th>Số lượng</th>
            <th>Mô tả</th>
            <th>Chi tiết</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        <?php // HTML
        $db = include '../config/database.php';
        $commentController = new Comment_Controller($db);
        $productController = new Product_Controller($db);
        foreach ($result as $product) : 
            ?>
            <tr class="product-table">
                <td><?= $product['id'] ?></td>
                <td><?= $product['categoryId'] ?></td>
                <td>
                    <img width="100px" src="../assets/image/<?= $product['image'] ?>" alt="">
                    <a href="?room=images&productId=<?= $product['id'] ?>" class="image-more"><i class="fa-regular fa-image"></i></a>
                </td>
                <td class="productNameTD"><?= $product['productName'] ?></td>
                <td><?= number_format($product['price']) ?> VNĐ</td>
                <td><?= $product['discount'] ?>%</td>
                <!-- /* ------------------------------ QUANTITY ------------------------------ */ -->
                <td>
                    <?php 
                    $quantity = $product['quantity'];
                    $quantityOld = $productController->quantityOld($quantity);
                    if($quantityOld >= $quantity){
                        messRed("Sold old");
                    }else{
                        echo $quantityOld . " / " . $product['quantity'];
                    }
                    ?>
                </td>
                <!-- /* ------------------------------ QUANTITY ------------------------------ */ -->
                <td><a class="black" href="?room=details-product&view=description&id=<?= $product['id'] ?>">Xem</a></td>
                <td><a class="black" href="?room=details-product&view=details&id=<?= $product['id'] ?>">Xem</a></td>
                <td>
                    <div class="statusMain">
                        <!-- XỬ LÍ HIỂN THỊ CHO ĐẸP THÔI -->
                        <?php 
                        $status = $product['status'];
                        $color = "";
                        if($status === "hot"){
                            $color = "red";
                        }elseif($status === "new"){
                            $color = "green";
                        }elseif($status === "sale"){
                            $color = "navi";
                        }elseif($status === "flashsale"){
                            $color = "yellow";
                        }
                        ?>
                        <span class="span-<?= $color ?>"><?= $status ?></span>
                        <!-- XỬ LÍ HIỂN THỊ CHO ĐẸP THÔI -->
                        <form action="?room=products&action=update-status-product&id=<?= $product['id'] ?>" method="POST" class="statusMore">
                            <button name="action" value="none" class="black">None</button>
                            <button name="action" value="hot" class="red">Hot</button>
                            <button name="action" value="new" class="green">New</button>
                            <button name="action" value="sale" class="black">Sale</button>
                            <button name="action" value="flashsale" class="yellow">Flash Sale</button>
                        </form>
                    </div>
                </td>
                <td class="actions">
                    <form action="" method="POST">
                        <a href="?room=comment-details&productId=<?= $product['id'] ?>" class="black rlvcmt">
                        <i class="fa-regular fa-comments"></i>
                            <?php
                                $numberComment = $commentController->quantityCommentAdmin($product['id']);
                                if($numberComment > 0){
                                    ?>
                                    <div class="dot-comments"><?= $numberComment ?></div>
                                    <?php // HTML
                                }
                            ?>
                        </a>
                        <a class="green" href="?room=edit-product&id=<?= $product['id'] ?>"><i class="fa-regular fa-pen-to-square"></i> Sửa</a>
                        <a class="black" href="?room=add-color&id=<?= $product['id'] ?>"><i class="fa-regular fa-pen-to-square"></i> Màu</a>
                        <a class="black" href="?room=add-size&id=<?= $product['id'] ?>"><i class="fa-regular fa-pen-to-square"></i> Size</a>
                        <a class="red" onclick="return confirmDelete('?action=delete-product&id=<?= $product['id'] ?>')" href=""><i class="fa-solid fa-trash-can"></i> Xóa</a>
                    </form>
                </td>
            </tr>
            <?php //HTML
        endforeach;
    }else{
        if(!isset($alertDelete) && !isset($alertUpdate)){
            ?><span class="span-red">Empty Product</span><?php // HTML
        }
    }
    ?>
</table>
<div class="pag-style">
    <div id="pagination-buttons"></div>
</div>
<!-- Xử lí hiển thị -->
<?= (isset($alertUpdate) && $alertUpdate === "Cập nhật thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Cập nhật thành công',allowOutsideClick: false}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=products';}});</script>" : ""?>
<?= (isset($alertUpdate) && $alertUpdate === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>
<?= (isset($alertDelete) && $alertDelete === "Thành công") ? "<script>Swal.fire({icon: 'success',title: 'Thành công',text: 'Xóa thành công',allowOutsideClick: false}).then((result) => { if (result.isConfirmed) {window.location.href = '?room=products';}});</script>" : ""?>
<?= (isset($alertDelete) && $alertDelete === "Lỗi") ? "<script>Swal.fire({icon: 'error',title: 'Lỗi',text: 'Error!',});</script>" : "" ?>
<!-- Xử lí hiển thị -->
<script>
    const rowsPerPage = 10;
    const allRows = document.querySelectorAll('.product-table');
    const totalRows = allRows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    const paginationContainer = document.getElementById('pagination-buttons');

    let currentPage = 1;

    function showPage(pageNumber) {
        currentPage = pageNumber;
        const startIndex = (pageNumber - 1) * rowsPerPage;
        const endIndex = pageNumber * rowsPerPage;

        allRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });

        renderPaginationButtons();
    }

    function renderPaginationButtons() {
        paginationContainer.innerHTML = '';

        if (totalPages > 1) {
            let startPage, endPage;
            if (totalPages <= 5) {
                startPage = 1;
                endPage = totalPages;
            } else {
                if (currentPage <= 3) {
                    startPage = 1;
                    endPage = 5;
                } else if (currentPage + 2 >= totalPages) {
                    startPage = totalPages - 4;
                    endPage = totalPages;
                } else {
                    startPage = currentPage - 2;
                    endPage = currentPage + 2;
                }
            }

            if (currentPage > 1) {
                const backButton = createButton('Back', currentPage - 1);
                paginationContainer.appendChild(backButton);
            }

            for (let i = startPage; i <= endPage; i++) {
                const pageButton = createButton(i, i);
                paginationContainer.appendChild(pageButton);
            }

            if (currentPage < totalPages) {
                const nextButton = createButton('Next', currentPage + 1);
                paginationContainer.appendChild(nextButton);
            }
        }
    }

    function createButton(text, pageNumber) {
        const button = document.createElement('button');
        button.innerText = text;
        button.addEventListener('click', () => showPage(pageNumber));
        return button;
    }

    showPage(1);
</script>