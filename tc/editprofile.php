
<?php

error_reporting(0);
session_start();
include_once '../oesdb.php';
include('../header.php');

 ?>
  <fieldset class='loginwall2'>
<?php
      

    if(!isset($_SESSION['tcname'])) {
        $_GLOBALS['message']="Session Timeout.Click here to <a href=\"../index.php\">Re-LogIn</a>";
    }
    
    else if(isset($_REQUEST['logout'])){
        unset($_SESSION['tcname']);
        unset($_SESSION['stdname']);
        header('Location: ../index.php');

    }
    
    else if(isset($_REQUEST['dashboard'])){
     header('Location: tcwelcome.php');

    }
    
    else if(isset($_REQUEST['savem'])){
        if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email'])){
             $_GLOBALS['message']="Some of the required Fields are Empty.Therefore Nothing is Updated";
        }
        
        else{
         $query="update student SET stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."', stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."',emailid='".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."',contactno='".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."',address='".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."',city='".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."',pincode='".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."' WHERE stdid='".$_REQUEST['tc']."';";
          
             if(!@executeQuery($query))
               $_GLOBALS['message']=mysql_error();
            else{
               
              $_GLOBALS['message']="Your Profile is Successfully Updated.";
             // header('Location: tcwelcome.php'); 
             
            }
        }
    closedb();

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="sc.css"/>
    <script type="text/javascript" src="../validate.js" ></script>
    </head>
 
    
    <body>
       
      <div id="container">
     
          <form id="editprofile" action="editprofile.php" method="post">
           <div class="menubar" style="padding-left: 60%;">
                     
                    <table id="menu"><tr>
                            
                         <td><input type="submit" value="Teacher Home" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                        <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['tcname'];
                               ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                        
                    </tr></table>
            </div>
              
              
      <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">EDIT PROFILE</b></font> </legend>       
       <div class="page">
           
           
           
                <?php

                    if($_GLOBALS['message']) {
                        echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                    }
                ?>
           
           <?php if(isset($_SESSION['tcname'])) {
           
          
                        $result=executeQuery("select stdid,stdname,stdpassword as stdpass ,emailid,contactno,address,city,pincode FROM student where stdname='".$_SESSION['tcname']."';");
                        if(mysql_num_rows($result)==0) {
                           header('Location: tcwelcome.php');
                        }
                        else if($r=mysql_fetch_array($result))
                        {
                          
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
                                       <td><input type="hidden" name="tc" value="<?php echo $r['stdid']; ?>"/><input type="text" name="pin" value="<?php echo htmlspecialchars_decode($r['pincode'],ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)" /></td>
                                   </tr>
                                    
                                    <tr><td colspan="2"><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('editprofile')" title="Save the changes" style="color: #36AE79;height: 40px;width: 180px"/></td></tr> 

                                 </table>
          
          
                                        <div class="menubar2" style="float: right;">
                     
                                            <table id="menu"><tr>
                                                  

                                                </tr></table>
                                       </div>
                  <?php
                      closedb();
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
include('../loginfooter.html');

