<?php

    use PayPal\Auth\OAuthTokenCredential;
    use PayPal\Api\Address;
    use PayPal\Api\Authorization;
    use PayPal\Api\Amount;
    use PayPal\Api\AmountDetails;
    use PayPal\Api\Details;
    use PayPal\Api\Item;
    use PayPal\Api\ItemList;
    use PayPal\Api\Payer;
    use PayPal\Api\Payment;
    use PayPal\Api\Sale;
    use PayPal\Api\PaymentExecution;
    use PayPal\Api\FundingInstrument;
    use PayPal\Api\RedirectUrls;
    use PayPal\Api\Transaction;
    use PayPal\Rest\ApiContext;

    class Paypal_rest {

        private $endpoints = array ('test' => 'api.sandbox.paypal.com', 'live' => 'api.paypal.com');
        private $clientIds = array ('test' => 'AfKl_hCMWPRSaydjeiRoGY211rS0jw5OOuBGPxO5JUqT1H9XkJDh8HDeApkZ', 'live' => 'AQy0BBDp8fB1SyklfqQXY26t9lM6A6Ttx50BPwuKjGRF9kNGEatVyQ-t12S-');
        private $secrets = array ('test' => 'EGVy6BDq0BHdTBih2B8w_OdIu3WkH6qFzMBRz7J6nEtE6FRJ5T7eRwd46Twr', 'live' => 'EK0vFBBbFMNoZFE814qGMWk18kc8e33iA-iVhpJq3ZCTTyXXNA9doUAOU1he');

        #private $live = true;
		private $live = false;
        private $endpoint;
        private $clientId;
        private $secret;
        private $CI;

        public function __construct() {
            try {
                if ($this->live == false) {
                    $this->endpoint = $this->endpoints['test'];
                    $this->clientId = $this->clientIds['test'];
                    $this->secret = $this->secrets['test'];
                } else {
                    $this->endpoint = $this->endpoints['live'];
                    $this->clientId = $this->clientIds['live'];
                    $this->secret = $this->secrets['live'];
                }

                $this->CI = &get_instance();
            } catch (Exception $e) {
                throw new Exception("Paypal Rest error in constructor : " . $e->getMessage());
            }
        }

        public function getPayer() { return new Payer(); }
        public function getItem() { return new Item(); }
        public function getItemList() { return new ItemList(); }
        public function getDetails() { return new Details(); }
        public function getAmount() { return new Amount(); }
        public function getTransaction() { return new Transaction(); }
        public function getRedirectUrls() { return new RedirectUrls(); }
        public function getPayment() { return new Payment(); }

        public function executePayment($mode, $paymentId, $payerId)
        {
            $apiContext = $this->getApiContext($mode);
			
			
			/*try {
                $payment = Payment::get($paymentId, $apiContext);
            } catch(Exception $ex) {
				echo '<pre>' . print_r($ex) . '<pre>';
				exit();	
            }
			
			exit();	*/
			
            $payment = Payment::get($paymentId, $apiContext);
			
			#echo '<pre>' . print_r($payment,true) . '</pre>';exit;

            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

			/*try {
                $result = $payment->execute($execution, $apiContext);
            } catch(Exception $ex) {
				print_r($ex);
            }*/
			#exit;
		
            $result = $payment->execute($execution, $apiContext);

            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            $saleId = $sale->getId();

            return $saleId;

            try {
                $sale = Sale::get($saleId, $apiContext);
            } catch(Exception $ex) {

            }

            # Return transaction ID
            return $sale->getId();

            return $payment;
            return $result;
        }

        public function getApiContext($mode) {
            if ($mode == 'live') {
                $this->endpoint = $this->endpoints['live'];
                $this->clientId = $this->clientIds['live'];
                $this->secret = $this->secrets['live'];
            } else {
                $this->endpoint = $this->endpoints['test'];
                $this->clientId = $this->clientIds['test'];
                $this->secret = $this->secrets['test'];
            }

            $apiContext = new ApiContext(new OAuthTokenCredential(
                $this->clientId,
                $this->secret
            ));
            $apiContext->setConfig(
                array(
                    'mode' => $mode,
                    #'http.ConnectionTimeOut' => 30,
                    #'log.LogEnabled' => true,
                    #'log.FileName' => '../PayPal.log',
                    #'log.LogLevel' => 'FINE',
                    #'validation.level' => 'log'
                )
            );
            return $apiContext;
        }
    }

