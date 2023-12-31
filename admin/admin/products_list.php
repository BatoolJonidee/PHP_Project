<?php
session_start();

include "sidenav.php";
include "topheader.php";
include("../../user/connect.php");
error_reporting(0);
if (isset($_GET['action']) && $_GET['action'] != "" && $_GET['action'] == 'delete') {
  $product_id = $_GET['product_id'];

  
  $sql = "SELECT photo FROM products WHERE product_id = $product_id";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  $pic_name = $row['photo'];

  $path = "../product_images/$pic_name";

  if (file_exists($path)) {
      unlink($path);
  }

  
  $query = "DELETE FROM products WHERE product_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $stmt->close();
}
//update products
$display = 'none';
if(isset($_POST["updateproduct"])){
  $product_id=$_POST['product_id'];
  $stat = "SELECT * FROM products WHERE product_id=$product_id";
  $result = mysqli_query($conn,$stat);
  $resultcheck1 = mysqli_num_rows($result);
  if($resultcheck1 > 0)
  {
      while($row = mysqli_fetch_assoc($result))

      {   
          $product_id = $row['product_id'];
          $newfName= $row["product_name"];
          $newlName= $row["price"];
          // $newEmail= $row[""];
          $newmobile= $row["quantity"];
          $newPassword= $row["description"];
          $sale = $row['sale'];
          $display= 'block';
      }
  }
}
if(isset($_POST["update"])){
  $newfName= $_POST["productname"];
  $newlName= $_POST["price"];
  // $newEmail= $_POST["newEmail"];
  $newmobile= $_POST["quantity"];
  $newPassword= $_POST["description"];
  $sale = $_POST['sale'];
  $product_id=$_POST['productid'];
  $query1= "
  UPDATE products SET product_name='$newfName',
   price='$newlName',
  quantity='$newmobile',
  description='$newPassword',
  sale='$sale'
   WHERE product_id='$product_id'
   ";
  $result = mysqli_query($conn,$query1);
  $display= 'none';
}

// pagination

$page=$_GET['page'];

if($page=="" || $page=="1")
{
$page1=0;	
}
else
{
$page1=($page*10)-10;	
} 

?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
        
        
         <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
              <div id="editdiv" style="display: <?php echo $display?>; ">
                    <form action="products_list.php" method="post">
                        <input type="hidden" value="<?php echo $product_id?>" name="productid">
                        <label class="col-2">Product Name:</label>
                        <input class="col-5" type="text" value="<?php echo $newfName?>" name="productname"><br>
                        <label class="col-2">Price:</label>
                        <input class="col-5" type="number" value="<?php echo $newlName?>" name="price"><br>
                        <label class="col-2">Quantity:</label>
                        <input class="col-5" type="number" value="<?php echo $newmobile?>" name="quantity"><br>
                        <label class="col-2">Discription</label>
                        <input class="col-5" type="text" value="<?php echo $newPassword?>" name="description"><br>
                        <label class="col-2">sale</label>
                        <input class="col-5" type="number" value="<?php echo $sale?>" name="sale"><br>
                        
                     
                        <input type="submit" class="btn btn-outline-secondary" value="Save" name="update">
                    </form>
              </div>
                <h4 class="card-title"> Products List</h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive ps">
                  <table class="table tablesorter " id="page1">
                    <thead class=" text-primary">
                      <tr><th>Image</th><th>Product Id</th><th>Name</th><th>Price</th><th>Sale %</th><th>Quantity</th>
	                      <a class=" btn btn-primary" href="add_products.php">Add New</a></th></tr></thead>
                    <tbody>
                      <?php 

                        $result=mysqli_query($conn,"SELECT * FROM products");

                        while($row=mysqli_fetch_array($result))
                        {
                       $image=$row["photo"];
                       $product_name = $row['product_name'];
                       $price = $row['price'];
                       $quantity = $row['quantity'];
                       $product_id = $row['product_id'];
                       $sale = $row['sale'];
                        echo "<tr><td><img src='../product_images/$image' style='width:50px; height:50px; border:groove #000'></td><td>$product_id</td><td>$product_name</td>
                        <td>$price</td><td>$sale</td><td>$quantity</td>
                        <td>
                        <a class=' btn btn-danger' href='products_list.php?product_id=$product_id&action=delete'>Delete</a>
                        
                        <form method='post'>
                        <input type='hidden' value=' " . $product_id . "' name='product_id'>
                        <input class='btn btn-outline-primary' type='submit' value='Edit' name='updateproduct'>
                        </form>
                        </td></tr>";
                        }

                        ?>
                    </tbody>
                  </table>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <!-- <span aria-hidden="true">&laquo;</span> -->
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                 <?php 
//counting paging

                $paging=mysqli_query($conn,"select product_id,product_image, product_title,product_price from products");
                $count=mysqli_num_rows($paging);

                $a=$count/10;
                $a=ceil($a);
                
                for($b=1; $b<=$a;$b++)
                {
                ?> 
                <li class="page-item"><a class="page-link" href="productlist.php?page=<?php echo $b;?>"><?php echo $b." ";?></a></li>
                <?php	
}
?>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
            
           

          </div>
          
          
        </div>
      </div>
      <?php
include "footer.php";
?>