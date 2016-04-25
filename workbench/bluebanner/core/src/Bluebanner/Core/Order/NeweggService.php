<?php
namespace Bluebanner\Core\Order;

class NeweggService implements NeweggServiceInterface{
	public $file;
	public $separator = ',';

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
     * 解析csv文件
     * @return array 返回订单数组
     */
	public function parseFile()
	{
		$lines = array();
		$result = array();
        ini_set("auto_detect_line_endings", true);
		$handle = @fopen($this->file,"r");
		while ($data = fgetcsv($handle, 0, $this->separator))	// laigw 20100209 导入文件出错，所有数据为Header信息。
		{
		   $lines[] = $data;
		}
		fclose($handle);
		
		$header = array_shift($lines);

        foreach ($lines as $key=>$val)
        {
        	$result[$key] = array_combine($header, $val);
        }

        return $result;
    }
			
}