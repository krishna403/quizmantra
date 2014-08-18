
  <?php/*

      error_reporting(0);
      session_start();
      include_once '../oesdb.php';
       include('../header.php');
 ?>

    <fieldset class='loginwall'>
               <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">LOGIN TC</b></font> </legend>  

    <?php
          if(isset($_REQUEST['tcsubmit'])){

              $result=executeQuery("select *,DECODE(tcpassword,'oespass') as tc from testconductor where tcname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and tcpassword=ENCODE('".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','oespass')");
              if(mysql_num_rows($result)>0){

                  $r=mysql_fetch_array($result);
                  
                  if(strcmp(htmlspecialchars_decode($r['tc'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0){
                      $_SESSION['tcname']=htmlspecialchars_decode($r['tcname'],ENT_QUOTES);
                      $_SESSION['tcid']=$r['tcid'];
                      unset($_GLOBALS['message']);
                      header('Location: tcwelcome.php');
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
                   
                   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


   <html>
        <head>
          <title>TC LOGIN</title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!--  <link rel="stylesheet" type="text/css" href="../oes.css"/>-->
        </head>
    
    
      <body>
        <?php

          if(isset($_GLOBALS['message']))
          {
           echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
          }
        ?>

         <div id="container">     
        <form id="tcloginform" action="index.php" method="post">
            
                    <div class="menubar">

                        <ul id="menu">
                             <?php if(isset($_SESSION['tcname'])){
                                   header('Location: tcwelcome.php');

                             }
                                 ?>
                               <!--  <li><input type="submit" value="Register" name="register" class="subbtn" title="Register"/></li>-->
                             
                        </ul>
                   </div>
            
            
                    <div class="page">

                            <table cellpadding="10" cellspacing="10">
                                
                             <tr>  
                                <td rowspan="5" style="padding-right:600px; padding-left: 40px;">
                                  <img src="images/whiteboard.jpg" alt="Molecule Wallpaper" width="600" height="430" />
                                </td>
                              </tr>
                                
                            <tr>
                                <td>TC Name</td>
                                <td><input type="text" tabindex="1" name="name" value="" size="30" /></td>

                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><input type="password" tabindex="2" name="password" value="" size="30" /></td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input type="submit" tabindex="3" value="Log In" name="tcsubmit" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" />
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
          include('../loginfooter.html');

