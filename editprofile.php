
<?php

error_reporting(0);
session_start();
//include_once 'oesdb.php';
include('lib.php');
include('header.php');

?>

<fieldset class='loginwall6'>
    
<?php

      editprofile();
                           
?>


   
       
        <div id="container" style="padding-left: 50%;">
      
           <form id="editprofile" action="editprofile.php" method="post">
               
                <div class="menubar">
                     <table id="menu"><tr>
                           <?php if(isset($_SESSION['stdname'])) {
                                  
                               ?>

                            
                            <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>                       
                            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                                   echo $_SESSION['stdname'];


                                                                                                  //    echo $rowsc[Name];
                                                     ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px"/></b></td>

                     </tr></table>
                </div>
             
         </div>
       
       <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">LOGIN </b></font> </legend>
       


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html>
  <head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="sc.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    </head>
  <body >
       <?php

        if($_GLOBALS['message']) {
           // echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
             echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$msg."</font></b></div>";
        }
        ?>
      
      <div class="page">
          
          <?php 
               $result=$db->query("select stdid,stdname,stdpassword as stdpass ,emailid,contactno,address,city,pincode,tc from student where stdname='".$_SESSION['stdname']."';");
                        if(mysql_num_rows($result)==0) {
                           header('Location: stdwelcome.php');
                        }
                        
                        else if($r= $db->fetch_array()){
           ?>
                          
                
           <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
              <tr>
                  <td>User Name</td>
                  <td><input type="text" name="cname" value="<?php echo htmlspecialchars_decode($r['stdname'],ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)"/></td>

              </tr>

                      <tr>
                  <td>Password</td>
                  <td><input type="password" name="password" value="<?php echo htmlspecialchars_decode($r['stdpass'],ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" /></td>
                 
              </tr>

              <tr>
                  <td>E-mail ID</td>
                  <td><input type="text" name="email" value="<?php echo htmlspecialchars_decode($r['emailid'],ENT_QUOTES); ?>" size="16" /></td>
              </tr>
                       <tr>
                  <td>Contact No</td>
                  <td><input type="text" name="contactno" value="<?php echo htmlspecialchars_decode($r['contactno'],ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)"/></td>
              </tr>

                  <tr>
                  <td>Address</td>
                  <td><textarea name="address" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['address'],ENT_QUOTES); ?></textarea></td>
              </tr>
                       <tr>
                  <td>City</td>
                  <td><input type="text" name="city" value="<?php echo htmlspecialchars_decode($r['city'],ENT_QUOTES); ?>" size="16" onkeyup="isalpha(this)"/></td>
              </tr>
                       <tr>
                  <td>PIN Code</td>
                  <td><input type="hidden" name="student" value="<?php echo $r['stdid']; ?>"/><input type="text" name="pin" value="<?php echo htmlspecialchars_decode($r['pincode'],ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)" /></td>
              </tr>
              
              <tr>
                  <td><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('editprofile')" title="Save the changes" style="color: #36AE79;height: 40px;width: 180px" /></td>
                  <td><input type="submit" value="Cancel" name="dashboard" class="subbtn" onclick="validateform('editprofile')" title="Save the changes" style="color: #36AE79;height: 40px;width: 180px" /></td>
              </tr>
              
           
           ?>   
              

            </table>
<?php
                      $db->_destruct();
                        }
                        
                 }
  ?>
      </div>

           </form>
      
      </div>
  </body>
</fieldset>
</fieldset>
<?php
  include('loginfooter.html');
