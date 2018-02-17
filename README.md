# Domain Analyser

(badges)

## Installation

Install using composer:

`composer require stratadox/domain-analyser`

## Todo

### Detect types
- Add TypeDetector
    - If variable, ask VariableTypeResolver
    - Else ask detectors
- Add VariableTypeResolver
    - Walk back statements in method, starting at the assignment
    - Ask Detectors below for type indications of local variable on each node
    - Continue until out of nodes (should be lazy)

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
