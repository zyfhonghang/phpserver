<?php
/**
 * 公共函数
 * 处理通用的一些操作
 */
final class General
{
    /**
     * 数据压缩方法
     */
 static function Compress($text)
{//数据压缩方法
  $srcCompress=base64_encode(gzencode($text,9));
  return $srcCompress;
}
static function Decompress($text)
{//数据解压方法
    $dString=base64_decode($text);
    $newString=gzdecode($dString);
    return $newString;
} 
static function encrypt($string,$key) {
        //加密方法 
        $cipher_alg = MCRYPT_TRIPLEDES;
        //初始化向量来增加安全性 
        $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
         
        //开始加密 
        $encrypted_string = mcrypt_encrypt($cipher_alg, $key, $string, MCRYPT_MODE_ECB, $iv); 
        return base64_encode($encrypted_string);//转化成16进制
//        return $encrypted_string;
    }
 static function decrypt($string,$key) {
     //解密方法
            $vstring = base64_decode($string);
            //加密方法 
            $cipher_alg = MCRYPT_TRIPLEDES;
            //初始化向量来增加安全性 
            $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
             
            //开始解密 
            $decrypted_string = mcrypt_decrypt($cipher_alg, $key, $vstring, MCRYPT_MODE_ECB, $iv); 
            return trim($decrypted_string);
     }
     /**
      * 语句中的##变量替换函数
      * @param type $tsql
      * @param type $args
      * @param type $username
      * @return type
      */
     static function cwfparsesql($tsql,$args,$username)
{
         $fsql=General::parsesql($tsql,$args);
         $fsql=str_ireplace('#cwfuser#',$username,$fsql);
         return $fsql;
     }
     /**
      *  解析SQL语句中的变量
      * @param type $tsql
      * @param type $args
      * @return type
      */
static function parsesql($tsql,$args)
{
       $w= explode('[##]',$args);  //拆分为字符串数组
       foreach($w as $y)
       { 
              $fh='\'';
              $fh2='\',\'';
             $csm= substr($y,1,strpos($y,$fh2)-1) ;
             //单引号的问题 
             $csz= str_ireplace($fh,$fh.$fh, substr($y,strpos($y,$fh2)+3,strlen($y)-strpos($y,$fh2)-4)); 
             //General::writelog('parsesql.log',$y);
             //General::writelog('parsesql.log',$csz);
             $tsql=str_ireplace('#'.$csm.'#',$csz,$tsql); 

       } 
       return $tsql;
}
     /**
      * 记录日志到文件中
      * @param type $logfile
      * @param type $content
      * @return type
      */
static function writelog($logfile,$content)
{
    return  file_put_contents($logfile, $content."\r\n",FILE_APPEND);
}
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

