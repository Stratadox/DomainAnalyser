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
    - Ask Detectors for type indications of local variable
- Add InstanceOfDetector
    - Detect if in instanceOf check
- Add InstanceOfExceptionDetector
    - Detect if an exception is thrown in negative instanceOf check
- Add ForeignTypeHintDetector
    - Detect if the variable is an argument in a type hinted call
    - Use reflection here? AST might be cumbersome.
- Add TypeHintDetector
    - Detect if the variable is an argument in the containing method call
- Add AmbiguityChecker
