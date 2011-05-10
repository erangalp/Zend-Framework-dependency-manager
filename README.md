This class manages and resolves dependencies on the Zend Framework. It catches missing ZF classes and fetches it from the ZF online repository.

*   Use Zend Framework dependent code anywhere - just include this class and it will build the library needed to run the code
*   Minimize your Zend Framework library in active projects. The dependency manager fetches only ZF components that are used in the project.

Usage is very simple - include the class and initialize it using the static ::start() function:

    <?php
    require_once('Zdm.php');
    set_time_limit(0);
    Zdm::start();