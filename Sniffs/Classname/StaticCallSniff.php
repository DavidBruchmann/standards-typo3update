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

use Typo3Update\Sniffs\Classname\AbstractClassnameChecker;

class Typo3Update_Sniffs_Classname_StaticCallSniff extends AbstractClassnameChecker
{
    /**
     * Define whether the T_STRING default behaviour should be checked before
     * or after the $stackPtr.
     *
     * @return bool
     */
    protected function shouldLookBefore()
    {
        return true;
    }

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array<int>
     */
    public function register()
    {
        return [T_DOUBLE_COLON];
    }
}
