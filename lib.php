

<?php


function studentSubmit(){
    
    global $db;
     if(strcmp("root",(htmlspecialchars($_REQUEST['name'],ENT_QUOTES)))==0){   
                 
         if(strcmp("root",(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0){  
                       
                   $_SESSION['admname']=htmlspecialchars($_REQUEST['name'],ENT_QUOTES);
                   unset($_GLOBALS['message']);    
                   echo $_REQUEST['name'];
                   echo $_REQUEST['password'];
                   header('Location: admin/admwelcome.php');
               }
          }
          
      else{ 
          
          //echo $db->query("select *,stdpassword as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."' "); 
         $result=$db->query("select *,stdpassword as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."' "); 
        // $result=executeQuery("select *,stdpassword as std from student where stdname='".htmlspecialchars($_REQUEST['name'],ENT_QUOTES)."' and stdpassword='".htmlspecialchars($_REQUEST['password'],ENT_QUOTES)."' ");
           if(mysql_num_rows($result)>0){

             // $r=mysql_fetch_array($result);
               
               $r=$db->fetch_array();
             
              
             if(strcmp(htmlspecialchars($r['std'],ENT_QUOTES),(htmlspecialchars($_REQUEST['password'],ENT_QUOTES)))==0){

                    $_SESSION['stdname']=htmlspecialchars($r['stdname'],ENT_QUOTES);
                    $_SESSION['stdid']=$r['stdid'];
                  
                        if($r['tc']==1){

                          $_SESSION['tcname']=htmlspecialchars($r['stdname'],ENT_QUOTES);
                          $_SESSION['tcid']=$r['stdid'];
                        }
                  
                  unset($_GLOBALS['message']);
                  header('Location: stdwelcome.php');
              }
              
              else{
                  $_GLOBALS['message']="Check Your user name and Password.";
             }
          }
          
          else {
              $_GLOBALS['message']="Check Your user name and Password.";
            }
            
         // closedb();
            $db->_destruct();
       }
    
    
}


function relocateHeader($location){
    
    if($location==''){
           studentSubmit();
      }
      
   else if($location=='register.php') {
       header('Location:'.$location);
    } 
}



///function printmessage(){
//    echo "<div class=\"message\" style='float:right;'><font color='#A80707'><b>".$_GLOBALS['message']."</font></b></div>";
//}





function editprofile(){
    
   // global $db;


    if(!isset($_SESSION['stdname'])){
     $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
    }
 
  else if(isset($_REQUEST['logout'])){
        unset($_SESSION['stdname']);
        unset($_SESSION['tcname']);
        header('Location: index.php');
       }
   
  else if(isset($_REQUEST['dashboard'])){
     header('Location: stdwelcome.php');
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
    
  //return $_GLOBALS['message'];
}
