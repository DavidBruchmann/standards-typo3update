<?php
namespace Typo3Update;

/*
 * Copyright (C) 2017  Daniel Siepmann <coding@daniel-siepmann.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301, USA.
 */

use PHP_CodeSniffer_File as PhpCsFile;
use Typo3Update\RemovedByYamlConfiguration;

abstract class AbstractYamlRemovedUsage
{
    protected $configured;

    public function __construct()
    {
        $this->configured = new RemovedByYamlConfiguration(
            $this->getRemovedConfigFiles(),
            $this->getPrepareStructureCallback()
        );
    }

    protected function getPrepareStructureCallback()
    {
        return function (array $typo3Versions) {
            return call_user_func_array([$this, 'prepareStructure'], [$typo3Versions]);
        };
    }

    abstract protected function prepareStructure(array $typo3Versions);

    abstract protected function getRemovedConfigFiles();

    protected function addWarning(PhpCsFile $phpcsFile, $stackPtr, array $removed)
    {
        $phpcsFile->addWarning(
            'Calls to removed code are not allowed; found %s. Removed in %s. %s. See: %s',
            $stackPtr,
            $removed['identifier'],
            [
                $removed['oldUsage'],
                $removed['versionRemoved'],
                $this->getReplacement($removed),
                $removed['docsUrl'],
            ]
        );
    }

    protected function getReplacement(array $config)
    {
        $newCall = $config['replacement'];
        if ($newCall !== null) {
            return $newCall;
        }
        return 'There is no replacement, just remove call';
    }
}
