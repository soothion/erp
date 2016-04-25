<?php
namespace Bluebanner\Core\Order;

class BuyService implements BuyServiceInterface{
	public $file;
	public $separator = "\t";

    public function __construct($config = null) {
	    $this->file = $config;
    }

    /**
     * 获取订单列表
     * @return array 订单列表数组
     */
    public function getOrderList(){	
    	return $this->parseFile();
    }


    /**
     * 格式化TEXT文档
     *
     * @param string $file  文件地址
     * @return void
     */
    public function parseFile()
    {
        $lines = array();
        $result = array();
        
        $handle = @fopen($this->file, "r");
        if ($handle) 
        {
           while (!feof($handle)) 
           {
               $buffer = fgets($handle, 1024 * 10);
               if ($buffer)
               {
                    $lines[] = $buffer;   
               }                   
           }
           fclose($handle);
        }
        
        //取出头部信息
        $header = array_shift($lines);
        $header = $this->parseLine($header);
        
        //取文档内容
        foreach ($lines as $key=>$val)
        {
            $result[$key] = @array_combine($header, $this->parseLine($val));
        }
        return $result;
    }


    /**
     * 将变量以\t符划分，存至数组中
     *
     * @param string $txt   待分割文本
     * @return array
     */
    private function parseLine($txt)  
    {           
        return $result = explode($this->separator, $txt);
    }
			
}