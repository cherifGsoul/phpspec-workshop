<?php

namespace spec\Cherif\Todo\Entity;

use Cherif\Todo\Entity\Todo;
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
        $this->isOpen()->shouldReturn(true);
    }

    function it_can_mark_todo_as_done()
    {
        $this->markAsDone('cherif');
        $this->isOpen()->shouldReturn(false);
        $this->isDone()->shouldReturn(true);
    }

    function it_throws_when_marked_as_done_by_another_owner()
    {
        $this->shouldThrow(DomainException::class)->during('markAsDone', ['ryadh']);
        $this->isOpen()->shouldReturn(true);
        $this->isDone()->shouldReturn(false);
    }

    function it_can_only_marked_as_done_when_is_open()
    {
        $this->markAsDone('cherif');
        $this->shouldThrow(DomainException::class)->during('markAsDone', ['cherif']);
        $this->isOpen()->shouldReturn(false);
        $this->isDone()->shouldReturn(true);
    }

    function it_reopen_marked_as_done_todo()
    {
        $this->markAsDone('cherif');
        $this->reopen('cherif');
        $this->isOpen()->shouldReturn(true);
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
        $this->isOpen()->shouldReturn(true);
        $this->isDone()->shouldReturn(false);
    }
}
