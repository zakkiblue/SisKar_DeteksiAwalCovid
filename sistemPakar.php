<?php 

//-- database configurations
$dbhost='localhost';
$dbuser='root';
$dbpass='';
$dbname='db_expert_covid';
//-- database connections
$db=new mysqli($dbhost,$dbuser,$dbpass,$dbname);
//-- halt and show error message if connection fail
if ($db->connect_error) {
    die('Connect Error ('.$db->connect_errno.')'.$db->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>covid</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <!-- owl stylesheets -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>

<body>
    <!--header section start -->
    <div class="header_section header_bg">
         <div class="container-fluid">
               <div class="main">
                  <div class="logo"><a href="index.html"><img src="images/logo.png"></a></div>
                  <div class="menu_text">
                     <ul>
                        <div class="togle_">
                           <div class="menu_main">
                              <ul>
                                 <li><a href="#">Login</a></li>
                                 <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                              </ul>
                           </div>
                        </div>
                        <div id="myNav" class="overlay">
                           <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                           <div class="overlay-content">
                              <a href="index.html">Home</a>
                              <a href="protect.html">Protect</a>
                              <a href="about.html">About</a>
                              <a href="doctors.html">Doctors</a>
                              <a href="news.html">News</a>
                           </div>
                        </div>
                        <span class="navbar-toggler-icon"></span>
                        <span onclick="openNav()"><img src="images/toogle-icon.png" class="toggle_menu"></span>
                        <span onclick="openNav()"><img src="images/toogle-icon1.png" class="toggle_menu_1"></span>
                     </ul>
                  </div>
               </div>
            </div>
            <!-- banner section start -->
            <div class="container">
               <div class="about_taital_main">
                  <h2 class="about_tag">Test Dini Covid-19</h2>
                  <div class="about_menu">
                     <ul>
                        <li><a href="index.html">Home</a></li>
                        <li>About</li>
                     </ul>
                  </div>
               </div>
            </div>
         <!-- banner section end -->
      </div>
      <!-- header section end -->
<div class="container ">
    <h3>Isi form berikut</h3>
<form method="post" class="mt-5 mb-5">
<!-- menampilkan daftar gejala-->
<?php
$sqli="SELECT * FROM ds_evidences";
$result=$db->query($sqli);
while($row=$result->fetch_object()){
    echo "<input type='checkbox' name='evidence[]' value='{$row->id}'"
         .(isset($_POST['evidence'])?(in_array($row->id,$_POST['evidence'])?" checked":""):"")
        ."> {$row->code} {$row->name}<br>";
}
?>
<input type="submit" value="proses">
</form>
<pre>
<?php
    //-- Mengambil Nilai Belief Gejala Yang dipilih
if(isset($_POST['evidence'])){
    if(count($_POST['evidence'])<2){
        echo "Pilih minimal 2 gejala";
    }else{
        $sql = "SELECT GROUP_CONCAT(b.code), a.cf
            FROM ds_rules a
            JOIN ds_problems b ON a.id_problem=b.id
            WHERE a.id_evidence IN(".implode(',',$_POST['evidence']).") 
            GROUP BY a.id_evidence";
        $result=$db->query($sql);
        $evidence=array();
        while($row=$result->fetch_row()){
            $evidence[]=$row;
        }
        //--- menentukan environement
        $sql="SELECT GROUP_CONCAT(code) FROM ds_problems";
        $result=$db->query($sql);
        $row=$result->fetch_row();
        $fod=$row[0];
        
        //--- menentukan nilai densitas
        echo "== MENENTUKAN NILAI DENSITAS ==\n";
        $densitas_baru=array();
        while(!empty($evidence)){
            $densitas1[0]=array_shift($evidence);
            $densitas1[1]=array($fod,1-$densitas1[0][1]);
            $densitas2=array();
            if(empty($densitas_baru)){
                $densitas2[0]=array_shift($evidence);
            }else{
                foreach($densitas_baru as $k=>$r){
                    if($k!="&theta;"){
                        $densitas2[]=array($k,$r);
                    }
                }
            }
            $theta=1;
            foreach($densitas2 as $d) $theta-=$d[1];
            $densitas2[]=array($fod,$theta);
            $m=count($densitas2);
            $densitas_baru=array();
            for($y=0;$y<$m;$y++){
                for($x=0;$x<2;$x++){
                    if(!($y==$m-1 && $x==1)){
                        $v=explode(',',$densitas1[$x][0]);
                        $w=explode(',',$densitas2[$y][0]);
                        sort($v);
                        sort($w);
                        $vw=array_intersect($v,$w);
                        if(empty($vw)){
                            $k="&theta;";
                        }else{
                            $k=implode(',',$vw);
                        }
                        if(!isset($densitas_baru[$k])){
                            $densitas_baru[$k]=$densitas1[$x][1]*$densitas2[$y][1];
                        }else{
                            $densitas_baru[$k]+=$densitas1[$x][1]*$densitas2[$y][1];
                        }
                    }
                }
            }
            foreach($densitas_baru as $k=>$d){
                if($k!="&theta;"){
                    $densitas_baru[$k]=$d/(1-(isset($densitas_baru["&theta;"])?$densitas_baru["&theta;"]:0));
                }
            }
            print_r($densitas_baru);
        }
        
        //--- perangkingan
        echo "== PERANGKINGAN ==\n";
        unset($densitas_baru["&theta;"]);
        arsort($densitas_baru);
        print_r($densitas_baru);
        
        //--- menampilkan hasil akhir
        echo "<div>== HASIL AKHIR ==</div>\n";
        $codes=array_keys($densitas_baru); 
        $final_codes=explode(',',$codes[0]);
        $sql="SELECT GROUP_CONCAT(name)  
        FROM ds_problems  
        WHERE code IN('".implode("','",$final_codes)."')"; 
        $result=$db->query($sql); 
        $row=$result->fetch_row(); 
        echo "Terdeteksi penyakit <b>{$row[0]}</b> dengan derajat kepercayaan ".round($densitas_baru[$codes[0]]*100,2)."%"; 
    }
}
?>
</div>
<!-- footer section start -->
<div class="footer_section layout_padding">
         <div class="container">
            <div class="footer_section_2">
               <div class="row">
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">Resources</h2>
                     <div class="footer_menu">
                        <ul>
                           <li><a href="#">What we do</a></li>
                           <li><a href="#">Media</a></li>
                           <li><a href="#">Travel Advice</a></li>
                           <li><a href="#">Protection</a></li>
                           <li><a href="#">Care</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">About</h2>
                     <p class="footer_text">Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various</p>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">Contact Us</h2>
                     <div class="location_text">
                        <ul>
                           <li>
                              <a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>
                              <span class="padding_15">Location</span></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>
                              <span class="padding_15">Call +01 1234567890</span></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>
                              <span class="padding_15">demo@gmail.com</span></a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h2 class="useful_text">countrys</h2>
                     <div class="map_image"><img src="images/map-bg.png"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <p class="copyright_text">© 2020 All Rights Reserved.<a href="https://html.design"> Free  html Templates</a></p>
               </div>
            </div>
         </div>
      </div>
      <!-- copyright section end -->
<!-- Javascript files-->
<script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
      <script>
         $(document).ready(function(){
         $(".fancybox").fancybox({
         openEffect: "none",
         closeEffect: "none"
         });
              
         $(".zoom").hover(function(){
              
         $(this).addClass('transition');
         }, function(){
              
         $(this).removeClass('transition');
         });
         });
      </script> 
      <script>
         function openNav() {
         document.getElementById("myNav").style.width = "100%";
         }
         function closeNav() {
         document.getElementById("myNav").style.width = "0%";
         }
      </script>  
</body>
</html>