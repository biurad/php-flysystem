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

namespace BiuradPHP\FileManager\Interfaces;

interface CloudConnectionInterface
{
    public const DEFAULT_CLOUD = 'ftp';

    /**
     * Make a new flysystem instance.
     *
     * @param string $driver
     *
     * @return FileManagerInterface
     */
    public function makeConnection(string $driver = self::DEFAULT_CLOUD): FileManagerInterface;
}
