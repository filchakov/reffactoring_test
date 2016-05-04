<?php

class EmailService
{

    const DAY_COMEBACK_EMAIL = 'Mon';

    /**
     * @var array
     */
    private $ordersArray = [];

    /**
     * @var array
     */
    private $customersArray = [];

    /**
     * @var array
     */
    private $oldCustomers = [];

    /**
     * @var EmailSenderService
     */
    private $emailSenderService;


    /**
     * EmailService constructor.
     * @param bool $debud
     */
    public function __construct($debud = true)
    {
        $this
            ->setEmailSenderService($debud)
            ->setOrdersArray(DataLayer::ListOrders())
            ->setCustomersArray(DataLayer::ListCustomers())
            ->mappingOldCustomer();
    }


    /**
     * @return string
     * @throws Exception
     */

    public function send(){

        $this->sendCustomer();

        if($this->isSendComebackEmail())
            $this->sendComeback('ComebackToUs');

        ConsoleMessage::getMessage("done");
    }


    /**
     * @return array
     */
    private function getOrdersArray()
    {
        return $this->ordersArray;
    }

    /**
     * @param $ordersArray
     * @return $this
     */
    private function setOrdersArray($ordersArray)
    {
        $this->ordersArray = [];

        foreach($ordersArray as $orderObject){
            $this->ordersArray[] = new OrderAdapter($orderObject);
        }

        return $this;
    }

    /**
     * @return array
     */
    private function getCustomersArray()
    {
        return $this->customersArray;
    }

    /**
     * @param $customersArray
     * @return $this
     */
    private function setCustomersArray($customersArray)
    {
        $this->customersArray = [];

        foreach($customersArray as $customerObject){
            $this->customersArray[] = new CustomerAdapter($customerObject);
        }

        return $this;
    }


    /**
     * @return bool
     */
    private function isSendComebackEmail()
    {
        return ($this->getEmailSenderService()->isDebud() || $this->checkComebackDay());
    }

    /**
     * @return bool
     */
    private function checkComebackDay()
    {
        return date('D', time()) === self::DAY_COMEBACK_EMAIL;
    }

    /**
     * @return array
     */
    private function getOldCustomers()
    {
        return $this->oldCustomers;
    }

    private function mappingOldCustomer()
    {
        foreach ($this->getCustomersArray() as $customerObject) {
            foreach ($this->getOrdersArray() as $orderObject) {
                if ($customerObject->getEmail() == $orderObject->getEmail()){
                    $this->oldCustomers[] = $customerObject;
                }
            }
        }
    }

    /**
     * @return EmailSenderService
     */
    public function getEmailSenderService()
    {
        return $this->emailSenderService;
    }

    /**
     * @param $debug
     * @return $this
     */
    public function setEmailSenderService($debug)
    {
        $this->emailSenderService = new EmailSenderService($debug);
        return $this;
    }

    /**
     * @throws Exception
     */
    private function sendCustomer()
    {
        ConsoleMessage::getMessage("Send Welcomemail");

        foreach($this->getCustomersArray() as $customer){
            $email = new WelcomeEmail($customer->getEmail(), ['email' => $customer->getEmail()]);
            $this->getEmailSenderService()->sendEmailMessage($email);
        }
    }

    /**
     * @param $voucher
     * @throws Exception
     */
    private function sendComeback($voucher){

        ConsoleMessage::getMessage("Send Comebackmail");

        foreach($this->getOldCustomers() as $customer){
            $email = new ComebackEmail($customer->getEmail(), ['email' => $customer->getEmail(), 'voucher' => $voucher]);
            $this->getEmailSenderService()->sendEmailMessage($email);
        }
    }

}