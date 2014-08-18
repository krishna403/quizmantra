
<?php

error_reporting(0);
session_start();

  include_once 'oesdb.php';
  include('header.php');
  
   $idarr=array();
   $marksarr=array();
   $testarr=array();
   $percsarr=array();
   $attemptarr=array();
  
  ?>
<fieldset class="loginwall9">
 
  
  <?php
  
  if(!isset($_SESSION['stdname'])) {
     $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
  }
  
  else if(isset($_REQUEST['logout'])) {
        unset($_SESSION['stdname']);
        header('Location: index.php');

    }
    else if(isset($_REQUEST['back'])) {
            header('Location: viewresult.php');

        }
        else if(isset($_REQUEST['dashboard'])) {
            header('Location: stdwelcome.php');

        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Result</title>
        <link rel="stylesheet" type="text/css" href="sc.css"/>
        <script type="text/javascript" src="validate.js" ></script>
    </head>
    
    
    <body >
        
        <div id="container" >
           
            <form id="summary" action="viewresult.php" method="post">
                
                <div class="menubar" style="padding-left: 60%;">
                    <table id="menu"><tr>
                        <?php if(isset($_SESSION['stdname'])) {
                              if(isset($_REQUEST['details'])) {
                            ?>

                              <td><input type="submit" value="Back" name="back" class="subbtn" title="View Results" style="color: #36AE79;height: 40px;width: 180px" /></td>


                              <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                                 echo $_SESSION['stdname'];

                                                  ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" style="color: #36AE79;height: 40px;width: 180px" /></b></td>

                              <?php
                            }
                        
                        else
                          {
                              ?>

                           <td><input type="submit" value="HOME" name="dashboard" class="subbtn" title="Dash Board" style="color: #36AE79;height: 40px;width: 180px" /></td>

                           <td style="padding-left:50px;"><b> Hello </b><font color='#74D8FF'><b><?php 
                                                                                               echo $_SESSION['stdname'];

                                                ?></b></font> ,Welcome to <b>Quiz Mantra | <input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out" /></b></td>

                          <?php
                           }
                          ?>

                    </tr></table>


                </div>
                
                
       <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">VIEW RESULT</b></font> </legend>        
           
           
           <?php

            $i=0;
                      
                if($_GLOBALS['message']) {
                     echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
                }
            ?>
           
             <div class="page">

             <?php

             if(isset($_REQUEST['details'])) {
                 
                 
                       $result=executeQuery("select s.stdname,t.testname,sub.subname,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as stime,TIMEDIFF(st.endtime,st.starttime) as dur,(select sum(marks) from question where testid=".$_REQUEST['details'].") as tm,IFNULL((select sum(q.marks) from studentquestion as sq, question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=".$_SESSION['stdid']." and sq.testid=".$_REQUEST['details']." and sq.attemptid=".$_REQUEST['attempt']."),0) as om from student as s,test as t, subject as sub,studenttest as st where s.stdid=st.stdid and st.testid=t.testid and t.subid=sub.subid and st.stdid=".$_SESSION['stdid']." and st.testid=".$_REQUEST['details']." and st.attemptid=".$_REQUEST['attempt'].";") ;
                            if(mysql_num_rows($result)!=0) {

                                $r=mysql_fetch_array($result);
                                ?>
                   <div style="width:90%;height:60%;border:2px solid #000;padding-left:10%;border-color: #36AE79;text-align: left;">
                     <table><tr><td>   
                             
                        <table cellpadding="10" cellspacing="30" border="0" align="center">
                        
                        <tr>
                            <td><b>Student Name : </b>&nbsp;&nbsp;<?php echo htmlspecialchars_decode($r['stdname'],ENT_QUOTES) ?></td>
                            
                            <td><b>Subject : </b>&nbsp;&nbsp;<?php echo htmlspecialchars_decode($r['subname'],ENT_QUOTES); ?></td>
                        
                        
                            <td><b>Test : </b>&nbsp;&nbsp;<?php echo htmlspecialchars_decode($r['testname'],ENT_QUOTES); ?></td>
                        
                            <td><b>Attempt : </b>&nbsp;&nbsp;<?php echo $_REQUEST['attempt']%10; ?></td>
                        
                            <td><b>Date and Time : </b>&nbsp;&nbsp;<?php echo $r['stime']; ?></td>
                        </tr>
                            
                        <tr>
                            <td><b>Test Duration : </b>&nbsp;&nbsp;<?php echo $r['dur']; ?></td>
                        
                            <td><b>Max. Marks : </b>&nbsp;&nbsp;<?php echo $r['tm']; ?></td>
                        
                            <td><b>Obtained Marks : </b>&nbsp;&nbsp;<?php echo $r['om']; ?></td>
                        
                            <td><b>Percentage : </b>&nbsp;&nbsp;<?php echo (($r['om']/$r['tm'])*100)." %"; ?></td>
                        </tr>
                        
                    </table>
                   </td></tr></table>
                   </div>    
                   
                            
                      <?php

                       $result1=executeQuery("select q.qnid as questionid,q.question as quest,q.correctanswer as ca,sq.answered as status,sq.stdanswer as sa from studentquestion as sq,question as q where q.qnid=sq.qnid and sq.testid=q.testid and sq.testid=".$_REQUEST['details']." and sq.stdid=".$_SESSION['stdid']." and sq.attemptid=".$_REQUEST['attempt']." order by q.qnid;" );

                          if(mysql_num_rows($result1)==0) {
                                  echo"<h3 style=\"color:#0000cc;text-align:center;\">1.Individual questions Cannot be displayed.</h3>";
                             }
                           else {
                          ?>
                   
                
                         
                 
                 
                 <table cellpadding="30" cellspacing="10" class="datatable" border="1" width="100%">
                        <tr>
                            <th>Q. No</th>
                            <th>Question</th>
                            <th>Correct Answer</th>
                            <th>Your Answer</th>
                            <th>Score</th>
                            <th>&nbsp;</th>
                        </tr>
                                   <?php
                                      while($r1=mysql_fetch_array($result1)) {

                                        if(is_null($r1['sa']))
                                        $r1['sa']="question"; 
                                           $result2=executeQuery("SELECT ".$r1['ca']." as corans,IF('".$r1['status']."'='answered',(select ".$r1['sa']." FROM question WHERE qnid=".$r1['questionid']." AND testid=".$_REQUEST['details']."),'unanswered') AS stdans, IF('".$r1['status']."'='answered',IFNULL((SELECT q.marks FROM question as q, studentquestion AS sq WHERE q.qnid=sq.qnid AND q.testid=sq.testid AND q.correctanswer=sq.stdanswer AND sq.stdid=".$_SESSION['stdid']." AND q.qnid=".$r1['questionid']." AND q.testid=".$_REQUEST['details']." AND sq.attemptid=".$_REQUEST['attempt']."),0),0) AS stdmarks FROM question WHERE qnid=".$r1['questionid']." AND testid=".$_REQUEST['details'].";");

                                            if($r2=mysql_fetch_array($result2)) {
                                                ?>
                        <tr>
                            <td><?php echo $r1['questionid']; $idarr[$i]=$r1['questionid'];?></td>
                            <td><?php echo htmlspecialchars_decode($r1['quest'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($r2['corans'],ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars_decode($r2['stdans'],ENT_QUOTES); ?></td>
                            <td><?php echo $r2['stdmarks']; $marksarr[$i]=$r2['stdmarks']; $i++; ?></td>
                                
                            
                                                    <?php
                                                    if($r2['stdmarks']==0) {
                                                        echo"<td class=\"tddata\"><img src=\"images/wrong.png\" title=\"Wrong Answer\" height=\"30\" width=\"40\" alt=\"Wrong Answer\" /></td>";
                                                    }
                                                    else {
                                                        echo"<td class=\"tddata\"><img src=\"images/correct.png\" title=\"Correct Answer\" height=\"30\" width=\"40\" alt=\"Correct Answer\" /></td>";
                                                    }
                                                    ?>
                        </tr>
                            <?php
                                                }
                                                else {
                                                    echo"<h3 style=\"color:#0000cc;text-align:center;\">Sorry Individual questions Cannot be displayed.</h3>".mysql_error();
                                                }
                                            }
                                        }
                                    }
                                    
                                    else {
                                        echo"<h3 style=\"color:#0000cc;text-align:center;\">Please logout and Try again.</h3>".mysql_error();
                                    }
                                  ?>
                       </table>
                       


                   </td>
                 </tr>
               </table>
                        
                        
               <table align="center"><tr>
                       <td colspan="2" align="center"><h4>Performance Graph</h4></td>
                     </tr>
                      <tr>
                     
                      <td>
                         
                         
                         
                                 <html>
                                    <head>
                                      <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                                      <script type="text/javascript">
                                          
                                        //  var arrmain=[];
                                       //   var arrx=[];
                                      //    var arry=[];
                                     //     var i=0;
                                          
                                          <?php 
                                      //       for($j=0 ; $j< (int)$i ; $j++){
                                            ?>  
                                        //      arrx[i]=Number(<?php// echo $marksarr[$j] ;?>);
                                        //      arry[i]=Number(<?php// echo $idarr[$j] ;?>);
                                             
                                       //      i++;
                                         <?php     
                                      //    }
                                        ?>
                                        google.load("visualization", "1", {packages:["corechart"]});
                                        google.setOnLoadCallback(drawChart);
                                        function drawChart() {
                                        
                                             
                                          var data = google.visualization.arrayToDataTable([
                                                 ['Question ID', 'Obtained Marks'],
                                                     <?php
                                                            $j = 0;
                                                            for($j=0 ; $j< (int)$i ; $j++){
                                                             echo "['{$idarr[$j]}',{$marksarr[$j]}],";
                                                            }
                                                      ?>
                                               ]);

                                          var options = {
                                            title: 'Quiz Mantra Individual Test Performance Graph',
                                             vAxis: {title: 'Question ID',  titleTextStyle: {color: 'red'}},
                                              hAxis: {title: 'Marks',  titleTextStyle: {color: 'red'}}
                                                     
                                          };

                                          var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                                          chart.draw(data, options);
                                        }
                                      </script>
                                    </head>
                                    <body>
                                      <div id="chart_div" style="width: 1500px; height: 500px;"></div>
                                    </body>
                                  </html>
                         
                         
                         
                         
                         
                         
                         </td>
                         
                     </tr>
                   </table> 
                        
                    <?php
                    
                       // echo htmlspecialchars_decode($r['testname'],ENT_QUOTES);
                        
                    
                    //   echo $marksarr[0]."   ".$idarr[0];
                   //    echo $marksarr[8]."  ".$idarr[8];
                  //    echo $i;
                    
              }
                        
                else {
                        $k=0;
                            $result=executeQuery("select st.*,t.testname,t.testdesc,DATE_FORMAT(st.starttime,'%d %M %Y %H:%i:%s') as startt from studenttest as st,test as t where t.testid=st.testid and st.stdid=".$_SESSION['stdid']." and st.status='over' order by st.testid;");
                              if(mysql_num_rows($result)==0) {
                                echo"<h3 style=\"color:#0000cc;text-align:center;\">I Think You Haven't Attempted Any Exams Yet..! Please Try Again After Your Attempt.</h3>";
                              }
                            
                            
                          else {
                 
                                ?>
                    <br><br><table cellpadding="30" cellspacing="10" border="1" class="datatable" style="margin-left: 3%;">
                                        <tr>
                                            <th>Test ID</th>
                                            <th>Date and Time</th>
                                            <th>Test Name</th>
                                            <th>Max. Marks</th>
                                            <th>Obtained Marks</th>
                                            <th>Percentage</th>
                                            <th>Details</th>
                                            <th>Attempt</th>
                                        </tr>
                            <?php
                            while($r=mysql_fetch_array($result)) {
                                                        $i=$i+1;
                                                        $om=0;
                                                        $tm=0;
                                                        
                                                        $result1=executeQuery("select sum(q.marks) as om from studentquestion as sq, question as q where sq.testid=q.testid and sq.qnid=q.qnid and sq.answered='answered' and sq.stdanswer=q.correctanswer and sq.stdid=".$_SESSION['stdid']." and sq.testid=".$r['testid']." and sq.attemptid=".$r['attemptid']." order by sq.testid;");
                                                        $r1=mysql_fetch_array($result1);

                                                        $result2=executeQuery("select sum(marks) as tm from question where testid=".$r['testid'].";");
                                                        $r2=mysql_fetch_array($result2);

                                                        if($i%2==0) {
                                                            echo "<tr class=\"alt\">";
                                                        }

                                                        else{
                                                            echo "<tr>";
                                                         }
                                                         
                                                        echo "<td>".$r['testid']."</td>";

                                                        echo "<td>".$r['startt']."</td><td>".htmlspecialchars_decode($r['testname'],ENT_QUOTES)." : ".htmlspecialchars_decode($r['testdesc'],ENT_QUOTES)."</td>";
                                                        $testarr[$k]="(id:".$r['testid'].") ".$r['testname'];
                                                        
                                                        if(is_null($r2['tm'])) {
                                                            $tm=0;
                                                            echo "<td>$tm</td>";
                                                        }
                                                        
                                                        else {
                                                            $tm=$r2['tm'];
                                                            echo "<td>$tm</td>";
                                                        }

                                                        if(is_null($r1['om'])) {
                                                            $om=0;
                                                            echo "<td>$om</td>";
                                                        }
                                                        
                                                        else {
                                                            $om=$r1['om'];
                                                            echo "<td>$om</td>";
                                                        }

                                                        if($tm==0) {
                                                            echo "<td>0</td>";
                                                        }
                                                        else {
                                                            echo "<td>".(($om/$tm)*100)." %</td>";
                                                            $percsarr[$k]=(($om/$tm)*100);
                                                            
                                                        }
                                                         
                                                        echo"<td class=\"tddata\"><a title=\"Details\" href=\"viewresult.php?details=".$r['testid']."&attempt=".$r['attemptid']."\"><img src=\"images/details.gif\" height=\"40\" width=\"130\" alt=\"Details\" /></a></td>";
                                                       // $_SESSION['attid']=$r['attemptid'];
                                                        
                                                        $attemptno=$r['attemptid']%10;
                                                        echo "<td>".$attemptno."</td></tr>";
                                                        
                                                        $attemptarr[$k]=(int)$attemptno;
                                                                
                                                     $k++;
                                                   }

                                               ?>

                             </table>
                            
                        <?php
                          }
                      ?>
                            
                            
                          <table align="center"><tr>
                             <td colspan="2" align="center"><h4>Graphical Representation</h4></td>
                              </tr>
                               <tr>

                               <td>
                          
                                           <html>
                                                <head>
                                                  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                                                  <script type="text/javascript">
                                                      
                                                    google.load("visualization", "1", {packages:["corechart"]});
                                                    google.setOnLoadCallback(drawChart);
                                                    function drawChart() {
                                                      var data = google.visualization.arrayToDataTable([
                                                        ['Test Name', 'Attempts', 'Percentage'],
                                                        
                                                         <?php
                                                            $i = 0;
                                                            for($i=0 ; $i<(int)$k ; $i++){
                                                             echo "['{$testarr[$i]}',{$attemptarr[$i]},{$percsarr[$i]}],";
                                                            }
                                                          ?>
                                                        ]);

                                                      var options = {
                                                        title: 'Overall Test Performances',
                                                        vAxis: {title: 'Test ID',  titleTextStyle: {color: 'red'}},
                                                        hAxis: {title: 'Percentage',  titleTextStyle: {color: 'red'}}
                                                       
                                                      };

                                                      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                                                      chart.draw(data, options);
                                                    }
                                                  </script>
                                                </head>
                                                <body>
                                                  <div id="chart_div" style="width: 1200px; height: 600px;"></div>
                                                </body>
                                              </html>
                         
                         
                         
                                   </td>
                         
                                </tr>
                              </table> 
                          <?php  
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
 include('loginfooter.html');

