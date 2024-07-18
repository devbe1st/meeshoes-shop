<?php 
class Cart_Controller{
    private $db;
    private $cartModel;
    function __construct(mysqli $db){
        $this->db = $db;
        $this->cartModel = new Cart_Model($this->db);
    }
    function showCartList(){
        $result = $this->cartModel->showCartList();
        include './views/cart.php';
    }
    function addToCart(){
        return $this->cartModel->addToCart();
    }
    function updateQuantityCart(){
        return $this->cartModel->updateQuantityCart();
    }
    function deleteCart(){
        return $this->cartModel->deleteCart();
    }
    function quantityCart(){
        return $this->cartModel->quantityCart();
    }
    function showCartListPageCheckout(){
        $result = $this->cartModel->showCartList();
        if(isset($result)){
            include './views/checkout.php';
        }else{
            $result = $this->cartModel->showCartList();
            include './views/cart.php';
        }
    }
}
?>