<?php

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
use Typo3Update\Options;
use Typo3Update\Sniffs\ExtendedPhpCsSupportTrait;
use Typo3Update\Sniffs\Removed\AbstractGenericPhpUsage;

class Typo3Update_Sniffs_Removed_GenericFunctionCallSniff extends AbstractGenericPhpUsage
{
    use ExtendedPhpCsSupportTrait;

    protected function getRemovedConfigFiles()
    {
        return Options::getRemovedFunctionConfigFiles();
    }

    protected function findRemoved(PhpCsFile $phpcsFile, $stackPtr)
    {
        if (!$this->isFunctionCall($phpcsFile, $stackPtr)) {
            return [];
        }

        return parent::findRemoved($phpcsFile, $stackPtr);
    }

    protected function getOldUsage(array $config)
    {
        $concat = '->';
        if ($config['static']) {
            $concat = '::';
        }
        return $config['fqcn'] . $concat . $config['name'];
    }
}
