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
use PHP_CodeSniffer_Tokens as Tokens;
use Typo3Update\Sniffs\Removed\AbstractGenericUsage;
use Typo3Update\Sniffs\Options;

/**
 * Sniff that handles all calls to removed functions.
 */
class Typo3Update_Sniffs_Removed_GenericFunctionCallSniff extends AbstractGenericUsage
{
    /**
     * Return file names containing removed configurations.
     *
     * @return array<string>
     */
    protected function getRemovedConfigFiles()
    {
        return Options::getRemovedFunctionConfigFiles();
    }

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array<int>
     */
    public function register()
    {
        return Tokens::$functionNameTokens;
    }

    /**
     * Check whether function at given point is removed.
     *
     * @return bool
     */
    protected function isRemoved(PhpCsFile $phpcsFile, $stackPtr)
    {
        if (!$this->isFunctionCall($phpcsFile, $stackPtr)) {
            return false;
        }

        return parent::isRemoved($phpcsFile, $stackPtr);
    }

    /**
     * The original function call, to allow user to check matches.
     *
     * As we match the function name, that can be provided by multiple classes,
     * you should provide an example, so users can check that this is the
     * legacy one.
     *
     * @param array $config The converted structure for a single function.
     *
     * @return string
     */
    protected function getOldUsage(array $config)
    {
        $concat = '->';
        if ($config['static']) {
            $concat = '::';
        }
        return $config['fqcn'] . $concat . $config['name'];
    }
}