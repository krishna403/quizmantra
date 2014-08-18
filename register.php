
<?php

    error_reporting(0);
    session_start();
    include_once 'oesdb.php';
    include('header.php');
    ?>
<fieldset class='loginwall'>

<?php

        if(isset($_REQUEST['stdsubmit']))
        {

                $result=executeQuery("select max(stdid) as std from student");
                $r=mysql_fetch_array($result);
                if(is_null($r['std']))
                $newstd=1;
                else
                $newstd=$r['std']+1;

                $result=executeQuery("select stdname as std from student where stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."';");

               if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email']))
               {
                    $_GLOBALS['message']="Some of the required Fields are Empty";
               }else if(mysql_num_rows($result)>0)
               {
                   $_GLOBALS['message']="Sorry the User Name is Not Available Try with Some Other name.";
               }
               else
               {
                $query="insert into student values($newstd,'".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."','0')";
                if(!@executeQuery($query))
                           $_GLOBALS['message']=mysql_error();
                else
                {
                   $success=true;
                   $_GLOBALS['message']="Successfully Your Account is Created.Click <a href=\"index.php\">Here</a> to LogIn";
                  // header('Location: index.php');
                }
               }
               closedb();
        }
    
   ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

  <html>

    <head>
      <title>Registration</title>
      <link rel="stylesheet" type="text/css" href="sc.css"/>
      <script type="text/javascript" src="validate.js" ></script>
   </head>
    
    
   <body id="register">
     
      
       
        <div id="container">
            
            
            <div class="menubar" style="padding-left: 50%;">
                             <table id="menu"><tr>
                                        <?php if(isset($_SESSION['stdname'])){
                                              header('Location: stdwelcome.php');
                                          }

                                        else{    
                                         ?>
                                               <td><div class="aclass"><a href="home.php" title="Back To Home"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Home</button></a></div></td>
                                               <td><div class="aclass"><a href="index.php" title="Click here  to Login"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Login</button></a></div></td>
                                              <td><a href="rating.php" name="logout"><button id="signin" style="color: #36AE79;height: 40px;width: 180px">Rate US</button></a></td> 
                                              <td> <a href="contact.php" name="datahistory"><button id="contactbutt" style="color: #36AE79;height: 40px;width: 180px">Contact US</button></a></td>

                                        <?php
                                              }
                                        ?>
                              </table>
                </div>
          
            <fieldset><legend>
           
              <?php if(!$success): ?>
                 <!--  <h2 style="text-align:center;color:#ffffff;">New User Registration</h2>-->
                  <font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">REGISTRATION </b></font> 
              <?php endif; ?>
        
            </legend>
                
                 
           
                
      <div class="page">
            
      <?php
          if($_GLOBALS['message']) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
          }
        ?>
       
            
       <?php
             if($success){
                echo "<h2 style=\"text-align:center;color:#0000ff;\">Thank You For Registering with Quiz Mantra.<br/><a href=\"index.php\">Login Now</a></h2>";
              }
              
             else{
          
         ?>
                    <form id="admloginform"  action="register.php" method="post" onsubmit="return validateform('admloginform');">
                      <table cellpadding="10" cellspacing="10" style="text-align:left;margin-left:5em" >
                        <tr>  
                          <td rowspan="10" style="padding-right:700px; padding-left: 40px;">
                                         <img src="images/bulb.jpg" alt="Molecule Wallpaper" width="500" height="600" />

                                     </td>
                            </tr>
                        <tr>
                            <td>User Name</td>
                            <td><input type="text" name="cname" value="" size="16" onkeyup="isalphanum(this)"/></td>

                        </tr>

                                <tr>
                            <td>Password</td>
                            <td><input type="password" name="password" value="" size="16" onkeyup="isalphanum(this)" /></td>

                        </tr>
                                <tr>
                            <td>Re-type Password</td>
                            <td><input type="password" name="repass" value="" size="16" onkeyup="isalphanum(this)" /></td>

                        </tr>
                        <tr>
                            <td>E-mail ID</td>
                            <td><input type="text" name="email" value="" size="16" /></td>
                        </tr>
                                 <tr>
                            <td>Contact No</td>
                            <td><input type="text" name="contactno" value="" size="16" onkeyup="isnum(this)"/></td>
                        </tr>

                            <tr>
                            <td>Address</td>
                            <td><textarea name="address" cols="20" rows="3"></textarea></td>
                        </tr>
                                 <tr>
                            <td>City</td>
                            <td><input type="text" name="city" value="" size="16" onkeyup="isalpha(this)"/></td>
                        </tr>
                                 <tr>
                            <td>PIN Code</td>
                            <td><input type="text" name="pin" value="" size="16" onkeyup="isnum(this)" /></td>
                        </tr>
                                 <tr>
                                     <td style="text-align:right;"><input type="submit" name="stdsubmit" value="Register" class="subbtn" style="color: #36AE79;height: 30px;width: 120px;font-size: 20px" /></td>
                            <td><input type="reset" name="reset" value="Reset" class="subbtn" style="color: #36AE79;height: 30px;width: 120px;font-size: 20px"/></td>
                        </tr>
                      </table>
                  </form>
            <?php 
                  }
            ?>
            
           </div>
          </div>
       </body>
      </fieldset>
     </fieldset>
 <?php
        include("loginfooter.html");

