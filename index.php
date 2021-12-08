<?php
//Include All Model File
foreach ( glob( "Model/*.php" ) as $filename ) {
	require_once $filename;
}
define( 'PRODUCTS', array(
	'R01' => array(
		"code"  => "R01",
		"name"  => "Red Widget",
		"price" => 32.95
	),
	'G01' => array(
		"code"  => "G01",
		"name"  => "Green Widget",
		"price" => 24.95
	),
	'B01' => array(
		"code"  => "B01",
		"name"  => "Blue Widget",
		"price" => 7.95
	)
) );
define( 'DELIVERY_RULES', array(
	array(
		"amount" => 50,
		"cost"      => 4.95
	),
	array(
		"amount" => 90,
		"cost"      => 2.95
	),
) );
$basket = new Basket();

$basket->add( 'B01' );
$basket->add( 'B01' );
$basket->add( 'R01' );
$basket->add( 'R01' );
$basket->add( 'R01' );

//buy one red widget,get the second half price
$basket->addPromotion( 'R01', 2, 50 );
$cart_amount = $basket->checkoutCart();

