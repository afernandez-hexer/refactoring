<?php

namespace App;

use App\System\Logger;
use App\Entity\Message;
use App\Entity\Customer;
use App\System\ClockService;
use App\Communication\Mailer;
use App\Repository\CustomerRepository;

class GreetCustomerForBirthdayHandler
{
    private $customerRepository;

    private $clockService;

    private $mailer;

    private $logger;

    public function __construct(
        CustomerRepository $customerRepository,
        ClockService $clockService,
        Mailer $mailer,
        Logger $logger
    ) {
        $this->customerRepository = $customerRepository;
        $this->clockService = $clockService;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function sendEmailToBirthdayCustomers(): void
    {
        $today = $this->clockService->today();

        $customers = $this->customerRepository->findByBirthday($today);

        $this->logger->log(sprintf("Se han encontrado %s cumpleañeros", count($customers)));

        if (count($customers) > 0) {
            foreach ($customers as $customer) {
                $this->sendEmailToCustomer($customer);
            }
        }
    }

    private function sendEmailToCustomer(Customer $customer)
    {
        $message = $this->createMessageFromCustomer($customer);

        $this->mailer->send($message);
    }

    private function createMessageFromCustomer(Customer $customer)
    {
        $message = new Message();
        $message->from = 'admin@test.com';
        $message->to = $customer->email;
        $message->subject = 'Feliz Cumpleaños';
        $message->content = sprintf('Feliz cumpleaños, %s', $customer->name);

        return $message;
    }
}