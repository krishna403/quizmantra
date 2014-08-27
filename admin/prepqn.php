
<?php

session_start();

include('../lib.php');
include('../header.php');

?>
<fieldset class="loginwall2">
<?php

  if((!isset($_SESSION['admname']) || !isset($_SESSION['testqn'])) && (!isset($_SESSION['tcname']) || !isset($_SESSION['testqn']))) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"../index.php\">Re-LogIn</a>";
   } 
  
   
  else if(isset($_REQUEST['logout'])) {
      
         if(isset($_SESSION['tcname'])){
             
            unset($_SESSION['tcname']);
            unset($_SESSION['stdname']);
        }
        
       else
         unset($_SESSION['admname']);
       
        header('Location: ../index.php');
  }
  
  else if (isset($_REQUEST['managetests'])){
    header('Location: testmng.php');
  }
  
  else if (isset($_REQUEST['delete'])) {
        unset($_REQUEST['delete']);
        $hasvar = false;
        $count = 1;
        
            foreach($_REQUEST as $variable){
                if (is_numeric($variable)){ 
                    $hasvar = true;

                    if(!@$db->query("delete from question where testid=" . $_SESSION['testqn'] . " and qnid=" . htmlspecialchars($variable)))
                        $_GLOBALS['message'] = mysql_error();
                }
            }


        $result = $db->query("select qnid from question where testid=" . $_SESSION['testqn'] . " order by qnid;");
            while($r = mysql_fetch_array($result))
                    if (!@$db->query("update question set qnid=" . ($count++) . " where testid=" . $_SESSION['testqn'] . " and qnid=" . $r['qnid'] . ";"))
                        $_GLOBALS['message'] = mysql_error();


                if(!isset($_GLOBALS['message']) && $hasvar == true)
                    $_GLOBALS['message'] = "Selected Questions are successfully Deleted";
                
                else if(!$hasvar){
                    $_GLOBALS['message'] = "First Select the Questions to be Deleted.";
               }
    } 

        else if (isset($_REQUEST['savem'])) {

             if (strcmp($_REQUEST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_REQUEST['question']) || empty($_REQUEST['optiona']) || empty($_REQUEST['optionb']) || empty($_REQUEST['optionc']) || empty($_REQUEST['optiond']) || empty($_REQUEST['marks'])) {
                  $_GLOBALS['message'] = "Some of the required Fields are Empty";
             }

             else if (strcasecmp($_REQUEST['optiona'], $_REQUEST['optionb']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionc'], $_REQUEST['optiond']) == 0) {
                  $_GLOBALS['message'] = "Two or more options are representing same answers.Verify Once again";
              }

             else {
               $query = "update question set question='" . htmlspecialchars($_REQUEST['question'],ENT_QUOTES) . "',optiona='" . htmlspecialchars($_REQUEST['optiona'],ENT_QUOTES) . "',optionb='" . htmlspecialchars($_REQUEST['optionb'],ENT_QUOTES) . "',optionc='" . htmlspecialchars($_REQUEST['optionc'],ENT_QUOTES) . "',optiond='" . htmlspecialchars($_REQUEST['optiond'],ENT_QUOTES) . "',correctanswer='" . htmlspecialchars($_REQUEST['correctans'],ENT_QUOTES) . "',marks=" . htmlspecialchars($_REQUEST['marks'],ENT_QUOTES) . " where testid=" . $_SESSION['testqn'] . " and qnid=" . $_REQUEST['qnid'] . " ;";
               if(!@$db->query($query))
                   $_GLOBALS['message'] = mysql_error();

               else
                   $_GLOBALS['message'] = "Question is updated Successfully.";
           }

           $db->_destruct();
        }
  
  
    else if (isset($_REQUEST['savea'])) {
                $cancel = false;
                $result = $db->query("select max(qnid) as qn from question where testid=" . $_SESSION['testqn'] . ";");
                $r = mysql_fetch_array($result);
                
                    if (is_null($r['qn']))
                        $newstd = 1;
                    
                    else
                        $newstd=$r['qn'] + 1;

                        $result = $db->query("select count(*) as q from question where testid=" . $_SESSION['testqn'] . ";");
                        $r2 = mysql_fetch_array($result);

                        $result = $db->query("select totalquestions from test where testid=" . $_SESSION['testqn'] . ";");
                        $r1 = mysql_fetch_array($result);

                    if(!is_null($r2['q']) && (int) htmlspecialchars_decode($r1['totalquestions'],ENT_QUOTES) == (int) $r2['q']) {
                        $cancel = true;
                        $_GLOBALS['message'] = "Already you have created all the Questions for this Test.<br /><b>Help:</b> If you still want to add some more questions then edit the test settings(option:Total Questions).";
                    }
                
                    else
                        $cancel=false;

                $result = $db->query("select * from question where testid=" . $_SESSION['testqn'] . " and question='" . htmlspecialchars($_REQUEST['question'],ENT_QUOTES) . "';");
                
                
                    if (!$cancel && $r1 = mysql_fetch_array($result)) {
                        $cancel = true;
                        $_GLOBALS['message'] = "Sorry, You trying to enter same question for Same test";
                    } 

                    else if (!$cancel)
                        $cancel = false;

                    if (strcmp($_REQUEST['correctans'], "<Choose the Correct Answer>") == 0 || empty($_REQUEST['question']) || empty($_REQUEST['optiona']) || empty($_REQUEST['optionb']) || empty($_REQUEST['optionc']) || empty($_REQUEST['optiond']) || empty($_REQUEST['marks'])) {
                              $_GLOBALS['message'] = "Some of the required Fields are Empty";
                    }

                    else if (strcasecmp($_REQUEST['optiona'], $_REQUEST['optionb']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optiona'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optionc']) == 0 || strcasecmp($_REQUEST['optionb'], $_REQUEST['optiond']) == 0 || strcasecmp($_REQUEST['optionc'], $_REQUEST['optiond']) == 0) {
                             $_GLOBALS['message'] = "Two or more options are representing same answers.Verify Once again";
                    } 

                    else if (!$cancel){
                            $query = "insert into question values(" . $_SESSION['testqn'] . ",$newstd,'" . htmlspecialchars($_REQUEST['question'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optiona'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optionb'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optionc'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['optiond'],ENT_QUOTES) . "','" . htmlspecialchars($_REQUEST['correctans'],ENT_QUOTES) . "'," . htmlspecialchars($_REQUEST['marks'],ENT_QUOTES) . ")";
                                if (!@$db->query($query))
                                    $_GLOBALS['message'] = mysql_error();
                                else
                                    $_GLOBALS['message'] = "Successfully New Question is Created.";
                        }
            $db->_destruct();
        }
    ?>


        <script type="text/javascript" src="../tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="../validate.js" ></script>

    <body>
      
            <div id="container">

             <form name="prepqn" action="prepqn.php" method="post">
                 <div class="menubar" style="padding-left: 40%;">


                <table id="menu"><tr>
                        
                    <?php
                      if ((isset($_SESSION['admname']) && isset($_SESSION['testqn'])) || (isset($_SESSION['tcname']) && isset($_SESSION['testqn']))) {

                    ?>
                       
                        <td><input type="submit" value="Manage Tests" name="managetests" class="subbtn" title="Manage Tests" style="color: #36AE79;height: 40px;width: 180px"/></td>

                    <?php
                       if(!(isset($_REQUEST['add'])) && !(isset($_REQUEST['edit'])) ){  
                     ?>
                            
                        <td><input type="submit" value="Delete" name="delete" class="subbtn" title="Delete" style="color: #36AE79;height: 40px;width: 180px" /></td>
                        <td><input type="submit" value="Add" name="add" class="subbtn" title="Add" style="color: #36AE79;height: 40px;width: 180px" /></td>
                        
                     <?php
                     }
                     ?>
                     
                      <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                               if(isset($_SESSION['tcname'])){
                                                                                                        echo $_SESSION['tcname'];
                                                                                                    }
                                                                                                    else
                                                                                                     echo $_SESSION['admname'];
                                              ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                   <?php                   
                  }
                ?>
                    </tr></table>

                </div>

           
      <fieldset><legend><font color='black'  size="4"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">TEST MANAGE </b></font></legend>
           
          <div class="page">
                     <?php
                     
                      if ($_GLOBALS['message']) {
                              echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                        }
                     
                     
                        $result = $db->query("select count(*) as q from question where testid=" . $_SESSION['testqn'] . ";");
                        $r1 = mysql_fetch_array($result);

                        $result = $db->query("select totalquestions from test where testid=" . $_SESSION['testqn'] . ";");
                        $r2 = mysql_fetch_array($result);
                        
                                    if ((int) $r1['q'] == (int) htmlspecialchars_decode($r2['totalquestions'],ENT_QUOTES))
                                        echo "<br><div class=\"pmsg\"> Test Name: " . $_SESSION['testname'] . "<br/><br/>Status: All the Questions are Created for this test.</div>";
                                    else
                                        echo "<br><div class=\"pmsg\"><b> Test Name: <font color='#36AE79'>" . $_SESSION['testname'] . "</font><br/><br/>Status:<font color='#36AE79'> Still you need to create " . (htmlspecialchars_decode($r2['totalquestions'],ENT_QUOTES) - $r1['q']) . " Question/s. After that only, test will be available for candidates.</font></b></div>";
                       ?>
                        <?php
                        if ((isset($_SESSION['admname']) && isset($_SESSION['testqn'])) || (isset($_SESSION['tcname']) && isset($_SESSION['testqn']))) {

                            if (isset($_REQUEST['add'])) {
                               
                        ?>
                                <table cellpadding="20" cellspacing="20" style="text-align:left;" >
                                    <tr>
                                        <td>Question</td>
                                        <td><textarea name="question" cols="40" rows="3"  ></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Option A</td>
                                        <td><input type="text" name="optiona" value="" size="30"  /></td>
                                    </tr>
                                    <tr>
                                        <td>Option B</td>
                                        <td><input type="text" name="optionb" value="" size="30"  /></td>
                                    </tr>

                                    <tr>
                                        <td>Option C</td>
                                        <td><input type="text" name="optionc" value="" size="30"  /></td>
                                    </tr>
                                    <tr>
                                        <td>Option D</td>
                                        <td><input type="text" name="optiond" value="" size="30"  /></td>
                                    </tr>
                                    <tr>
                                        <td>Correct Answer</td>
                                        <td>
                                            <select name="correctans">
                                                <option value="<Choose the Correct Answer>" selected>&lt;Choose the Correct Answer&gt;</option>
                                                <option value="optiona">Option A</option>
                                                <option value="optionb">Option B</option>
                                                <option value="optionc">Option C</option>
                                                <option value="optiond">Option D</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Marks</td>
                                        <td><input type="text" name="marks" value="1" size="30" onkeyup="isnum(this)" /></td>

                                    </tr>
                                    
                                    <tr>
                                          <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                          <td><input type="submit" value="Save" name="savea" class="subbtn" onclick="validateqnform('prepqn')" title="Save the Changes" style="color: #36AE79;height: 40px;width: 180px" /></td>
                                    </tr>   

                                </table>

                       <?php
                            }
                            
                            else if(isset($_REQUEST['edit'])) {
                                $result = $db->query("select * from question where testid=" . $_SESSION['testqn'] . " and qnid=" . $_REQUEST['edit'] . ";");
                               
                                if (mysql_num_rows($result) == 0) {
                                    header('Location: prepqn.php');
                                } 
                                
                                else if ($r = mysql_fetch_array($result)) {


                               ?>
                                    <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em;" >
                                        <tr>
                                            <td>Question<input type="hidden" name="qnid" value="<?php echo $r['qnid']; ?>" /></td>
                                            <td><textarea name="question" cols="40" rows="3"  ><?php echo htmlspecialchars_decode($r['question'],ENT_QUOTES); ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>Option A</td>
                                            <td><input type="text" name="optiona" value="<?php echo htmlspecialchars_decode($r['optiona'],ENT_QUOTES); ?>" size="30"  /></td>
                                        </tr>
                                        <tr>
                                            <td>Option B</td>
                                            <td><input type="text" name="optionb" value="<?php echo htmlspecialchars_decode($r['optionb'],ENT_QUOTES); ?>" size="30"  /></td>
                                        </tr>

                                        <tr>
                                            <td>Option C</td>
                                            <td><input type="text" name="optionc" value="<?php echo htmlspecialchars_decode($r['optionc'],ENT_QUOTES); ?>" size="30"  /></td>
                                        </tr>
                                        <tr>
                                            <td>Option D</td>
                                            <td><input type="text" name="optiond" value="<?php echo htmlspecialchars_decode($r['optiond'],ENT_QUOTES); ?>" size="30"  /></td>
                                        </tr>
                                        <tr>
                                            <td>Correct Answer</td>
                                            <td>
                                                <select name="correctans">
                                                    <option value="optiona" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optiona")==0)
                                        echo "selected"; ?>>Option A</option>
                                                    <option value="optionb" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optionb")==0)
                                        echo "selected"; ?>>Option B</option>
                                                    <option value="optionc" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optionc")==0)
                                        echo "selected"; ?>>Option C</option>
                                                    <option value="optiond" <?php if (strcmp(htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES), "optiond")==0)
                                        echo "selected"; ?>>Option D</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Marks</td>
                                            <td><input type="text" name="marks" value="<?php echo htmlspecialchars_decode($r['marks'],ENT_QUOTES); ?>" size="30" onkeyup="isnum(this)" /></td>

                                        </tr>
                                        
                                        <tr>
                                             <td><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel" style="color: #36AE79;height: 40px;width: 180px"/></td>
                                              <td><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateqnform('prepqn')" title="Save the changes" style="color: #36AE79;height: 40px;width: 180px" /></td>

                                        </tr>

                                    </table>
                           <?php
                                    $db->_destruct();
                                }
                            }

                      else {
                                $result=$db->query("select * from question where testid=" . $_SESSION['testqn'] . " order by qnid;");
                                if (mysql_num_rows($result)==0){
                                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Questions Yet..!</h3>";
                                } 
                                
                                else{
                                    $i=0;
                         ?>
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Qn.No</th>
                                            <th>Question</th>
                                            <th>Correct Answer</th>
                                            <th>Marks</th>
                                            <th>Edit</th>
                                        </tr>
                        <?php
                                    while ($r = mysql_fetch_array($result)) {
                                        $i = $i + 1;
                                        if ($i % 2 == 0)
                                            echo "<tr class=\"alt\">";
                                        else
                                            echo "<tr>";
                                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['qnid'] . "\" /></td><td> " . $i
                                        . "</td><td>" . htmlspecialchars_decode($r['question'],ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r[htmlspecialchars_decode($r['correctanswer'],ENT_QUOTES)],ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['marks'],ENT_QUOTES) . "</td>"
                                        . "<td class=\"tddata\"><a title=\"Edit " . $r['qnid'] . "\"href=\"prepqn.php?edit=" . $r['qnid'] . "\"><img src=\"../images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>"
                                        . "</td></tr>";
                                    }
                       ?>
                                    </table>
                      <?php
                                }
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
  include('../loginfooter.html');
