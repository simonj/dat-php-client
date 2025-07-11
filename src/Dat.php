<?php

namespace Dat;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Ramsey\Uuid\Uuid;

class Dat
{
    private static $instance;
    private $client;
    private $baseUrl;
    private $enabled;
    private $screen;
    private $color;
    private $level;
    private $arguments = [];
    private $shouldPause = false;

    public function __construct(string $host = '127.0.0.1', int $port = 3030, bool $enabled = true)
    {
        $this->baseUrl = "http://{$host}:{$port}";
        $this->enabled = $enabled && !$this->isProduction();
        $this->client = new Client([
            'timeout' => 1.0,
            'connect_timeout' => 1.0,
        ]);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function send(...$arguments): self
    {
        if (!$this->enabled) {
            return $this;
        }

        $this->arguments = $arguments;

        if ($this->shouldPause) {
            $this->sendPauseRequest();
        }

        $this->sendDebugMessage();

        return $this;
    }

    public function color(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function level(string $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function red(): self
    {
        return $this->color('red');
    }

    public function green(): self
    {
        return $this->color('green');
    }

    public function blue(): self
    {
        return $this->color('blue');
    }

    public function yellow(): self
    {
        return $this->color('yellow');
    }

    public function orange(): self
    {
        return $this->color('orange');
    }

    public function purple(): self
    {
        return $this->color('purple');
    }

    public function gray(): self
    {
        return $this->color('gray');
    }

    public function screen(string $name): self
    {
        $this->screen = $name;
        return $this;
    }

    public function pause(): self
    {
        $this->shouldPause = true;
        return $this;
    }

    public function pass($value)
    {
        $this->send($value);
        return $value;
    }

    public function clearAll(): self
    {
        if (!$this->enabled) {
            return $this;
        }

        try {
            $this->client->post($this->baseUrl . '/clear/all');
        } catch (ConnectException $e) {
            // Silently fail if dat server is not running
        } catch (RequestException $e) {
            // Silently fail on other request errors
        }

        return $this;
    }

    public function clearScreen(): self
    {
        if (!$this->enabled) {
            return $this;
        }

        try {
            $this->client->post($this->baseUrl . '/clear/screen');
        } catch (ConnectException $e) {
            // Silently fail if dat server is not running
        } catch (RequestException $e) {
            // Silently fail on other request errors
        }

        return $this;
    }

    private function sendDebugMessage(): void
    {
        if (empty($this->arguments)) {
            return;
        }

        $caller = $this->getCaller();
        $message = $this->formatArguments($this->arguments);

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'timestamp' => time(),
            'message' => $message,
            'arguments' => $this->arguments,
            'sourceFile' => $caller['file'] ?? null,
            'sourceLine' => $caller['line'] ?? null,
            'color' => $this->color,
            'level' => $this->level,
            'screen' => $this->screen,
            'executionTime' => microtime(true) * 1000,
        ];

        try {
            $this->client->post($this->baseUrl . '/debug', [
                'json' => $payload,
            ]);
        } catch (ConnectException $e) {
            // Silently fail if dat server is not running
        } catch (RequestException $e) {
            // Silently fail on other request errors
        }

        // Reset state for next call
        $this->reset();
    }

    private function sendPauseRequest(): void
    {
        try {
            $this->client->post($this->baseUrl . '/pause');
        } catch (ConnectException $e) {
            // Silently fail if dat server is not running
        } catch (RequestException $e) {
            // Silently fail on other request errors
        }
    }

    private function formatArguments(array $arguments): string
    {
        $formatted = [];

        foreach ($arguments as $arg) {
            if (is_string($arg)) {
                $formatted[] = $arg;
            } elseif (is_array($arg) || is_object($arg)) {
                $formatted[] = json_encode($arg, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } elseif (is_bool($arg)) {
                $formatted[] = $arg ? 'true' : 'false';
            } elseif (is_null($arg)) {
                $formatted[] = 'null';
            } else {
                $formatted[] = (string) $arg;
            }
        }

        return implode(' ', $formatted);
    }

    private function getCaller(): array
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);

        // Find the first frame that's not from this class or the global helper
        foreach ($trace as $frame) {
            if (!isset($frame['class']) || $frame['class'] !== self::class) {
                if (isset($frame['function']) && $frame['function'] === 'dat') {
                    continue;
                }
                return $frame;
            }
        }

        return $trace[0] ?? [];
    }

    private function isProduction(): bool
    {
        $env = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? getenv('APP_ENV') ?: 'development';
        return strtolower($env) === 'production';
    }

    private function reset(): void
    {
        $this->arguments = [];
        $this->color = null;
        $this->level = null;
        $this->screen = null;
        $this->shouldPause = false;
    }
}