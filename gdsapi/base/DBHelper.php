<?php

/*
 * 数据库操作类
 * 用于执行SQL语句获取数据
 */
class dbhelper { 
	/** 
     * 返回多行记录 
     * @param  $sql 
     * @param  $parameters 
     * @return  记录数据 
     */ 
    public function queryrows($sql, $parameters = null) 
    {  
    	return $this->exequery($sql, $parameters); 
    } 
    public function queryjson($sql, $parameters = null)
    {
         $mydt=$this->queryrows($sql,$parameters);
         $str=json_encode($mydt, JSON_UNESCAPED_UNICODE);  
         return  $str;
    }
     public function queryjsons($sql) 
     {
          $str="";
          $stmt=$this->runquery($sql);
          do{
             
              try
              {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);//update语句报错
            
            if ($rows) 
            {
                if(empty($str))
                {
                 $str = json_encode($rows, JSON_UNESCAPED_UNICODE);
            }
            else
            {
                    $str =$str.'┿'.json_encode($rows, JSON_UNESCAPED_UNICODE);
            }
                }
              }
 catch (Exception $e)
 {}
          } while ($stmt->nextRowset());
          return $str;
      }
      
    /** 
     * 返回为单条记录 
     * @param  $sql 
     * @param  $parameters 
     * @return 
     */ 
    public function queryrow($sql, $parameters = null) { 
        $rs = $this->exequery($sql, $parameters); 
        if (count($rs) > 0) 
            { 
            return $rs[0]; 
        } else { 
            return null; 
        } 
    } 
 
    /** 
     * 查询单字段，返回整数 
     * @param  $sql 
     * @param  $parameters 
     * @return 
     */ 
    public function queryforint($sql, $parameters = null) { 
        $rs = $this->exequery($sql, $parameters); 
        if (count($rs) > 0) { 
            return intval($rs[0][0]); 
        } else { 
            return null; 
        } 
    } 
 
    /** 
     * 查询单字段，返回浮点数(float) 
     * @param  $sql 
     * @param  $parameters 
     * @return 
     */ 
    public function queryforfloat($sql, $parameters = null) { 
        $rs = $this->exequery($sql, $parameters); 
        if (count($rs) > 0) { 
            return floatval($rs[0][0]); 
        } else { 
            return null; 
        } 
    } 
 
    /** 
     * 查询单字段，返回浮点数(double) 
     * @param  $sql 
     * @param  $parameters 
     * @return 
     */ 
    public function queryfordouble($sql, $parameters = null) { 
        $rs = $this->exequery($sql, $parameters); 
        if (count($rs) > 0) { 
            return doubleval($rs[0][0]); 
        } else { 
            return null; 
        } 
    } 
 
    /** 
     * 查询单字段，返回对象，实际类型有数据库决定 
     * @param  $sql 
     * @param  $parameters 
     * @return 
     */ 
    public function queryforobject($sql, $parameters = null) { 
        $rs = $this->exequeryall($sql, $parameters); 
        if (count($rs) > 0) 
            {  
             // print_r( $rs[0]);
             // echo $rs[0]["news_name"];
            return $rs[0][0]; 
        } else 
            { 
            return null; 
        } 
    } 
     public function exequeryall($sql, $parameters = null) { 
        $conn = $this->getconnection(); 
        $stmt = $conn->prepare($sql); 
        $stmt->execute($parameters); 
        $rs = $stmt->fetchall(PDO::FETCH_BOTH); 
      //  $rs = $stmt->fetchall(PDO::FETCH_NAMED); 
        
        $stmt = null; 
        $conn = null; 
        return $rs; 
    } 
    /** 
     * 执行一条更新语句.insert / upadate / delete 
     * @param  $sql 
     * @param  $parameters 
     * @return  影响行数 
     */ 
    public function update($sql, $parameters = null) { 
        return $this->exeupdate($sql, $parameters); 
    } 
 /**
  * 创建数据库连接对象
  * @return \pdo
  */
    private function getconnection() { 
        $conn = new pdo(dbconfig::getdsn(), dbconfig::getusername(), dbconfig::getpassword()); 
         $conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); 
           // 设置 PDO 错误模式为异常 ，用于抛出异常
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("SET NAMES utf8");
        return $conn;
    } 
    /**
     *  返回数据 ，列名不允许重复，只返回第一个
     * @param type $sql
     * @param type $parameters
     * @return type
     */
    public function exequery($sql, $parameters = null) { 
        $conn = $this->getconnection(); 
        $stmt = $conn->prepare($sql); 
        $stmt->execute($parameters); 
        $rs = $stmt->fetchall(PDO::FETCH_ASSOC); 
      //  $rs = $stmt->fetchall(PDO::FETCH_NAMED); 
        
        $stmt = null; 
        $conn = null; 
        return $rs; 
    } 
    
    public function runquery($sql) 
    {
       $conn = $this->getconnection(); 
       $stmt=$conn->query($sql); 
       return $stmt;
       //$rs = $stmt->fetchall(PDO::FETCH_ASSOC);
        //    $stmt = null; 
        //$conn = null; 
        //  return $rs; 
    }
    /**
    * 返回行数
    * @param type $sql
    * @param type $parameters
    * @return type
    */
    private function exeupdate($sql, $parameters = null) { 
        $conn = $this->getconnection(); 
        $stmt = $conn->prepare($sql); 
        $stmt->execute($parameters); 
        $affectedrows = $stmt->rowcount(); 
        $stmt = null; 
        $conn = null; 
        return $affectedrows; 
    } 
}
 
 