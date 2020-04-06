<?php

namespace spec\Cherif\Todo\Entity;

use Cherif\Todo\Entity\Todo;
use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use DomainException;
use PhpSpec\ObjectBehavior;

class TodoSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('add', ['Learn PHPSpec', 'cherif']);
    }

    function it_should_open_by_default()
    {
        //$this->isOpen()->shouldReturn(true);
        $this->shouldBeOpen();
    }

    function it_can_mark_todo_as_done()
    {
        $this->markAsDone('cherif');
        //$this->isOpen()->shouldReturn(false);
        $this->shouldNotBeOpen();
        //$this->isDone()->shouldReturn(true);
        $this->shouldBeDone();
    }

    function it_throws_when_marked_as_done_by_another_owner()
    {
        $this->shouldThrow(DomainException::class)->during('markAsDone', ['ryadh']);
        $this->shouldBeOpen();
        $this->shouldNotBeDone();
    }

    function it_can_only_marked_as_done_when_is_open()
    {
        $this->markAsDone('cherif');
        $this->shouldThrow(DomainException::class)->during('markAsDone', ['cherif']);
        $this->shouldNotBeOpen();
        $this->shouldBeDone();
    }

    function it_reopen_marked_as_done_todo()
    {
        $this->markAsDone('cherif');
        $this->reopen('cherif');
        $this->shouldBeOpen();
    }

    function it_throws_when_reopened_by_another_owner()
    {
        $this->markAsDone('cherif');
        $this->shouldThrow(DomainException::class)->during('reopen', ['ryadh']);
        $this->isOpen()->shouldReturn(false);
        $this->isDone()->shouldReturn(true);
    }

    function it_can_only_reopened_when_is_done()
    {
        $this->shouldThrow(DomainException::class)->during('reopen', ['cherif']);
        $this->shouldBeOpen();
        $this->shouldNotBeDone();
    }

    function it_adds_a_deadline()
    {
        $todayTimestamp = strtotime(date('d/m/Y'));
        $deadline = date("d/m/Y", strtotime("+1 month", $todayTimestamp));
        $date = DateTimeImmutable::createFromFormat('d/m/Y', $deadline, new DateTimeZone('Africa/Algiers'));
        $this->addDeadline($date, 'cherif');
        $this->shouldHaveDeadline();
    }

    function it_throws_when_deadline_added_by_another_owner()
    {
        $todayTimestamp = strtotime(date('d/m/Y'));
        $deadline = date("d/m/Y", strtotime("+1 month", $todayTimestamp));
        $date = DateTimeImmutable::createFromFormat('d/m/Y', $deadline, new DateTimeZone('Africa/Algiers'));
        $this->shouldThrow(DomainException::class)->during('AddDeadline', [$date, 'ryadh']);
    }

    function it_throws_when_the_deadline_is_not_in_the_future()
    {
        $date = new DateTimeImmutable();
        $this->shouldThrow(DomainException::class)->during('AddDeadline', [$date, 'cherif']);
    }

    function it_adds_a_reminder()
    {
        //Today's date
        $today = new DateTimeImmutable();
        // add one month for the deadline
        $deadline = $today->add(new DateInterval('P1M'));

        $this->addDeadline($deadline, 'cherif');
        // Substract 2 days for the reminder
        $reminder = $deadline->sub(new DateInterval('P2D'));
        $this->addReminder($reminder, 'cherif');
        $this->shouldHaveReminder();
    }

    function it_throws_when_reminder_added_by_another_owner()
    {
       //Today's date
       $today = new DateTimeImmutable();
       // add one month for the deadline
       $deadline = $today->add(new DateInterval('P1M'));
       
       $this->addDeadline($deadline, 'cherif');
       // Substract 2 days for the reminder
       $reminder = $deadline->sub(new DateInterval('P2D'));
        $this->shouldThrow(DomainException::class)->during('AddReminder', [$reminder, 'ryadh']);
    }

    function it_throws_when_the_reminder_is_not_in_the_future()
    {
        $date = new DateTimeImmutable();
        $this->shouldThrow(DomainException::class)->during('addReminder', [$date, 'cherif']);
    }

    function it_throws_when_reminder_added_without_a_deadline()
    {
         //Today's date
         $today = new DateTimeImmutable();
         
         $reminder = $today->add(new DateInterval('P1M'));
        $this->shouldThrow(DomainException::class)->during('addReminder', [$reminder, 'cherif']);
    }

}
