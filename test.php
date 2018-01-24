<?php 

require_once('./src/php/Factory.php');
require_once('./src/php/Inventory.php');
require_once('./src/php/Stock.php');

$applicationId = 'b933a143-a9dc-4051-a7be-81af2690e199';
$applicationSecret = '80cc5f08-3060-45bc-8899-8fe0c72abdbc';
$token = '88878dfdc49bbd8dbb8305192a4f8558';

$authString = 'applicationId=' . $applicationId . '&applicationSecret=' . $applicationSecret . '&token=' . $token;

$authorization = json_decode(Factory::GetResponse("Auth/AuthorizeByApplication", $authString, "", "https://api.linnworks.net/"));
// $StockItemsFull = json_decode(Factory::GetResponse("Stock/GetStockItemsFull","keyword=PEN&loadCompositeParents=true&loadVariationParents=true&entriesPerPage=1&pageNumber=1&dataRequirements=[1,2]&searchTypes=[SKU]",$authorization->Token,"https://api.linnworks.net/"));

$apiToken = $authorization->Token;
$apiServer = "https://api.linnworks.net/";

$Inventory = new InventoryMethods();
$Stock = new StockMethods();

$stockitems = $Stock->GetStockItemsFull('',false,false,100,1,$a = array(0, 0),$b = array(0, 0),$apiToken, $apiServer);

$getCategories = $Inventory->GetCategories($apiToken, $apiServer);

echo "<h1>Test</h1>";


echo "applicationId: "; echo $applicationId; echo "<br/>";
echo "applicationSecret: "; echo $applicationSecret; echo "<br/>";
echo "token: "; echo $token; echo "<br/>";
echo "authString: "; echo $authString; echo "<br/>";


echo "authorization: "; echo print_r($authorization); echo "<br/>";

echo "getCategories: "; echo "<pre>"; print_r($getCategories); echo "</pre>";

echo "StockItemsFull: "; echo "<pre>"; print_r($stockitems); echo "</pre>";

?>