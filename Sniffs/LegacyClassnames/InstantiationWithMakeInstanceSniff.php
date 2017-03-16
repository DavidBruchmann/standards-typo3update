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

use PHP_CodeSniffer_Tokens as Tokens;

/**
 * Detect and migrate static calls to old legacy classnames.
 */
class Typo3Update_Sniffs_LegacyClassnames_InstantiationWithMakeInstanceSniff implements PHP_CodeSniffer_Sniff
{
    use \Typo3Update\Sniffs\LegacyClassnames\ClassnameCheckerTrait;
    use \Typo3Update\Sniffs\ExtendedPhpCsSupportTrait;

    /**
     * Original token content for reuse accross methods.
     * @var string
     */
    protected $originalTokenContent = '';

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
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if (!$this->isFunctionCall($phpcsFile, $stackPtr)) {
            return;
        }
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['content'] !== 'makeInstance') {
            return;
        }

        $classnamePosition = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $stackPtr);
        if ($classnamePosition === false) {
            return;
        }

        $classname = trim($tokens[$classnamePosition]['content'], '\'"');
        $this->originalTokenContent = $tokens[$classnamePosition]['content'];
        $this->addFixableError($phpcsFile, $classnamePosition, $classname);
    }

    /**
     * As token contains more then just class name, we have to build new content ourself.
     *
     * @param string $classname
     * @return string
     */
    protected function getTokenForReplacement($classname)
    {
        $stringSign = $this->originalTokenContent[0];
        $token = explode($stringSign, $this->originalTokenContent);
        $token[1] = $classname;

        // Migrate double quote to single quote.
        // This way no escaping of backslashes in class names is necessary.
        if ($stringSign === '"') {
            $stringSign = "'";
        }

        return implode($stringSign, $token);
    }
}