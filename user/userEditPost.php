<html>
    <script src="assets/jquery.js"></script>  
  
   <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">  </script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->


   <?php
   include "../includes/lang.php";
   require_once "../php/adminCrude.php";
include "../includes/header.php";
require "../php/fetchApi.php";

   if(isset($_GET['pid'])){ //pid is post id to be edited
    $uidx = $_GET['pid'];
  }

   ?>
<script>
  $(document).ready(function(){


  /// this will triger the address list for selecting address for all of the forms
  $('#z').hide()
  $('#ADD').click(function(){
    $('#z').show()
  $('#z').load('user/divTags.php #jiji')
})
  })


</script>
<script>
  // this function sends the selected address to api. that api sets the address to a session then the session will be
  // the input to the database
  function handler(address){
    $('#jiji').hide();
    $('#z').hide()
    $('#dbad').val(address); 
    $('#ADD').text(address);
  }

  function typeHandler(data, apiId, showId, hideId){
    $('#z').hide()
    $('#'+hideId).hide()
    $('#'+apiId).val(data)
    $('#'+showId).text(data)
    if(data == "Cloth and Shoe"){
    $('#targetLoader').load('admin/divTags.php #targetFor')
  }else{
    $('#targetLoader').empty()
  }

  if(data == 'Computer and Laptop'){
    $('#computer').load('admin/divTags.php #sizeInch,#proc,#storage,#core,#ram')
  }else{
    $('#computer').empty()
  }
  }

  // function to load the categoty of post based on the needed div tag from divTags.php provided by onclick event
  function typeLoader(divId){
    $('#z').show()
    $('#z').load('user/divTags.php #'+divId)
  }


</script>
    <script>

  $(document).ready(function(){
  /// this will triger the address list for selecting address for all of the forms
  $('#ADD').click(function(){
  $('#z').load('user/divTags.php #jiji')
})




    $('#editV').on('submit', function(e){
      alert('informs')
      e.preventDefault()
      $.ajax({
        url: 'admin/editHandler.php',
        type: 'post',
        data: $('#editV').serialize(),
        success : function(){
          $('#alertVacancy').text('Edit SUCCESSFULL!  ')
        }
      })
      return false;

    })

    // $('#editT').on('submit', function(e){
    //   alert('inform')

    //   e.preventDefault()
    //   $.ajax({
    //     url: 'admin/editHandler.php',
    //     type: 'post',
    //     data: $('#editT').serialize(),
    //     success : function(){
    //       $('#alertVacancy').text('Edit SUCCESSFULL!  ')
    //     }
    //   })
    //   return false;

    // })


    $('form').on('submit', function(e){
      // alert('inform')

          e.preventDefault()
          $.ajax({
            url: 'admin/editHandler.php',
            type: 'post',
            data:  new FormData( this ),
            success : function(data){
              $( 'form' ).each(function(){
                    this.reset();
              });
              $('#alertVacancy').text(data)
              // $('#alertVacancy').delay(3200).fadeOut(300);
            },
            processData: false,
        contentType: false
          })
          
          return false;

    })

    



  })
  



</script>
    <?php
require_once "../php/adminCrude.php";





?>


    <main id="main" class="main">
    <!-- <div id="contw" class="modal-dialog"> -->
    <!-- <div class="modal-content"> -->
 <!-- /// to select address like jiji style -->
