<?php
 /*
  * 数据相关的操作
  * 业务中用到的函数
*/
function WT_CMS_User($name,$args,$username,$appkey,$updata)
{
    $sql='SELECT * FROM feifeicom.ff_admin limit 0,100'; 
    $dbt=new dbhelper(); 
    $str=$dbt->queryjson($sql,null);  
    $dbt=null;
    return  $str;
}
function WT_CMS_001($name,$args,$username,$appkey,$updata)
{
    $sql='SELECT list_id,list_name,list_skin FROM feifeicom.ff_list'; 
    $dbt=new dbhelper();
      $str=$dbt-> queryjsons($tsql); 
      $dbt=null;
    return $str;
}
function WT_CMS_Newslist($name,$args,$username,$appkey,$updata)
{
    $sql='select news_id,news_name,news_ename,news_keywords,news_type,news_pic,news_pic_bg,news_pic_slide,news_inputer,news_reurl,news_remark,news_content from ff_news order by news_id desc limit 0,200'; 
    $dbt=new dbhelper();
    $str=$dbt-> queryjsons($sql); 
    $dbt=null;
    return $str;
}
function WT_CMS_Newslist01($name,$args,$username,$appkey,$updata)
{ 
    $sql='select news_id,news_name,news_reurl from ff_news order by news_id desc limit #pageindex#,#rowcount#;'; 
    $tsql= General::parsesql($sql, $args); 
    $file='WT_CMS_Newslist01.log'; 
     General::writelog($file, $tsql);
    $dbt=new dbhelper();
    $str=$dbt->queryjsons($tsql); 
    $dbt=null;
    return $str;
}
function WT_CMS_NewsAdd1($name,$args,$username,$appkey,$updata)
{
     $file  = 'sqlrun.log'; 
    General::writelog($file, $args);
    $sql='insert into ff_news(news_cid,news_name,news_reurl,news_content)select 6,\'#标题#\',\'#来源#\',\'#内容#\' from ff_news where not EXISTS(select 1 from ff_news where news_reurl=\'#来源#\') limit 0,1;select row_count();'; 
    $tsql= General::parsesql($sql, $args); 
    General::writelog($file, $tsql); 
    $dbt=new dbhelper();
    $str=$dbt-> queryjsons($tsql); 
    $dbt=null;
    return $str;
}



