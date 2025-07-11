<?php

require '../vendor/autoload.php';

echo "Dat PHP Client - Basic Usage Examples\n";
echo "=====================================\n\n";

// Basic debugging
echo "1. Basic debugging:\n";
dat('Hello from PHP!');
dat('Simple string message');

// Debug different data types
echo "2. Different data types:\n";
dat(42);
dat(3.14);
dat(true);
dat(null);
dat(['name' => 'John', 'age' => 30]);

// Multiple arguments
echo "3. Multiple arguments:\n";
$user = ['name' => 'Jane', 'email' => 'jane@example.com'];
dat('User data:', $user, 'timestamp:', time());

// Colored output
echo "4. Colored output:\n";
dat('Success message')->green();
dat('Error message')->red();
dat('Warning message')->yellow();
dat('Info message')->blue();
dat('Debug message')->gray();

// Screen organization
echo "5. Screen organization:\n";
dat('Authentication flow started')->screen('auth');
dat('Validating credentials')->screen('auth');
dat('Database query executed')->screen('database');
dat('API response received')->screen('api');

// Helper functions
echo "6. Helper functions:\n";
dat_if(true, 'This will be shown');
dat_if(false, 'This will not be shown');

// Demonstrate dat_once in a loop
echo "7. dat_once in loop:\n";
for ($i = 0; $i < 3; $i++) {
    dat_once('This message appears only once');
    dat("Loop iteration: $i");
}

// Stack trace example
echo "8. Stack trace:\n";
function exampleFunction() {
    dat_trace(3); // Show 3 stack frames
}
exampleFunction();

// Caller information
echo "9. Caller information:\n";
function anotherFunction() {
    dat_caller();
}
anotherFunction();

// Pass-through debugging
echo "10. Pass-through debugging:\n";
$calculation = 10 * 5;
$result = dat('Calculation result:')->pass($calculation);
echo "Result: $result\n";

// Object debugging
echo "11. Object debugging:\n";
class TestClass {
    public $property1 = 'value1';
    private $property2 = 'value2';
    
    public function test() {
        dat('Method called on object', $this);
    }
}

$obj = new TestClass();
$obj->test();

// Complex data structures
echo "12. Complex data structures:\n";
$complexData = [
    'users' => [
        ['id' => 1, 'name' => 'John'],
        ['id' => 2, 'name' => 'Jane']
    ],
    'settings' => [
        'theme' => 'dark',
        'notifications' => true
    ],
    'metadata' => [
        'created' => date('Y-m-d H:i:s'),
        'version' => '1.0.0'
    ]
];

dat('Complex data structure:', $complexData);

// Clear examples (commented out to avoid clearing during demo)
// echo "13. Clear operations:\n";
// dat()->clearScreen();  // Clear current screen
// dat()->clearAll();     // Clear all messages

echo "\nAll examples sent to Dat!\n";
echo "Check your Dat application to see the debug output.\n";