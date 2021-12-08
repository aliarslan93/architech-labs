<?php

/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 8.12.2021
 * Time: 00:12
 */
include 'Product.php';

class Basket extends Product {
	/**
	 * @var int
	 */
	private $total = 0;
	/**
	 * @var array
	 */
	protected $cart_items = array();
	/**
	 * @var array()
	 */
	protected $promotions = array();

	/**
	 * @param string $product_code
	 */
	public function add( $product_code ) {
		$this->cart_items[] = $this->getProduct( $product_code );
	}

	/**
	 * @param $product_code
	 * @param $unit
	 * @param $discount
	 */
	public function addPromotion( $product_code, $unit, $discount ) {
		$this->promotions[ $product_code ] = array(
			'code'     => $product_code,
			'unit'     => $unit,
			'discount' => $discount
		);
	}

	/**
	 * @param $products Product
	 * @param $promotions array
	 *
	 * @return mixed
	 */
	public function checkPromotion( $products, $promotions ) {


		foreach ( $products as $product ) {
			if ( array_key_exists( $product->code, $promotions ) ) {
				$promotions[ $product->code ]['unit'] --;
				if ( $promotions[ $product->code ]['unit'] > 1 ) {
					return $this->checkPromotion( $products, $promotions );
				}
				if ( $promotions[ $product->code ]['unit'] == 0 ) {
					$product->setPrice( ( $product->price * $promotions[ $product->code ]['discount'] ) / 100 );
				}

			}
		}
	}

	public function checkoutCart() {
		if ( empty( $this->cart_items ) ) {
			return "Please add product ";
		}
		$this->checkPromotion( $this->cart_items, $this->promotions );
		$this->sumTotal();
		$delivery_cost = $this->calculateDeliveryAmount( $this->total );

		return $this->total += $delivery_cost;
	}

	private function sumTotal() {
		foreach ( $this->cart_items as $cart_item ) {
			$this->total += $cart_item->price;
		}
	}

	/**
	 * @param float $cart_amount
	 *
	 * @return bool
	 */
	private function calculateDeliveryAmount( $cart_amount = null ) {
		if ( is_null( $cart_amount ) ) {
			$cart_amount = $this->total;
		}
		if ( is_array( DELIVERY_RULES ) && ! empty( DELIVERY_RULES ) ) {
			foreach ( DELIVERY_RULES as $rule ) {
				if ( $cart_amount < $rule['amount'] ) {
					return $rule['cost'];
				}
			}
		}

		return false;

	}
}