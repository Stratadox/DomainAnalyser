# Domain Analyser

(badges)

# Installation

Install using composer:

`composer require stratadox/domain-analyser`

# Todo

- Add TypeDetector
    - Done if non-variable right hand side
    - If variable, ask VariableTypeResolver
- Add VariableTypeResolver
    - Walk back statements in method, starting at the assignment
    - Ask Detectors below for type indications of local variable on each node
    - Continue until found or out of nodes
- Add InstanceOfDetector
    - Detect if in instanceOf check
- Add InstanceOfExceptionDetector
    - Detect if an exception is thrown in negative instanceOf check
- Add ForeignTypeHintDetector
    - Detect if the variable is an argument in a type hinted call
    - Use reflection here? AST might be cumbersome
- Add ReturnTypeDetector
    - Detect if the variable is declared by assigning it to a method with return type
- Add ParameterTypeHintDetector
    - Detect if the variable is a type hinted argument in the containing method call
- Add AmbiguityChecker
