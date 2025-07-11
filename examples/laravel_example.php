<?php

require '../vendor/autoload.php';

echo "Dat PHP Client - Laravel-style Usage Examples\n";
echo "==============================================\n\n";

// Simulate a Laravel-style application flow
echo "Simulating Laravel application flow...\n\n";

// 1. Route handling
echo "1. Route handling:\n";
dat('Route matched: /users/{id}')->screen('routing');
dat('Route parameters:', ['id' => 123])->screen('routing');

// 2. Middleware
echo "2. Middleware processing:\n";
dat('Authentication middleware started')->screen('middleware');
dat('User authenticated:', ['user_id' => 123, 'role' => 'admin'])->screen('middleware');
dat('CORS middleware applied')->screen('middleware');

// 3. Controller
echo "3. Controller logic:\n";
class UserController {
    public function show($id) {
        dat("UserController@show called with ID: $id")->screen('controllers');
        
        // Simulate validation
        if ($id <= 0) {
            dat('Invalid user ID provided')->red()->screen('controllers');
            return false;
        }
        
        dat('User ID validation passed')->green()->screen('controllers');
        return $this->findUser($id);
    }
    
    private function findUser($id) {
        dat("Finding user with ID: $id")->screen('database');
        
        // Simulate database query
        $query = "SELECT * FROM users WHERE id = $id";
        dat('Executing query:', $query)->screen('database');
        
        // Simulate user data
        $userData = [
            'id' => $id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'created_at' => '2023-01-01 00:00:00'
        ];
        
        dat('User found:', $userData)->green()->screen('database');
        return $userData;
    }
}

$controller = new UserController();
$user = $controller->show(123);

// 4. Model/ORM simulation
echo "4. Model/ORM operations:\n";
class User {
    public static function find($id) {
        dat("User::find($id) called")->screen('eloquent');
        
        // Simulate query builder
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        dat('Generated SQL:', $sql)->screen('eloquent');
        dat('Bindings:', [$id])->screen('eloquent');
        
        // Simulate execution time
        $startTime = microtime(true);
        usleep(1000); // Simulate 1ms query time
        $endTime = microtime(true);
        
        dat('Query executed in:', ($endTime - $startTime) * 1000 . 'ms')->blue()->screen('eloquent');
        
        return [
            'id' => $id,
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ];
    }
}

$user = User::find(123);

// 5. Event handling
echo "5. Event handling:\n";
dat('UserLoggedIn event dispatched')->screen('events');
dat('Event payload:', ['user_id' => 123, 'timestamp' => time()])->screen('events');

// 6. Queue jobs
echo "6. Queue jobs:\n";
dat('SendWelcomeEmail job queued')->screen('queues');
dat('Job payload:', ['user_id' => 123, 'email' => 'john@example.com'])->screen('queues');

// 7. Cache operations
echo "7. Cache operations:\n";
dat('Cache key generated:', 'user_123_profile')->screen('cache');
dat('Cache miss - fetching from database')->yellow()->screen('cache');
dat('Cache stored with TTL:', 3600)->screen('cache');

// 8. API responses
echo "8. API responses:\n";
$response = [
    'data' => $user,
    'meta' => [
        'status' => 'success',
        'timestamp' => time()
    ]
];
dat('API response prepared:', $response)->screen('api');

// 9. Error handling
echo "9. Error handling:\n";
try {
    // Simulate an error
    if (rand(1, 10) > 5) {
        throw new Exception('Something went wrong!');
    }
} catch (Exception $e) {
    dat('Exception caught:', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ])->red()->screen('errors');
}

// 10. Performance monitoring
echo "10. Performance monitoring:\n";
$startTime = microtime(true);

// Simulate some work
for ($i = 0; $i < 1000; $i++) {
    // Simulate processing
}

$endTime = microtime(true);
$executionTime = ($endTime - $startTime) * 1000;

dat('Performance metrics:', [
    'execution_time' => $executionTime . 'ms',
    'memory_usage' => memory_get_usage(true),
    'peak_memory' => memory_get_peak_usage(true)
])->screen('performance');

// 11. Debugging complex queries
echo "11. Complex query debugging:\n";
$complexQuery = [
    'select' => ['users.*', 'profiles.bio'],
    'from' => 'users',
    'joins' => [
        ['table' => 'profiles', 'on' => 'users.id = profiles.user_id']
    ],
    'where' => [
        ['users.active', '=', 1],
        ['users.created_at', '>', '2023-01-01']
    ],
    'order_by' => ['users.name', 'ASC'],
    'limit' => 50
];

dat('Complex query structure:', $complexQuery)->screen('query-builder');

// 12. Feature flags
echo "12. Feature flags:\n";
$featureFlags = [
    'new_ui' => true,
    'beta_features' => false,
    'analytics' => true
];

dat('Feature flags loaded:', $featureFlags)->screen('features');

foreach ($featureFlags as $flag => $enabled) {
    dat_if($enabled, "Feature '$flag' is enabled")->green()->screen('features');
}

echo "\nLaravel-style examples completed!\n";
echo "Check your Dat application to see the organized debug output.\n";