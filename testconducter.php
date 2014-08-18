
<?php

error_reporting(0);
session_start();
  include_once 'oesdb.php';
  include('header.php');
  ?>

 <fieldset class="loginwall3">
 <fieldset><legend><font color='black'  size="6"><b style="font-family:  'Hoefler Text', Georgia, 'Times New Roman', serif;">VIEW RESULT</b></font> </legend>

<?php
  
  $final=false;
    if(!isset($_SESSION['stdname'])) {
        $_GLOBALS['message']="Session Timeout.Click here to <a href=\"../index.php\">Re-LogIn</a>";
    }
    
    else if(isset($_REQUEST['logout'])){
           unset($_SESSION['stdname']);
           header('Location: ../index.php');

    }
    
    else if(isset($_REQUEST['dashboard'])){
     header('Location: stdwelcome.php');

    }
    
    
    else if(isset($_REQUEST['next']) || isset($_REQUEST['summary']) || isset($_REQUEST['viewsummary'])) {
        $answer='unanswered';
        if(time()<strtotime($_SESSION['endtime'])){
            if(isset($_REQUEST['markreview'])){
                $answer='review';
            }
            
            else if(isset($_REQUEST['answer'])){
                $answer='answered';
            }
            
            else{
                $answer='unanswered';
            }
            
            
            if(strcmp($answer,"unanswered")!=0){
                
                if(strcmp($answer,"answered")==0){
                    $query="update studentquestion set answered='answered',stdanswer='".htmlspecialchars($_REQUEST['answer'],ENT_QUOTES)."' where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].". and attemptid=".$_SESSION['attempt'].";";
                }
                
                else{
                    $query="update studentquestion set answered='review',stdanswer='".htmlspecialchars($_REQUEST['answer'],ENT_QUOTES)."' where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].". and attemptid=".$_SESSION['attempt'].";";
                }
                
                if(!executeQuery($query)){
                      $_GLOBALS['message']="Your previous answer is not updated.Please answer once again";
                }
               closedb();
            }
            
            
           if(isset($_REQUEST['viewsummary'])){
                 header('Location: summary.php');
            }
            if(isset($_REQUEST['summary'])){
                 header('Location: summary.php');
             }
        }
        
        
        if((int)$_SESSION['qn']<(int)$_SESSION['tqn']){
             $_SESSION['qn']=$_SESSION['qn']+1;
        }
        
        if((int)$_SESSION['qn']==(int)$_SESSION['tqn']){
           $final=true;
        }

    }
    
    
    
    else if(isset($_REQUEST['previous'])){
        
        $answer='unanswered';
        
        if(time()<strtotime($_SESSION['endtime'])){
            
            if(isset($_REQUEST['markreview'])){
                $answer='review';
            }
            
            else if(isset($_REQUEST['answer'])){
                $answer='answered';
            }
            
            else{
                $answer='unanswered';
            }
            
            if(strcmp($answer,"unanswered")!=0){
                if(strcmp($answer,"answered")==0){
                    $query="update studentquestion set answered='answered',stdanswer='".htmlspecialchars($_REQUEST['answer'],ENT_QUOTES)."' where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].". and attemptid=".$_SESSION['attempt'].";";
                }
                
                else{
                    $query="update studentquestion set answered='review',stdanswer='".htmlspecialchars($_REQUEST['answer'],ENT_QUOTES)."' where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].". and attemptid=".$_SESSION['attempt'].";";
                }
                
                if(!executeQuery($query)){
                $_GLOBALS['message']="Your previous answer is not updated.Please answer once again";
                }
                closedb();
            }
        }
        
        
        if((int)$_SESSION['qn']>1){
            $_SESSION['qn']=$_SESSION['qn']-1;
        }

    }
    
    else if(isset($_REQUEST['fs'])){
      header('Location: testack.php');
   }
    
 ?>

    <?php
    header("Cache-Control: no-cache, must-revalidate");
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html>
  <head>
    <title>Test Exexution</title>
  
    <link rel="stylesheet" type="text/css" href="sc.css"/>
    <script type="text/javascript" src="validate.js" ></script>
    <script type="text/javascript" src="cdtimer.js" ></script>
    <script type="text/javascript" >
    <!--
        <?php
                $elapsed=time()-strtotime($_SESSION['starttime']);
                if(((int)$elapsed/60)<(int)$_SESSION['duration'])
                {
                    $result=executeQuery("select TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%H') as hour,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%i') as min,TIME_FORMAT(TIMEDIFF(endtime,CURRENT_TIMESTAMP),'%s') as sec from studenttest where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid'].". AND attemptid=".$_SESSION['attempt'].";");
                  
                    if($rslt=mysql_fetch_array($result))
                    {
                     echo "var hour=".$rslt['hour'].";";
                     echo "var min=".$rslt['min'].";";
                     echo "var sec=".$rslt['sec'].";";
                    }
                    else
                    {
                        $_GLOBALS['message']="Try Again";
                    }
                    closedb();
                }
                else
                {
                    echo "var sec=01;var min=00;var hour=00;";
                }
        ?>
        
    -->
    </script>

    </head>
  <body>
      
       <?php

        if($_GLOBALS['message']) {
            echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
           }
        ?>
      <div id="container">
      
         <form id="testconducter" action="testconducter.php" method="post">
            <div class="menubar" style="text-align:center;">
                <h2 style="font-family:helvetica,sans-serif;font-weight:bolder;font-size:120%;color:#f50000;padding-top:0.3em;letter-spacing:1px;">QUIZ MANTRA : TEST EXECUTION</h2>
            </div>
        <div class="page">
           
          <?php
         
          if(isset($_SESSION['stdname']))
          {
                $result=executeQuery("select stdanswer,answered from studentquestion where stdid=".$_SESSION['stdid']." and testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].". AND attemptid=".$_SESSION['attempt'].";");
                $r1=mysql_fetch_array($result);
                
                $result=executeQuery("select * from question where testid=".$_SESSION['testid']." and qnid=".$_SESSION['qn'].";");
                $r=mysql_fetch_array($result);
          ?>
          <div class="tc">

              <table border="0" width="100%" class="ntab">
                  <tr>
                      <th style="width:40%;"><h3><span id="timer" class="timerclass"></span></h3></th>
                      <th style="width:40%;"><h4 style="color: #af0a36;">Question No: <?php echo $_SESSION['qn']; ?> </h4></th>
                      <th style="width:20%;"><h4 style="color: #af0a36;"><input type="checkbox" name="markreview" value="mark"> Mark for Review</input></h4></th>
                  </tr>
              </table>
              
             <textarea cols="100" rows="8" name="question" readonly style="width:96.8%;text-align:left;margin-left:2%;margin-top:2px;font-size:120%;font-weight:bold;margin-bottom:0;color:#0000ff;padding:2px 2px 2px 2px;"><?php echo htmlspecialchars_decode($r['question'],ENT_QUOTES); ?></textarea>
             
             <table border="0" width="100%" class="ntab">
                  <tr><td>&nbsp;</td></tr>
                  <tr><td >1. <input type="radio" name="answer" value="optiona" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optiona")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optiona'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td >2. <input type="radio" name="answer" value="optionb" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optionb")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optionb'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td >3. <input type="radio" name="answer" value="optionc" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optionc")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optionc'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td >4. <input type="radio" name="answer" value="optiond" <?php if((strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"review")==0 ||strcmp(htmlspecialchars_decode($r1['answered'],ENT_QUOTES),"answered")==0)&& strcmp(htmlspecialchars_decode($r1['stdanswer'],ENT_QUOTES),"optiond")==0 ){echo "checked";} ?>> <?php echo htmlspecialchars_decode($r['optiond'],ENT_QUOTES); ?></input></td></tr>
                  <tr><td>&nbsp;</td></tr>
                  
                  <tr><th style="width:12%;text-align:right;"><h4><input type="submit" name="previous" value="Previous" class="subbtn" style="color: #36AE79;height: 40px;width: 180px"/></h4></th>
                      <th style="width:80%;"><h4><input type="submit" name="<?php if($final==true){
                                                                     echo "viewsummary" ;
                                                                 }
                                                                else{
                                                                     echo "next";
                                                                     
                                                                } ?>" value="<?php if($final==true){ 
                                                                                  echo "View Summary" ;
                                                                                  
                                                                                }
                                                                                else{ 
                                                                                    echo "Next";
                                                                                    
                                                                                } ?>" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" /></h4></th>
                      
                      <th style="width:8%;text-align:right;"><h4><input type="submit" name="summary" value="Summary" class="subbtn" style="color: #36AE79;height: 40px;width: 180px" /></h4></th>
                  </tr>
                  
              </table>
              

          </div>
          <?php
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

