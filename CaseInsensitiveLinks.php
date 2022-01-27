<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, see https://www.gnu.org/licenses/.
 *
 */

class CaseInsensitiveLinks {
    public static function onHtmlPageLinkRendererEnd(\MediaWiki\Linker\LinkRenderer $linkRenderer, \MediaWiki\Linker\LinkTarget $target, $isKnown, &$text, &$attribs, &$ret) {
        if($isKnown) {
            return true;
        }

        // Ignore the namespaces that are always case insensitive
        $ns = $target->getNamespace();
        if($ns == NS_USER || $ns == NS_USER_TALK || $ns == -1) {
            return true;
        }

        // Check if it starts with upper or lowercase
        $chr = mb_substr($target->getText(), 0, 1, "UTF-8");
        if(mb_strtolower($chr, "UTF-8") == $chr) {
            $capitalize = true;
        } else {
            $capitalize = false;
        }

        // Create a link with the alternative capitalization
        $newlink = \Title::newFromText(CaseInsensitiveLinks::modify_first_char($target->getText(), $capitalize), $ns);

        // Render it if it exists
        if($newlink->exists()) {
            $ret = $linkRenderer->makeLink($newlink, \HtmlArmor::getHtml($text));
            return false;
        }

        return true;
    }

    private static function modify_first_char($string, $capitalize) {
        $firstChar = mb_substr($string, 0, 1, "UTF-8");
        $then = mb_substr($string, 1, null, "UTF-8");
        if($capitalize) {
            return mb_strtoupper($firstChar, "UTF-8") . $then;
        } else {
            return mb_strtolower($firstChar, "UTF-8") . $then;
        }
    }
}
?>
