<?php
/**
 * Short description for OrderService.php
 * Created on 2014-04-22
 * @author <a href="mailto:chongwish@gmail.com">chongwish</a>
 * @subpackage OrderService
 * @package OrderService
 * @category
 * @version 0.1
 */

namespace Bluebanner\Core\Purchase;

use Bluebanner\Core\Model\PurchaseOrder;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface {

  public function __construct(PurchaseOrder $modelPurchaseOrder) {
    $this->modelPurchaseOrder = $modelPurchaseOrder;
  }

  /**
   * @return string like: P12121212
   */
  public function genInvoice() {
    $prefix = 'P';
    $today = date('ymd');

    $invoices = DB::table($this->modelPurchaseOrder->getTbl())->where('invoice', 'like', $prefix . $today . '%')->lists('invoice');

    $suffix = count($invoices) + 1;
    $result = $prefix . $today . str_pad($suffix, 2, '0', STR_PAD_LEFT);

    while (in_array($result, $invoices)) {
      $suffix += 1;
      $result = $prefix . $today . str_pad($suffix, 2, '0', STR_PAD_LEFT);
    }

    return $result;
  }

  public function assignInventory(array $qtys, $allQty) {
    $result = array();
    $orgAllQty = array_sum($qtys);
    
    if ($allQty == $orgAllQty) {
      while (current($qtys)) {
        $result[key($qtys)]['qty_free'] = 0;
        next($qtys);
      }
      return $result;

    } else if ($allQty < $orgAllQty) {
      $minQty = current($qtys);

      foreach ($qtys as $qty) {
        if ($minQty > $qty) {
          $minQty = $qty;
        }
      }

      if (floor($allQty / $orgAllQty * $minQty) == 0) {
        throw new \Exception('qty must be larger than ' . ceil($orgAllQty / $minQty));
      }

      $countQty = 0;
      foreach ($qtys as $key => $qty) {
        $result[$key]['qty_confirmed'] = floor($allQty / $orgAllQty * $qty);
        $countQty += $result[$key]['qty_confirmed'];
        $result[$key]['qty_free'] = 0;
      }
      $result[$key]['qty_confirmed'] += $allQty - $countQty;

    } else {
      $countQty = 0;
      foreach ($qtys as $key => $qty) {
        $result[$key]['qty_confirmed'] = floor($allQty / $orgAllQty * $qty);
        $countQty += $result[$key]['qty_confirmed'];
        $result[$key]['qty_free'] = $result[$key]['qty_confirmed'] - $qty;
      }
      $result[$key]['qty_confirmed'] += $allQty - $countQty;
      $result[$key]['qty_free'] = $result[$key]['qty_confirmed'] - $qty;
    }

    return $result;
  }

  public function parsePrice($prices, $qty, $type = 'normal', $count = 0) {
    $result = array('tax_unit_price' => 0, 'usd_unit_price' => 0, 'unit_price' => 0);

    switch ($type) {
      case 'usd':
      case 'USD':
        $price = $result['usd_unit_price'] = $prices['usd_unit_price'];
        break;
      case 'tax':
      case 'TAX':
        $price = $result['usd_unit_price'] = $prices['tax_unit_price'];
        break;
      case 'normal':
      case 'NORMAL':
        $price = $result['unit_price'] = $prices['unit_price'];
        break;
      default:
        throw new \Exception('No such type of price');
    }

    $result['total'] = $price * $qty - $count;

    return $result;
  }
}

?>