<div id="z"  class="modal-dialog" style="position: absolute; top: 3%; width: 100%; z-index:3; " ></div>
<?php
/////////////////////////////////////////////////////////////
  // if post vacancy is selected it loads this if block
  if(isset($_GET['type'])){
    if($_GET['type'] == "vacancy"){
    ?>
 
      <div class="pagetitle">
      <h1> <?php echo $lang['vacancyPost'] ?></h1>
      </div>


    <div id="vacancyBox" class="container">
  <form  id="editV"  method="POST" enctype="multipart"  >
      <input hidden name="pid" value="<?php echo $uidx; ?>">
    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['companyName'] ?></label>
      <input type="text" class="form-control" id=" " 
      aria-describedby="emailHelp" name="companyName" placeholder=" " 
      value="<?php 
                $p = editVacancyPost($uidx);
                $row = $p->fetch_assoc();
                echo $row['companyName']; 
      ?>">

    </div>
   

      <script>
            // $(document).ready(function(){
            //   $('#jobTT').on('change', function(){
            //     if(this.value == 'OTHER'){
            //       $('#jobT').load('divTags.php #jobType')
            //     }
                
            //   })
            // })

          </script>

<div  class="form-group" >
<label  for="inputGroupSelect01"><?php echo $lang['jobType'] ?></label>

        <select  class="form-select" name="jobType" id="">
          <option selected  ><?php echo $row['type'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allCategoryLister('vacancy');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['jobTitle'] ?></label>
      <input type="text" class="form-control" id="jobTitle" 
      aria-describedby="emailHelp" name="jobTitle" placeholder="Company Name" 
      value="<?php 
                $p = editVacancyPost($uidx);
                $row = $p->fetch_assoc();
                echo $row['title']; 
      ?>">
 
    </div>
    <div class="form-group">

      <label   for="inputGroupSelect01"><?php echo $lang['positionType'] ?></label>

    <select class="form-select" name="positionType" id="inputGroupSelect01">
      <option selected><?php 
                $p = editVacancyPost($uidx);
                $row = $p->fetch_assoc();
                echo $row['positionType']; 
      ?></option>
          <option value="Full Time"><?php echo $lang['fullTime'] ?></option>
          <option value="Part Time"><?php echo $lang['partTime'] ?></option>
          <option value="Temporary"><?php echo $lang['Temporary'] ?></option>
          <option value="Contractual"> <?php echo $lang['Contractual'] ?></option>
    </select>
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1"><?php echo $lang['Gender'] ?></label>
        <select class="form-select" name="sex" id="inputGroupSelect01">
          <option value=" "><?php echo $row['sex'] ?></option>
          <option value="Male"><?php echo $lang['Male'] ?></option>
          <option value="Female"><?php echo $lang['Female'] ?></option>
          <option value="Both"><?php echo $lang['Both'] ?></option>
        </select>
    </div>


    <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['appStart'] ?>:</label>
          <input type="date" class="form-control" id="Deadline" 
          aria-describedby="emailHelp" name="appStart" placeholder="Company Name" value="<?php echo $row['appStart'] ?>" >

        </div>


    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['appDead'] ?></label>
      <input type="date" class="form-control" id="Deadlined" 
      aria-describedby="emailHelp" name="Deadline" placeholder="Company Name"
      value="<?php 
                $p = editVacancyPost($uidx);
                $row = $p->fetch_assoc();
                echo $row['deadLine']; 
      ?>"
      >

    </div>
    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['requierdPositionNo'] ?></label>
      <input type="number" class="form-control" id="jobTitle" 
      aria-describedby="emailHelp" name="reqNo" placeholder="Company Name"
      value="<?php 
                $p = editVacancyPost($uidx);
                $row = $p->fetch_assoc();
                echo $row['positionNum']; 
      ?>"
      >
 
    </div>

    <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['phone'] ?></label>
          <input type="number" class="form-control" id="jobTitle" 
          aria-describedby="emailHelp" name="phone" placeholder="phone number"
          value="<?php 
                $p = editVacancyPost($uidx);
                $row = $p->fetch_assoc();
                echo $row['phone']; 
      ?>"
          >
    
        </div>


        <div  class="form-group" >
        <select  class="form-select" name="location" id="">
          <option><?php echo $row['address'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['Salary'] ?>: </label>
          <input type="text" class="form-control" id="jobTitle" 
          aria-describedby="emailHelp" name="salary" placeholder="phone number" value="<?php
                        $p = editVacancyPost($uidx);
                        $row = $p->fetch_assoc();
          echo $row['salary'] ?>" >
         </div>





    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['Description'] ?></label>
      <textarea type="text" class="form-control" id="des" 
      aria-describedby="emailHelp" name="description"  
      value= ""
      
      ><?php 
                $p = editVacancyPost($uidx);
                $row = $p->fetch_assoc();
                echo $row['info']; 
      ?></textarea>
 
    </div>
      <!-- <input type="submit"   value="POST"> -->
      <input type="submit" value="Save Changes">
    <div id="alertVacancy"></div>

</form>
  
    
    <?php
    }
  }
  //////////////////////////////////////////////////////////////////////////
  //if post tender is selected it loads this if block
  if(isset($_GET['type'])){
    if($_GET['type'] == 'tender'){
      ?>
         <div class="pagetitle">
  <h1><?php echo $lang['tenderPost'] ?></h1>

    <p>
    </p>

    <div id="vacancyBox" class="container">
    <form id="editT" action="editPost.php" method="POST" >
    <input hidden name="uid" value="<?php echo $uidx; ?>">
    <div class="form-group">

    <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['title'] ?></label>
          <input type="text" class="form-control" id="tenderType" 
          aria-describedby="emailHelp" name="title" placeholder="Company Name"
          value="<?php
        $out = tenderEditLister($uidx);
        $row = $out->fetch_assoc();
        echo $row['title']
      
      ?>"
          >
        </div>

      <label for="exampleInputEmail1"><?php echo $lang['tenderType'] ?></label>
      <input type="text" class="form-control" id="tenderType" 
      aria-describedby="emailHelp" name="tenderType" placeholder="Company Name"
      value="<?php
        $out = tenderEditLister($uidx);
        $row = $out->fetch_assoc();
        echo $row['type']
      
      ?>"
      >
    </div>


    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['startingDate'] ?></label>
      <input type="date" class="form-control" id="startingDate" 
      aria-describedby="emailHelp" name="startDate" placeholder="Company Name" 
      value="<?php
        $out = tenderEditLister($uidx);
        $row = $out->fetch_assoc();
        echo $row['startingDate'];
      
      ?>"
      >
    </div>

    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['appDead'] ?></label>
      <input type="date" class="form-control" id="Deadline2" 
      aria-describedby="emailHelp" name="Deadline2" placeholder="Company Name" 
      value="<?php
        $out = tenderEditLister($uidx);
        $row = $out->fetch_assoc();
        echo $row['deadLine'];
      
      ?>"
      >
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['initialCost'] ?></label>
      <input type="number" class="form-control" id="phoneNo" 
      aria-describedby="emailHelp" name="initialCost" placeholder="Company Name" 
      value="<?php
        $out = tenderEditLister($uidx);
        $row = $out->fetch_assoc();
        echo $row['initialCost'];
      
      ?>"
      >
    </div>
  
    <div  class="input-group mb-3" >
        <select  class="form-select" name="location2" id="">
          <option><?php echo $row['address'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

        <div class="form-group">

          <label for="exampleInputEmail1"> <?php echo $lang['phone'] ?> : </label>
           <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="phone" placeholder="" value="+<?php 
         echo  $row['phone']?>">
        </div>

    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['Description'] ?></label>
      <textarea type="text" class="form-control" id="des2" 
      aria-describedby="emailHelp" name="description2" placeholder="Describition" 
      value=""
      ><?php
        $out = tenderEditLister($uidx);
        $row = $out->fetch_assoc();
        echo $row['info']
      
      ?></textarea>
    </div>

    <input type="submit" onclick="x()" value="Save Changes">
    <div id="alertVacancy"></div>
    </form>
    
    <script>
// photo updater and deleter
function pUpdate(divz, photo){
 $('#'+divz).empty()
 $.post('admin/editHandler.php', {photoPath: photo, tableName: "tender", pid: "<?php echo $uidx ?>"}, 
   function(returnedData){
     $('#'+divz).append(returnedData)        
 })
}

</script>
<?php
$i = 0;
$pp = photoSplit($row['photoPath1']);
if(!empty($row['photoPath1'])){
foreach($pp as $photo){
  ?>
       <div id="<?php echo $i ?>">
       <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
       <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
       </div>
  <?php
  $i ++;
}
}else{
 ?>
       <form method="POST" enctype="multipart/form-data" >
       <input hidden name="pid" value="<?php echo $uidx; ?>">
       <input hidden name="tName" value="tender">
       <div class="row">
       <div id="registerBox">
       <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
       <input type="file" class="form-control" id="photo" name="photo[]" multiple >
       
       </div>
       </div>

       <input type="submit" value="Change Photo">
       </form>
 
 <?php
}
?>


    </div>
  
  </section>
                
      
      <?php
    }
    
    //////////////////////////////////////////////////////
    elseif($_GET['type'] == 'ad'){
      $adEdit = adEditDataLister($uidx);
      while($adRow = $adEdit->fetch_assoc()){
        ?>
<script>
  $(document).ready(function(){
$('#selchange').on('change', function(){
  // alert('change')
  $('#jj').hide()
  if(this.value == "Cloth and Shoe"){
    $('#jj').show()
    $('#targetLoader').load('admin/divTags.php #targetFor')
  }else{
    $('#targetLoader').empty()
    $('#jj').hide()
  }
 
})

// $('#tCategory').on('change', function(){
//   if(this.value == "OTHER"){
//     $('#adTy').load('admin/divTags.php #otherAd')
//   }
 
// })



})
</script>
    <form id="car" action="editPost.php" method="POST"   enctype="multipart/form-data">
        <input hidden name="pid" value="<?php  echo $uidx ?>"
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['title'] ?></label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="title" placeholder="Company Name" 
          value="<?php echo $adRow['title'] ?>">
        </div>


        <div  class="form-group" >
          <label><?php echo $lang['adsCategory'] ?></label>
        <select  class="form-select" name="type" id="selchange">
          <option selected ><?php echo $adRow['type'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allCategoryLister('ad');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){

                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  
      
                  $i++;
                }
              ?> 
        </select>
        </div>


        <div id="jj">
        <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['for'] ?>: </label>
       
        <select class="form-select" name="for" id="inputGroupSelect01">
          <option value=" "><?php echo $lang['Gender'] ?></option>
          <option value="Male"><?php echo $lang['Male'] ?></option>
          <option value="Female"><?php echo $lang['Female'] ?></option>
          <option value="Both"><?php echo $lang['Both'] ?></option>
        </select>
        </div>
        </div>



        <?php
        if($adRow['for'] != " "){
?>

<div id="targetLoader" class="input-group mb-3">
        <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['for'] ?>: </label>
       
        <select class="form-select" name="for" id="inputGroupSelect01">
          <option value=" "><?php echo $lang['Gender'] ?></option>
          <option value="Male"><?php echo $lang['Male'] ?></option>
          <option value="Female"><?php echo $lang['Female'] ?></option>
          <option value="Both"><?php echo $lang['Both'] ?></option>
        </select>
        </div>
</div>
<?php
        }
        
        ?>




        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['Price'] ?>:</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="price" placeholder="Company Name" 
          value="<?php echo $adRow['price'] ?>"
          >
         </div>




        <div  class="form-group" >
          <label> City </label>
        <select  class="form-select" name="address" id="">
          <option><?php echo $adRow['address'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>


        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['phone'] ?></label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="phone" placeholder="09..."
          value="<?php echo $adRow['phone'] ?>"
          >
         </div>

        <div class="form-group">
        <select class="form-select" name="shipping" id="inputGroupSelect01">
          <option><?php echo $adRow['shipping'] ?></option>
          <option value="NO">NO</option>
          <option value="YES">YES</option>

        </select>
        </div>


        <div class="form-group">
          <label for="exampleInputEmail1">Describtion</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="info" placeholder="location"><?php echo $adRow['info'] ?></textarea>
          
        </div>


        <input type="submit"  value="Save Changes">
                      <div id="alertVacancy"></div>
        </form>

        <script>
// photo updatedr and deleter
function pUpdate(divz, photo){
 $('#'+divz).empty()
 $.post('admin/editHandler.php', {photoPath: photo, tableName: "ad", pid: "<?php echo $uidx ?>"}, 
   function(returnedData){
     $('#'+divz).append(returnedData)        
 })
}

</script>
<?php
$i = 0;
$pp = photoSplit($adRow['photoPath1']);
if(!empty($adRow['photoPath1'])){
foreach($pp as $photo){
  ?>
       <div id="<?php echo $i ?>">
       <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
       <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
       </div>
  <?php
  $i ++;
}
}else{
 ?>
       <form method="POST" enctype="multipart/form-data" >
       <input hidden name="pid" value="<?php echo $uidx; ?>">
       <input hidden name="tName" value="ad">
       <div class="row">
       <div id="registerBox">
       <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
       <input type="file" class="form-control" id="photo" name="photo[]" multiple >
       </div>
       </div>

       <input type="submit" value="Change Photo">
       </form>
 
 <?php
}
?>



      
        <?php

        ?>

        <?php
      }
      
      ?>


      <?php
    }
    ////////////////////////////////////////////////////////////
    elseif($_GET['type'] == 'car'){
      $carE = carPostDataLister($uidx);
      $carRow = $carE->fetch_assoc();
      ?>

        <form id="car" action="editPost.php" method="POST" enctype="multipart/form-data" >
          <input hidden name="pid" value="<?php echo $uidx; ?>">

          <div class="form-group">
              <label for="exampleInputEmail1"><?php echo $lang['title'] ?></label>
              <input type="text" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="title" placeholder="Company Name" 
              value="<?php echo $carRow['title'] ?>"
              >
             </div>

<script>
  $(document).ready(function(){
    // $('#sCar').on('change', function(){
    //   if(this.value == "other"){
    //     $('#typeC').load("divTags.php #typeCar")
    //   }

    // })

$('#forRentOrSell').on('change', function(){
    if(this.value == 'For Rent'){
      $('#cfr').load("divTags.php #carFR");

    }else{
      $('#cfr').hide()

    }
  
})
  })
</script>

        <div class="input-group mb-3">
            <div class="form-select" id="carShow" onclick="typeLoader('carType')" ><?php echo $carRow['type'] ?></div>      
            <input id="carApi" name="type2" hidden value=" ">   
        </div>

        <div  class="input-group mb-3" >
          <label><?php echo $lang['carModel'] ?></label>
        <select  class="form-select" name="type2" id="s">
          <option><?php echo $carRow['type'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc=   allCategoryLister('car');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){

                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  
                  
                  
                  $i++;
                }
              ?> 
        </select>
        </div>


            
        <script>
          $(document).ready(function(){
            $('#carar').hide()
            $('#forRentOrSell').on('change', function(){
              if(this.value == 'For Rent'){
                $('#carar').show()
              }else if(this.value == 'For Sell'){
                $('#cfr').hide()
                $('#carar').hide()
              }
            })
          })
        </script>


        <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['sellOrRent'] ?>: </label>
        <select class="form-select" name="forRentOrSell" id="forRentOrSell">
          <option selected><?php echo $carRow['forRentOrSell'] ?></option>
          <option value="For Rent"> <?php echo $lang['forRent'] ?></option>
          <option value="For Sell"><?php echo $lang['forSell'] ?></option>
        </select>
        </div>



          <div  class="form-group" >
            <label><?php echo $lang['city'] ?></label>
        <select  class="form-select" name="address" id="s">
          <option><?php echo $carRow['address'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>






         <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['ownerBroker'] ?>: </label>
         <select class="form-select" name="ownerBroker" id="inputGroupSelect01">
          <option selected value="<?php echo $carRow['ownerBroker'] ?>"><?php echo $carRow['ownerBroker'] ?></option>
          <option value="Owner"> <?php echo $lang['broker'] ?></option>
          <option value="Broker"> <?php echo $lang['owner'] ?></option>
        </select>
        </div>

         <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['yearMade']  ?>: </label>
         <select class="form-select" name="status2" id="inputGroupSelect01">
          <option ><?php echo $carRow['status'] ?> ?></option>
          <?php 
            $cYear = date('Y');
            for($y=1980;$y<=$cYear;$y++){
              ?>
              <option value="<?php echo $y ?>"><?php echo $y ?></option>
              <?php
            }
          ?>
          

        </select>
        </div>

    

        <!-- // if the post has no for rent select feild, then when the user selects the for rent option, this div will automatically pop up. when it pops out it hides the for rent options bellow this div if there any for rent options -->

        <div id="carar">
        <div  class="input-group mb-3" >
        <select  class="form-select" aria-label="Default select example" name="rentStatus" id="rentS">
          <option  > <?php echo $lang['rentStatus'] ?></option>
          <option value="With Driver"> <?php echo $lang['withDriver'] ?></option>
          <option selected value="Car Only"><?php echo $lang['carOnly'] ?></option>
        </select>
        </div>

        
        <div  class="input-group mb-3" >
        <select  class="form-select" aria-label="Default select example" name="forWho" id="forWho">
          <option value=" " ><?php echo $lang['rentFor'] ?></option>
          <option value="All"><?php echo $lang['all'] ?></option>
          <option value="Private"><?php echo $lang['private'] ?></option>
          <option value="Govormental Offices"><?php echo $lang['govormentalOffices'] ?></option>
          <option value="Private Company"><?php echo $lang['privateCompany'] ?></option>
          <option value="NGO"><?php echo $lang['ngo'] ?></option>
        </select>
        </div>

        
        <div class="form-group" id="whyRent">
          <label for="exampleInputEmail1"><?php echo $lang['whyRent'] ?></label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="whyRent" placeholder="Description"></textarea>
          <small id="emailHelp" class="form-text text-muted"><?php echo $lang['descWhyRent'] ?></small>
        </div>
        </div>




        <?php
        if($carRow['forRentOrSell'] == 'For Rent'){
            ?>
          <div id="cfr">
          <div  class="form-group" >
          <label for="exampleInputEmail1"><?php echo $lang['rentStatus'] ?> </label>
        <select  class="form-select" name="rentStatus" id="rentS">
        <option selected><?php echo $carRow['rentStatus'] ?></option>
        <option value="With Driver"> <?php echo $lang['withDriver'] ?></option>
          <option selected value="Car Only"><?php echo $lang['carOnly'] ?></option>
        </select>
        </div>

        
        <div  class="input-group mb-3" >
        <label for="exampleInputEmail1"><?php echo $lang['rentFor'] ?> </label>

        <select  class="form-select" name="forWho" id="forWho">
        <option selected><?php echo $carRow['forWho'] ?></option>
          <option value=" " ><?php echo $lang['rentFor'] ?></option>
          <option value="All"><?php echo $lang['all'] ?></option>
          <option value="Private"><?php echo $lang['private'] ?></option>
          <option value="Govormental Offices"><?php echo $lang['govormentalOffices'] ?></option>
          <option value="Private Company"><?php echo $lang['privateCompany'] ?></option>
          <option value="NGO"><?php echo $lang['ngo'] ?></option>
        </select>
        </div>

        
        <div class="form-group" id="whyRent">
 
          <label for="exampleInputEmail1"><?php echo $lang['whyRent'] ?></label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="whyRent" placeholder="Description"><?php echo $carRow['whyRent'] ?> </textarea>
          <small id="emailHelp" class="form-text text-muted"><?php echo $lang['descWhyRent'] ?></small>
        </div>
          </div>
            <?php
        }
        ?>




         <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['fuleType'] ?>: </label>
  

        <select class="form-select" name="fuleKind" id="inputGroupSelect01">
          <option selected></option>
          <option value="Benzene"><?php echo $lang['benzene'] ?></option>
          <option value="Diesel"><?php echo $lang['diesel'] ?></option>
        </select>
        </div>



         <div class="form-group">
          <label class="form-group" for="inputGroupSelect01"> <?php echo $lang['Transmission'] ?>: </label>
  
        
        <select class="form-select" name="transmission" id="inputGroupSelect01">
          <option selected><?php echo $lang['Transmission'] ?></option>
          <option value="automatic"><?php echo $lang['Automatic'] ?></option>
          <option value="manual"><?php echo $lang['Manual'] ?></option>
        </select>
        </div>

        <div class="form-group">
              <label for="exampleInputEmail1"><?php echo $lang['bodyStatus'] ?> :</label>
              <input type="text" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="bodyStatus" placeholder="Company Name"
              value="<?php echo $carRow['bodyStatus'] ?>">
 
        </div>

        <div class="form-group">
              <label for="exampleInputEmail1"><?php echo $lang['km'] ?>:</label>
              <input type="text" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="km" placeholder="Company Name"
              value="<?php echo $carRow['km'] ?>">
         </div>



         <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['priceType'] ?> </label>
         <select class="form-select" name="fixidOrN" id="inputGroupSelect01">
          <option selected><?php echo $lang['priceType'] ?></option>
          <option value="Fixed"><?php echo $lang['Fixed'] ?></option>
          <option value="Negotiatable"><?php echo $lang['Negotiatable'] ?></option>
          <option value="Negotiatable"><?php echo $lang['slightlyNegotiable'] ?></option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['Price'] ?>: </label>
          <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="price2" placeholder="Company Name" 
          value="<?php echo $carRow['price'] ?>"
          >
         </div>

        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['Description'] ?></label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="info2" placeholder="location"> <?php echo $carRow['info'] ?> </textarea>
         </div>

        <input type="submit" onclick="x()" value="Save Changes">
        <div id="alertVacancy"></div>

        <script>
//photo updater and deleter
function pUpdate(divz, photo){
 $('#'+divz).empty()
 $.post('admin/editHandler.php', {photoPath: photo, tableName: "car", pid: "<?php echo $uidx ?>"}, 
   function(returnedData){
     $('#'+divz).append(returnedData)        
 })
}

</script>
<?php
$i = 0;
$pp = photoSplit($carRow['photoPath1']);
if(!empty($carRow['photoPath1'])){
foreach($pp as $photo){
  ?>
       <div id="<?php echo $i ?>">
       <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
       <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
       </div>
  <?php
  $i ++;
}
}else{
 ?>
       <form method="POST" enctype="multipart/form-data" >
       <input hidden name="pid" value="<?php echo $uidx; ?>">
       <input hidden name="tName" value="car">
       <div class="row">
       <div id="registerBox">
       <label for="exampleInputEmail1"><?php echo $lang['up'] ?> </label>
       <input type="file" class="form-control" id="photo" name="photo[]" multiple >
        </div>
       </div>

       <input type="submit" value="Change Photo">
       </form>

 <?php
}
?>




          </form>
      <?php
    }
    //////////////////////////////////////////////////////////////////////
    elseif($_GET['type'] == 'housex'){
      $houseOut = singleHousePostLister($uidx);
      $houseRow = $houseOut->fetch_assoc();
      ?>
      

      <script>
      $(document).ready(function(){

        // $('#city').on('change',function(){
        //   if(this.value == "otherCity"){
        //   $('#cityBox').load('divTags.php #otherCity')
 
        // }
   
        // })

        // $('#subCity').on('change',function(){
        // if(this.value == "otherSubCity"){
        //  $('#subCityBox').load('divTags.php #otherSubCity')
        // }
      
        // })

        $('#HorL').on('change', function(){
          if(this.value == "HOUSE"){
          $('#houseTypeLoader').load("divTags.php #houseType")
          $('#bedOrBath').load('divTags.php #bedBath')
        }
        })
        })
      </script>

<form id="house" action="editPost.php" method="POST" enctype="multipart/form-data" >
             <input hidden name="pid" value="<?php echo $uidx; ?>">
             <input hidden name="houseOrLand" value="HOUSE">

        </div>

        <div class="form-group">
              <!-- <label for="exampleInputEmail1">Titles</label> -->
              <input hidden type="text" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="title" placeholder="Company Name" 
              value="<?php echo $houseRow['title'] ?> "
              >
              
            </div>

        
<div id="houseTypeLoader">


<div id="houseType" class="input-group mb-3">
  
        <div class="form-group">
        </div>
        <select class="form-select" aria-label="Default select example" name="type" id="selHouseType">
          <option selected><?php echo $houseRow['type'] ?></option>
<?php
require_once "../php/adminCrude.php";
$tab = $_GET['cat'];
$categorySort = array();
$category = allCategoryLister('housesell');
while($rowc = $category->fetch_assoc()){
  $categorySort[] = $rowc['category'];
}
sort($categorySort);
foreach($categorySort as $sorted){
  echo $tab;
  ?>
  <option value="<?php echo $sorted ?>"><?php echo $sorted ?></option>
  
  <?php


    

    }

?>
        </select>
</div>
</div>




            
<script>


  // sub city filter api
  function hCity(x){
    // alert(x)
    $.ajax({
        url: 'user/userApi.php',
        type: 'post',
        data: {
          cityH: x
        },
        success: function(data){
          // alert(data)
          $('#subH').empty()
          $('#subH').append(data)
        }
      })
  }
</script>

<div  class="form-group" >
<label>City: </label>
        <select  class="form-select" aria-label="Default select example" name="city" onchange="hCity(this.value)" id="">
          <option><?php echo $houseRow['city'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

        
<?php
//if there is subcity setted this subcity block will be renderd
if($houseRow['subCity'] != ' '){
  ?>
         <div id="subH"   class="form-group" >
        <label>Sub City: </label>
          <?php
        require_once '../php/fetchApi.php';
    $locc= allPostListerOn2Columen('adcategory', 'tableName', 'SUBCITY', 'subcityKey', 'Addis Ababa');
    $city = array();
    if($locc->num_rows != 0){
      ?>
                <select  class="form-select" aria-label="Default select example" name="subCity" >
          <option><?php echo $houseRow['subCity'] ?></option>
      <?php
    while($rowLoc = $locc->fetch_assoc()){
        $city[]= $rowLoc['category'];
    }
    sort($city);
    $i = 0;
    foreach($city as $loc){
      if($loc == 'Addis Ababa'){
        ?>
        <option selected ><?php echo $loc ?></option>
        <?php
      }else{
        ?>
         <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
        <?php
      }
      ?>
      
    
      
      <?php
      $i++;
    }
  }
    ?>
    </select>
        </div> 
  <?php
}

?>




        

 
      <!-- kebele list -->
      <div class="form-group">
        <label>Wereda: </label>
        <select class="form-select" aria-label="Default select example" name="wereda"  id="inputGroupSelect01">
          <option ><?php echo $houseRow['wereda'] ?></option>
          <?php 
             for($y=1;$y<=30;$y++){
               if($y <= 9 ){
                 ?>
                 <option value="<?php echo '0'.$y ?>"><?php echo '0'.$y ?></option>
                 <?php
               }else{
                ?>
                <option value="<?php echo $y ?>"><?php echo $y ?></option>
                <?php
               }

            }
          ?>
          

        </select>
        </div>


        <div class="form-group">
          <label  for="inputGroupSelect01"> Owner Or Broker: </label>
        <select class="form-select" name="ownerBroker" id="inputGroupSelect01">
          <option selected value="<?php echo $houseRow['ownerBroker'] ?> " ><?php echo $houseRow['ownerBroker'] ?> </option>
          <option value="Owner">Owner</option>
          <option value="Broker">Broker</option>
        </select>
        </div>
        

        <div class="form-group">
          <label  for="inputGroupSelect01"> For Rent or Sell: </label>
        <select class="form-select" name="forRentOrSell" id="inputGroupSelect01">
          <option selected><?php echo $houseRow['forRentOrSell'] ?> </option>
          <option value="For Rent">For Rent</option>
          <option value="For Sell">For Sell</option>
        </select>
        </div>


        <div class="form-group">
              <!-- <label for="exampleInputEmail1"><?php echo $lang['spArea'] ?> : </label> -->
              <input type="text" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="spArea" placeholder="<?php echo $lang['enArea'] ?>" value="<?php echo $houseRow['spArea'] ?>">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Area :</label>
              <input type="number" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="area" placeholder="Company Name" 
              value="<?php echo $houseRow['area'] ?>">
              
            </div>

            <div id="bedOrBath">

              
              <div id="bedBath">
<div class="form-group">
              <label for="exampleInputEmail1">Number Of BedRoom :</label>
              <input type="number" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="bedRoomNo" placeholder="Company Name" 
              value="<?php echo $houseRow['bedRoomNo'] ?>">
              
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Bath Of BedRoom :</label>
              <input type="number" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="bathRoomNo" placeholder="Company Name"
              value="<?php echo $houseRow['bathRoomNo'] ?>">
              
            </div>
</div>
              

            </div>




            <div class="form-group">
              <label for="exampleInputEmail1">Price :</label>
              <input type="number" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="cost" placeholder="Company Name"
              value="<?php echo $houseRow['cost'] ?>">
              
            </div>



        <div class="form-group">
          <label  for="inputGroupSelect01"> Fixed Or Negotiatable </label>
        <select class="form-select" name="fixidOrN" id="inputGroupSelect01">
          <option selected><?php echo $houseRow['fixedOrN'] ?> </option>
          <option value="Fixed">Fixed</option>
          <option value="Negotiatable">Negotiatable</option>
          <option value="Negotiatable">Slightly Negotiable</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Describtion</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="info" placeholder="location"><?php echo $houseRow['info'] ?> </textarea>
          
        </div>

        <input type="submit" value="Save Changes">
        <div id="alertVacancy"></div>

         <script>
// photo updater and deleter
           function pUpdate(divz, photo){
            $('#'+divz).empty()
            $.post('admin/editHandler.php', {photoPath: photo, tableName: "housesell", pid: "<?php echo $uidx ?>"}, 
              function(returnedData){
                $('#'+divz).append(returnedData)        
            })
           }

         </script>
           <?php
           $i = 0;
           $pp = photoSplit($houseRow['photoPath1']);
           if(!empty($houseRow['photoPath1'])){
           foreach($pp as $photo){
             ?>
                  <div id="<?php echo $i ?>">
                  <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
                  <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
                  </div>
             <?php
             $i ++;
           }
          }else{
            ?>
                  <form method="POST" enctype="multipart/form-data" >
                  <input hidden name="pid" value="<?php echo $uidx; ?>">
                  <input hidden name="tName" value="housesell">
                  <div class="row">
                  <div id="registerBox">
                  <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
                  <input type="file" class="form-control" id="photo" name="photo[]" multiple >
                  
                  </div>
                  </div>

                  <input type="submit" value="Change Photo">
                  </form>
            
            <?php
          }
           ?>


             </form>


      <?php
    }

    //////////////////////////////// 
    elseif($_GET['type'] == 'land'){
      $houseOut = singleHousePostLister($uidx);
      $houseRow = $houseOut->fetch_assoc();
      ?>
      

      <script>
      $(document).ready(function(){

        $('#city').on('change',function(){
          if(this.value == "otherCity"){
          $('#cityBox').load('divTags.php #otherCity')
 
        }
   
        })

        $('#subCity').on('change',function(){
        if(this.value == "otherSubCity"){
         $('#subCityBox').load('divTags.php #otherSubCity')
        }
      
        })

        $('#HorL').on('change', function(){
          if(this.value == "HOUSE"){
          $('#houseTypeLoader').load("divTags.php #houseType")
          $('#bedOrBath').load('divTags.php #bedBath')
        }
        })
        })
      </script>

<form id="house" action="editPost.php" method="POST" enctype="multipart/form-data" >
             <input hidden name="pid" value="<?php echo $uidx; ?>">
             <input hidden name="houseOrLand" value="LAND">



        <div class="form-group">
              <label for="exampleInputEmail1">Title</label>
              <input type="text" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="title" placeholder="Company Name" 
              value="<?php echo $houseRow['title'] ?> "
              >
              
            </div>

        

            <div id="subCityBox" class="form-group">
            <label for="exampleInputEmail1">Type</label>

 <input type="text"  class="form-control" id="nameTitle" 
               aria-describedby="emailHelp" name="type"  value="<?php echo $houseRow['type'] ?>">
         </div>

         <script>


// sub city filter api
function hCity(x){
  // alert(x)
  $.ajax({
      url: 'user/userApi.php',
      type: 'post',
      data: {
        cityH: x
      },
      success: function(data){
        // alert(data)
        $('#subH').empty()
        $('#subH').append(data)
      }
    })
}
</script>

<div  class="form-group" >
<label>City: </label>
      <select  class="form-select" aria-label="Default select example" name="city" onchange="hCity(this.value)" id="">
        <option><?php echo $houseRow['city'] ?></option>
        <?php 
            require_once '../php/fetchApi.php';
              $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
              $city = array();
              while($rowLoc = $locc->fetch_assoc()){
                  $city[]= $rowLoc['category'];
              }
              sort($city);
              $i = 0;
              foreach($city as $loc){
                if($loc == 'Addis Ababa'){
                  ?>
                  <option selected ><?php echo $loc ?></option>
                  <?php
                }else{
                  ?>
                   <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                  <?php
                }
                ?>
                
              
                <?php
                $i++;
              }
            ?> 
      </select>
      </div>

      
<?php
//if there is subcity setted this subcity block will be renderd
if($houseRow['subCity'] != ' '){
?>
       <div id="subH"   class="form-group" >
      <label>Sub City: </label>
        <?php
      require_once '../php/fetchApi.php';
  $locc= allPostListerOn2Columen('adcategory', 'tableName', 'SUBCITY', 'subcityKey', 'Addis Ababa');
  $city = array();
  if($locc->num_rows != 0){
    ?>
              <select  class="form-select" aria-label="Default select example" name="subCity" >
        <option><?php echo $houseRow['subCity'] ?></option>
    <?php
  while($rowLoc = $locc->fetch_assoc()){
      $city[]= $rowLoc['category'];
  }
  sort($city);
  $i = 0;
  foreach($city as $loc){
    if($loc == 'Addis Ababa'){
      ?>
      <option selected ><?php echo $loc ?></option>
      <?php
    }else{
      ?>
       <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
      <?php
    }
    ?>
    
  
    
    <?php
    $i++;
  }
}
  ?>
  </select>
      </div> 
<?php
}

?>




      


    <!-- kebele list -->
    <div class="form-group">
      <label>Wereda: </label>
      <select class="form-select" aria-label="Default select example" name="wereda"  id="inputGroupSelect01">
        <option ><?php echo $houseRow['wereda'] ?></option>
        <?php 
           for($y=1;$y<=30;$y++){
             if($y <= 9 ){
               ?>
               <option value="<?php echo '0'.$y ?>"><?php echo '0'.$y ?></option>
               <?php
             }else{
              ?>
              <option value="<?php echo $y ?>"><?php echo $y ?></option>
              <?php
             }

          }
        ?>
        

      </select>
      </div>

        <div class="form-group">
          <label  for="inputGroupSelect01"> Owner Or Broker: </label>
        <select class="form-select" name="ownerBroker" id="inputGroupSelect01">
          <option selected value="<?php echo $houseRow['ownerBroker'] ?> " ><?php echo $houseRow['ownerBroker'] ?> </option>
          <option value="Owner">Owner</option>
          <option value="Broker">Broker</option>
        </select>
        </div>
        

        <div class="form-group">
          <label  for="inputGroupSelect01"> For Rent or Sell: </label>
        <select class="form-select" name="forRentOrSell" id="inputGroupSelect01">
          <option selected><?php echo $houseRow['forRentOrSell'] ?> </option>
          <option value="For Rent">For Rent</option>
          <option value="For Sell">For Sell</option>
        </select>
        </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Area :</label>
              <input type="number" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="area" placeholder="Company Name" 
              value="<?php echo $houseRow['area'] ?>">
              
            </div>

            <div id="bedOrBath">

            </div>




            <div class="form-group">
              <label for="exampleInputEmail1">Price :</label>
              <input type="number" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="cost" placeholder="Company Name"
              value="<?php echo $houseRow['cost'] ?>">
              
            </div>



        <div class="form-group">
          <label  for="inputGroupSelect01"> Fixed Or Negotiatable </label>
        <select class="form-select" name="fixidOrN" id="inputGroupSelect01">
          <option selected><?php echo $houseRow['fixedOrN'] ?> </option>
          <option value="Fixed">Fixed</option>
          <option value="Negotiatable">Negotiatable</option>
          <option value="Negotiatable">Slightly Negotiable</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Describtion</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="info" placeholder="location"><?php echo $houseRow['info'] ?> </textarea>
          
        </div>

        <input type="submit" value="Save Changes">
        <div id="alertVacancy"></div>

         <script>
// photo updater and deleter
           function pUpdate(divz, photo){
            $('#'+divz).empty()
            $.post('admin/editHandler.php', {photoPath: photo, tableName: "housesell", pid: "<?php echo $uidx ?>"}, 
              function(returnedData){
                $('#'+divz).append(returnedData)        
            })
           }

         </script>
           <?php
           $i = 0;
           $pp = photoSplit($houseRow['photoPath1']);
           if(!empty($houseRow['photoPath1'])){
           foreach($pp as $photo){
             ?>
                  <div id="<?php echo $i ?>">
                  <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
                  <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
                  </div>
             <?php
             $i ++;
           }
          }else{
            ?>
                  <form method="POST" enctype="multipart/form-data" >
                  <input hidden name="pid" value="<?php echo $uidx; ?>">
                  <input hidden name="tName" value="housesell">
                  <div class="row">
                  <div id="registerBox">
                  <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
                  <input type="file" class="form-control" id="photo" name="photo[]" multiple >
                  
                  </div>
                  </div>

                  <input type="submit" value="Change Photo">
                  </form>
            
            <?php
          }
           ?>


             </form>


      <?php
    }


    //////////////////////////////////////////////////////////
    elseif($_GET['type'] == 'electronics'){
      $elcEdit = elecSinglePostViewer($uidx);
      $elecRow = $elcEdit->fetch_assoc();

      ?>
        <script>
$(document).ready(function(){
$('#sElc').on('change', function(){
  if(this.value == 'Computer and Laptop'){
    $('#computer').load('admin/divTags.php #sizeInch,#proc,#storage,#core,#ram')
  }else{
    $('#computer').empty()
  }
})
})

</script>
      <form  method="POST" enctype="multipart/form-data" >
      <input hidden name="posterId" value="<?php echo $uidx; ?>">

      <div class="form-group">
          <label for="exampleInputEmail1">Title</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="titleElc" placeholder="Title of Your Post" 
          value="<?php echo $elecRow['title'] ?>">
          
        </div>
 
        
<div  class="input-group mb-3" >
        <select  class="form-select" name="type" id="sElc">
          <option><?php echo $elecRow['type'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumen('adCategory', 'tableName', 'electronics');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>


<div id="computer">
        <?php 
          if($elecRow['ram'] != " " &&
          $elecRow['processor'] != " " &&
          $elecRow['core'] != " " &&
          $elecRow['storage'] != " " &&
          $elecRow['size'] != " " ){

            ?>
            
      <div id="sizeInch" class="form-group">
          <label for="exampleInputEmail1">Size In Inch:</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="size" placeholder="Size of Item" 
          value="<?php echo $elecRow['size'] ?>">
          
        </div>

              <div id="ram" class="form-group">
          <label for="exampleInputEmail1">Ram:</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="ram" placeholder="Size of Item" 
          value="<?php echo $elecRow['ram'] ?>">
          
        </div>

        <div id="proc" class="form-group">
          <label for="exampleInputEmail1">Processor Type:</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="processor" placeholder="Processor Type" 
          value="<?php echo $elecRow['processor'] ?>">
          
        </div>

        <div id="storage" class="form-group">
          <label for="exampleInputEmail1">Storage Size:</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="storage" placeholder="Storage Size"
          value="<?php echo $elecRow['storage'] ?>">
          
        </div>

        <div id="core" class="form-group">
          <label for="exampleInputEmail1">Core Count:</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="core" placeholder="Core count"
          value="<?php echo $elecRow['core'] ?>">
          
        </div>
            <?php

          }
        
        ?>
</div>
     <div class="form-group">
      <label  for="inputGroupSelect01"> Status Of Item: </label>
     <select class="form-select" name="status" id="inputGroupSelect01">
      <option selected value="<?php echo $elecRow['status'] ?>"><?php echo $elecRow['status'] ?></option>
      <option   value="NEW"><?php echo $lang['new'] ?></option>
      <option value="MEDIUM"><?php echo $lang['Medium'] ?></option>
      <option value="OLD"><?php echo $lang['Old'] ?></option>
    </select>
    </div>



    <div id="computer"></div>

    <div class="form-group">
           <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="phone" placeholder="<?php echo $elecRow['phone'] ?>">
        </div>

    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['labelPrice'] ?>: </label>
      <input type="number" class="form-control" id="nameTitle" 
      aria-describedby="emailHelp" name="price" placeholder="Price in Birr" 
      value="<?php echo $elecRow['price'] ?>">
    </div>

 
    <div  class="input-group mb-3" >
        <select  class="form-select" name="address" id="">
          <option><?php echo $elecRow['address'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

    <div class="form-group">
      <label for="exampleInputEmail1"><?php echo $lang['Description'] ?></label>
      <textarea type="text" class="form-control" id="des2" 
      aria-describedby="emailHelp" name="info" placeholder="Detailed Info"><?php echo $elecRow['info'] ?></textarea>
    </div>

        <input type="submit" onclick="x()" value="Save Changes">
    <div id="alertVacancy"></div>

<script>

function pUpdate(divz, photo){
 $('#'+divz).empty()
 $.post('admin/editHandler.php', {photoPath: photo, tableName: "electronics", pid: "<?php echo $uidx ?>"}, 
   function(returnedData){
     $('#'+divz).append(returnedData)        
 })
}

</script>
<?php
$i = 0;
$pp = photoSplit($elecRow['photoPath1']);
if(!empty($elecRow['photoPath1'])){
foreach($pp as $photo){
  ?>
       <div id="<?php echo $i ?>">
       <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
       <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button> 
       </div>
  <?php
  $i ++;
}
}else{
 ?>
       <form method="POST" enctype="multipart/form-data" >
       <input hidden name="pid" value="<?php echo $uidx; ?>">
       <input hidden name="tName" value="electronics">
       <div class="row">
       <div id="registerBox">
       <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
       <input type="file" class="form-control" id="photo" name="photo[]" multiple >
       </div>
       </div>

       <input type="submit" value="Change Photo">
       </form>
 
 <?php
}
?>




      </form>
      
      <?php
    }
  }
  /////////////////////////////////////////////////////////
  if(isset($_GET['type'])){
    if($_GET['type'] == 'charity'){
      $out = aSinglePostViewx($uidx, 'charity');
      $cRow = $out->fetch_assoc();

      ?>
<form  method="POST" enctype="multipart/form-data">

<input hidden name="posterId" value="<?php echo $uidx; ?>">

<div class="form-group">
  <label for="exampleInputEmail1">Charity Title</label>
  <input type="text" class="form-control" id="nameTitle" 
  aria-describedby="emailHelp" name="title" placeholder="Title"
  value="<?php echo $cRow['title'] ?>">
</div>

 


    <div  class="input-group mb-3" >
        <select  class="form-select" name="address" id="">
          <option><?php echo $cRow['address']; ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

<div class="form-group">
  <label for="exampleInputEmail1">Phone no:</label>
  <input type="text" class="form-control" id="nameTitle" 
  aria-describedby="emailHelp" name="phone" placeholder="phone" value="<?php echo $cRow['phone'] ?>" >
</div>


<div class="form-group">
<label for="exampleInputEmail1">Describtion</label>
<textarea type="text" class="form-control" id="des2" 
aria-describedby="emailHelp" name="info" placeholder="Detailed Info"><?php echo $cRow['info'] ?></textarea>
</div>

<div id="alertVacancy"></div>
<input type="submit"  value="Save Changes">

<script>

function pUpdate(divz, photo){
 $('#'+divz).empty()
 $.post('admin/editHandler.php', {photoPath: photo, tableName: "charity", pid: "<?php echo $uidx ?>"}, 
   function(returnedData){
     $('#'+divz).append(returnedData)        
 })
}

</script>
<?php
$i = 0;
$pp = photoSplit($cRow['photoPath1']);
if(!empty($cRow['photoPath1'])){
foreach($pp as $photo){
  ?>
       <div id="<?php echo $i ?>">
       <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
       <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
       </div>
  <?php
  $i ++;
}
}else{
 ?>
       <form method="POST" enctype="multipart/form-data" >
       <input hidden name="pid" value="<?php echo $uidx; ?>">
       <input hidden name="tName" value="charity">
       <div class="row">
       <div id="registerBox">
       <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
       <input type="file" class="form-control" id="photo" name="photo[]" multiple >
       </div>
       </div>

       <input type="submit" value="Change Photo">
       </form>
 
 <?php
}
?>





</form>

      <?php
    }
  }

  ///////////////////////////
  if(isset($_GET['type'])){
    if($_GET['type'] == 'jobhometutor'){

      $out = aSinglePostViewx($uidx, 'jobhometutor');
      $row = $out->fetch_assoc();

      ?>
      
      <h5>Home Tutor Job Application</h5>

<form  method="POST" enctype="multipart/form-data">
<input hidden name="posterId" value="<?php echo $uidx; ?>">

<div class="form-group">
  <label for="exampleInputEmail1">Full Name</label>
  <input type="text" class="form-control" id="nameTitle" 
  aria-describedby="emailHelp" name="name" placeholder="Full Name"  value="<?php echo $row['name'] ?>">
</div>

<div class="form-group">
   <label  for="inputGroupSelect01">Gender</label>
<select class="form-select" name="sex" id="inputGroupSelect01">
  <option selected value="<?php echo $row['sex'] ?>" ><?php echo $row['sex'] ?></option>
  <option value="Male">Mele</option>
  <option value="Female">Female</option>
</select>
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Educational Background:</label>
  <textarea type="text" class="form-control" id="des2" 
  aria-describedby="emailHelp" name="eduBackground" placeholder="location"> <?php echo $row['eduBackground'] ?> </textarea>
</div>


<div class="form-group">
   <label   for="inputGroupSelect01">Range </label>
 <select class="form-select" name="clientRange" id="inputGroupSelect01">
  <option value="<?php echo $row['clientRange'] ?>" ><?php echo $row['clientRange'] ?></option>
  <option value="1-8">1-8 Grade</option>
  <option value="9-12">9-10</option>
  <option value="9-10">9-10</option>
  <option value="10-11">10-11</option>
  <option value="11-12">11-12</option>

</select>
</div>

<div class="form-group">
   <label for="inputGroupSelect01">Payment Status</label>
 <select class="form-select" name="paymentStatus" id="inputGroupSelect01">
  <option selected value="<?php echo $row['paymentStatus'] ?>" ><?php echo $row['paymentStatus'] ?></option>
  <option value="Horly">Hourly</option>
  <option value="Dayly">Dayly</option>
  <option value="Monthly">Monthly</option>

</select>
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Price:</label>
  <input type="number" class="form-control" id="nameTitle" 
  aria-describedby="emailHelp" name="price" placeholder="Full Name" value="<?php echo $row['price'] ?>" >
  
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Phone </label>
  <input type="number" class="form-control" id="nameTitle" 
  aria-describedby="emailHelp" name="phone" placeholder="Full Name" value="<?php echo $row['phone'] ?>" >
</div>

 

    <div  class="input-group mb-3" >
        <select  class="form-select" name="address" id="">
          <option><?php echo $row['address']; ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>
<div class="form-group">
  <h6>If you are representing  or if you are Agent, please fill the next form.</h6>
  <label for="exampleInputEmail1">Company Info</label>
  <textarea type="text" class="form-control" id="des2" 
  aria-describedby="emailHelp" name="companyInfo" placeholder="location"><?php echo $row['companyInfo'] ?></textarea>
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Description About You</label>
  <textarea type="text" class="form-control" id="des2" 
  aria-describedby="emailHelp" name="info" placeholder="info"><?php echo $row['info'] ?></textarea>
</div>



<input type="submit" onclick="x()" value="Save Changes.">
<div id="alertVacancy"></div>

</form>


<script>
// photo updater and deleter
           function pUpdate(divz, photo){
            $('#'+divz).empty()
            $.post('admin/editHandler.php', {photoPath: photo, tableName: "jobhometutor", pid: "<?php echo $uidx ?>"}, 
              function(returnedData){
                $('#'+divz).append(returnedData)        
            })
           }

         </script>
           <?php
           $i = 0;
           $pp = photoSplit($row['photoPath1']);
           if(!empty($row['photoPath1'])){
           foreach($pp as $photo){
             ?>
                  <div id="<?php echo $i ?>">
                  <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
                  <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
                  </div>
             <?php
             $i ++;
           }
          }else{
            ?>
                  <form method="POST" enctype="multipart/form-data" >
                  <input hidden name="pid" value="<?php echo $uidx; ?>">
                  <input hidden name="tName" value="jobhometutor">
                  <div class="row">
                  <div id="registerBox">
                  <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
                  <input type="file" class="form-control" id="photo" name="photo[]" multiple >
                  
                  </div>
                  </div>

                  <input type="submit" value="Change Photo">
                  </form>
            
            <?php
          }
           ?>



      <?php
    }
  }
  //////////////////////////////////////////
  if(isset($_GET['type'])){
    if($_GET['type'] == 'hotel'){
      $outp = aSinglePostViewx($uidx, 'hotelhouse');
      $row = $outp->fetch_assoc();
      ?>
               <h5>Hotel Worker Job Application</h5>
          <form  method="POST" enctype="multipart/form-data">
          <input hidden name="postId" value="<?php echo $uidx; ?>">
          <!-- <input hidden name="hotelOrHouse" value="HOTEL"> -->
          <div class="form-group">
          <label for="exampleInputEmail1">Full Name</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="name" placeholder="Full Name" value="<?php echo $row['name'] ?>">
          </div>

        <div class="form-group">
          <label for="inputGroupSelect01">Gender</label>
        <select class="form-select" name="sex" id="inputGroupSelect01">
          <option selected value="<?php echo $row['sex'] ?>" ><?php echo $row['sex'] ?></option>
          <option value="Male">Mele</option>
          <option value="Female">Female</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Age</label>
          <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="age" placeholder="Full Name" value="<?php echo $row['age'] ?>">
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Field </label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="field" placeholder="Full Name" value="<?php echo $row['field'] ?>" >
        </div>
        <div  class="input-group mb-3" >
        <select  class="form-select" name="address" id="">
          <option><?php echo $row['address']; ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

        <div class="form-group">
          <label   for="inputGroupSelect01">Work Type</label>
        <select class="form-select" name="workType" id="inputGroupSelect01">
          <option selected  > <?php echo $row['type'] ?></option>
          <option value="Half Day">Half Day</option>
          <option value="Full Day">Full Day</option>
          <option value="Monthly">Monthly</option>

        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Price:</label>
          <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="price" placeholder="Full Name" value="<?php echo $row['price'] ?>" >
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Experience</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="experience" placeholder="info"><?php echo $row['experience'] ?></textarea>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Current Address</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="cAddress" placeholder="info"> <?php echo $row['currentAddress'] ?></textarea>
        </div>



        <div class="form-group">
        <h6>If you are an agent, then fill your discription</h6>
          <label for="exampleInputEmail1">Agent Info</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="agentInfo" placeholder="location"> <?php echo $row['agentInfo'] ?></textarea>
        </div>

<br>
        <h5>Can You Provide Biding Person</h5>
        <p>Answer</p>
        <h5><?php echo $row['bidingPerson'] ?></h5>

        <h5>Change Answer</h5>

        <div class="form-check form-check-inline">
          <input class="form-check-input" required type="radio" name="bidp" id="inlineRadio1" value="YES">
          <label class="form-check-label" for="inlineRadio1">Yes</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" required type="radio" name="bidp" id="inlineRadio2" value="NO">
          <label class="form-check-label" for="inlineRadio2">No</label>
        </div><br>

        <input class="btn btn-dark" type="submit" onclick="x()" value="Save Changes">
          <div id="alertVacancy"></div>
          </form>

        
        <script>
// photo updater and deleter
           function pUpdate(divz, photo){
            $('#'+divz).empty()
            $.post('admin/editHandler.php', {photoPath: photo, tableName: "hotelhouse", pid: "<?php echo $uidx ?>"}, 
              function(returnedData){
                $('#'+divz).append(returnedData)        
            })
           }

         </script>
           <?php
           $i = 0;
           $pp = photoSplit($row['photoPath1']);
           if(!empty($row['photoPath1'])){
           foreach($pp as $photo){
             ?>
                  <div id="<?php echo $i ?>">
                  <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
                  <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
                  </div>
             <?php
             $i ++;
           }
          }else{
            ?>
                  <form method="POST" enctype="multipart/form-data" >
                  <input hidden name="pid" value="<?php echo $uidx; ?>">
                  <input hidden name="tName" value="hotelhouse">
                  <div class="row">
                  <div id="registerBox">
                  <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
                  <input type="file" class="form-control" id="photo" name="photo[]" multiple >
                  </div>
                  </div>

                  <input type="submit" value="Change Photo">
                  </form>
            
            <?php
          }
           ?>


             </form>


          



      
      <?php
    }
  }
///////////////////////////////////////////
if(isset($_GET['type'])){
  if($_GET['type'] == 'houseKeeper'){
    $out = aSinglePostViewx($uidx, 'hotelhouse');
    $row = $out->fetch_assoc();

    ?>
    
    
    <h5>House Keeper Job Application</h5>
    <form  method="POST" enctype="multipart/form-data">
          <input hidden name="postId" value="<?php echo $uidx; ?>">
          <!-- <input hidden name="hotelOrHouse" value="HOTEL"> -->
          <div class="form-group">
          <label for="exampleInputEmail1">Full Name</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="name" placeholder="Full Name" value="<?php echo $row['name'] ?>">
          </div>

        <div class="form-group">
          <label for="inputGroupSelect01">Gender</label>
        <select class="form-select" name="sex" id="inputGroupSelect01">
          <option selected value="<?php echo $row['sex'] ?>" ><?php echo $row['sex'] ?></option>
          <option value="Male">Mele</option>
          <option value="Female">Female</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Age</label>
          <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="age" placeholder="Full Name" value="<?php echo $row['age'] ?>">
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Religion</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="religion" placeholder="Full Name" value="<?php echo $row['religion'] ?>" >
        </div>

        <div  class="input-group mb-3" >
        <select  class="form-select" name="address" id="">
          <option><?php echo $row['address']; ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

        <div class="form-group">
          <label  for="inputGroupSelect01">Work Type</label>
        <select class="form-select" name="workType" id="inputGroupSelect01">
          <option selected ><?php echo $row['type'] ?></option>
          <option value="Half Day">Half Day</option>
          <option value="Full Day">Full Day</option>
          <option value="Monthly">Monthly</option>

        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Price:</label>
          <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="price" placeholder="Full Name" value="<?php echo $row['price'] ?>" >
          
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Experience</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="experience" placeholder="info"><?php echo $row['experience'] ?></textarea>
          
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Current Address</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="cAddress" placeholder="info"> <?php echo $row['currentAddress'] ?></textarea>
          
        </div>



        <div class="form-group">
        <h6>If you are an agent, then fill your discription</h6>
          <label for="exampleInputEmail1">Agent Info</label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="agentInfo" placeholder="location"> <?php echo $row['agentInfo'] ?></textarea>
          
        </div>

<br>
        <h5>Can You Provide Biding Person</h5>
        <p>Answer</p>
        <h5><?php echo $row['bidingPerson'] ?></h5>

        <h5>Change Answer</h5>

        <div class="form-check form-check-inline">
          <input class="form-check-input" required type="radio" name="bidp" id="inlineRadio1" value="YES">
          <label class="form-check-label" for="inlineRadio1">Yes</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" required type="radio" name="bidp" id="inlineRadio2" value="NO">
          <label class="form-check-label" for="inlineRadio2">No</label>
        </div><br>

        <input class="btn btn-dark" type="submit" onclick="x()" value="Save Changes">
        <div id="alertVacancy"></div>

          </form>

        
        <script>
// photo updater and deleter
           function pUpdate(divz, photo){
            $('#'+divz).empty()
            $.post('admin/editHandler.php', {photoPath: photo, tableName: "hotelhouse", pid: "<?php echo $uidx ?>"}, 
              function(returnedData){
                $('#'+divz).append(returnedData)        
            })
           }

         </script>
           <?php
           $i = 0;
           $pp = photoSplit($row['photoPath1']);
           if(!empty($row['photoPath1'])){
           foreach($pp as $photo){
             ?>
                  <div id="<?php echo $i ?>">
                  <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
                  <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
                  </div>
             <?php
             $i ++;
           }
          }else{
            ?>
                  <form method="POST" enctype="multipart/form-data" >
                  <input hidden name="pid" value="<?php echo $uidx; ?>">
                  <input hidden name="tName" value="hotelhouse">
                  <div class="row">
                  <div id="registerBox">
                  <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
                  <input type="file" class="form-control" id="photo" name="photo[]" multiple >
                  
                  </div>
                  </div>

                  <input type="submit" value="Change Photo">
                  </form>
            
            <?php
          }
           ?>


             </form>
    <?php
  }
}
////////////////////////////////////////////////
if(isset($_GET['type'])){
  if($_GET['type'] == 'zebegna'){

    $out = aSinglePostViewx($uidx, 'zebegna');
    $row = $out->fetch_assoc();
    ?>
    
    <form  method="POST" enctype="multipart/form-data">
          <input hidden name="postId" value="<?php echo $uidx; ?>">
          <div class="form-group">
          <label for="exampleInputEmail1">Full Name</label>
          <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="name" placeholder="Full Name" value="<?php echo $row['name'] ?>">
          
          </div>

        <div class="form-group">
          <label  for="inputGroupSelect01">Gender</label>
        <select class="form-select" name="sex" id="inputGroupSelect01">
          <option selected value="<?php echo $row['sex'] ?>" ><?php echo $row['sex'] ?></option>
          <option value="Male">Mele</option>
          <option value="Female">Female</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Age</label>
          <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="age" placeholder="Full Name" value="<?php echo $row['age'] ?>">
          
        </div>
        <div  class="form-group" >
        <label for="exampleInputEmail1">City:</label>

        <select  class="form-select" aria-label="Default select example" name="address" id="">
          <option><?php echo $lang['city'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

         <div class="form-group">
          <label  for="inputGroupSelect01"><?php echo $lang['workHour'] ?></label>
         <select class="form-select" name="workStat" id="inputGroupSelect01">
          <option selected value="<?php echo $row['workStat'] ?>" ><?php echo $row['workStat'] ?></option>
          <option value="Company">Company</option>
          <option value="Full Day">Private</option>
          <option value="House">House</option>
          <option value="Hotel">Hotel</option>
          <option value="Banks">Banks</option>

        </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Phone:</label>
          <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="phone" placeholder="Full Name" value="<?php echo $row['phone'] ?>">
          
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['Experience'] ?></label>
          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="experience" placeholder="<?php echo $lang['Experience'] ?>"> <?php echo $row['experience'] ?></textarea>
         </div>


         <div class="input-group mb-3">
         <label for="exampleInputEmail1"><?php echo $lang['workHour'] ?></label>
          <select class="form-select" aria-label="Default select example" name="workType" id="inputGroupSelect01">
            <option selected><?php echo $row['workHour'] ?></option>
            <option value="Half Day"><?php echo $lang['halfDay'] ?></option>
            <option value="Full Day"><?php echo $lang['fullDay'] ?></option>
            <option value="Monthly"><?php echo $lang['Monthly'] ?></option>

          </select>
 </div>

 <div class="form-group">
           <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="price" placeholder="<?php echo $lang['Salary'] ?>" value="<?php echo $row['salary'] ?>" >
         </div>


         <h6><?php echo $lang['bidingPersonQ'] ?></h6>


         <div class="form-group">
          <select class="form-select" name="bidp" id="inputGroupSelect01">
          <option selected value="<?php echo $row['bid'] ?>" ><?php echo $row['workStat'] ?></option>
          <option value="YES"><?php echo $lang['yes'] ?></option>
          <option value="NO"><?php echo $lang['no'] ?></option>
        </select>
        </div>


        <h6><?php echo $lang['weaponQ'] ?></h6>

        <div class="form-group">
          <select class="form-select" name="legalWp" id="inputGroupSelect01">
          <option selected  ><?php echo $row['weapon'] ?></option>
          <option value="YES"><?php echo $lang['yes'] ?></option>
          <option value="NO"><?php echo $lang['no'] ?></option>
        </select>
        </div>


        <div class="form-group">
        <h6 style="color: coral;" > <?php echo $lang['agentInfoQ'] ?></h6>

          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="agentInfo" placeholder="<?php echo $lang['agentInfo'] ?>" value="<?php echo $row['agentInfo'] ?> " ></textarea>
        </div>


 

        <input class="btn btn-dark" type="submit" onclick="x()" value="Save Changes!">
        </form>
        <div id="alertVacancy"></div>

        
        <script>
// photo updater and deleter
           function pUpdate(divz, photo){
            $('#'+divz).empty()
            $.post('admin/editHandler.php', {photoPath: photo, tableName: "zebegna", pid: "<?php echo $uidx ?>"}, 
              function(returnedData){
                $('#'+divz).append(returnedData)        
            })
           }

         </script>
           <?php
           $i = 0;
           $pp = photoSplit($row['photoPath1']);
           if(!empty($row['photoPath1'])){
           foreach($pp as $photo){
             ?>
                  <div id="<?php echo $i ?>">
                  <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
                  <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button>
                  </div>
             <?php
             $i ++;
           }
          }else{
            ?>
                  <form method="POST" enctype="multipart/form-data" >
                  <input hidden name="pid" value="<?php echo $uidx; ?>">
                  <input hidden name="tName" value="zebegna">
                  <div class="row">
                  <div id="registerBox">
                  <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
                  <input type="file" class="form-control" id="photo" name="photo[]" multiple >
                  
                  </div>
                  </div>

                  <input type="submit" value="Change Photo">
                  </form>
            
            <?php
          }
           ?>




          


        
          <div id="alertVacancy"></div>
       
    
    <?php
  }
}

///// real estate editing


include "../includes/header.php";
include "../includes/lang.php";


///// real estate posting
if(isset($_GET['type']) && $_GET['type'] == 'real'){

  $editFetch = allPostListerOn2Columen('realestate', 'selectKey', 'rs', 'id', $uidx);
  $reditFetch = $editFetch->fetch_assoc();
  ?>
  
  <!-- <script src="assets/jquery.js"  ></script> -->
<script>
  $(document).ready(function(){
  $('#cl').click(function(){
  location.reload();

  })

  $('sponser').on('submit', function(e){
     

    })

  })



// $(document).ready(function(){
//   $('#sponser').on('submit', function(){
//     alert('in the sponser ajax')

//     $.ajax({
//             url: './user/paymentPage.php?sub=true',
//             type: 'post',
//             data:  new FormData( this ),
//             success : function(data){
//               $( 'form' ).each(function(){
//                     this.reset();
//               });
//               $('#alertVacancy').text(data)
//               $('.modal-dialog').load(data)
//               // $('#alertVacancy').delay(5200).fadeOut(1000);
//               // location.reload()
//             },
//             processData: false,
//         contentType: false
//           })
//   })
// })

</script>

<div  class="modal-dialog">
  <div  id="contSp"  class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel"><?php echo $lang['upload'] ?></h5>
      <button id="cl"   type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"> </button>
    </div>
          <div class="modal-body">

          <form id="sponser"    method="POST" enctype="multipart/form-data">
          <input hidden name="postId" value="<?php echo $reditFetch['id'] ?>">
 


            <!-- for rent or sell  -->
            <div class="form-group">
          <label  for="inputGroupSelect01"> <?php echo $lang['sellOrRent'] ?>: </label>
        <select class="form-select" name="forRentOrSell" id="forRentOrSell">
          <option selected><?php echo $reditFetch['forRentOrSell'] ?></option>
          <option value="For Rent"> <?php echo $lang['forRent'] ?></option>
          <option value="For Sell"><?php echo $lang['forSell'] ?></option>
        </select>
        </div>



          <!-- title -->
          <div class="form-group">
           <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="title" value="<?php echo $reditFetch['title'] ?>">
          </div>

          <!-- company name -->
          <div class="form-group">
           <input type="text" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="company" value="<?php echo $reditFetch['company'] ?>">
          </div>


          <script>


  // sub city filter api
  function hCity(x){
    // alert(x)
    $.ajax({
        url: 'user/userApi.php',
        type: 'post',
        data: {
          cityH: x
        },
        success: function(data){
          // alert(data)
          $('#subH').empty()
          $('#subH').append(data)
        }
      })
  }
</script>



<script>
  $(document).ready(function(){
    $('#catRs').on('change', function(){
      if(this.value == "Industrial RS" || this.value == "Land For RS" || this.value == "Hotel and Lodging"){
        $('#rsFloor').hide()
      }else{
        $('#rsFloor').show()
      }
    })
  })
</script>

<!-- category  -->
<div  class="input-group mb-3">
 
 <select id="catRs" class="form-select" aria-label="Default select example" name="rsType" id="inputGroupSelect01">
   <option selected><?php echo $reditFetch['type'] ?></option>
   <option value="Commercial RS">Commercial RS</option>
   <option value="Hotel and Lodging">Hotel and Lodging</option>
   <option value="Industrial RS">Industrial RS</option>
   <option value="Land For RS">Land For RS</option>
   <option value="Mixed Use">Mixed Use</option>
   <option value="Office Space">Office Space</option>
   <option value="Residential Rs">Residential Rs</option>

 </select>
 </div> 



<!--  city list -->

<div  class="input-group mb-3" >
  <!-- <label><?php echo $lang['city'] ?></label> -->
        <select  class="form-select" aria-label="Default select example" name="city" onchange="hCity(this.value)" id="">
           <option><?php echo $reditFetch['address'] ?></option>
          <?php 
              require_once '../php/fetchApi.php';
                $locc= allPostListerOnColumenORDER('adcategory', 'tableName', 'CITY');
                $city = array();
                while($rowLoc = $locc->fetch_assoc()){
                    $city[]= $rowLoc['category'];
                }
                sort($city);
                $i = 0;
                foreach($city as $loc){
                  if($loc == 'Addis Ababa'){
                    ?>
                    <option selected ><?php echo $loc ?></option>
                    <?php
                  }else{
                    ?>
                     <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
                    <?php
                  }
                  ?>
                  
                
                  <?php
                  $i++;
                }
              ?> 
        </select>
        </div>

      
        <!-- // subcity and kebele only for realestate filter block -->


        <div id="subH"   class="input-group mb-3" >
          <?php
        require_once '../php/fetchApi.php';
    $locc= allPostListerOn2Columen('adcategory', 'tableName', 'SUBCITY', 'subcityKey', 'Addis Ababa');
    $city = array();
    if($locc->num_rows != 0){
      ?>
                <select  class="form-select" aria-label="Default select example" name="subCity" >
          <option><?php echo $reditFetch['subCity'] ?></option>
      <?php
    while($rowLoc = $locc->fetch_assoc()){
        $city[]= $rowLoc['category'];
    }
    sort($city);
    $i = 0;
    foreach($city as $loc){
      if($loc == 'Addis Ababa'){
        ?>
        <option selected ><?php echo $loc ?></option>
        <?php
      }else{
        ?>
         <option value="<?php echo $loc ?>" ><?php echo $loc ?></option>
        <?php
      }
      ?>
      
    
      
      <?php
      $i++;
    }
  }
    ?>
    </select>
        </div>

         
      <!-- kebele list -->
      <div class="form-group">
        <select class="form-select" aria-label="Default select example" name="wereda"  id="inputGroupSelect01">
          <option ><?php echo $reditFetch['wereda'] ?></option>
          <?php 
             for($y=1;$y<=30;$y++){
               if($y <= 9 ){
                 $pre = 0;
                 ?>
                 <option value="<?php echo $pre.$y ?>"><?php echo '0'.$y ?></option>
                 <?php
               }else{
                ?>
                <option value="<?php echo $y ?>"><?php echo $y ?></option>
                <?php
               }

            }
          ?>
          

        </select>
        </div>

            <!-- area  -->
            <div class="form-group">
              <label for="exampleInputEmail1"><?php echo $lang['Area'] ?> : </label>
              <input type="number" class="form-control" id="nameTitle" 
              aria-describedby="emailHelp" name="area" value="<?php echo $reditFetch['area'] ?>">
            </div>


            <!-- floor  -->
      <div id="rsFloor" class="form-group">
        <select class="form-select" aria-label="Default select example" name="floor"  id="inputGroupSelect01">
          <option ><?php echo $reditFetch['floor'] ?></option>
          <option value="G"> Ground </option>
          <option value="1"> 1 <sup>st</sup> </option>
          <option value="2"> 2 <sup>nd</sup> </option>
          <option value="3"> 3 <sup>rd</sup> </option>
          <?php 
             for($y=4;$y<=20;$y++){
                ?>
                <option value="<?php echo $y ?>"><?php echo $y ?> <sup>th</sup></option>
                <?php
            

            }
          ?>
          

        </select>
        </div>

     




        <!-- phone number  -->
        <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $lang['phone'] ?> : </label>
           <input type="number" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="phone" placeholder=" " value="<?php echo $reditFetch['phone'] ?>">
        </div>

        <!-- email  -->
        <div class="form-group">
          <label for="exampleInputEmail1"><?php echo $lang['email'] ?></label>
           <input type="email" class="form-control" id="nameTitle" 
          aria-describedby="emailHelp" name="email" value="<?php echo $reditFetch['email'] ?>">
        </div>


                
<!-- price  -->
<div class="form-group">
  <label for="exampleInputEmail1"><?php echo $lang['labelPrice'] ?> :</label>
  <input type="number" class="form-control" id="nameTitle" 
  aria-describedby="emailHelp" name="price" value="<?php echo $reditFetch['price'] ?>">
</div>




<!-- price type  -->
<div class="input-group mb-3">

<select class="form-select" aria-label="Default select example" name="fixidOrN" id="inputGroupSelect01">
  <option selected> <?php echo $reditFetch['priceType'] ?></option>
  <option value="Fixed"><?php echo $lang['Fixed'] ?></option>
  <option value="Negotiatable"><?php echo $lang['Negotiatable'] ?></option>
  <option value="Negotiatable"><?php echo $lang['slightlyNegotiable'] ?></option>
</select>
</div>
        

 

        <div class="form-group">
        <h6 style="color: coral;" > <?php echo $lang['Description'] ?></h6>

          <textarea type="text" class="form-control" id="des2" 
          aria-describedby="emailHelp" name="info" placeholder="<?php echo $lang['Descriptionmore'] ?>"><?php echo $reditFetch['info'] ?></textarea>
        </div>


        <input class="btn btn-dark" type="submit" value="Save Changes!">
        </form>
<script>

function pUpdate(divz, photo){
 $('#'+divz).empty()
 $.post('admin/editHandler.php', {photoPath: photo, tableName: "realestate", pid: "<?php echo $reditFetch['id'] ?>"}, 
   function(returnedData){
     $('#'+divz).append(returnedData)        
 })
}

</script>
<?php
$i = 0;
$pp = photoSplit($reditFetch['photoPath1']);
if(!empty($reditFetch['photoPath1'])){
foreach($pp as $photo){
  ?>
       <div id="<?php echo $i ?>">
       <img class="img-thumbnail" src="<?php  echo $photo ;?>" alt="Card">  
       <button type="button" onclick="pUpdate('<?php echo $i ?>', '<?php echo $photo ?>')" class="btn btn-dark"><?php echo $lang['deletePhoto'] ?></button> 
       </div>
  <?php
  $i ++;
}
}else{
 ?>
       <form method="POST" enctype="multipart/form-data" >
       <input hidden name="pid" value="<?php echo $uidx; ?>">
       <input hidden name="tName" value="realestate">
       <div class="row">
       <div id="registerBox">
       <label for="exampleInputEmail1"><?php echo $lang['up'] ?>  </label>
       <input type="file" class="form-control" id="photo" name="photo[]" multiple >
       </div>
       </div>

       <input type="submit" value="Change Photo">
       </form>
 
 <?php
}
?>





          


         
          <div id="alertVacancy"></div>
         

          <!-- </div> -->
      <!-- </div> -->
      <!-- /.modal-content -->
            <!-- /// to select address like jiji style -->
            <div id="z"  class="modal-dialog" style="position: absolute; top: 3%; width: 100%;" ></div>
  </div><!-- /.modal-dialog -->
      
  
  
  <?php
}
?>

 


    </div>
    </div>
</main><!-- End #main -->
