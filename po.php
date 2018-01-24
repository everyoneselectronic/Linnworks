<?php 

require_once('./src/php/Factory.php');
require_once('./src/php/Auth.php');
require_once('./src/php/Dashboards.php');
require_once('./src/php/Inventory.php');
require_once('./src/php/Stock.php');
require_once('./src/php/PurchaseOrder.php');

$auth = new AuthMethods();

$applicationId = 'b933a143-a9dc-4051-a7be-81af2690e199';
$applicationSecret = '80cc5f08-3060-45bc-8899-8fe0c72abdbc';
$token = '88878dfdc49bbd8dbb8305192a4f8558';


$authorization = $auth->AuthorizeByApplication($applicationId,$applicationSecret,$token);
$apiToken = $authorization->Token;
$apiServer = "https://api.linnworks.net/";

$PurchaseOrder = new PurchaseOrderMethods();
$Dashboards = new DashboardsMethods();
$Inventory = new InventoryMethods();
$Stock = new StockMethods();

$lowStock = $Dashboards->GetLowStockLevel('',10,$apiToken, $apiServer);

$sid = array('key' => '100001' );
$item = $Stock->GetStockItemsByKey($sid,$apiToken, $apiServer);
$itemID = $item[0]->StockItemId;

$sup = $Inventory->GetSuppliers($apiToken, $apiServer);
$loc = $Inventory->GetStockLocations($apiToken, $apiServer);

echo "<h1>Test</h1>";
echo "applicationId: "; echo $applicationId; echo "<br/>";
echo "applicationSecret: "; echo $applicationSecret; echo "<br/>";
echo "token: "; echo $token; echo "<br/><br/>";

echo "authorization: "; echo print_r($authorization); echo "<br/><br/>";

echo "lowStock: "; echo "<pre>"; print_r($loc); echo "</pre>";

// echo $lowStock[0]["ItemTitle"];
$currentTime = $auth->GetServerUTCTime();

// need to get all item parameters make functions
$createParameters = array(
  'fkSupplierId' => '5d1f3893-dad8-4653-befc-a982d21c07b4',
  'fkLocationId' => '00000000-0000-0000-0000-000000000000',
  'ExternalInvoiceNumber' => 'sample string 3',
  'Currency' => 'GBP',
  'SupplierReferenceNumber' => 'sample string 9',
  'DateOfPurchase' => $currentTime,
  'QuotedDeliveryDate' => '2018-01-24T15:47:17.0730815Z',
  'PostagePaid' => 3.0,
  'ShippingTaxRate' => 4.0,
  'ConversionRate' => 5.0
);

$po = $PurchaseOrder->Create_PurchaseOrder_Initial($createParameters,$apiToken, $apiServer);

// echo "po: "; echo "<pre>"; print_r($po); echo "</pre>";

// need to get all item parameters make functions
// min qty, pack size to make valid order
$addItemParameter = array(
  "pkPurchaseId" => $po,
  "fkStockItemId" => $itemID,
  "Qty" => 10,
  "PackQuantity" => 1,
  "PackSize" => 1,
  "Cost" => 1.0,
  "TaxRate" => 0.0
);

$addItem = $PurchaseOrder->Add_PurchaseOrderItem($addItemParameter,$apiToken, $apiServer);
echo "item: "; echo "<pre>"; print_r($addItem); echo "</pre>";


?>

<!-- 

get low stock items
sort items into suupliers
generate suuplier po's
add items
generate pdfs
email suupliers
colse any po stuff

gui
errr report emails sent

 -->