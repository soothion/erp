<?php
namespace Bluebanner\Core\Item;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Bluebanner\Core\Model\RequestQueue;
use Bluebanner\Core\Model\RequestQueueError;
use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;
use Bluebanner\Core\Model\Item;
use Bluebanner\Core\Model\Platform;

class FileNotFoundException extends \Exception {
}

;
class FileExtensionNotSupportedException extends \Exception {
};
class FileInvalidateException extends \Exception {
};

class RequestService implements RequestServiceInterface {

	protected $qid;

	protected $file;

	private static $categories;

	public function setQueueId($id) {
		$this -> qid = $id;
	}

	public function getQueueId() {
		return $this -> qid;
	}

	public function setUploadFilePath($path) {
		$this -> file = $path;
	}

	public function getUploadFilePath() {
		return $this -> file;
	}

	public function handler() {
		if (!$this -> validate())
			throw new FileInvalidateException('file can not pass validation.');

		$data = \Excel::excel2Array($this -> getUploadFilePath());
		$rows = array_splice($data[0], 2);
		$queue = RequestQueue::find($this -> qid);
		$dataModel = array();
		if (is_array($rows)) {
			foreach ($rows as $k => $row) {
			    if($row[0][0]==""){break;}  //排除excel清除内容后，还保存格式的表格
				if ($item = Item::where('sku', '=', $row[0][0]) -> first()) {

					$dataModel[$k]['item_id'] = $item -> id;
					if ($platform = Platform::where('name', '=', $row[0][2]) -> first()) {
						$dataModel[$k]['platform_id'] = $platform -> id;
					} else {
						$queue -> increment('error', 1);
						$this -> errorLogBuild($queue -> id, $row[0][0], "请核对此sku的渠道" . $row[0][2] . "是否存在");
					}
					if ($row[0][1] <= 0) {
						$queue -> increment('error', 1);
						$this -> errorLogBuild($queue -> id, $row[0][0], "请核对此sku的数量是否为正整数");
					} else {
						$dataModel[$k]['qty'] = $row[0][1];
					}
					
					if (time()>= strtotime($row[0][3])) {
						$queue -> increment('error', 1);
						$this -> errorLogBuild($queue -> id, $row[0][0], "请核对此sku的时间是否大于今天");
					} else {
						$dataModel[$k]['end_date'] = date("Y-m-d h:i:s",strtotime($row[0][3]));
					}
                    $dataModel[$k]['request_id'] = $queue->request_id;
					  $queue -> increment('total', 1);
				} else {
					$queue -> increment('error', 1);
				    $queue -> increment('total', 1);
					$this -> errorLogBuild($queue -> id, $row[0][0], "请核对sku" . $row[0][0] . "是否存在");
					echo "error";
				}
				//校对渠道准确性
			}
           $queue = RequestQueue::find($this -> qid);
          if($queue->error==0){
        	 $this->AddDetailData($dataModel);
			 $queue -> update(array('total' => count($dataModel)));
			 $queue->increment('approved', count($dataModel));
			 echo "success";
        }
		  
		}
       
    
	}

	public function validate() {
		// check if exists
		if (!file_exists($this -> getUploadFilePath()))
			throw new FileNotFoundException('file can not found in path:' . $this -> getUploadFilePath());

		// check extension
		if (!in_array(\File::extension($this -> getUploadFilePath()), array('xlsx', 'xls')))
			throw new FileExtensionNotSupportedException('only support xlsx, xls');

		return true;

	}

	private function errorLogBuild($qid, $row, $des) {
		RequestQueueError::create(array('queue_id' => $qid, 'content' => $row, 'desc' => $des));
	}

	private function AddDetailData($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				PurchaseRequestDetail::create($value);
			}
		}
	}

}
