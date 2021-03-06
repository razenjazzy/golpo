<?php

namespace React\Dns\Resolver;

use React\Cache\ArrayCache;
use React\Cache\CacheInterface;
use React\Dns\Config\HostsFile;
use React\Dns\Query\CachingExecutor;
use React\Dns\Query\CoopExecutor;
use React\Dns\Query\ExecutorInterface;
use React\Dns\Query\HostsFileExecutor;
use React\Dns\Query\RetryExecutor;
use React\Dns\Query\TimeoutExecutor;
use React\Dns\Query\UdpTransportExecutor;
use React\EventLoop\LoopInterface;

class Factory
{
    public function create($nameserver, LoopInterface $loop)
    {
        $nameserver = $this->addPortToServerIfMissing($nameserver);
        $executor = $this->decorateHostsFileExecutor($this->createRetryExecutor($loop));

        return new Resolver($nameserver, $executor);
    }

    public function createCached($nameserver, LoopInterface $loop, CacheInterface $cache = null)
    {
        // default to keeping maximum of 256 responses in cache unless explicitly given
        if (!($cache instanceof CacheInterface)) {
            $cache = new ArrayCache(256);
        }

        $nameserver = $this->addPortToServerIfMissing($nameserver);
        $executor = $this->decorateHostsFileExecutor($this->createCachedExecutor($loop, $cache));

        return new Resolver($nameserver, $executor);
    }

    /**
     * Tries to load the hosts file and decorates the given executor on success
     *
     * @param ExecutorInterface $executor
     * @return ExecutorInterface
     * @codeCoverageIgnore
     */
    private function decorateHostsFileExecutor(ExecutorInterface $executor)
    {
        try {
            $executor = new HostsFileExecutor(
                HostsFile::loadFromPathBlocking(),
                $executor
            );
        } catch (\RuntimeException $e) {
            // ignore this file if it can not be loaded
        }

        // Windows does not store localhost in hosts file by default but handles this internally
        // To compensate for this, we explicitly use hard-coded defaults for localhost
        if (DIRECTORY_SEPARATOR === '\\') {
            $executor = new HostsFileExecutor(
                new HostsFile("127.0.0.1 localhost\n::1 localhost"),
                $executor
            );
        }

        return $executor;
    }

    protected function createExecutor(LoopInterface $loop)
    {
        return new TimeoutExecutor(
            new UdpTransportExecutor($loop),
            5.0,
            $loop
        );
    }

    protected function createRetryExecutor(LoopInterface $loop)
    {
        return new CoopExecutor(new RetryExecutor($this->createExecutor($loop)));
    }

    protected function createCachedExecutor(LoopInterface $loop, CacheInterface $cache)
    {
        return new CachingExecutor($this->createRetryExecutor($loop), $cache);
    }

    protected function addPortToServerIfMissing($nameserver)
    {
        if (strpos($nameserver, '[') === false && substr_count($nameserver, ':') >= 2) {
            // several colons, but not enclosed in square brackets => enclose IPv6 address in square brackets
            $nameserver = '[' . $nameserver . ']';
        }
        // assume a dummy scheme when checking for the port, otherwise parse_url() fails
        if (parse_url('dummy://' . $nameserver, PHP_URL_PORT) === null) {
            $nameserver .= ':53';
        }

        return $nameserver;
    }
}
