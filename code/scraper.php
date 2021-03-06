<?php 
include('htmlParser.php');
$pizzas = [];
for ($j=1; $j <= 16; $j++) { 
	$html = str_get_html(file_get_contents("http://pizzapronto-odense.dk/menu.php?cats=$j"));
	foreach ($html->find('tr.product-row') as $pizza) { 
		$sizes = [];
		foreach ($pizza->children[1]->children as $size) {
			if($size->attr["class"] === "product-prices-content"){
				$sizes[] = array(
					'name' => utf8_encode($size->children[0]->children[0]->children[0]->children[0]->nodes[0]->_[4]),
					'price' => floatval($size->children[0]->children[0]->children[1]->children[0]->nodes[0]->_[4]) 
				);
			}
		}
		$toppings = [];
		foreach ($pizza->children[0]->children[1]->children as $topping) {
			$toppings[] = utf8_encode(strtolower(preg_replace('/[.,\s]+/', '',$topping->nodes[0]->_[4])));
		}
		$pizzas[] = array(
			'name' => utf8_encode($pizza->children[0]->children[0]->children[1]->nodes[0]->_[4]),
			'number' => $pizza->children[0]->children[0]->children[0]->nodes[0]->_[4],
			'topping' => $toppings,
			'size' => $sizes
		);
	}
}

//header('Content-Type: application/json');
//echo json_encode($pizzas);
file_put_contents("pizza.json", json_encode($pizzas))
?>