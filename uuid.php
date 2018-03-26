<?php
set_time_limit(0);
ini_set('memory_limit','512M');
define('mulu'   , str_replace('\\',"/",dirname(__FILE__)).'/');


function p(){
    $args=func_get_args();
    if(count($args)<1){
           echo ("<font color='red'>必须为p()函数提供参数!");
           return;
   }	
   echo '<div style="width:100%;text-align:left"><pre>';

   foreach($args as $arg){
       if(is_array($arg)){  
             print_r($arg);
             echo '<br>';
         }else if(is_string($arg)){
           echo $arg.'<br>';
         }else{
           var_dump($arg);
           echo '<br>';
         }
       }
           echo '</pre></div>';	
}


//远程获取
function qfopen($HTTP_Servr,$kai=1){
   $handle = fopen ($HTTP_Servr, "rb"); //$_SERVER["QUERY_STRING"] ?后网址必须http://
   $contents = ""; 
   do { 
   $data = fread($handle, 10240); 
   if (strlen($data) == 0) { 
   break; 
   } 
   $contents .= $data; 
} while(true); 
   fclose ($handle);

    return  $contents;
}

$_POST['uuid'] = array();
$_POST['uuid2'] = array();
$_POST['max'] = 0;
$_POST['num'] = 0;

function mululiu($dir,$virtual = false){
    $ds = '/';
    $dir = $virtual ? realpath( $dir ) : $dir;
    $dir = substr( $dir, -1 ) == $ds ? substr( $dir, 0, -1) : $dir;
       if (is_dir( $dir ) && $handle = opendir( $dir )){
   
        while ( $file = readdir( $handle )){
                if ( $file == '.' || $file == '..') continue;
                elseif ( is_dir( $dir . $ds . $file)) mululiu( $dir . $ds . $file);
                else{
   
                    $_POST['max']++;
   
   
   
                   $yuanlu = $dir . $ds . $file;
   
                  
                   if( strpos( $file , ".meta") !== false  ){

                    $shuzi = qfopen($yuanlu);
                    preg_match_all('#uid": "(.*)",#',$shuzi,$url_arr);

                    if($url_arr['1']){
                        foreach($url_arr['1'] as $ddd){
                            $_POST['uuid'][] = $ddd;
                        }

                    }

        
   
                     
   
                   }
   
                   
                
                }
                  
          }
   
        closedir( $handle );
        
        return true; 
       } 
   }
   


 function mululiu2($dir,$virtual = false){
    $ds = '/';
    $dir = $virtual ? realpath( $dir ) : $dir;
    $dir = substr( $dir, -1 ) == $ds ? substr( $dir, 0, -1) : $dir;
       if (is_dir( $dir ) && $handle = opendir( $dir )){
   
        while ( $file = readdir( $handle )){

            if ( $file == '.' || $file == '..') continue;
            elseif ( is_dir( $dir . $ds . $file)) mululiu2( $dir . $ds . $file);
            else{

                $_POST['num']++;

                shell_exec("`clear`");

                echo "uuid替换进度 ".(  sprintf("%.3f",($_POST['num']/$_POST['max']*100)) )." %\r\n";

                $yuanlu = $dir . $ds . $file;

                $shuju = qfopen($yuanlu);

                if( strpos( $shuju , "uid") !== false  ){

                    $shuju = str_replace($_POST['uuid'],$_POST['uuid2'],$shuju);
                    file_put_contents( $yuanlu , $shuju );
                }
            }

        }
   
        closedir( $handle );
    
    return true; 
    } 
}






function typeid($zifu){
    $zifu  =str_replace("-","",$zifu);
    $qianwu = substr($zifu,0,5);

    
    $ase64KeyChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";

    $length = strlen($zifu);
    $i  = 5;
    $zi = "";
    while ($i < $length) {
        $hexVal1 = hexdec($zifu[$i]);
        $hexVal2 = hexdec($zifu[$i + 1]);
        $hexVal3 = hexdec($zifu[$i + 2]);
        $zi .=$ase64KeyChars[($hexVal1 << 2) | ($hexVal2 >> 2)];
        $zi .=$ase64KeyChars[(($hexVal2 & 3) << 4) | $hexVal3];
        
        $i += 3;
    }
    return $qianwu.$zi;
}

mululiu(mulu);

/*不能大于五位*/
$QIANZIU = "b11";
$QIANZIUlen = strlen($QIANZIU);

foreach($_POST['uuid'] as $dfd){

    $_POST['uuid2'][] =$QIANZIU.substr($dfd,$QIANZIUlen,strlen($dfd));

}

foreach($_POST['uuid'] as $dfd){
    $_POST['uuid'][]  = typeid($dfd);
    $_POST['uuid2'][] = typeid($QIANZIU.substr($dfd,$QIANZIUlen,strlen($dfd)));
}

mululiu2(mulu);