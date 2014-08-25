

    <?php

    
    /* function for page relocation using header*/

    function relocateHeader($location){
       
        if($location==''){
               studentSubmit();
          }
       else {
      //     header('Location: testack.php');
           header("Location: $location");
        } 
    }



    /* print the error and other successful notifications */
    function printmessage($msg){
       echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$msg."</font></b></div>";
    }

    
    /*  logout function  */

    function logout($token){
        
       unset($_SESSION['stdname']);
        
        if(isset($token)){
          unset($_SESSION['tcname']);
        }
        
      relocateHeader('index.php');
    }
    
    
    /*  registration for student*/
    
    function registration(){
        
        global $db;
        global $_GLOBALS;
        
         $result=$db->query("select max(stdid) as std from student");
                $r=mysql_fetch_array($result);
                if(is_null($r['std']))
                $newstd=1;
                else
                $newstd=$r['std']+1;

                $result=$db->query("select stdname as std from student where stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."';");

               if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email']))
               {
                    $_GLOBALS['message']="Some of the required Fields are Empty";
               }else if(mysql_num_rows($result)>0)
               {
                   $_GLOBALS['message']="Sorry the User Name is Not Available Try with Some Other name.";
               }
               else
               {
                $query="insert into student values($newstd,'".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."','".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."','0')";
                if(!$db->query($query))
                           $_GLOBALS['message']=mysql_error();
                
                else
                {
                   $success=true;
                   $_GLOBALS['message']="Successfully Your Account is Created.Click <a href=\"index.php\">Here</a> to LogIn";
                  // header('Location: index.php');
                }
               }
              $db->_destruct();
              
       // return $_GLOBALS['message'];
    }


    
    
    /* redirect index page for different type of users ex. student,teacher,and admin */

    function studentSubmit(){

        global $db;
        global $_GLOBALS;
        
         if(strcmp("root",(htmlspecialchars($_REQUEST['name'],ENT_QUOTES)))==0){   

             if(strcmp("root",(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0){  

                       $_SESSION['admname']=htmlspecialchars($_REQUEST['name'],ENT_QUOTES);
                       unset($_GLOBALS['message']);    
                       echo $_REQUEST['name'];
                       echo $_REQUEST['password'];
                       relocateHeader('stdwelcome.php');
                   }
              }

          else{ 
              //echo $db->query("select *,stdpassword as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."' "); 
             $result=$db->query("select *,stdpassword as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."' "); 
            // $result=executeQuery("select *,stdpassword as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."' ");
               if(mysql_num_rows($result)>0){
                   $r=$db->fetch_array();

                 if(strcmp(htmlspecialchars($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0){

                        $_SESSION['stdname']=htmlspecialchars($r['stdname'],ENT_QUOTES);
                        $_SESSION['stdid']=$r['stdid'];

                            if($r['tc']==1){

                              $_SESSION['tcname']=htmlspecialchars($r['stdname'],ENT_QUOTES);
                              $_SESSION['tcid']=$r['stdid'];
                            }

                      unset($_GLOBALS['message']);
                      relocateHeader('stdwelcome.php');
                  }

                  else{
                      $_GLOBALS['message']="Check Your user name and Password.";
                 }
              }

              else {
                  $_GLOBALS['message']="Check Your user name and Password.";
                }

                $db->_destruct();
           }
    }

    
    
    
    /*  edit profile */

    
    function editprofile(){
        
        global $db;
        global $_GLOBALS;
        
        
        
        if(!isset($_SESSION['stdname'])){
          $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
       }
 
       else if(isset($_REQUEST['logout'])){
           logout('ep');
       }
   
      else if(isset($_REQUEST['dashboard'])){
           relocateHeader('stdwelcome.php');
      }
    
      else if(isset($_REQUEST['savem'])){
        
       if(empty($_REQUEST['cname'])||empty ($_REQUEST['password'])||empty ($_REQUEST['email'])){
           $_GLOBALS['message']="Some of the required Fields are Empty.Therefore Nothing is Updated";
        }
        
       else{
        $query="update student set stdname='".htmlspecialchars($_REQUEST['cname'],ENT_QUOTES)."', stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."',emailid='".htmlspecialchars($_REQUEST['email'],ENT_QUOTES)."',contactno='".htmlspecialchars($_REQUEST['contactno'],ENT_QUOTES)."',address='".htmlspecialchars($_REQUEST['address'],ENT_QUOTES)."',city='".htmlspecialchars($_REQUEST['city'],ENT_QUOTES)."',pincode='".htmlspecialchars($_REQUEST['pin'],ENT_QUOTES)."' where stdid='".$_REQUEST['student']."';";
        
        if(!$db->query($query))
           $_GLOBALS['message']=mysql_error();
        else
           $_GLOBALS['message']="Your Profile is Successfully Updated.";
       }
   // closedb();
       $db->_destruct();
    }
  }
  
  
  
  /*  resume test */
  
  function resumetest(){
      
      global $db;
      global $_GLOBALS;
      
      
    if(!isset($_SESSION['stdname'])) {
       $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
     }
  
     else if(isset($_REQUEST['logout'])) {
         logout('');
     } 
    
    else if(isset($_REQUEST['dashboard'])){
        relocateHeader('stdwelcome.php');
        }
        
        else if(isset($_REQUEST['resume'])){
            
            $result =$db->query("select testname from test where testid=".$_REQUEST['resume'].";");
               
               if($r=mysql_fetch_array($result)){
                    $_SESSION['testname']=htmlspecialchars_decode($r['testname'],ENT_QUOTES);
                    $_SESSION['testid']=$_REQUEST['resume'];
                }
            }
            
            else if(isset($_REQUEST['resumetest'])){
                
                    if(!empty($_REQUEST['tc'])){
                        $result=$db->query("select testcode as tcode from test where testid=".$_SESSION['testid'].";");

                        if($r=mysql_fetch_array($result)){
                            
                            if(strcmp(htmlspecialchars_decode($r['tcode'],ENT_QUOTES),htmlspecialchars($_REQUEST['tc'],ENT_QUOTES))!=0) {
                                $display=true;
                                $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                            }
                            
                            else{
                                $result=$db->query("select totalquestions,duration from test where testid=".$_SESSION['testid'].";");
                                $r=mysql_fetch_array($result);
                               
                                $_SESSION['tqn']=htmlspecialchars_decode($r['totalquestions'],ENT_QUOTES);
                                $_SESSION['duration']=htmlspecialchars_decode($r['duration'],ENT_QUOTES);
                              
                                $result = $db->query("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].". and attemptid=".$_SESSION['attempt'].";");
                                $r=mysql_fetch_array($result);
                              
                                $_SESSION['starttime']=$r['startt'];
                                $_SESSION['endtime']=$r['endt'];
                                $_SESSION['qn']=1;
                                relocateHeader('testconducter.php');
                            }

                        }
                        else {
                            $display=true;
                            $_GLOBALS['message']="You have entered an Invalid Test Code.Try again.";
                        }
                    }
                    else {
                        $display=true;
                        $_GLOBALS['message']="Enter the Test Code First!";
                    }
                }
      
  }
  
  
  
  
  
  
  /*  Student test */
  
    function studenttest(){
        
        
        global $db;
        global $_GLOBALS;
        
        
            
     if (!isset($_SESSION['stdname'])) {
        $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
     }
    
      else if (isset($_SESSION['starttime'])) {
         relocateHeader('testconducter.php');
      }

     else if (isset($_REQUEST['logout'])) {
         logout('');
      }

     else if (isset($_REQUEST['dashboard'])) {
         relocateHeader('stdwelcome.php');
     }

      else if (isset($_REQUEST['starttest'])) {
    
        if (!empty($_REQUEST['tc'])) {
            
            $result = $db->query("select testcode as tcode from test where testid=" . $_SESSION['testid'] . ";");

            if($r = mysql_fetch_array($result)) {
                if(strcmp(htmlspecialchars_decode($r['tcode'], ENT_QUOTES), htmlspecialchars($_REQUEST['tc'], ENT_QUOTES)) != 0) {
                    $display = true;
                    $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
                 }
            
                else{
                    
                 $result= $db->query("select * from question where testid=" . $_SESSION['testid'] . " order by qnid;");
                
                    if (mysql_num_rows($result) == 0) {
                        $_GLOBALS['message'] = "Tests questions cannot be selected.Please Try after some time!";
                    }
                
                    else {
                        $error = false;
                        $results= $db->query("select stdid,testid from studenttest");
                           
                           while ($rs=mysql_fetch_array($results)){
                            
                               if($rs['stdid']==$_SESSION['stdid'] && $rs['testid']==$_SESSION['testid']){
                                   $bool=true;
                                   break;
                               }
                            }    
                                
                                
                         if($bool){      
                                
                            $resulta = $db->query("select attemptid from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . ";");
                                while ($ra=mysql_fetch_array($resulta)){

                                    //echo $_SESSION['testid'];
                                   // echo $_SESSION['stdid'];
                                    
                                     $concatids=$_SESSION['stdid'].$_SESSION['testid'];
                                     $concatidsrev= strrev($concatids);
                                      
                                     $revattempt=strrev($ra['attemptid']);
                                     $lengthattempt=strlen($ra['attemptid']);

                                     $position= strpos($revattempt,$concatidsrev);
                                     $finalpos=$lengthattempt-$position;

                                     $att=(int)(substr($ra['attemptid'],$finalpos));  
                                     $att++;
                                     
                                     $attempt=intval($concatids.$att);
                                   //  $attempt=(int)$attempt;
                                  //    $x=$ra['attemptid'];
                                     
                                    
                                  //  if($x<10){
                                  //     $rem=(int)$ra['attemptid']%10;
                                  //      $rem++;
                                  //      $val=(int)$ra['attemptid']/10;
                                  //      $attempt=((int)$val*10+$rem);
                                      //  $attempt=(int)($val.$rem);
                                 //   }
                                    
                                 //   else if($x<100 && $x>9){
                                  //      $rem=(int)$ra['attemptid']%100;
                                 //       $rem++;
                                  //      $val=(int)$ra['attemptid']/100;
                                  //      $attempt=((int)$val*100+$rem);
                                //    }
                                    
                                 //   else if($x<1000 && $x>99){
                                  //      $rem=(int)$ra['attemptid']%1000;
                                 //       $rem++;
                                  //      $val=(int)$ra['attemptid']/1000;
                                  //      $attempt=((int)$val*1000+$rem);
                                  //  }
                                    
                                 //   else if($x<10000 && $x>999){
                                 //       $rem=(int)$ra['attemptid']%10000;
                                 //       $rem++;
                                 // //      $val=(int)$ra['attemptid']/10000;
                                 //       $attempt=((int)$val*10000+$rem);
                                 //   }

                                } 
                                
                          }
                          
                          else{
                               $attempt=$_SESSION['stdid'].$_SESSION['testid'].'1';
                          }
                             
                          $_SESSION['attempt']=$attempt;
                          
                        if(!$db->query("insert into studenttest values(". $_SESSION['stdid'] . "," . $_SESSION['testid'] . ",(select CURRENT_TIMESTAMP),date_add((select CURRENT_TIMESTAMP),INTERVAL (select duration from test where testid=" . $_SESSION['testid'] . ") MINUTE),0,'inprogress',".(int)$attempt.")"))
                               $_GLOBALS['message'] = "error" . mysql_error();

                       
                        
                        else{
                                while($r = mysql_fetch_array($result)){
                                    
                                  //  $query="insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL,".$_SESSION['attempt'].")";
                                 //   echo $query;
                                    
                                  if (!$db->query("insert into studentquestion values(" . $_SESSION['stdid'] . "," . $_SESSION['testid'] . "," . $r['qnid'] . ",'unanswered',NULL,".$_SESSION['attempt'].")")) {
                                     
                                     
                                      echo $_SESSION['stdid'] . " " . $_SESSION['testid'] . " " . $r['qnid']." ".$_SESSION['attempt'].',';
                                      $_GLOBALS['message'] = "Failure while preparing questions for you.Try again";
                                      $error = true;
                                    }
                                }
                                
                                if ($error==true){
                             
                                } 

                                else {
                                    
                                   // $query="select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";";
                                  //  echo $query;
                                   
                                            
                                    $result = $db->query("select totalquestions,duration from test where testid=" . $_SESSION['testid'] . ";");
                                    $r = mysql_fetch_array($result);
                                    
                                    $_SESSION['tqn'] = htmlspecialchars_decode($r['totalquestions'], ENT_QUOTES);
                                    $_SESSION['duration'] = htmlspecialchars_decode($r['duration'], ENT_QUOTES);
                                    
                                      
                                   // $query2="select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . "and attemptid=" . $_SESSION['attempt'] . ";";
                                  //  echo $query2;
                                    
                                 //  $var= "select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . " and attemptid=" . $_SESSION['attempt'] . ";";
                                 //  echo $var;
                                 //  exit;
                                   
                                   $result = $db->query("select DATE_FORMAT(starttime,'%Y-%m-%d %H:%i:%s') as startt,DATE_FORMAT(endtime,'%Y-%m-%d %H:%i:%s') as endt from studenttest where testid=" . $_SESSION['testid'] . " and stdid=" . $_SESSION['stdid'] . " and attemptid=" . $_SESSION['attempt'] . ";");
                                    $r = mysql_fetch_array($result);
                                    
                                    
                                    $_SESSION['starttime'] = $r['startt'];
                                    $_SESSION['endtime'] = $r['endt'];
                                    $_SESSION['qn'] = 1;
                                    
                                  //  echo $_SESSION['starttime'];
                                  //  echo $_SESSION['endtime'];
                                  //  exit;
                                 //   header('Location: home.php');
                                    relocateHeader('testconducter.php');
                                }
                        }
                        

                        }
                    }
                }
                else {
                    $display = true;
                    $_GLOBALS['message'] = "You have entered an Invalid Test Code.Try again.";
                }

            } 
            else {
                    $display = true;
                    $_GLOBALS['message'] = "Enter the Test Code First!";
                }

          }
           else if (isset($_REQUEST['testcode'])) {

                    $_SESSION['testname'] = $_REQUEST['testcode'];
                }

            else if (isset($_REQUEST['savem'])) {

                if (empty($_REQUEST['cname']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
                    $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
                }

                else {
                    $query = "update student set stdname='" . htmlspecialchars($_REQUEST['cname'], ENT_QUOTES) . "', stdpassword='" . htmlspecialchars($_REQUEST['password'], ENT_QUOTES) . "',emailid='" . htmlspecialchars($_REQUEST['email'], ENT_QUOTES) . "',contactno='" . htmlspecialchars($_REQUEST['contactno'], ENT_QUOTES) . "',address='" . htmlspecialchars($_REQUEST['address'], ENT_QUOTES) . "',city='" . htmlspecialchars($_REQUEST['city'], ENT_QUOTES) . "',pincode='" . htmlspecialchars($_REQUEST['pin'], ENT_QUOTES) . "' where stdid='" . $_REQUEST['student'] . "';";
                    if (!$db->query($query))
                        $_GLOBALS['message'] = mysql_error();
                    else
                        $_GLOBALS['message'] = "Your Profile is Successfully Updated.";
                 }
              $db->_destruct();
           }


    }
    
    
    /**
     * testtake function used when test will be finish 
     * here we are unset the most of functions
     * **/
    
    
    function testaken(){
        
        global $db;
        global $_GLOBALS;
        
            if(!isset($_SESSION['stdname'])) {
             $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
            }
            else if(isset($_REQUEST['logout'])){
                unset($_SESSION['stdname']);
                relocateHeader('index.php');
            }
            else if(isset($_REQUEST['dashboard'])){
                relocateHeader('stdwelcome.php');
            }

            if(isset($_SESSION['starttime'])){
                unset($_SESSION['starttime']);
                unset($_SESSION['endtime']);
                unset($_SESSION['tqn']);
                unset($_SESSION['qn']);
                unset($_SESSION['duration']);

                $db->query("update studenttest set status='over' where testid=".$_SESSION['testid']." and stdid=".$_SESSION['stdid'].". and attemptid=".$_SESSION['attempt'].";");
            }

    }
    
    
        
    /**
     * test category function 
     * category and subjects 
     * **/
    
    function testcategory(){
        
        
         global $db;
        global $_GLOBALS;
        
        
           if (!isset($_SESSION['stdname'])) {
                $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
            }


            else if (isset($_REQUEST['logout'])) {
               unset($_SESSION['stdname']);
               header('Location: index.php');
           }

            else if (isset($_REQUEST['dashboard'])) {
                header('Location: stdwelcome.php');
            }

              if($_SERVER['REQUEST_METHOD']=='POST'){ 

                       if(isset($_POST['submit'])){

                           echo $_POST['subcat'];

                           $_SESSION['testid']=$_POST['subcat'];

                          header('Location: stdtest.php');

                       }


              $db->_destruct();
           }
    }
    
    
    /**
     * test conductor function 
     * question paper and formats 
     * **/
    
    
    function testconductor(){
        
         global $db;
          global $_GLOBALS;
          
        

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

                           if(!$db->query($query)){
                                 $_GLOBALS['message']="Your previous answer is not updated.Please answer once again";
                           }
                          $db->_destruct();
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

                           if(!$db->query($query)){
                           $_GLOBALS['message']="Your previous answer is not updated.Please answer once again";
                           }
                           $db->_destruct();
                       }
                   }


                   if((int)$_SESSION['qn']>1){
                       $_SESSION['qn']=$_SESSION['qn']-1;
                   }

               }

               else if(isset($_REQUEST['fs'])){
                 header('Location: testack.php');
              }


        
    }