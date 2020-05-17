<?php

declare(strict_types=1);

/*
 * This code is under BSD 3-Clause "New" or "Revised" License.
 *
 * PHP version 7 and above required
 *
 * @category  FileManager
 *
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @copyright 2019 Biurad Group (https://biurad.com/)
 * @license   https://opensource.org/licenses/BSD-3-Clause License
 *
 * @link      https://www.biurad.com/projects/filemanager
 * @since     Version 0.1
 */

namespace BiuradPHP\FileManager\Adapters;

use BiuradPHP\FileManager\Interfaces\ConnectorInterface;
use Google\Cloud\Storage\StorageClient;
use InvalidArgumentException;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

/**
 * This is the gcs connector class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Nir Radian <nirradi@gmail.com>
 */
class GoogleCloudStorageConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @return GoogleStorageAdapter
     */
    public function connect(array $config)
    {
        $auth = $this->getAuth($config);
        $client = $this->getClient($auth);
        $config = $this->getConfig($config);

        return $this->getAdapter($client, $config);
    }

    /**
     * Get the authentication data.
     *
     * @param string[] $config
     *
     * @return string[]
     * @throws InvalidArgumentException
     */
    protected function getAuth(array $config)
    {
        if (!array_key_exists('projectId', $config)) {
            throw new InvalidArgumentException('The gcs connector requires project id configuration.');
        }

        $auth = [
            'projectId' => $config['projectId'],
        ];

        if (array_key_exists('keyFile', $config)) {
            $auth['keyFilePath'] = $config['keyFile'];
        }

        return $auth;
    }

    /**
     * Get the gcs client.
     *
     * @param string[] $auth
     *
     * @return StorageClient
     */
    protected function getClient(array $auth)
    {
        return new StorageClient($auth);
    }

    /**
     * Get the configuration.
     *
     * @param string[] $config
     *
     * @throws InvalidArgumentException
     *
     * @return array
     */
    protected function getConfig(array $config)
    {
        if (!array_key_exists('bucket', $config)) {
            throw new InvalidArgumentException('The gcs connector requires bucket configuration.');
        }

        return array_intersect_key($config, array_flip(['bucket', 'prefix', 'apiUri']));
    }

    /**
     * Get the gcs adapter.
     *
     * @param StorageClient $client
     * @param string[] $config
     *
     * @return GoogleStorageAdapter
     */
    protected function getAdapter(StorageClient $client, array $config)
    {
        $bucket = $client->bucket($config['bucket']);

        $adapter = new GoogleStorageAdapter($client, $bucket);

        if (array_key_exists('prefix', $config)) {
            $adapter->setPathPrefix($config['prefix']);
        }

        if (array_key_exists('apiUri', $config)) {
            $adapter->setStorageApiUri($config['apiUri']);
        }

        return $adapter;
    }
}