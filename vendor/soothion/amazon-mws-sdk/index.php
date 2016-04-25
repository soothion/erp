<?php
require 'vendor/autoload.php';

$serviceUrl = "https://mws.amazonservices.com";

define ('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');
define('AWS_ACCESS_KEY_ID', 'YOUR_AWS_ACCESS_KEY_ID');
define('AWS_SECRET_ACCESS_KEY', 'YOUR_AWS_SECRET_ACCESS_KEY');
define('APPLICATION_NAME', 'YOUR_APPLICATION_NAME');
define('APPLICATION_VERSION', '2010-10-01');
define ('MERCHANT_ID', 'YOUR_MERCHANT_ID');

$config = array (
  'ServiceURL' => $serviceUrl,
  'ProxyHost' => null,
  'ProxyPort' => -1,
  'MaxErrorRetry' => 3,
);

/************************************************************************
 * Instantiate Implementation of MarketplaceWebService
 * 
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
 * are defined in the .config.inc.php located in the same 
 * directory as this sample
 ***********************************************************************/
 $service = new MarketplaceWebService_Client(
     AWS_ACCESS_KEY_ID, 
     AWS_SECRET_ACCESS_KEY, 
     $config,
     APPLICATION_NAME,
     APPLICATION_VERSION);
 
/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebService
 * responses without calling MarketplaceWebService service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebService/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebService_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out 
 * sample for Get Report List Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebService_Model_GetReportListRequest
 // object or array of parameters
$parameters = array (
  'Merchant' => MERCHANT_ID,
  'AvailableToDate' => new DateTime('2014-09-10', new DateTimeZone('UTC')),
  'AvailableFromDate' => new DateTime('2014-09-01', new DateTimeZone('UTC')),
  'ReportTypeList' => array('Type'=> array('_GET_FLAT_FILE_ALL_ORDERS_DATA_BY_LAST_UPDATE_')),
  'Acknowledged' => false, 
);

$request = new MarketplaceWebService_Model_GetReportListRequest($parameters);

// $request = new MarketplaceWebService_Model_GetReportListRequest();
// $request->setMerchant(MERCHANT_ID);
// $request->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
// $request->setAvailableFromDate(new DateTime('-3 months', new DateTimeZone('UTC')));
// $request->setAcknowledged(false);
 
invokeGetReportList($service, $request);

/**
  * Get Report List Action Sample
  * returns a list of reports; by default the most recent ten reports,
  * regardless of their acknowledgement status
  *   
  * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
  * @param mixed $request MarketplaceWebService_Model_GetReportList or array of parameters
  */
  function invokeGetReportList(MarketplaceWebService_Interface $service, $request) 
  {
      try {
              $response = $service->getReportList($request);
              
                echo ("Service Response\n");
                echo ("=============================================================================\n");

                echo("        GetReportListResponse\n");
                if ($response->isSetGetReportListResult()) { 
                    echo("            GetReportListResult\n");
                    $getReportListResult = $response->getGetReportListResult();
                    if ($getReportListResult->isSetNextToken()) 
                    {
                        echo("                NextToken\n");
                        echo("                    " . $getReportListResult->getNextToken() . "\n");
                    }
                    if ($getReportListResult->isSetHasNext()) 
                    {
                        echo("                HasNext\n");
                        echo("                    " . $getReportListResult->getHasNext() . "\n");
                    }
                    $reportInfoList = $getReportListResult->getReportInfoList();
                    foreach ($reportInfoList as $reportInfo) {
                        echo("                ReportInfo\n");
                        if ($reportInfo->isSetReportId()) 
                        {
                            echo("                    ReportId\n");
                            echo("                        " . $reportInfo->getReportId() . "\n");
                        }
                        if ($reportInfo->isSetReportType()) 
                        {
                            echo("                    ReportType\n");
                            echo("                        " . $reportInfo->getReportType() . "\n");
                        }
                        if ($reportInfo->isSetReportRequestId()) 
                        {
                            echo("                    ReportRequestId\n");
                            echo("                        " . $reportInfo->getReportRequestId() . "\n");
                        }
                        if ($reportInfo->isSetAvailableDate()) 
                        {
                            echo("                    AvailableDate\n");
                            echo("                        " . $reportInfo->getAvailableDate()->format(DATE_FORMAT) . "\n");
                        }
                        if ($reportInfo->isSetAcknowledged()) 
                        {
                            echo("                    Acknowledged\n");
                            echo("                        " . $reportInfo->getAcknowledged() . "\n");
                        }
                        if ($reportInfo->isSetAcknowledgedDate()) 
                        {
                            echo("                    AcknowledgedDate\n");
                            echo("                        " . $reportInfo->getAcknowledgedDate()->format(DATE_FORMAT) . "\n");
                        }
                    }
                } 
                if ($response->isSetResponseMetadata()) { 
                    echo("            ResponseMetadata\n");
                    $responseMetadata = $response->getResponseMetadata();
                    if ($responseMetadata->isSetRequestId()) 
                    {
                        echo("                RequestId\n");
                        echo("                    " . $responseMetadata->getRequestId() . "\n");
                    }
                } 

     } catch (MarketplaceWebService_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
     }
 }
                                                                                

?>