<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    2.0.7
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe;

class Stripe
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '2.0.7';
    /**
     * The amount converter class and method name.
     *
     * @var string
     */
    protected static $amountConverter = '\\Cartalyst\\Stripe\\AmountConverter::convert';
    /**
     * The Config repository instance.
     *
     * @var \Cartalyst\Stripe\ConfigInterface
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param  string $apiKey
     * @param  string $apiVersion
     * @return void
     */
    public function __construct( $apiKey = null, $apiVersion = null )
    {
        $this->config = new Config( self::VERSION, $apiKey, $apiVersion );
    }

    /**
     * Create a new Stripe API instance.
     *
     * @param  string $apiKey
     * @param  string $apiVersion
     * @return \Cartalyst\Stripe\Stripe
     */
    public static function make( $apiKey = null, $apiVersion = null )
    {
        return new static( $apiKey, $apiVersion );
    }

    /**
     * Returns the current package version.
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the amount converter class and method name.
     *
     * @return string
     */
    public static function getAmountConverter()
    {
        return static::$amountConverter;
    }

    /**
     * Sets the amount converter class and method name.
     *
     * @param  $amountConverter  string
     * @return void
     */
    public static function setAmountConverter( $amountConverter )
    {
        static::$amountConverter = $amountConverter;
    }

    /**
     * Disables the amount converter.
     *
     * @return void
     */
    public static function disableAmountConverter()
    {
        static::setAmountConverter( null );
    }

    /**
     * Sets the default amount converter;
     *
     * @return void
     */
    public static function setDefaultAmountConverter()
    {
        static::setAmountConverter(
            static::getDefaultAmountConverter()
        );
    }

    /**
     * Returns the default amount converter.
     *
     * @return string
     */
    public static function getDefaultAmountConverter()
    {
        return '\\Cartalyst\\Stripe\\AmountConverter::convert';
    }

    /**
     * Returns the Config repository instance.
     *
     * @return \Cartalyst\Stripe\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Sets the Config repository instance.
     *
     * @param  \Cartalyst\Stripe\ConfigInterface $config
     * @return $this
     */
    public function setConfig( ConfigInterface $config )
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->config->getApiKey();
    }

    /**
     * Sets the Stripe API key.
     *
     * @param  string $apiKey
     * @return $this
     */
    public function setApiKey( $apiKey )
    {
        $this->config->setApiKey( $apiKey );

        return $this;
    }

    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->config->getApiVersion();
    }

    /**
     * Sets the Stripe API version.
     *
     * @param  string $apiVersion
     * @return $this
     */
    public function setApiVersion( $apiVersion )
    {
        $this->config->setApiVersion( $apiVersion );

        return $this;
    }

    /**
     * Sets the idempotency key.
     *
     * @param  string $idempotencyKey
     * @return $this
     */
    public function idempotent( $idempotencyKey )
    {
        $this->config->setIdempotencyKey( $idempotencyKey );

        return $this;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param  string $method
     * @param  array $parameters
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    public function __call( $method, array $parameters )
    {
        if ( $this->isIteratorRequest( $method ) ) {
            $apiInstance = $this->getApiInstance( substr( $method, 0, -8 ) );

            return ( new Pager( $apiInstance ) )->fetch( $parameters );
        }

        return $this->getApiInstance( $method );
    }

    /**
     * Determines if the request is an iterator request.
     *
     * @return bool
     */
    protected function isIteratorRequest( $method )
    {
        return substr( $method, -8 ) === 'Iterator';
    }

    /**
     * Returns the Api class instance for the given method.
     *
     * @param  string $method
     * @return \Cartalyst\Stripe\Api\ApiInterface
     * @throws \BadMethodCallException
     */
    protected function getApiInstance( $method )
    {
        $class = "\\Cartalyst\\Stripe\\Api\\" . ucwords( $method );

        if ( class_exists( $class ) ) {
            return new $class( $this->config );
        }

        throw new \BadMethodCallException( "Undefined method [{$method}] called." );
    }

    /**
     * @return Api\Account
     */
    public function account()
    {
        return new Api\Account( $this->config );
    }

    /**
     * @return Api\ApplicationFeeRefunds
     */
    public function applicationFeeRefunds()
    {
        return new Api\ApplicationFeeRefunds( $this->config );
    }

    /**
     * @return Api\ApplicationFees
     */
    public function applicationFees()
    {
        return new Api\ApplicationFees( $this->config );
    }

    /**
     * @return Api\Balance
     */
    public function balance()
    {
        return new Api\Balance( $this->config );
    }

    /**
     * @return Api\BankAccounts
     */
    public function bankAccounts()
    {
        return new Api\BankAccounts( $this->config );
    }

    /**
     * @return Api\Bitcoin
     */
    public function bitcoin()
    {
        return new Api\Bitcoin( $this->config );
    }

    /**
     * @return Api\Cards
     */
    public function cards()
    {
        return new Api\Cards( $this->config );
    }

    /**
     * @return Api\Charges
     */
    public function charges()
    {
        return new Api\Charges( $this->config );
    }

    /**
     * @return Api\CountrySpecs
     */
    public function countrySpecs()
    {
        return new Api\CountrySpecs( $this->config );
    }

    /**
     * @return Api\Coupons
     */
    public function coupons()
    {
        return new Api\Coupons( $this->config );
    }

    /**
     * @return Api\Customers
     */
    public function customers()
    {
        return new Api\Customers( $this->config );
    }

    /**
     * @return Api\Disputes
     */
    public function disputes()
    {
        return new Api\Disputes( $this->config );
    }

    /**
     * @return Api\Events
     */
    public function events()
    {
        return new Api\Events( $this->config );
    }

    /**
     * @return Api\ExternalAccounts
     */
    public function externalAccounts()
    {
        return new Api\ExternalAccounts( $this->config );
    }

    /**
     * @return Api\FileUploads
     */
    public function fileUploads()
    {
        return new Api\FileUploads( $this->config );
    }

    /**
     * @return Api\InvoiceItems
     */
    public function invoiceItems()
    {
        return new Api\InvoiceItems( $this->config );
    }

    /**
     * @return Api\Invoices
     */
    public function invoices()
    {
        return new Api\Invoices( $this->config );
    }

    /**
     * @return Api\OrderReturns
     */
    public function orderReturns()
    {
        return new Api\OrderReturns( $this->config );
    }

    /**
     * @return Api\Orders
     */
    public function orders()
    {
        return new Api\Orders( $this->config );
    }

    /**
     * @return Api\Plans
     */
    public function plans()
    {
        return new Api\Plans( $this->config );
    }

    /**
     * @return Api\Products
     */
    public function products()
    {
        return new Api\Products( $this->config );
    }

    /**
     * @return Api\Recipients
     */
    public function recipients()
    {
        return new Api\Recipients( $this->config );
    }

    /**
     * @return Api\Refunds
     */
    public function refunds()
    {
        return new Api\Refunds( $this->config );
    }

    /**
     * @return Api\Skus
     */
    public function skus()
    {
        return new Api\Skus( $this->config );
    }

    /**
     * @return Api\Sources
     */
    public function sources()
    {
        return new Api\Sources( $this->config );
    }

    /**
     * @return Api\Subscriptions
     */
    public function subscriptions()
    {
        return new Api\Subscriptions( $this->config );
    }

    /**
     * @return Api\Tokens
     */
    public function tokens()
    {
        return new Api\Tokens( $this->config );
    }

    /**
     * @return Api\TransferReversals
     */
    public function transferReversals()
    {
        return new Api\TransferReversals( $this->config );
    }

    /**
     * @return Api\Transfers
     */
    public function transfers()
    {
        return new Api\Transfers( $this->config );
    }
}
