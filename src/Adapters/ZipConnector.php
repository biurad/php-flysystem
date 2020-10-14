<?php

declare(strict_types=1);

/*
 * This file is part of Biurad opensource projects.
 *
 * PHP version 7.1 and above required
 *
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @copyright 2019 Biurad Group (https://biurad.com/)
 * @license   https://opensource.org/licenses/BSD-3-Clause License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Biurad\FileManager\Adapters;

use Biurad\FileManager\Interfaces\FlyAdapterInterface;
use InvalidArgumentException;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Config;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;

/**
 * This is the zip connector class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 * @author Divine Niiquaye Ibok <divineibok@gmail.com>
 */
class ZipConnector implements FlyAdapterInterface
{
    /**
     * {@inheritdoc}
     *
     * @return ZipArchiveAdapter
     */
    public function connect(Config $config): AdapterInterface
    {
        if (!$config->has('path')) {
            throw new InvalidArgumentException('The zip connector requires "path" configuration.');
        }

        return new ZipArchiveAdapter($config->get('path'));
    }
}
