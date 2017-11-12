 <?php
        // put your code here
        require_once("cwfbase/General.php"); //调用General
        $name='DUmf7lMbc1LP6fh4L7H6LA=='; 
          $tname=General::decrypt($name, "cwfapp11");
          echo $tname;
        $args='SjA95BGjqxaXZqpXAC3z1yNI1LnUCluosVf3Tg50CYvoFnz5aHNm30PUKR9PFNjn';
        echo '<br>解密:';
        echo   General::decrypt($args, "cwfapp21");
  //先解密，后解压
        $targs= General::Decompress(General::decrypt($args, "cwfapp21")) ;
         echo '<br>targs:'; 
        echo $targs;
       
        $username='CVVASs7YEEQ=';
         $tusername =General::decrypt($username, "cwfuser1");
         echo '<br>用户信息';
        echo $tusername;
         
        $apkey='omVNSXtuU5SAzfLT7/rlbA==';
          $tappkey=General::decrypt($apkey, "cwfappke");
              echo '<br>appkey:';
        echo $tappkey;
            
        $update='SjA95BGjqxbBklE6Xv3bApQVKZz5drC6IX0V11iCMEUSXonZxJGKdA==';
       //echo  General::decrypt($update, "cwfapp31");
           echo '<br>updata解密:';
         echo  General::decrypt($update, "cwfapp31");
         $tupdata=General::Decompress(General::decrypt($update, "cwfapp31"));
            echo '<br>updata解压:';
       echo $tupdata;
    $result=  'a:1;b:2;c:4;';
         echo '<br>结果压缩加密:';
$jjs=  General::encrypt(General::Compress($result),'cwfresul');
echo $jjs;
           echo '<br>解密:';
echo General::decrypt($jjs,'cwfresul');
  echo '<br>再压缩:';
echo  General::Compress($jjs);
         echo '<br>结果:';
echo General::Decompress( General::decrypt($jjs,'cwfresul'));

        ?>
 