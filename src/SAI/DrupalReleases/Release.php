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
 * <release>
 *     <name>drupal 7.22</name>
 *     <version>7.22</version>
 *     <tag>7.22</tag>
 *     <version_major>7</version_major>
 *     <version_patch>22</version_patch>
 *     <status>published</status>
 *     <release_link>http://drupal.org/drupal-7.22-release-notes</release_link>
 *     <download_link>
 *         http://ftp.drupal.org/files/projects/drupal-7.22.tar.gz
 *     </download_link>
 *     <date>1365027013</date>
 *     <mdhash>068d7a77958fce6bb002659aa7ccaeb7</mdhash>
 *     <filesize>3183014</filesize>
 *     <files>...</files>
 *     <terms>...</terms>
 * </release>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Release extends \ArrayObject
{

    /**
     *
     */
    public function __construct(\SimpleXMLElement $release)
    {
        $array = (array) $release;
        $array['files'] = new Files($array['files']);
        $array['terms'] = new Terms($array['terms']);

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     *
     */
    public function download()
    {
        // TODO
    }

}
