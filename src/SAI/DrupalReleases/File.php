<?php

/**
 * This file is part of the Drupal Releases package.
 *
 * (c) Shawn Iwinski <shawn.iwinski@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SAI\DrupalReleases;

/**
 * <file>
 *     <url>http://ftp.drupal.org/files/projects/drupal-7.22.tar.gz</url>
 *     <archive_type>tar.gz</archive_type>
 *     <md5>068d7a77958fce6bb002659aa7ccaeb7</md5>
 *     <size>3183014</size>
 *     <filedate>1365027013</filedate>
 * </file>
 * <file>
 *     <url>http://ftp.drupal.org/files/projects/drupal-7.22.zip</url>
 *     <archive_type>zip</archive_type>
 *     <md5>cc252b9ad65d4c639a7ff83978771749</md5>
 *     <size>3637890</size>
 *     <filedate>1365027014</filedate>
 * </file>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class File extends \ArrayObject
{

    /**
     *
     */
    public function __construct(\SimpleXMLElement $file)
    {
        parent::__construct((array) $file, \ArrayObject::STD_PROP_LIST);
    }

    /**
     *
     */
    public function download()
    {
        // TODO
    }

}
