
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
    
    else if(isset($_REQUEST['logout'])) {
            unset($_SESSION['tcname']);
            unset($_SESSION['stdname']);
            header('Location: ../index.php');

     }
        
    else if(isset($_REQUEST['dashboard'])) {
            header('Location: tcwelcome.php');

      }
      
    else if(isset($_REQUEST['back'])) {
                header('Location: rsltmng.php');

       }

?>
<html>
    <head>
        <title>Manage Results</title>
        <link rel="stylesheet" type="text/css" href="sc.css"/>

    </head>
    
    <body>
     
     <div id="container">
            
        <form name="rsltmng" action="rsltmng.php" method="post">
            <div class="menubar" style="padding-left: 60%;">
                     
                 <table id="menu"><tr>
                       
         <?php 
           if(isset($_SESSION['tcname'])) {
               
                            if(isset($_REQUEST['testid'])) {
                          ?>
                               <td><input type="submit" value="Back" name="back" class="subbtn" title="Manage Results" style="color: #36AE79;height: 40px;width: 180px" /></td>
                          <?php 
                             }
                             else { 
                          ?>
                               <td><input type="submit" value="Teacher Home" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>
                         <?php
                         } 
                         ?>
                           <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                             echo $_SESSION['tcname'];
                                                                                    
                
                               ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>
                    </tr></table>

               </div>
                
            <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">MANAGE RESULT</b></font> </legend> 
           
                <div class="page">
                    
                    <?php

                        if($_GLOBALS['message']) {
                            echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                        }
                        ?>
                    
                         <?php
                         
                             if(isset($_REQUEST['testid'])){
                                 
                                 $result=executeQuery("select t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,IFNULL((select sum(marks) from question where testid=".$_REQUEST['testid']."),0) as maxmarks from test as t, subject as sub where sub.subid=t.subid and t.testid=".$_REQUEST['testid'].";") ;
                                    if(mysql_num_rows($result)!=0) {

                                     $r=mysql_fetch_array($result);
                            ?>
                               
                                       <table align="center" cellpadding="15" cellspacing="10" border="0" style="text-align:left;line-height:20px;">
                                            <tr>
                                                <td colspan="2"><b><p style="color:#0000cc;text-align:center;">Test Summary</p></b></td>
                                            </tr>
                                           <tr><td colspan="2"><hr style="border-width:2px;"/></td></tr>
                                            <tr>
                                                <td>Test Name</td>
                                                <td><?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Subject Name</td>
                                                <td><?php echo htmlspecialchars_decode($r['subname'],ENT_QUOTES); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Validity</td>
                                                <td><?php echo $r['fromdate']." To ".$r['todate']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Max. Marks</td>
                                                <td><?php echo $r['maxmarks']; ?></td>
                                            </tr>
                                            <tr><td colspan="2"><hr style="border-width:2px;"/></td></tr>
                                            <tr>
                                                <td colspan="2"><h3 style="color:#0000cc;text-align:center;">Attempted Students : </h3></td>
                                            </tr>
                                          

                                        </table>
                                  
                    
                                <?php

                                  $result1=executeQuery("select s.stdname,s.emailid,IFNULL((select sum(q.marks) from studentquestion as sq,question as q where q.qnid=sq.qnid and sq.testid=".$_REQUEST['testid']." and sq.stdid=st.stdid and sq.stdanswer=q.correctanswer),0) as om from studenttest as st, student as s where s.stdid=st.stdid and st.testid=".$_REQUEST['testid'].";" );

                                    if(mysql_num_rows($result1)==0){
                                        echo"<h4 style=\"color:#0000cc;text-align:center;\">No Students Yet Attempted this Test!</h4>";
                                    }
                                    
                                    else{
                                 ?>
                                    
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Email-ID</th>
                                            <th>Obtained Marks</th>
                                            <th>Result(%)</th>

                                        </tr>
                                    <?php
                                    while($r1=mysql_fetch_array($result1)) {

                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars_decode($r1['stdname'],ENT_QUOTES); ?></td>
                                            <td><?php echo htmlspecialchars_decode($r1['emailid'],ENT_QUOTES); ?></td>
                                            <td><?php echo $r1['om']; ?></td>
                                            <td><?php echo ($r1['om']/$r['maxmarks']*100)." %"; ?></td>


                                        </tr>
                                                        <?php

                                             }

                                         }
                                   }
                          
                             ?>
                                    </table>


                             <?php

                           }
                   else {

                            $result=executeQuery("select t.testid,t.testname,DATE_FORMAT(t.testfrom,'%d %M %Y') as fromdate,DATE_FORMAT(t.testto,'%d %M %Y %H:%i:%S') as todate,sub.subname,(select count(stdid) from studenttest where testid=t.testid) as attemptedstudents from test as t, subject as sub where sub.subid=t.subid and t.teacherid=".$_SESSION['tcid'].";");
                                
                             if(mysql_num_rows($result)==0) {
                                   echo "<h3 style=\"color:#0000cc;text-align:center;\">No Tests Yet...!</h3>";
                                   }
                                   
                                  else{
                                      $i=0;

                              ?>
                                    <table cellpadding="30" cellspacing="10" class="datatable">
                                        <tr>
                                            <th>Test Name</th>
                                            <th>Validity</th>
                                            <th>Subject Name</th>
                                            <th>Attempted Students</th>
                                            <th>Details</th>
                                        </tr>
                              <?php
                                                    while($r=mysql_fetch_array($result)) {
                                                        $i=$i+1;
                                                        if($i%2==0) {
                                                            echo "<tr class=\"alt\">";
                                                        }
                                                        else { echo "<tr>";}
                                                        echo "<td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)."</td><td>".$r['fromdate']." To ".$r['todate']." PM </td>"
                                                            ."<td>".htmlspecialchars_decode($r['subname'],ENT_QUOTES)."</td><td>".$r['attemptedstudents']."</td>"
                                                            ."<td class=\"tddata\"><a title=\"Details\" href=\"rsltmng.php?testid=".$r['testid']."\"><img src=\"../images/details.gif\" height=\"35\" width=\"150\" alt=\"Details\" /></a></td></tr>";
                                                    }
                                                    ?>
                                    </table>
                           <?php
                                        }
                       }
                    closedb();
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
