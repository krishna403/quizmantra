
<?php
error_reporting(0);
session_start();
include_once '../oesdb.php';
include('../header.php');

?>

  <fieldset class='loginwall3'>

 <?php



  if (!isset($_SESSION['admname'])) {
      $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"../index.php\">Re-LogIn</a>";
   } 
   
   else if (isset($_REQUEST['logout'])) {
     unset($_SESSION['admname']);
     header('Location: ../index.php');
   }
   
   else if (isset($_REQUEST['dashboard'])) {
    header('Location: admwelcome.php');
   }
   
   else if (isset($_REQUEST['tcmng'])) {
    header('Location: tcmng.php');
   }

   else if (isset($_REQUEST['delete'])){
       unset($_REQUEST['delete']);
       $hasvar = false;
       
      foreach ($_REQUEST as $variable){
         if (is_numeric($variable)){
             $hasvar = true;

            if (!@executeQuery("delete from student where stdid=$variable")) {
                if (mysql_errno () == 1451) 
                    $_GLOBALS['message'] = "Too Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this user, then first manually delete all the records that are associated with this user.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
         }
      }
        if(!isset($_GLOBALS['message']) && $hasvar == true)
            $_GLOBALS['message'] = "Selected User/s are successfully Deleted";

        else if(!$hasvar){
            $_GLOBALS['message'] = "First Select the users to be Deleted.";
        }
  } 


   else if (isset($_REQUEST['savem'])){
  
       if(empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])){
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
       } 
    
       else{
           
            $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword='" . htmlspecialchars($_REQUEST['password']) . "',emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . htmlspecialchars($_REQUEST['student'], ENT_QUOTES) . "';";
                if (!@executeQuery($query))
                    $_GLOBALS['message'] = mysql_error();
                else
                    $_GLOBALS['message'] = "User Information is Successfully Updated.";
         }
      closedb();
    }
    
    
     else if(isset($_REQUEST['savea'])){
                $result = executeQuery("select max(stdid) as std from student");
                
                $r=mysql_fetch_array($result);

                    if (is_null($r['std']))
                        $newstd = 1;
                    else
                        $newstd=$r['std'] + 1;

               $result=executeQuery("select stdname as std from student where stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "';");


                    if(empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
                        $_GLOBALS['message'] = "Some of the required Fields are Empty";
                    }

                    else if(mysql_num_rows($result) > 0){
                        $_GLOBALS['message'] = "Sorry User Already Exists.";
                    }

                    else{
                        $query = "insert into student values($newstd,'" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "','" . '0' . "')";
                            if (!@executeQuery($query)) {
                           
                                    $_GLOBALS['message'] = mysql_error();
                            }
                            else
                                $_GLOBALS['message'] = "Successfully New User is Created.";
                      }
            closedb();
    }
    ?>


    <html>
        <head>
            <title>Manage Users</title>
            <link rel="stylesheet" type="text/css" href="sc.css"/>
            <script type="text/javascript" src="../validate.js" ></script>
        </head>
        <body>
            
   
        <div id="container">
            
            <form name="usermng" action="usermng.php" method="post">
                <div class="menubar" style="padding-left: 30%;">


                    <table id="menu"><tr>
                        <?php
                        if(isset($_SESSION['admname'])){
                        ?>
                           
                                                <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board"  style="color: #36AE79;height: 40px;width: 180px" /></td>
                                                <td><input type="submit" value="Teachers" name="tcmng" class="subbtn" title="Test Conductors Management"  style="color: #36AE79;height: 40px;width: 180px" /></td>
                                                
                              

                        <?php
                            if(!isset($_REQUEST['edit']) && !isset($_REQUEST['add'])){  
                        ?>
                                                <td><input type="submit" value="Add User" name="add" class="subbtn" title="Add"  style="color: #36AE79;height: 40px;width: 180px" /></td>
                                                <td><input type="submit" value="Delete User" name="delete" class="subbtn" title="Delete"  style="color: #36AE79;height: 40px;width: 180px" /></td>
                                                
                        <?php 
                        
                            }
                            ?>
                            
                             <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['admname'];
                                                                                    
                
                                               ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                      <?php
                     } 
                    ?>
                                        </tr> </table>
                                     </div>
                
                
             <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">USER MANAGE </b></font> </legend>
                 <div class="page">
                     
                     
                  <?php
                  
                    if (isset($_GLOBALS['message'])) {
                           echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                        }
                    
                        
                    if (isset($_SESSION['admname'])) {
                        echo "<div class=\"pmsg\" style=\"text-align:center;\">Students Management </div>";
                   
                        
                        if (isset($_REQUEST['add'])) {
                    ?>
                                            
                                            
                    <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
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
                             <td><input type="submit" value="Save" name="savea" class="subbtn" onclick="validateform('usermng')" title="Save the Changes"  style="color: #36AE79;height: 40px;width: 180px" /></td>
                             <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"  style="color: #36AE79;height: 40px;width: 180px"/></td>
                        </tr>                        

                    </table>

            <?php
                } 
                
                
                else if (isset($_REQUEST['edit'])) {
                    $result = executeQuery("select stdid,stdname,stdpassword as stdpass ,emailid,contactno,address,city,pincode from student where stdname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");
                    if (mysql_num_rows($result) == 0) {
                        header('Location: usermng.php');
                    }
                    
                    else if ($r = mysql_fetch_array($result)) {

            ?>
                    <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
                        <tr>
                            <td>User Name</td>
                            <td><input type="text" name="cname" value="<?php echo htmlspecialchars_decode($r['stdname'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)"/></td>

                        </tr>

                        <tr>
                            <td>Password</td>
                            <td><input type="text" name="password" value="<?php echo htmlspecialchars_decode($r['stdpass'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" /></td>

                        </tr>

                        <tr>
                            <td>E-mail ID</td>
                            <td><input type="text" name="email" value="<?php echo htmlspecialchars_decode($r['emailid'], ENT_QUOTES); ?>" size="16" /></td>
                        </tr>
                        <tr>
                            <td>Contact No</td>
                            <td><input type="text" name="contactno" value="<?php echo htmlspecialchars_decode($r['contactno'], ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)"/></td>
                        </tr>

                        <tr>
                            <td>Address</td>
                            <td><textarea name="address" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['address'], ENT_QUOTES); ?></textarea></td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td><input type="text" name="city" value="<?php echo htmlspecialchars_decode($r['city'], ENT_QUOTES); ?>" size="16" onkeyup="isalpha(this)"/></td>
                        </tr>
                        <tr>
                            <td>PIN Code</td>
                            <td><input type="hidden" name="student" value="<?php echo htmlspecialchars_decode($r['stdid'], ENT_QUOTES); ?>"/><input type="text" name="pin" value="<?php echo $r['pincode']; ?>" size="16" onkeyup="isnum(this)" /></td>
                        </tr>
                        
                        <tr>
                            <td><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('usermng')" title="Save the changes"  style="color: #36AE79;height: 40px;width: 180px" /></td>
                             <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"  style="color: #36AE79;height: 40px;width: 180px" /></td>
                         </tr>                       

                    </table>
               <?php
                    closedb();
                }
            } 
            
            
            else {
                $result = executeQuery("select * from student order by stdid;");
             
                if (mysql_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Users Yet..!</h3>";
                }
                
                else {
                    $i = 0;
                ?>
                    <table cellpadding="30" cellspacing="10" class="datatable">
                        <tr>
                            <th>&nbsp;</th>
                            <th>User Name</th>
                            <th>Email-ID</th>
                            <th>Contact Number</th>
                            <th>Edit</th>
                        </tr>
                  <?php
                    while ($r = mysql_fetch_array($result)) {
                        $i = $i + 1;
                        if ($i % 2 == 0)
                            echo "<tr class=\"alt\">";
                        else
                            echo "<tr>";
                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['stdid'] . "\" /></td><td>" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['emailid'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['contactno'], ENT_QUOTES) . "</td>"
                        . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"usermng.php?edit=" . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
                    }
                     ?>
                    </table>
               <?php
                }
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

