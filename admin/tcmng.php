
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
  
  
  
  else if (isset($_REQUEST['delete'])) {
         unset($_REQUEST['delete']);
         $hasvar = false;
         foreach ($_REQUEST as $variable) {

              if (is_numeric($variable)) { 
                  $hasvar = true;

                  if (!@executeQuery("delete from student where stdid=$variable")){

                          $_GLOBALS['message'] = mysql_errno();
                  }

               }
          }

         if (!isset($_GLOBALS['message']) && $hasvar == true)
              $_GLOBALS['message'] = "Selected Teacher/s are successfully Deleted";
          else if (!$hasvar) {
             $_GLOBALS['message'] = "First Select the Teachers to be Deleted.";
          }
     }
     
     

   else if(isset($_REQUEST['savem'])){
       
        if(empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])){
            $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
        }
        
        else{
            $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'],ENT_QUOTES) . "', stdpassword='" . htmlspecialchars($_REQUEST['password'],ENT_QUOTES) . "',emailid='" . htmlspecialchars($_REQUEST['email'],ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES) . "',address='" .htmlspecialchars($_REQUEST['address'],ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'],ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'],ENT_QUOTES) . "' where stdid='" . $_REQUEST['tc'] . "';";
          
            if (!@executeQuery($query))
                $_GLOBALS['message'] = mysql_error();
            else
                $_GLOBALS['message'] = "Teacher Information is Successfully Updated.";
        }
      closedb();
   }
   
   
   else if (isset($_REQUEST['savea'])) {
       
          //  $result = executeQuery("select max(tcid) as tc from testconductor");
          //  $r = mysql_fetch_array($result);
            
        //    if (is_null($r['tc']))
        //        $newstd = 1;
        //    else
        //        $newstd=$r['tc'] + 1;

           // $result = executeQuery("select tcname as tc from testconductor where tcname='" . htmlspecialchars($_REQUEST['cname'],ENT_QUOTES) . "';");


         //   if(empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])){
          //      $_GLOBALS['message'] = "Some of the required Fields are Empty";
         //   } 
            
         //   else if(mysql_num_rows($result) > 0){
         //       $_GLOBALS['message'] = "Sorry User Already Exists.";
        //    }
         //   
        //    else{
                //$query = "insert into testconductor values($newstd,'" . htmlspecialchars($_REQUEST['cname'],ENT_QUOTES) . "',ENCODE('" . htmlspecialchars($_REQUEST['password'],ENT_QUOTES) . "','oespass'),'" . htmlspecialchars($_REQUEST['email'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['address'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['city'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['pin'],ENT_QUOTES) . "')";
                
                $query=executeQuery("update student set tc='" .$_REQUEST['tcbool']. "' where stdid='" . $_REQUEST['id'] . "';");
                
                
               // if (!@executeQuery($query)) {
               //     if(mysql_errno ()==1062) //duplicate value
               //     $_GLOBALS['message'] = "Given Teacher Name voilates some constraints, please try with some other name.";
               //     else
               //     $_GLOBALS['message'] = mysql_error();
             //   }
              //  else
                    $_GLOBALS['message'] = "Successfully New Teacher is Created.";
           
            closedb();
         }
   ?>


    <html>
        <head>
            <title>Manage Teacher</title>
            <link rel="stylesheet" type="text/css" href="sc.css"/>
            <script type="text/javascript" src="../validate.js" ></script>
        </head>
        <body>

        <div id="container">
            
          <form name="tcmng" action="tcmng.php" method="post">
              
              <div class="menubar" style="padding-left: 40%;">
                  
                    <table id="menu"><tr>
               
                 <?php
                     if (isset($_SESSION['admname'])){
                ?>
                        <td><input type="submit" value="ADMIN HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                 <?php
                    if(!isset($_REQUEST['category']) && !isset($_REQUEST['edit']) ) {  
                 ?>
                       
                        <td><input type="submit" value="Create Teacher" name="add" class="subbtn" title="Add" style="color: #36AE79;height: 40px;width: 180px"/></td>
                        <td><input type="submit" value="Delete" name="delete" class="subbtn" title="Delete" style="color: #36AE79;height: 40px;width: 180px" /></td>
                 <?php
                  }
                ?>
            <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['admname'];
                                       ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
           
           
           <?php
           
         }
       ?>
                    </tr></table>

                </div>
                
     <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">MANAGE TEACHER</b></font> </legend>             
      <div class="page">
          
            <?php

                if ($_GLOBALS['message']) {
                    echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                }

                if (isset($_SESSION['admname'])) {
                   // echo "<div class=\"pmsg\" style=\"text-align:center;\">Teachers Management </div>";
                  
                    
                    
                    
                    
                 if(isset($_REQUEST['add'])) {
                    
                    $result = executeQuery("select * FROM student ");
                    
                    if (mysql_num_rows($result)==0) {
                          header('Location: tcmng.php');
                      }
                    
                    else //if($r=mysql_fetch_array($result)) {
                    {
                       ?>
          
                     <form action="tcmng.php" method="post">
                         
                         <br><br>
                         
                         <div style="width:70%;height:80%;border:2px solid #000;padding-left:20%;border-color: #36AE79">
                         
                         <table cellpadding="10" cellspacing="10"><tr><td rowspan="2"><label><b>Nominated Names of Students For Getting Teacher Authority : </b></label></td>
                             <tr><td>
                            <?php
                                  echo "<select name='names' style='height:40px;width:200px;>";
                                                                          while($r= mysql_fetch_array($result))
                                                                               {
                                                                                 echo "<option name='names'>" . $r['stdname'] . "</option>";
                                                                              }
                                          echo "</select>"; 
                               
                                          
                             ?>       
                          </td>           
                           <td colspan="2"><input type='submit' name='category' value='Search' style="color: #36AE79;height: 40px;width: 180px"></input></td></tr>
                            
                        </table>
                             
                         </div>    
                        </form>
                                <?php                  
                                
                
                       closedb();
                      }
         
                  
                } 
             
                 if (isset($_REQUEST['category'])) {       
                     
                     $stdnamevar=$_POST['names'];
                      $result = executeQuery("select * FROM student WHERE stdname='$stdnamevar' ");
                    
                       if($r=mysql_fetch_array($result)) {
                      
                        ?>    
          
                         <table cellpadding="10" cellspacing="10" style="text-align:left;margin-left:15em" >
                                 
                                 <tr><td><label>Student ID : </label></td><td><input type="text" name="id" value="<?php echo $r['stdid'] ?>" readonly /></td></tr>
                                 <tr><td><label>Student Name : </label></td><td><input type="text" name="name" value="<?php echo $r['stdname'] ?>" readonly /></td></tr>
                                 <tr><td><label>Email ID : </label></td><td><input type="text" value="<?php echo $r['emailid'] ?>" readonly /></td></tr>
                                 
                                 <tr><td>Make Teacher : </td>
                                  <td> <input type="radio" name="tcbool" value='0' <?php if ($r['tc'] == '0') {
                                           echo "checked";
                                      } ?>> No</input></td>

                                <td> <input type="radio" name="tcbool" value='1' <?php if ($r['tc'] == '1') {
                                     echo "checked";
                                 } ?>> Yes</input></td>


                             </tr>
                             
                             <tr>
                                 <td><input type="submit" value="Save" name="savea" class="subbtn" onclick="validateform('usermng')" title="Save the Changes" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                 <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel" style="color: #36AE79;height: 40px;width: 180px" /></td>
                             </tr>
                         </table>
                    <?php

                   }
                 }   
                 
                 else if (isset($_REQUEST['edit'])) {
                     
                        $result = executeQuery("select stdid,stdname,stdpassword as stdpass ,emailid,contactno,address,city,pincode,tc from student where stdname='" . htmlspecialchars($_REQUEST['edit'],ENT_QUOTES) . "';");
                       
                          if (mysql_num_rows($result) == 0) {
                               header('Location: tcmng.php');
                            } 
                        
                          else if ($r = mysql_fetch_array($result)) {

                     ?>
                            <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
                                <tr>
                                    <td>TC Name</td>
                                    <td><input type="text" name="cname" value="<?php echo htmlspecialchars_decode($r['stdname'],ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)"/></td>

                                </tr>

                                <tr>
                                    <td>Password</td>
                                    <td><input type="text" name="password" value="<?php echo htmlspecialchars_decode($r['stdpass'],ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" /></td>

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
                                    <td><input type="hidden" name="tc" value="<?php echo htmlspecialchars_decode($r['stdid'],ENT_QUOTES); ?>"/><input type="text" name="pin" value="<?php echo htmlspecialchars_decode($r['pincode'],ENT_QUOTES); ?>" size="16" onkeyup="isnum(this)" /></td>
                                </tr>
                                
                                <tr>
                                   <td><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('usermng')" title="Save the changes" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                   <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                    
                                </tr>

                            </table>
                 <?php
                            closedb();
                        }
                    } 
                    
                    else {
                        
                        if(!isset($_REQUEST['add'])){
                        
                        $result = executeQuery("select * from student WHERE tc=1 order by stdid ;");
                      
                        if(mysql_num_rows($result) == 0){
                            echo "<h3 style=\"color:#0000cc;text-align:center;\">No Teachers Yet..!</h3>";
                        }
                        
                        else{
                                 $i=0;
                            ?>
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>TC Name</th>
                                            <th>Email-ID</th>
                                            <th>Contact Number</th>
                                            <th>Edit</th>
                                        </tr>
                            <?php
                                    while($r = mysql_fetch_array($result)){
                                        $i = $i + 1;
                                        if ($i % 2 == 0)
                                            echo "<tr class=\"alt\">";
                                        else
                                            echo "<tr>";
                                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['stdid'] . "\" /></td><td>" . htmlspecialchars_decode($r['stdname'],ENT_QUOTES)
                                        . "</td><td>" . htmlspecialchars_decode($r['emailid'],ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['contactno'],ENT_QUOTES) . "</td>"
                                        . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'],ENT_QUOTES) . "\"href=\"tcmng.php?edit=" . htmlspecialchars_decode($r['stdname'],ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
                                    }
                            ?>
                                    </table>
                           <?php
                        }
                     closedb();
                    }
                 
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

