<?php
/**
 * Short description for RequestForm.php
 * Created on 2014-05-20
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage RequestForm
 * @package RequestForm
 * @category
 * @version 0.1
 */

use Bluebanner\Core\Model\PurchaseRequest;
use Bluebanner\Core\Model\PurchaseRequestDetail;

class RequestForm extends \BaseForm {
  public function __construct(PurchaseRequest $modelPurchaseRequest, PurchaseRequestDetail $modelPurchaseRequestDetail) {
    $this->modelPurchaseRequest = $modelPurchaseRequest;
    $this->modelPurchaseRequestDetail = $modelPurchaseRequestDetail;
  }

  // @todo
  public function validateRequestStatus($id, $expStatus = null) {
    if (!$expStatus) {
      if ('pending' == $this->modelPurchaseRequest->getStatus($id, Sentry::getUser()->id)) {
        $result['status'] = 'confirmed';
      } else if ('confirmed' == $this->modelPurchaseRequest->getStatus($id, Sentry::getUser()->id)) {
        $result['status'] = 'pending';
      } else {
        throw new Exception('The status only can be confirmed or pending');
      }
    } else {
      if (!$this->modelPurchaseRequest->isIdBelongUser($id, Sentry::getUser()->id)) {
        throw new Exception('You have no power to operate it');
      }
      $result['status'] = $expStatus;
    }

    $result['updated_at'] = date('Y-m-d H:i:s');

    return $result;
  }
}

?>