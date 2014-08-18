<?php

error_reporting(0);
session_start();
      include_once '../oesdb.php';
      include('../header.php');
      
    ?>

  <fieldset class='loginwall2'>
<?php
      
    if(!isset($_SESSION['tcname'])){
      $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"../index.php\">Re-LogIn</a>";
   } 

    else if (isset($_REQUEST['logout'])){
        unset($_SESSION['tcname']);
        unset($_SESSION['stdname']);
        header('Location: ../index.php');
    }
    
    else if (isset($_REQUEST['dashboard'])){
       header('Location: tcwelcome.php');
    } 

    else if (isset($_REQUEST['delete'])){
        unset($_REQUEST['delete']);
        $hasvar = false;
            foreach ($_REQUEST as $variable){
               if (is_numeric($variable)) { 
                   $hasvar = true;

                   if (!@executeQuery("delete from subject where subid=$variable and teacherid=" . $_SESSION['tcid'] . ";")) {
                           $_GLOBALS['message'] = mysql_errno();
                   }
               }
           }
           
        if (!isset($_GLOBALS['message']) && $hasvar == true)
            $_GLOBALS['message'] = "Selected Subject/s are successfully Deleted";
        
        else if (!$hasvar){
            $_GLOBALS['message'] = "First Select the subject/s to be Deleted.";
        }
        
    } 


     else if (isset($_REQUEST['savem'])){
         if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
             $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
         }
         
         else{
             $query = "update subject set subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "', subdesc='" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "'where subid=" . $_REQUEST['subject'] . " AND teacherid=" . $_SESSION['tcid'] . ";";
                if (!@executeQuery($query))
                    $_GLOBALS['message'] = mysql_error();
                else
                    $_GLOBALS['message'] = "Subject Information is Successfully Updated.";
          } 
        closedb();
     }
     
     
      else if (isset($_REQUEST['savea'])){
        $result=executeQuery("select max(subid) as sub from subject");
             $r=mysql_fetch_array($result);
             
                if(is_null($r['sub']))
                    $newstd = 1;
                else
                    $newstd=$r['sub'] + 1;

                $result = executeQuery("select subname as sub from subject where subname='" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "' AND teacherid=" . $_SESSION['tcid'] . ";");

                    if (empty($_REQUEST['subname']) || empty($_REQUEST['subdesc'])) {
                        $_GLOBALS['message'] = "Some of the required Fields are Empty";
                    }

                    else if (mysql_num_rows($result) > 0) {
                        $_GLOBALS['message'] = "Sorry Subject Already Exists.";
                    }

                    else {
                        $query = "insert into subject values($newstd,'" . htmlspecialchars($_REQUEST['subname'], ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['subdesc'], ENT_QUOTES) . "'," . $_SESSION['tcid'] . ")";
                        if (!@executeQuery($query)) {
                                $_GLOBALS['message'] = mysql_error ();
                        }
                        else
                            $_GLOBALS['message'] = "Successfully New Subject is Created.";
                    }
            closedb();
      }
  ?>


  <html>
    <head>
        <title>Manage Subjects</title>
        <link rel="stylesheet" type="text/css" href="sc.css"/>
        <script type="text/javascript" src="../validate.js" ></script>
    </head>
       <body>
                  <div id="container">
                     <form name="submng" action="submng.php" method="post">
                        
                         
                         <div class="menubar" style="padding-left: 40%;">
                                <table id="menu"><tr>
                                    <?php
                                    if (isset($_SESSION['tcname'])){

                                    ?>
                                               
                                                  <td><input type="submit" value="Teacher Home" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px"/></td>

                                                     <td><input type="submit" value="Delete" name="delete" class="subbtn" title="Delete" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                                      <td><input type="submit" value="Add" name="add" class="subbtn" title="Add" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                                      <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['tcname'];
                                                                                    
                
                                                   ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                                    <?php 
                                       
                                    }
                                    ?>
                                           </tr></table>

                             </div>
                         
          <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">MANAGE SUBJECT</b></font> </legend>                 
           
              <div class="page">
                     
             <?php
             
               if ($_GLOBALS['message']){
                    echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
               }
                 
                       
               if(isset($_SESSION['tcname'])){

                       if(isset($_REQUEST['add'])){
                               ?>
                                 <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
                                     <tr>
                                         <td>Subject Name</td>
                                         <td><input type="text" name="subname" value="" size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('Subject Name is Empty');this.focus();this.value='';}"/></td>

                                     </tr>

                                     <tr>
                                         <td>Subject Description</td>
                                         <td><textarea name="subdesc" cols="20" rows="3" onblur="if(this.value==''){alert('Subject Description is Empty');this.focus();this.value='';}"></textarea></td>
                                     </tr>
                                 </table>
                        <?php
                            } 
    
    
    
                        else if(isset($_REQUEST['edit'])){

                            $result = executeQuery("select subid,subname,subdesc from subject where subname='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "' and teacherid=" . $_SESSION['tcid'] . ";");
                           
                            if (mysql_num_rows($result) == 0){
                                header('submng.php');
                            }
                            
                            else if ($r = mysql_fetch_array($result)) {
                          ?>
                                        <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
                                            <tr>
                                                <td>Subject Name</td>
                                                <td><input type="text" name="subname" value="<?php echo htmlspecialchars_decode($r['subname'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)"/></td>

                                            </tr>
                                            <tr>
                                                <td>Subject Description</td>
                                                <td><textarea name="subdesc" cols="20" rows="3"><?php echo htmlspecialchars_decode($r['subdesc'], ENT_QUOTES); ?></textarea><input type="hidden" name="subject" value="<?php echo $r['subid']; ?>"/></td>
                                            </tr>
                                        </table>
                         <?php
                                        closedb();
                                    }
                            }
            
            else{

                        $result = executeQuery("select * from subject where teacherid=" . $_SESSION['tcid'] . " order by subid;");
                        
                        if (mysql_num_rows($result) == 0) {
                            echo "<h3 style=\"color:#0000cc;text-align:center;\">No Subjets Yet..!</h3>";
                        }
                        else {
                            $i = 0;
                        ?>
                            <table cellpadding="30" cellspacing="10" class="datatable">
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Subject Name</th>
                                    <th>Subject Description</th>
                                    <th>Edit</th>
                                </tr>
                         
                         <?php
                            while ($r=mysql_fetch_array($result)){
                                
                                $i = $i + 1;
                                if ($i % 2 == 0) {
                                    echo "<tr class=\"alt\">";
                                }
                                else{
                                    echo "<tr>";
                                }
                                
                                echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['subid'] . "\" /></td><td>" . htmlspecialchars_decode($r['subname'], ENT_QUOTES)
                                . "</td><td>" . htmlspecialchars_decode($r['subdesc'], ENT_QUOTES) . "</td>"
                                . "<td class=\"tddata\"><a title=\"Edit " . htmlspecialchars_decode($r['stdname'], ENT_QUOTES) . "\"href=\"submng.php?edit=" . htmlspecialchars_decode($r['subname'], ENT_QUOTES) . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
                            }
                         ?>
                            </table>
                        <?php
                      }
                   closedb();
                }
                      
                ?>
                  
                            <div class="menubar2" style="float: right">
                              <?php  
                                  if (isset($_REQUEST['edit'])){ 
                                    ?>
                                                            <td><input type="submit" value="Save" name="savem" class="subbtn" onclick="validatesubform('submng')" title="Save the changes" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                                            <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel" style="color: #36AE79;height: 40px;width: 180px"/></td>
                                                            

                                    <?php
                                        }
                                 else if(isset($_REQUEST['add'])){
                                    ?>
                                                            <td><input type="submit" value="Save" name="savea" class="subbtn" onclick="validatesubform('submng')" title="Save the Changes" style="color: #36AE79;height: 40px;width: 180px"/></td>
                                                            <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel" style="color: #36AE79;height: 40px;width: 180px"/></td>
                                                            

                                    <?php
                                        }
                                      
                              ?>
                             </div>
                           <?php
                
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

