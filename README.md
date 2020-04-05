## What is PHPSpec ?
[PHPSpec](http://www.phpspec.net/) is a php toolset to drive emergent design by specification.

## PhpSpec workshop:

This is the source for the workshop teaching how to use PHPSpec to implement [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)

![Clean Architecture](https://blog.cleancoder.com/uncle-bob/images/2012-08-13-the-clean-architecture/CleanArchitecture.jpg)

### The clean architecture characteristiques:

- Independent of frameworks. The architecture does not depend on the existence of
some library of feature-laden software. This allows you to use such frameworks as
tools, rather than forcing you to cram your system into their limited constraints.
- Testable. The business rules can be tested without the UI, database, web server, or
any other external element.
- Independent of the UI. The UI can change easily, without changing the rest of the
system. A web UI could be replaced with a console UI, for example, without
changing the business rules.
- Independent of the database. You can swap out Oracle or SQL Server for Mongo,
BigTable, CouchDB, or something else. Your business rules are not bound to the
database.
- Independent of any external agency. In fact, your business rules don’t know
anything at all about the interfaces to the outside world.

### The application

The application of the workshop is a todo-list with the following rules:

- **Todo** has a name and an owner
- **Todo** should be opened by default
- **Todo** can be marked as done
- **Todo** can only be marked as done by its owner
- **Todo** can only be marked as done when it is opened
- **Todo** can be reopend
- **Todo** can only be reopened by its owner
- **Todo** can only be reopened if it is maked as done
- **Todo** can have a deadline
- **Todo** can have a reminder
- **Todo** dedaline can only be added by the todo owner
- **Todo** reminder can only be added by the todo owner 

Based on those rules the following use cases had been identified:
- Add **Todo**
- Mark **Todo** as done
- Reopen a **Todo**
- Add **Todo** deadline
- Add **Todo** reminder

### WORKSHOP VIDEOS
* [PART01](https://bit.ly/2UHkFN0)
* [PART02](https://bit.ly/3aJQk65)
