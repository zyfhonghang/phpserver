<?php
/*
 * 平台级处理函数
 */
require_once("cmsdata.php"); //调用General
function allot_task($name,$args,$username,$appkey,$updata)
{
      $result=$name;
   
      if(is_callable($result))
      { 
          $var=$result($name,$args,$username,$appkey,$updata);
          return $var;
      }
 else {
          return runworktable($name,$args,$username,"selectsql");
      }
    return "编码$tname 参数$targs 账号$tusername 主键$tappkey 数据$tupdata";
}
function runworktable($name,$args,$username,$filedname)
{
    $wsql="select $filedname from cwfsys_worktable where objname='$name'";
    $dbt=new dbhelper();
    $tsql=$dbt->queryforobject($wsql);//获取SQL语句
    if(empty($tsql))
    {
        return "$name $filedname 没有设置对应的执行语句";
    }
    $tsql= General::cwfparsesql($tsql, $args,$username); 
    $str=$dbt->queryjsons($tsql); 
    $dbt=null;
    return $str;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

