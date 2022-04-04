<?php

namespace App\Tests\Communication;

use App\Entity\Message;
use App\Communication\Mailer;

class MailerSpy extends Mailer
{
	private array $messages;

	public function send(Message $message): void
	{
		$this->messages[] = $message;
	}

	public function timesCalled(): int 
	{
		return count($this->messages);
	}

	public function lastMessageSent(): Message
	{
		$message = array_pop($this->messages);
		
		return $message;
	}
}