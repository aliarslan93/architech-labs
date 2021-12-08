<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 7.12.2021
 * Time: 23:24
 */

class Product {

	public $code;
	public $name;
	public $price;

	public function __construct( $code = null, $name = null, $price = null ) {
		$this->code  = $code;
		$this->name  = $name;
		$this->price = $price;
	}


	public function getProduct( $productCode ) {

		if ( array_key_exists( $productCode, PRODUCTS ) ) {
			return new Product( PRODUCTS[ $productCode ]['code'], PRODUCTS[ $productCode ]['name'], PRODUCTS[ $productCode ]['price'] );
		}
	}

	public function getPrice() {
		return $this->price;
	}

	public function setPrice( $price ) {
		$this->price = $price;
	}
}