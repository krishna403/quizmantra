
 <?php

      error_reporting(0);
      session_start();
      include_once 'oesdb.php';
      include('header.php');
  ?>



       <fieldset class='loginwall'>
           
           <div class="menubar" style="padding-left: 50%;">
                             <table id="menu"><tr>
                                        <?php if(isset($_SESSION['stdname'])){
                                              header('Location: stdwelcome.php');
                                          }

                                        else{    
                                         ?>
                                               <td><div class="aclass"><a href="home.php" title="Back To Home"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Home</button></a></div></td>
                                              <td><div class="aclass"><a href="register.php" title="Click here  to Register"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Register</button></a></div></td>
                                              <td><a href="rating.php" name="logout"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Rate US</button></a></td> 
                                              <td> <a href="contact.php" name="datahistory"><button id="contactbutt" style="color: #36AE79;height: 40px;width: 180px">Contact US</button></a></td>

                                        <?php
                                              }
                                        ?>
                              </table>
                          </div>
           
        
           
           
       <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">LOGIN </b></font> </legend>

           
    <?php
      if(isset($_REQUEST['register'])){
          header('Location: register.php');
      }
      
      
      else if($_REQUEST['stdsubmit']){
          
          if(strcmp("root",(htmlspecialchars($_REQUEST['name'],ENT_QUOTES)))==0){   
                   if(strcmp("root",(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0){  
                       
                   $_SESSION['admname']=htmlspecialchars($_REQUEST['name'],ENT_QUOTES);
                   unset($_GLOBALS['message']);    
                   header('Location: admin/admwelcome.php');
               }
          }
          
      else{ 
          
         $result=executeQuery("select *,stdpassword as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."' ");
           if(mysql_num_rows($result)>0){

              $r=mysql_fetch_array($result);
             
              
             if(strcmp(htmlspecialchars($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0){

                    $_SESSION['stdname']=htmlspecialchars($r['stdname'],ENT_QUOTES);
                    $_SESSION['stdid']=$r['stdid'];
                  
                        if($r['tc']==1){

                          $_SESSION['tcname']=htmlspecialchars($r['stdname'],ENT_QUOTES);
                          $_SESSION['tcid']=$r['stdid'];
                        }
                  
                  unset($_GLOBALS['message']);
                  header('Location: stdwelcome.php');
              }
              
              else{
                  $_GLOBALS['message']="Check Your user name and Password.";
             }
          }
          
          else {
              $_GLOBALS['message']="Check Your user name and Password.";
            }
            
          closedb();
      }
      }

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html>
        <head>
          <title>Sign In</title>
          <link rel="stylesheet" type="text/css" href="sc.css"/>
        </head>

    
            <body id="register">
                <?php

                  if($_GLOBALS['message']){
                   echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                  }
                ?>

                   
              <div id="container">
               <form id="stdloginform" action="index.php" method="post">
                   
                          <div class="page">

                             <table cellpadding="10" cellspacing="10">
                                        
                                 <tr>  
                                     <td rowspan="4" style="padding-right:600px; padding-left: 40px;">
                                        <img src="images/whiteboard.jpg" alt="Molecule Wallpaper" width="600" height="430" />

                                               </td>
                                      </tr>
                                    <tr>
                                        <td>User Name</td>
                                        <td><input type="text" tabindex="1" name="name" value="" size="30" /></td>

                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td><input type="password" tabindex="2" name="password" value="" size="30" /></td>
                                    </tr>

                                    <tr>
                                        <td style="padding-bottom: 200px; padding-right: 8%;" colspan="2">
                                            <input type="submit" tabindex="3" value="Log In" name="stdsubmit" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" />
                                        </td><td></td>
                                    </tr>
                                 </table>
                           </div>
                  </form>

               </div>
          </body>
     </fieldset>
  </fieldset>
                              
 <?php
    include("loginfooter.html");
