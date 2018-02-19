# Domain Analyser

(badges)

## Installation

Install using composer:

`composer require stratadox/domain-analyser`

## Goal

The ultimate goal of the Domain Analyser is to provide information of the types
of all the properties of all the classes in a given context.

When a property type can have one of multiple types, the goal is to provide all
possible types the property could have.

## Challenges

The main difficulty in achieving this goal is the nature of the language. 
In a dynamically typed language with implicit type conversion and an 
allow-everything mentality, it can often be near impossible to find out which 
type a variable is supposed to have.

In a statically typed language, this entire module would serve no purpose.
The entire purpose of this module could probably be expressed in java as:
```
field.getType();
```

PHP, however, does not (at the time of writing) provide the possibility of 
declaring property types.

## Opportunities

Since PHP5, it is possible to add type hints for classes and interfaces to 
arguments of a function or method. PHP7 expanded these possibilities by adding 
support for scalar type hints. Additionally, support for type hints on return 
types was introduced.

## Challenges left

These type hints are a great help, but they don't solve the entire challenge.

For starters, they don't apply to properties. Property types are often asserted
through type hints on the parameters of constructors or setters, but linking
those parameters to properties is not standard functionality.

Next, these property type assertions are optional, and sometimes impossible.
When implementing an interface that does not apply type hints, for example for
reasons of backwards compatibility or interoperability, restricting the input
types is prohibited by the language.

Sometimes, the capacities of type hinting system are insufficient. When passing
an array-of-things as parameter, one can hint on the array type itself, but not 
on the contents of the array.

Due to the above limitations, code bases often contain additional checks for
asserting the types of the input variables before assigning them to properties.

This package attempts to resolve these challenges. 

## Target

Due to PHP's dynamically typed nature, in some cases it's difficult for a human
to figure out the expected property (or parameter) type, let alone for a static
analyser.

This package makes the (now explicit) assumption that the aforementioned type
hinting is applied to at least a minimum level.

The module acknowledges that due to reasons of backwards compatibility, the type
hinting system cannot always be used to its fullest potential. It demands of its
audience that in such cases, alternative type checking is performed.

The target for this Analyser is to recognise the possible types of those 
properties where the developer has made a reasonable effort to restrict the 
input that affects them.

Such efforts may include:
- Typed constructor parameters
- Typed setters (even though boo setters bad)
- Positive InstanceOf checks, as assign condition
- Negative InstanceOf checks, by throwing an exception (or return?)
- Comparisons against the `gettype` function
- Using functions like `is_string`, `is_int`, etc.
- Using the parameter as argument in a method that restricts input
- Applying any of the above to the elements of a collection

## Scope

Projects that do not take the effort to assert input types are out of scope.
Not going there.

Non-interpreted indications such as docblock annotations. 
They are ignored by the parser and as such they might as well be incorrect.

### In-scope example

In the example below, reasonable care is taken to verify the input:
```php
<?php

class InScope
{
    private $things;

    public function __construct(array $things)
    {
        foreach ($things as $name => $thing) {
            $this->validateName($name);
            $this->validateThing($thing);
        }
        $this->things = $things;
    }

    public function thing($withName)
    {
        return $this->things[$withName];
    }

    private function validateName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException;
        }
    }

    private function validateThing(Thing $thing) {}
}
```
The Domain Analyser should correctly identify InScope's `things` property as an
associative arrays of `Thing` objects, indexed by `string` typed values.

### Out-of-scope example

In the example below, the developer still has to protect their invariants:
```php
<?php

class OutOfScope
{
    private $things;

    public function __construct(array $things)
    {
        $this->things = $things;
    }

    public function thing($withName)
    {
        return $this->things[$withName];
    }
}
```
Although the Domain Analyser should indicate the type as array, there is no way 
of knowing what kind of contents it has.
Theoretically, one could track all instantiations and infer the type by tracking
the original values, but that's way tricky and a bad incentive anyway.

## Todo

### Detect types
- Add TypeDetector
    - If variable, ask VariableTypeResolver
    - Else ask detectors
- Add VariableTypeResolver
    - Walk back statements in method, starting at the assignment
    - Ask Detectors for type indications of local variable on each node
    - Continue until out of nodes or found a DefiniteType

### Collect return types

- Add ReturnCollector
    - Collect return statements
- Add MethodIndex
    - Cache for return types by method
- Add MethodIndexer
    - Ask TypeDetector for the return types of the collected methods
    - Add return types to MethodIndex

### Collect parameter types

- Add ParameterCollector
    - Collect method parameters
- Add ParameterIndex
    - Cache for parameter types by method and parameter
- Add ParameterTypeResolver
    - VariableTypeResolver but in the other direction
    - The other direction has branches: queue upon branching (with limit?)
- Add ParameterIndexer
    - Ask ParameterTypeResolver 

### Type detection

- Add InstanceOfDetector
    - Detect if in instanceOf check
    - Check if the current node is the expression in instanceOf
- Add InstanceOfExceptionDetector
    - Detect if an exception is thrown in negative instanceOf check
    - Check if: 
        - Current node is an if statement
        - The if condition is instanceOf
        - There is a throw in the direct children
- Add ForeignTypeHintDetector
    - Detect if the variable is an argument in a call 
    - Check with ParameterIndex
- Add ReturnTypeDetector
    - Detect if the variable is declared by assignment to a method call with known return type
    - Check with MethodIndex
- Add ParameterTypeHintDetector
    - Detect if the variable is a type hinted argument in the containing method call
    - The simple case..

The above document contains conceptual goals.
Its main purpose is to organise my thoughts, no guarantees or promises are intended.
