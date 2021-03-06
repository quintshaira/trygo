<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2016 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Escaper;

/**
 * @since 0.13.0
 */
class RegExp implements EscaperInterface
{
    const REG_EXP_DELIMITER = '/';

    /**
     * @param string $subject
     *
     * @return string
     */
    protected static function escapeSingleItem($subject)
    {
        return self::REG_EXP_DELIMITER . preg_quote($subject, self::REG_EXP_DELIMITER) . self::REG_EXP_DELIMITER . 'u';
    }

    public static function escape($subject)
    {
        if (is_array($subject)) {
            foreach ($subject as &$item) {
                $item = self::escapeSingleItem($item);
            }
        } else {
            $subject = self::escapeSingleItem($subject);
        }

        return $subject;
    }
}
