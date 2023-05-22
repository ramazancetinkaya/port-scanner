# Port scanner
A library for scanning ports on a given host

## Overview

- The `PortScanner` class provides a `scan` method that takes the host, start port, end port, and optional timeout as parameters and returns an array of open ports on the host.
- The `PortScanner` class is organized under the `PortScanner` namespace to prevent naming conflicts.
- The `scan` method validates the host parameter using the `FILTER_VALIDATE_IP` and `FILTER_VALIDATE_DOMAIN` filters. If the host is invalid, an `InvalidArgumentException` is thrown.
- The method also validates the port range to ensure it is within valid limits (1 to 65535) and that the start port is not greater than the end port. If the port range is invalid, an InvalidArgumentException is thrown.
- The method loops through each port in the given range and attempts to establish a connection using `fsockopen`. If a connection is successful (resource is created), the port is considered open, and it is added to the `$openPorts` array.
- The method returns the array of open ports once the scan is complete.
- Error handling is implemented using error suppression (`@` operator) and checking if the connection resource is created to avoid displaying errors to users and to handle closed ports gracefully.
- The `declare(strict_types=1)` statement enforces strict typing, which improves code reliability.

## Example Usage

```php
<?php

use PortScanner\PortScanner;

try {
    // Create an instance of PortScanner
    $scanner = new PortScanner();

    // Scan ports on a host
    $host = 'example.com';
    $startPort = 1;
    $endPort = 100;
    $timeout = 1; // Optional, defaults to 1 second

    $openPorts = $scanner->scan($host, $startPort, $endPort, $timeout);

    // Process the open ports
    if (!empty($openPorts)) {
        echo "Open ports on $host:\n";
        foreach ($openPorts as $port) {
            echo "$port\n";
        }
    } else {
        echo "No open ports found on $host in the given range.\n";
    }
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}
```

In this example, we create an instance of `PortScanner`, set the host, start port, end port, and optional timeout values, and then call the `scan()` method. If any exceptions are thrown during the process, they are caught and appropriate error messages are displayed.

The open ports returned by the `scan()` method are then processed and either displayed or used for further actions.
