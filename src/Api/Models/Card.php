<?php namespace Cartalyst\Stripe\Api\Models;
/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Carbon\Carbon;
use Guzzle\Service\Command\ResponseClassInterface;

class Card extends Collection implements ResponseClassInterface {

	use GuzzleCommandTrait;

	/**
	 * Checks if the card has expired.
	 *
	 * @return bool
	 */
	public function hasExpired()
	{
		return Carbon::createFromDate($this->exp_year, $this->exp_month) < Carbon::now();
	}

}
