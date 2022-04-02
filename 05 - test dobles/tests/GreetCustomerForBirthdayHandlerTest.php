<?php

use App\System\Logger;
use App\Entity\Customer;
use App\System\ClockService;
use PHPUnit\Framework\TestCase;
use App\Tests\Communication\MailerSpy;
use App\GreetCustomerForBirthdayHandler;
use App\Tests\Repository\MemoryCustomerRepository;

class GreetCustomerForBirthdayHandlerTest extends TestCase
{
    public function testSendEmailToOneBirthdayCustomer()
    {
        $customers = $this->getCustomers();

        $today = new \DateTime('2022-04-04');

        $mailer = $this->createMailer();

        $sut = $this->createSUT($customers, $today, $mailer);

        $sut->sendEmailToBirthdayCustomers();

        $this->assertEquals(1, $mailer->timesCalled());

        $message = $mailer->lastMessageSent();

        $this->assertEquals('rober@test.com', $message->to);
    }

    private function getCustomers(): array
    {
        $customers = [];

        $customer = new Customer();
        $customer->id = 'r-123';
        $customer->email = 'rober@test.com';
        $customer->name = 'Roberto';
        $customer->birthday = new \DateTime('2000-04-04');

        $customers[] = $customer;

        return $customers;
    }

    private function createSUT(array $customers, \DateTime $today, MailerSpy $mailer)
    {
        $customerRepository = $this->createCustomerRepository($customers);
        $clockService = $this->createClockService($today);
        $logger = $this->createLogger();

        return new GreetCustomerForBirthdayHandler(
            $customerRepository, $clockService, $mailer, $logger
        );
    }

    private function createCustomerRepository(array $customers)
    {
        $repository = new MemoryCustomerRepository();

        if (count($customers) > 0) {
            foreach ($customers as $customer) {
                $repository->store($customer);
            }
        }

        return $repository;
    } 

    private function createClockService(\DateTime $today)
    {
        $stub = $this->createMock(ClockService::class);

        $stub
            ->method('today')
            ->will(
                $this->returnValue($today)
            )
        ;

        return $stub;
    } 

    private function createMailer()
    {
        return new MailerSpy();
    } 

    private function createMailerAsAMock(int $timesCalled, \App\Entity\Message $expectedMessage)
    {
        $mailer = $this->createMock(\App\Communication\Mailer::class);

        $mailer
            ->expects(
                $this->exactly($timesCalled)
                // $this->once()
                // $this->atLeastOnce()
                // $this->any()
            )
            ->method('send')
            ->with($expectedMessage)
        ;

        return $mailer;
    }

    private function createLogger()
    {
        $dummy = $this->createMock(Logger::class);

        return $dummy;
    } 
}