<?php

namespace spec\Cherif\Todo\UseCase\Interactor;

use Cherif\Todo\Entity\Todo;
use Cherif\Todo\Entity\TodoList;
use Cherif\Todo\UseCase\Interactor\MarkTodoAsDoneInteractor;
use Cherif\Todo\UseCase\Data\MarkTodoAsDoneInput;
use Cherif\Todo\UseCase\Data\MarkTodoAsDoneOutput;
use DomainException;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkTodoAsDoneInteractorSpec extends ObjectBehavior
{
    function let(TodoList $todoList, Todo $todo)
    {
        $this->beConstructedWith($todoList);
        $todoList->getForName('Learn OOP')->willReturn($todo);
    }
    
    function it_marks_todo_as_done(TodoList $todoList, Todo $todo)
    {
        // Create the input class
        $input = new MarkTodoAsDoneInput('Learn OOP', 'cherif');
        
        // Use mock test double to check the call for entity method
        $todo->markAsDone($input->getOwner())->shouldBeCalled();

        // Use Stub test double to simulate $todo->getName result
        $todo->getName()->willReturn($input->getName());

        // Use Stub test double to simulate $todo->getOwner result
        $todo->getOwner()->willReturn($input->getOwner());

        // Check the result of the output
        $this->handle($input)->shouldReturnAnInstanceOf(MarkTodoAsDoneOutput::class);

        // Use spy test double to check the $todo::list method is called
        $todoList->save($todo)->shouldHaveBeenCalled();
    }

    function it_throws_when_todo_owner_is_not_valid(TodoList $todoList, Todo $todo)
    {
        $input = new MarkTodoAsDoneInput('Learn OOP', 'ryadh');

        $todo->markAsDone($input->getOwner())->willThrow(DomainException::class);

        $todoList->getForName($input->getName())->willReturn($todo);
         
        // Use Stub test double to simulate $todo->getName result
        $todo->getName()->willReturn($input->getName());

         // Use Stub test double to simulate $todo->getOwner result
        $todo->getOwner()->willReturn('cherif');
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }

    function it_can_only_be_marked_as_done_when_is_open(TodoList $todoList, Todo $todo)
    {
        $todoList->getForName('Learn OOP')->willReturn($todo);
        $input = new MarkTodoAsDoneInput('Learn OOP', 'cherif');
        $todo->markAsDone($input->getOwner())->willThrow(DomainException::class);
        $this->shouldThrow(InvalidArgumentException::class)->during('handle', [$input]);
    }
}
