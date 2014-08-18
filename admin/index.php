  

 <?php /*

      error_reporting(0);
      session_start();
      include_once '../oesdb.php';
       include('../header.php');
      
   ?>
       
      <fieldset class='loginwall'>
               <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">LOGIN ADMIN </b></font> </legend>              
                   
                   
   <?php                
      
      if(isset($_REQUEST['admsubmit']))
      {
          
          $result=executeQuery("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and admpassword='".md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES))."'");
        
         // $result=mysql_query("select * from adminlogin where admname='".htmlspecialchars($_REQUEST['name'])."' and admpassword='".md5(htmlspecialchars($_REQUEST['password']))."'");
          if(mysql_num_rows($result)>0)
          {
              
              $r=mysql_fetch_array($result);
              if(strcmp($r['admpassword'],md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0)
              {
                  $_SESSION['admname']=htmlspecialchars_decode($r['admname'],ENT_QUOTES);
                  unset($_GLOBALS['message']);
                  header('Location: admwelcome.php');
              }
              
              else{
                 $_GLOBALS['message']="Check Your user name and Password."; 
              }
         }
         
          else{
              $_GLOBALS['message']="Check Your user name and Password.";   
           }
           
          closedb();
      }
      
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html>
        <head>
          <title>Administrator Login</title>
          <link rel="stylesheet" type="text/css" href="sc.css"/>
        </head>
        
             <body id="register">

                <?php

                  if(isset($_GLOBALS['message']))
                  {
                   echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
                  }
                ?>
                 
        <div id="container">
      
            <div class="page">
                 <form id="indexform" action="index.php" method="post">


                            <table cellpadding="10" cellspacing="10">

                              <tr>  
                                <td rowspan="5" style="padding-right:600px; padding-left: 40px;">
                                  <img src="images/whiteboard.jpg" alt="Molecule Wallpaper" width="600" height="430" />
                                </td>
                              </tr>
                                

                                <tr>
                                    <td>Admin Name</td>
                                    <td><input type="text" name="name" value="" size="30" /></td>

                                </tr>
                                
                                <tr>
                                    <td> Password</td>
                                    <td><input type="password" name="password" value="" size="30" /></td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input type="submit" value="Log In" name="admsubmit" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" />
                                    </td>
                                </tr>
                                
                            </table>
                     </form>
               </div>

     
           </div>    
       </body>
     </fieldset>
   </fieldset>

    <?php
          include("../loginfooter.html");
*/