<?php
ob_start();
session_start();

require_once "../php/adminCrude.php";







if(isset($_POST['titleElc'],
    $_POST['type'],
    $_POST['status'],
    $_POST['price'],
    $_POST['address'],
    $_POST['info'],
    $_FILES['photo'],
    $_POST['posterId'],
    $_POST['phone']
)){

    $title = $_POST['titleElc'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $info = $_POST['info'];
    $posterId = $_POST['posterId'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $size = " ";
    $processor = " ";
    $storage = " ";
    $core = " ";
    $ram = " ";



    $fName1 = $_FILES['photo'];


    if(isset($_POST['size'], $_POST['processor'], $_POST['core'], $_POST['storage'], $_POST['ram'])){
        $size = $_POST['size'];
        $processor = $_POST['processor'];
        $storage = $_POST['storage'];
        $core = $_POST['core'];
        $ram = $_POST['ram'];
    }
    
    // $photo = electronicsPhotoUploader($fName1, $fName2, $fName3, $tmpName1, $tmpName2, $tmpName3);

    $up = uploadPhotos('car', $fName1);

    if($up[4] == 'error'){
      echo $up[0];
    }else{
      $out = elecPostAdder($type, $status, $posterId, $title, $address, $price,
      $info, $up[0], $ram, $processor, $size, $storage, $core, $phone);
            
      if($out){
        echo 'Post Succesfully!';
      }else{
        echo 'error';
      }
    }




}

// vacancy post handler block
if(isset(
    $_POST['companyName'], $_POST['jobType'], 
    $_POST['jobTitle'], $_POST['positionType'],
    $_POST['Deadline'], $_POST['reqNo'], $_POST['location'], $_POST['appStart'],
    $_POST['description'],$_POST['uid'], $_POST['sex'], $_POST['phone'], $_POST['salary'], $_POST['salaryStatus']
  )){
    $companyName = $_POST['companyName'];
    $jobType =$_POST['jobType'];
    $jobTitle=$_POST['jobTitle'];
    $positionType=$_POST['positionType'];
    $Deadline=$_POST['Deadline'];
    $reqNo=$_POST['reqNo'];
    $location=$_POST['location'];
    $info=$_POST['description']; 
    $id = $_POST['uid'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $salaryStatus= $_POST['salaryStatus'];
    $appStart = $_POST['appStart'];

    $ask = addVacancyPost($appStart,$salaryStatus, $salary, $phone, $jobType, $positionType, $companyName, $jobTitle, $location, $Deadline, $id , $reqNo, $info, $sex  );
    if($ask){
      echo 'Post Successfull.!';
    }else{
      echo 'Error Posting';
    }
  }

  //tender post data handler block
  elseif(isset($_POST['tenderType'],
   $_POST['startDate'],
    $_POST['Deadline2'],
     $_POST['initialCost'],
     $_POST['location2'],
     $_POST['description2'],$_POST['uid'], $_POST['title'], $_POST['phone']
     )
     ){

      $up = array('');

      $tenderType = $_POST['tenderType'];
      $startingDate = $_POST['startDate'];
      $deadLine=$_POST['Deadline2'];
      $location=$_POST['location2'];
      $initialCost=$_POST['initialCost'];
      $info = $_POST['description2'];
      $id2 = $_POST['uid'];
      $title = $_POST['title'];
      $phone = $_POST['phone'];

      if (isset($_FILES['photo']) && $_FILES['photo']['size'] != 0 ){
        $fileName1 = $_FILES['photo'];

        $up = uploadSinglePhoto('tender', $fileName1);
        if($up[4] == 'error'){
          print_r($up);
        }else{
          $db = addTenderPost($tenderType, $startingDate, $deadLine, $location, $initialCost, $info, $id2, $title, $up[0], $phone   );
          if($db){
            echo 'Post Succesfullypho!';
          }else{
            echo 'error';
          }
        }
      }else{
        $db = addTenderPost($tenderType, $startingDate, $deadLine, $location, $initialCost, $info, $id2, $title, ' ', $phone  );
        if($db){
          echo 'Post Succesfully!';
        }else{
          echo 'error';
        }
      }





     }


    //car post handler
    if(isset($_POST['type2'],$_POST['status2'],$_POST['forRentOrSell'],$_POST['fuleKind'],$_POST['fixidOrN'],$_POST['price2'],$_POST['info2'],$_POST['posterId2'],
      $_FILES['photo'], $_POST['title'], $_POST['address'],$_POST['rentStatus'], $_POST['forWho'], $_POST['whyRent'],
       $_POST['transmission'], $_POST['bodyStatus'], $_POST['km'], $_POST['ownerBroker'])){
      // echo 'inx';
      $title = $_POST['title'];
      $type = $_POST['type2'];
      $status = $_POST['status2'];
      $forRentOrSell= $_POST['forRentOrSell'];
      $fixidOrN= $_POST['fixidOrN'];
      $fuleKind = $_POST['fuleKind'];
      $price = $_POST['price2'];
      $info = $_POST['info2'];
      $addr = $_POST['address'];
      if($_POST['rentStatus'] != ' ' && $_POST['forWho'] != ' ' && $_POST['whyRent'] != ' '){
        $rentStatus = $_POST['rentStatus'];
        $forWho = $_POST['forWho'];
        $whyRent = $_POST['whyRent'];
      }
      else{
        $rentStatus = ' ';
        $forWho = ' ';
        $whyRent = ' ';
  
      }




      $transmission = $_POST['transmission'];
      $bodyStatus = $_POST['bodyStatus'];
      $km = $_POST['km'];
      $ob = $_POST['ownerBroker'];

      $posterId = $_POST['posterId2'];
      $fName1 = $_FILES['photo'];

      $up = uploadPhotos('car', $fName1);

      if($up[4] == 'error'){
        echo $up[0];
      }else{
        $out12 = carPostAdder($addr,$title,$type, $status,
        $fuleKind, $posterId, $fixidOrN, $up[0],$price,$info,$forRentOrSell, $transmission, $bodyStatus, $km, $ob, $forWho, $rentStatus, $whyRent );
        
        if($out12){
          echo 'Post Succesfully!';
        }else{
          echo 'error';
        }
      }



      // $carPhoto = carPhotoUploader($fName1, $fName2, $fName3, $tmpName1, $tmpName2, $tmpName3 );


    }


     //ad post handler block
     if(isset($_POST['type'], $_POST['price'], $_POST['address'], $_POST['phone'], $_POST['title'],
     $_POST['posterId'], $_POST['info'], $_FILES['photo'], $_POST['shipping'], $_POST['big'])){
      $for = " ";
      if(isset($_POST['for'])){
        $for = $_POST['for'];
      }
      $ship = $_POST['shipping'];
      $type = $_POST['type'];
      $price = $_POST['price'];
      $address =  $_POST['address'];
      $phone = $_POST['phone'];
      $title = $_POST['title'];
      $posterId = $_POST['posterId'];
      $info = $_POST['info'];
      $fName1 = $_FILES['photo'];
      $big = $_POST['big'];




      // $adOut = adPhotoUploader($fName1, $fName2, $fName3, $tmpName1, $tmpName2, $tmpName3  );
      $up = uploadPhotos('ad', $fName1);

      if($up[4] == 'error'){
        echo $up[0];
      }else{
        $out7 = adPostPoster($big, $type, $price, $address, $phone, $for, $title, $posterId, $info, $up[0], $ship);
        echo 'Post Succesfully!';
      }



    
    }

    //house or land post data inserter
    if(isset(
      $_POST['houseOrLand'], $_POST['city'],$_POST['subCity'], $_POST['wereda'],
       $_POST['forRentOrSell'], $_POST['area'], $_POST['cost'], $_POST['fixidOrN'], 
       $_POST['info'], $_FILES['photo'],$_POST['posterId'],
        $_POST['title'], $_POST['ownerBroker']
    )){
      echo 'inn house';

      // these variables will not be set if user choose house so initial value will be empty
      $bedRoomNo = 0;
      $bathRoomNo = 0;
      $type = " ";
      $spArea = " ";
      
      if(isset(
        $_POST['bedRoomNo'],
        $_POST['bathRoomNo'],
        $_POST['type'],
        $_POST['spArea']
      )){
        $bedRoomNo = $_POST['bedRoomNo'];
        $bathRoomNo = $_POST['bathRoomNo'];
        $type = $_POST['type'];
        $spArea = $_POST['spArea'];
      }
      $title = $_POST['title'];
      $houseOrLand =$_POST['houseOrLand'];
      $city =$_POST['city'];
      $subCity=$_POST['subCity'];
      $wereda= $_POST['wereda'];
      $forRentOrSell=$_POST['forRentOrSell'];
      $area=$_POST['area'];
      $price=$_POST['cost'];
      $fixidOrN=$_POST['fixidOrN'];
      $info=$_POST['info'];
      $posterId = $_POST['posterId'];
      $fName1 = $_FILES['photo'];

      $ob = $_POST['ownerBroker'];

      $up = uploadPhotos('housesell', $fName1);

      if($up[4] == 'error'){
        echo $up[0];
      }else{
        $outH = addHouseOrLandPost($title, $type, $houseOrLand, $city, $subCity, $wereda,
        $forRentOrSell, $area, $bedRoomNo, $bathRoomNo, $price, $fixidOrN, $info,
         $posterId, $up[0], $ob, $spArea );
        
         if($outH){
          echo 'Post Succesfully!';
         }else{
          echo 'error';
         }
      }
      
      // $houseUpload = houseOrLandPhotoUploader($fName1, $fName2, $fName3, $tmpName1, $tmpName2, $tmpName3);
      

      

    }

/////////////////////////////////////////////
            //charity api

            if(isset($_POST['title'], $_POST['address'], $_POST['phone'], $_POST['info'], $_FILES['photo'], $_POST['posterId'])){
              require_once "../php/adminCrude.php";
              // echo 'inzzdfa';
              $title = $_POST['title'];
              $loc = $_POST['address'];
              $phone = $_POST['phone'];
              $info = $_POST['info'];
              $fileVar = $_FILES['photo'];
              $pid = $_POST['posterId'];
    
              $up = uploadPhotos('charity', $fileVar);
              // echo $up[4];
    
    
              $db = charityUpload($title, $up[0], $info, $loc, $phone, $pid);
              if($db){
                echo 'Post Successfull';
              }else{
                echo 'Posting Error';
              }
    
            }

///////////////////////////////////////////////////
// home tutor insert api
if(isset(
  $_POST['name'], $_POST['sex'], 
  $_POST['eduBackground'], $_POST['clientRange'],
  $_POST['paymentStatus'],  $_POST['price'],
  $_POST['address'],  $_POST['companyInfo'],
  $_POST['info'], $_POST['phone'], $_POST['posterId'], $_FILES['photo']
)){

$pid = $_POST['posterId'];
$name =$_POST['name'];
$sex =  $_POST['sex'];
$edu = $_POST['eduBackground'];
$range = $_POST['clientRange'];
$payStatus = $_POST['paymentStatus'];
$price =  $_POST['price'];
$address = $_POST['address'];
$cinfo = $_POST['companyInfo'];
$info = $_POST['info'];
$phone = $_POST['phone'];

$fileVar = $_FILES['photo'];

$o = uploadSinglePhoto('jobhometutor', $fileVar);

if($o[4] == 'error'){
  echo 'error uploading photo';
}else{
  $out = homeTutoreAdder($pid, $name, $sex, $edu, $range, $payStatus, $price, $address,
$phone, $cinfo, $info, $o[0]);
if($out){
  echo 'Post Successfull';
}else{
  echo 'ERROR';
}

}




}

////////////////////////////////////////////////////
//house keeper and hotel api
if(isset(
  $_POST['name'], $_POST['sex'], 
  $_POST['age'],
  $_POST['address'],$_POST['workType'],
  $_POST['price'], 
  $_POST['experience'], $_POST['cAddress'],
  $_POST['bidp'], $_POST['agentInfo'],
   $_FILES['photo'], $_POST['posterId'],$_POST['hotelOrHouse']
)){

$hotelOrHouse = $_POST['hotelOrHouse'];
$pid = $_POST['posterId'];
$name =$_POST['name'];
$sex =  $_POST['sex'];
$price =  $_POST['price'];
$experience = $_POST['experience'];
$bid = $_POST['bidp'];
$address = $_POST['address'];
$age =  $_POST['age'];
$cAddress = $_POST['cAddress'];
$wType = $_POST['workType'];
$agentInfo = $_POST['agentInfo'];
$fileVar = $_FILES['photo'];

$religion = " ";
$field = " ";

if(isset($_POST['religion'])){
  $religion = $_POST['religion'];
}
if(isset( $_POST['field'])){
  $field =  $_POST['field'] ;
}

$up = uploadSinglePhoto('hotelHouse', $fileVar);
if($up[4] == 'error'){
  echo "error";
}else{
  $out = hotelHouseDataAdder($hotelOrHouse,$name, $sex, $age, $religion, $field, $address, $wType,
  $price, $experience, $bid, $cAddress, $agentInfo, $up[0], $pid);
  if($out){
    echo 'Post Successfull';
  }else{
    echo 'ERROR';
  }
  
}




}

///////////////////////////////////////////
//zebegna post adder handler api
if(isset(
  $_POST['name'], $_POST['sex'], $_POST['age'],
   $_POST['address'], $_POST['workStat'], $_POST['phone'], $_FILES['photo'], $_POST['posterId'], $_POST['experience'], $_POST['workType'], $_POST['bidp'], $_POST['legalWp'], $_POST['agentInfo'], $_POST['price']
)){

  $name =$_POST['name'];
  $sex=$_POST['sex'];
  $age=$_POST['age'];
  $address=$_POST['address'];
  $phone=$_POST['phone'];
  $fileVar = $_FILES['photo'];
  $pid = $_POST['posterId'];
  $workStat=$_POST['workStat'];
  $exp = $_POST['experience'];
  $workType = $_POST['workType'];
  $bidp = $_POST['bidp'];
  $legalWp = $_POST['legalWp'];
  $agentInfo = $_POST['agentInfo'];
  $salary = $_POST['price'];
  
  $up = uploadSinglePhoto('zebegna', $fileVar);

  if($up[4] == 'error'){
    echo 'error file';
    print_r($up);
  }else{

    $out = zebegnaPostAdder($name, $sex, $age, $address, $phone, $up[0], $workStat, $pid, $agentInfo, $legalWp, $bidp, $workType, $exp, $salary );
    if($out){
      echo 'Post Success'; 
    }else{
      echo 'Error on posting';
    }

  }

}


//////////////////blog 

if(isset($_POST['frontLabel'], $_POST['title'], $_POST['content'], $_FILES['photo'], $_POST['posterId'])){
  $frontLabel = $_POST['frontLabel'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $fileVar = $_FILES['photo'];
  $posterId = $_POST['posterId']; 

  $content = addslashes($content);

  $up = uploadPhotos('blog', $fileVar);
  if($up[4] == 'error'){
    foreach($up as $val){
      echo $val;
    }
  }elseif($up[4] == 'work'){
    $enter = blogAdder($title, $frontLabel, $content, $posterId, $up[0]);
    if($enter){
      echo 'Posted Successfully.';
    }else{
      echo 'Error';
    }
  }

  


}


// echo 'apid in the api';
/////////////real estate posting api
if(isset($_POST['posterId'], $_POST['title'], $_POST['company'], $_POST['phone'], $_POST['email'], $_POST['price'], $_POST['fixidOrN'], $_POST['info'], $_FILES['photo'], $_POST['selectKey'],$_POST['city'])){


  $selectKey = $_POST['selectKey'];
  $posterId = $_POST['posterId'];
  $title = $_POST['title'];
 $company = $_POST['company'];
 $phonem = $_POST['phone'];
$email = $_POST['email'];
$price = $_POST['price'];
$fixidOrN = $_POST['fixidOrN'];
$info = $_POST['info'];
$fileVar = $_FILES['photo'];
$city = $_POST['city'];


  if(isset($_POST['forRentOrSell'], $_POST['wereda'], $_POST['floor'] , $_POST['area'])){
    echo 'realz';
    $forRentOrSell = $_POST['forRentOrSell'];
    $rsType= $_POST['rsType'];
   

    //so that there are cities which doesnot have subcity
    if(isset($_POST['subCity'])){
      $subCity = $_POST['subCity'];
    }
   
    $wereda = $_POST['wereda'];
    $floor = $_POST['floor'];
    $area = $_POST['area'];
  }else{
    echo 'else rel';
      // null data entery if real estate is not selected
  $forRentOrSell = " ";
  $rsType = " ";

  $subCity = " ";
  $wereda = 0;
  $floor = 0;
  $area = 0;
  }


  
  $up = uploadPhotos('realestate', $fileVar);
  if($up[4] == 'error'){
    foreach($up as $val){
      echo $val;
    }
  }elseif($up[4] == 'work'){
    $enter = realEstate($posterId,$rsType, $title, $company, $phonem, $city, $wereda, $floor, $forRentOrSell, $subCity, $area  , $email, $price, $fixidOrN, $info, $up[0], $selectKey);
    if($enter){
      echo 'Posted Successfully.';
    }else{
      echo 'Error';
    }
  }

}


?>