
<?php

    error_reporting(0);
    session_start();
    
    include('lib.php');
    include('header.php');
    
  ?>

<fieldset class='loginwall'>

   <?php
   
        if(isset($_REQUEST['stdsubmit'])){
            registration();
        }
   ?>

    
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
           
              <?php if(!$success) ?>
                  <font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">REGISTRATION </b></font> 
              <?php// endif; ?>
        
            </legend>
                
                 
           
                
      <div class="page">
            
      <?php
          if($_GLOBALS['message']){
              printmessage($_GLOBALS['message']);
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
                            <td><input type="text" name="cname" value="<?PHP if(isset($_REQUEST['stdsubmit'])){htmlspecialchars($_REQUEST['cname'],ENT_QUOTES);}?>" size="16" onkeyup="isalphanum(this)"/></td>

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
                            <td><input type="text" name="email" value="<?PHP if(isset($_REQUEST['stdsubmit'])){htmlspecialchars($_REQUEST['email'],ENT_QUOTES);}?>" size="16" /></td>
                        </tr>
                                 <tr>
                            <td>Contact No</td>
                            <td><input type="text" name="contactno" value="<?PHP if(isset($_REQUEST['stdsubmit'])){htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES);}?>" size="16" onkeyup="isnum(this)"/></td>
                        </tr>

                            <tr>
                            <td>Address</td>
                            <td><textarea name="address" cols="20" rows="3"><?PHP if(isset($_REQUEST['stdsubmit'])){htmlspecialchars($_REQUEST['address'],ENT_QUOTES);}?></textarea></td>
                        </tr>
                                 <tr>
                            <td>City</td>
                            <td><input type="text" name="city" value="<?PHP if(isset($_REQUEST['stdsubmit'])){htmlspecialchars($_REQUEST['city'],ENT_QUOTES);}?>" size="16" onkeyup="isalpha(this)"/></td>
                        </tr>
                                 <tr>
                            <td>PIN Code</td>
                            <td><input type="text" name="pin" value="<?PHP if(isset($_REQUEST['stdsubmit'])){htmlspecialchars($_REQUEST['pin'],ENT_QUOTES);}?>" size="16" onkeyup="isnum(this)" /></td>
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

