A micro configuration interface for PHP
=======================================

Usage:

    $handler = new \UConfig\INIFileHandler('/path/to/config.ini');
    $defaults = [
        'section' => [
            'bar' => 1,
            'zoo' => 2,
        ],
    ];
    $config = new \UConfig\Config($defaults);
    $config->addHandler(new \UConfig\INIFileHandler('/path/to/config.ini'));

    $bar = $config->get('section', 'bar');
    // $bar = 1

    try {
        $config->get('nonexistent', 'bar');
    } catch ( \UConfig\SectionNotFoundException $ex ) {
        die("Section not found: " . $ex->getMessage());
    } catch ( \UConfig\OptionNotFoundException $ex ) {
        die("Option not found: " . $ex->getMessage());
    }


Handlers
--------
Configuration is handled by *configuration handlers*. To implement a
new handler, add a class that implements the `UConfig\Handler`
interface, with a method called `load()` that returns a configuration
array, which must be structured as follows:

     $config = [
         'section' => [
             'key1' => value,
             'key2' => value,
             //(...)
         ],
         'anothersection' => [
             'key1' => value,
             'key2' => value,
             //(...)
        ]
    ]

A `UConfig\Config` object may have many handlers attached to it. Use
the `addHandler()` method to add handlers. Configuration is loaded in
sequence, with later handler overriding previous ones.

Currently, only the `UConfig\INIFileHandler` is provided. Other
handlers may be added in the future.
