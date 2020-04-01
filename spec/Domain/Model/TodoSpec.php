<?php

namespace spec\Cherif\Todolist\Domain\Model;

use Cherif\Todolist\Domain\Model\Todo;
use PhpSpec\ObjectBehavior;

class TodoSpec extends ObjectBehavior
{
    function it_is_open_by_default()
    {
        $this->beConstructedThrough('add', ['Learn PHPSpec', 'mahi']);
        $this->isOpen()->shouldReturn(true);
        $this->isDone()->shouldReturn(false);
    }

    function it_can_be_marked_as_done()
    {
        $this->beConstructedThrough('add', ['Learn PHPSpec', 'mahi']);
        $this->markAsDone();
        $this->isOpen()->shouldReturn(false);
        $this->isDone()->shouldReturn(true);
    }
}
