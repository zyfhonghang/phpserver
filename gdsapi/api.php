<?php
/*
 * 工程入口类，完成工程文件加载
 */ 
ini_set('date.timezone','Asia/Shanghai');
require_once("lib/nusoap.php"); //调用NuSoap
require_once("cwfbase/General.php"); //调用General
require_once("cwfbase/dbconfig.php"); //调用配置信息 
require_once("cwfbase/DBHelper.php"); //调用配置信息
require_once("cwfhandle/hinge.php");//调用任务处理
$server = new soap_server(); //创建soap服务端
$server->configureWSDL("cwf_service"); //配置WSDL
// 避免乱码  
$server->soap_defencoding = 'UTF-8';  
$server->decode_utf8 = false; 
$server->xml_encoding = 'UTF-8';
$namespace = "http://www.w1tj.com"; 
$server->wsdl->schemaTargetNamespace = $namespace; //设置wsdl命名空间为http://www.w1tj.com
$server->register( // 注册Web服务
        'job_dataentry', //定义名称 
        array('name'=>'xsd:string','args'=>'xsd:string','username'=>'xsd:string','appkey'=>'xsd:string','signed'=>'xsd:string','updata'=>'xsd:string'),  //接受参数
        array('return'=>'xsd:string'),  //返回
        $namespace, //命名空间
        false, // soapaction:默认
        'rpc', // 类型: rpc or document
        'encoded', // 参数：encoded（编码）或 literal（文字）
        'A web method of data' //描述
);        
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';                
$server->service($POST_DATA); //将提交的数据传递给soap服务

function job_dataentry($name,$args,$username,$appkey,$signed,$updata) 
{ //服务执行内容，本示例中为显示输入的帐号密码
     
    $check=check_params($name,$args,$appkey,$signed);
    if(!empty($check))
    {
        return $check;
    }
    //进行安全验证
    //判断签名是否正确 md5(参数1+参数2+参数3+' '+私钥)
    
    $nsigned=md5($name.$args.$username.$appkey.'#'.'1f2bf2e032a11fec0ea5d7f9d6a5aa1d');
    if(strcasecmp($nsigned,$signed)!=0)
    {
       return "err:安全验证未通过 $nsigned $signed ".$name.$args.$username.$appkey.'#'.'1f2bf2e032a11fec0ea5d7f9d6a5aa1d';     
    }
  
    $result=run_job($name,$args,$username,$appkey,$updata);
 
    return  General::encrypt(General::Compress($result),'cwfresul');
  //  return  General::encrypt(General::Compress($result), 'cwfresul'); 
}
 /*
             *name    只加密
             *username 只加密
             *args    压缩后加密
             *appkey  只加密
             *update  压缩后加密
             *
             */
function run_job($name,$args,$username,$appkey,$updata)
{
   //执行事件的处理
   //解码参数 
    $tname=General::decrypt($name, "cwfapp11");
    
    //先解密后解压
    $targs= General::Decompress(General::decrypt($args, "cwfapp21")) ;
 
    if(empty($username))
    {
        $tusername="";
    }
    else 
    {
       $tusername =General::decrypt($username, "cwfuser1");
    }
 
    $tappkey=General::decrypt($appkey, "cwfappke");
 
   
    if(empty($updata))
    {
        $tupdata="";
    }
    else 
    {   
        //先解密后解压
        $tupdata=General::Decompress(General::decrypt($updata, "cwfapp31"));
    }
    
  //  return "编码$tname";
    return allot_task($tname,$targs,$tusername,$tappkey,$tupdata);
}
//**检查必填参数
function check_params($name,$args,$appkey,$signed)
{
    if(empty($name))
    {
        return "err:name 不能为空";        
    }
    if(empty($args))
    {
        return "err:args 不能为空";        
    }
    if(empty($appkey))
    {
        return "err:appkey 不能为空";        
    }
    if(empty($signed))
    {
        return "err:signed 不能为空";        
    }
    return "";
}
 
//修改 php.ini（如果是 windows 系统，那么文件在 C 盘，Windows 目录下，假如系统是安装在 C 盘）。
//使用记事本打开 php.ini 查找 date.timezone 去掉前面的分号修改成为：date.timezone = PRC
//重启http服务（如apache2或iis等）即可！
