<?php
/**
 * Port Scanner Library
 *
 * A library for scanning ports on a given host.
 *
 * @category Library
 * @package  PortScanner
 * @version  1.0.0
 * @author   Ramazan Çetinkaya
 * @license  MIT License
 * @link     https://github.com/ramazancetinkaya/port-scanner
 */

declare(strict_types=1);

namespace PortScanner;

use InvalidArgumentException;

/**
 * Class PortScanner
 *
 * A port scanning utility for checking open ports on a given host.
 */
class PortScanner
{
    /**
     * Scan ports on the given host.
     *
     * @param string $host The host to scan.
     * @param int $startPort The starting port number.
     * @param int $endPort The ending port number.
     * @param int $timeout The timeout value for each port scan in seconds.
     * @return array An array containing the open ports on the host.
     * @throws InvalidArgumentException If the host is invalid or ports range is invalid.
     */
    public function scan(string $host, int $startPort, int $endPort, int $timeout = 1): array
    {
        if (!filter_var($host, FILTER_VALIDATE_IP) && !filter_var($host, FILTER_VALIDATE_DOMAIN)) {
            throw new InvalidArgumentException('Invalid host provided.');
        }

        if ($startPort < 1 || $endPort > 65535 || $startPort > $endPort) {
            throw new InvalidArgumentException('Invalid port range provided.');
        }

        $openPorts = [];

        for ($port = $startPort; $port <= $endPort; $port++) {
            $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);

            if (is_resource($connection)) {
                fclose($connection);
                $openPorts[] = $port;
            }
        }

        return $openPorts;
    }
}
