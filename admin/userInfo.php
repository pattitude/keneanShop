<?php
require_once "../php/fetchApi.php";
require_once "../php/auth.php";
require_once "../php/adminCrude.php";

if(isset($_POST['poster'])){
    $userPoster = $_POST['poster'];
}


$user = $get->aSinglePostView($userPoster, 'user');
$urow = $user->fetch_assoc();
?>

<script>
  
  function del(pid, table){
          
          if(confirm("Are You Sure You Want to Delete This Post?") == true){
            $.ajax({
              url: 'admin/editHandler.php',
              type: 'POST',
              data: {delete: true, table: table, postId: pid},
              success: function(data){
                alert(data)
                location.reload()
              }
            })
          }
        }


    function ban(id, ban){
        if(confirm("Are You Sure You Want to BAN user?") == true){
        $.ajax({
            url: 'user/userApi.php',
            type: 'POST',
            data: {id: id, ban: ban},
            success: function(data){
                alert(data)
            }
        })
    }
}
</script>

<div style="background-image: url(admin/assets/img/zumra.png);">
      <div class="card w-25 float-left ">
      <img class="img-thumbnail" src="<?php echo $urow['photoPath1']?>" class="card-img-top" alt="...">
    
      </div>

      <h5 >Name : <?php echo $urow['firstName'].' '.$urow['lastName'] ?></h5><br>
    <h5> Location <?php echo $urow['about'] ?>  </h5><br>
    <h5> Phone: <?php echo $urow['phone'] ?> </h5><br>
    <?php if($urow['userStatus'] == 'BAN'){
        ?>
         <button class="btn btn-dark" onclick="ban('<?php echo $userPoster ?>', 'UNBAN')" > UnBan User </button>
        <?php

    }else{
        ?>
        <button class="btn btn-dark" onclick="ban('<?php echo $userPoster ?>', 'BAN' )" > Ban User </button>
        <?php
    } 
    ?>
    
        
</div>
<h2> User Posts</h2>
<?php
$dbTables = array('ad', 'car', 'charity', 'electronics',
      'housesell', 'tender', 'vacancy', 'zebegna', 'jobhometutor', 'hotelhouse' );
      
      $excluded = array('zebegna', 'jobhometutor', 'hotelhouse' );
      ?>
      <div class="row">
      <?php


foreach($dbTables as $posts){  
    $oneTablePostList = $auth->userPostsLister($userPoster, $posts);
    echo 'in for';
    ?>

     
        
      <?php
      while($row = $oneTablePostList->fetch_assoc()){  
        ?>
          <div  class="col-md-3">
              <div class="card mb-4 box-shadow ">
                <?php 
                
                if($posts == 'car' || $posts =='electronics' || $posts == 'charity' || $posts == 'ad'){
                  if($posts == 'ad'){
                    if($row['bigDiscount'] == 'ACTIVE'){
?>
          <a class="img-thumbnail" href="./Description.php?cat=<?php echo $posts;?>&postId=<?php echo $row['id'];?>&label=Big Discount Ads&type=big" > <img class="bd-placeholder-img card-img-top" width="100%" height="150" src="<?php $p = $admin->photoSplit($row['photoPath1']); echo $p[0] ;?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img></a> 
<?php
                    }else{
?>
          <a class="img-thumbnail " href="./Description.php?cat=<?php echo $posts;?>&postId=<?php echo $row['id'];?>&label=Product Ads&type=product" > <img class="bd-placeholder-img card-img-top" width="100%" height="150" src="<?php $p = $admin->photoSplit($row['photoPath1']); echo $p[0] ;?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img></a> 

<?php                     
                    }                    
                  }elseif($posts == 'car' || $posts =='electronics' || $posts == 'charity'){
                    ?>
            <a class="img-thumbnail " 
            href="./Description.php?cat=<?php echo $posts;?>&postId=<?php echo $row['id'];?>&label= &type= " > <img class="bd-placeholder-img card-img-top" width="100%" height="150" src="<?php $p = $admin->photoSplit($row['photoPath1']); echo $p[0] ;?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img></a> 
  
                    <?php
                  }
                }if($posts == 'housesell'){
                  if($row['houseOrLand'] == 'HOUSE'){
                    ?>
                    <a class="img-thumbnail" href="./Description.php?cat=<?php echo $posts;?>&postId=<?php echo $row['id'];?>&label=House Posts&type=house" > <img class="bd-placeholder-img card-img-top" width="100%" height="150" src="<?php $p = $admin->photoSplit($row['photoPath1']); echo $p[0] ;?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img></a> 
                        <?php
                  }else{
                    ?>
                    <a class="img-thumbnail" href="./Description.php?cat=<?php echo $posts;?>&postId=<?php echo $row['id'];?>&label=Land Posts&type=land" > <img class="bd-placeholder-img card-img-top" width="100%" height="150" src="<?php $p = $admin->photoSplit($row['photoPath1']); echo $p[0] ;?>" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"></img></a> 
                          <?php                  
                  }

                }
                ?>

                <div class="card-body">
                  <?php
                  if(!in_array($posts, $excluded)){
                    ?>
                    <p class="card-text"><?php echo $row['title'] ?></p>
                    <?php
                  }else{
                    ?>
                    <p class="card-text"><?php echo $row['name'] ?></p>        
                    <?php
                  }
                  ?>
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                   <?php 
                   if($posts == 'hotelhouse'){
                     if($row['hotelOrHouse'] == 'HOUSE'){
                      ?>
                     <?php
                     }elseif($row['hotelOrHouse'] == 'HOTEL'){
                       ?>
                       <?php
                     }
                   }else{
                    ?>
                    <?php
                  }
                   ?>
                 <a onclick="del('<?php echo $row['id']  ?>', '<?php echo $posts ?>')">   <button type="button"  class="btn btn-sm btn-outline-secondary">Delete</button></a>

                    </div>
                    <small class="text-muted"><?php echo $row['view'] ?> views</small>
                  </div>
                </div>
              </div>
            </div>
                </div>
            <?php }} ?>
    </div>