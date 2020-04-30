<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

/*
    Id3v1 - Class for manipulating Id3v1 tags
    Copyright (C) 2007  Karol Babioch

    This program is free software; you can
    redistribute it  and/or modify it under the terms
    of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of
    the License, or (at your option) any later version.

    This program is distributed in the hope that it
    will be useful, but WITHOUT ANY WARRANTY; without
    even the implied warranty of MERCHANTABILITY or
    ITNESS FOR A PARTICULAR PURPOSE. See the GNU
    General Public License for more details.

    You should have received a copy of the GNU
    General Public License along with this program;
    if not, write to the Free Software Foundation,
    Inc., 51 Franklin St, Fifth Floor, Boston,
    MA 02110, USA
*/

use RuntimeException;

/**
 * @author      Karol Babioch <karol@babioch.de>
 * @copyright   Karol Babioch
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @package     Id3v1
 */

/**
 * This class offers you the posibility to manipulate Id3v1 tags
 * in a modern, object oriented, way.
 *
 * This class offers you to read and write Id3v1 in the version
 * 1.0 and 1.1. It implements a so called "fluent interface", so
 * the access is easy and effective.
 *
 * @version      1.0
 * @link         http://www.babioch.de/
 * @package      Id3v1
 * @author       Karol Babioch <karol@babioch.de>
 * @copyright    Karol Babioch
 * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 */
class Id3v1
{
    /**
     * Represents Id3v1.0
     */
    public const ID3V1_0 = 'ID3V1_0';
    /**
     * Represents Id3v1.1
     */
    public const ID3V1_1 = 'ID3V1_1';
    /**
     * Holds the tags
     *
     * @see __construct
     * @see getTitle()
     * @see getArtist()
     * @see getAlbum()
     * @see getYear()
     * @see getComment()
     * @see getTrack()
     * @see getGenre()
     * @see getGenreId()
     * @see setTitle()
     * @see setArtist()
     * @see setAlbum()
     * @see setYear()
     * @see setComment()
     * @see setTrack()
     * @see setGenre()
     * @see setGenreId()
     */
    protected $_tags = [];
    /**
     * Holds the PHP stream
     *
     * @see __construct()
     */
    protected $_stream = null;
    /**
     * Holds the Id3v1 version
     *
     * @see self::ID3V1_0
     * @see self::ID3V1_1
     * @see setId3v1Version()
     * @see getId3v1Version()
     */
    protected $_version = null;
    /**
     * Indicates if the source is read-only
     *
     * @see __construct()
     */
    protected $_readOnly = false;
    /**
     * Holds all known ID3 Genres
     *
     * @link http://id3.org/d3v2.3.0
     * @see  getGenreList()
     * @see  getGenreNameByid()
     * @see  getGenreIdByName()
     */
    protected static $_genres = [
        'Blues',
        'Classic Rock',
        'Country',
        'Dance',
        'Disco',
        'Funk',
        'Grunge',
        'Hip-Hop',
        'Jazz',
        'Metal',
        'New Age',
        'Oldies',
        'Other',
        'Pop',
        'R&B',
        'Rap',
        'Reggae',
        'Rock',
        'Techno',
        'Industrial',
        'Alternative',
        'Ska',
        'Death Metal',
        'Pranks',
        'Soundtrack',
        'Euro-Techno',
        'Ambient',
        'Trip-Hop',
        'Vocal',
        'Jazz+Funk',
        'Fusion',
        'Trance',
        'Classical',
        'Instrumental',
        'Acid',
        'House',
        'Game',
        'Sound Clip',
        'Gospel',
        'Noise',
        'Alternative Rock',
        'Bass',
        'Soul',
        'Punk',
        'Space',
        'Meditative',
        'Instrumental Pop',
        'Instrumental Rock',
        'Ethnic',
        'Gothic',
        'Darkwave',
        'Techno-Industrial',
        'Electronic',
        'Pop-Folk',
        'Eurodance',
        'Dream',
        'Southern Rock',
        'Comedy',
        'Cult',
        'Gangsta',
        'Top 40',
        'Christian Rap',
        'Pop/Funk',
        'Jungle',
        'Native US',
        'Cabaret',
        'New Wave',
        'Psychedelic',
        'Rave',
        'Showtunes',
        'Trailer',
        'Lo-Fi',
        'Tribal',
        'Acid Punk',
        'Acid Jazz',
        'Polka',
        'Retro',
        'Musical',
        'Rock & Roll',
        'Hard Rock',
        'Folk',
        'Folk-Rock',
        'National Folk',
        'Swing',
        'Fast Fusion',
        'Bebob',
        'Latin',
        'Revival',
        'Celtic',
        'Bluegrass',
        'Avantgarde',
        'Gothic Rock',
        'Progressive Rock',
        'Psychedelic Rock',
        'Symphonic Rock',
        'Slow Rock',
        'Big Band',
        'Chorus',
        'Easy Listening',
        'Acoustic',
        'Humour',
        'Speech',
        'Chanson',
        'Opera',
        'Chamber Music',
        'Sonata',
        'Symphony',
        'Booty Bass',
        'Primus',
        'Porn Groove',
        'Satire',
        'Slow Jam',
        'Club',
        'Tango',
        'Samba',
        'Folklore',
        'Ballad',
        'Power Ballad',
        'Rhytmic Soul',
        'Freestyle',
        'Duet',
        'Punk Rock',
        'Drum Solo',
        'Acapella',
        'Euro-House',
        'Dance Hall',
    ];

    /**
     * Class constructor
     *
     * Checks if the parameters are valid and then gets ID3 tags, if there
     * are some.
     *
     * @param      $filename
     * @param bool $readOnly
     * @see $_tags
     */
    public function __construct(
        $filename,
        $readOnly = false
    ) {
        if (\is_bool($readOnly)) {
            $this->_readOnly = $readOnly;
        }
        if (!\is_string($filename)) {
            throw new RuntimeException('Filename must be a string');
        }
        if (!\is_file($filename)) {
            throw new RuntimeException('File doesn\'t exist');
        }
        $mode = $this->_readOnly ? 'rb' : 'rb+';
        if (!$this->_stream = @\fopen($filename, $mode, false)) {
            throw new RuntimeException('File cannot be opened');
        }
        if (!$this->_readOnly) {
            \flock($this->_stream, \LOCK_SH);
        }
        \fseek($this->_stream, -128, \SEEK_END);
        $rawTag = \fread($this->_stream, 128);
        if ($rawTag[125] === \chr(0) && $rawTag[126] !== \chr(0)) {
            $format         = 'a3marking/a30title/a30artist/a30album/a4year' . '/a28comment/x1/C1track/C1genre';
            $this->_version = self::ID3V1_1;
        } else {
            $format         = 'a3marking/a30title/a30artist/a30album/a4year' . '/a30comment/C1genre';
            $this->_version = self::ID3V1_0;
        }
        $tags = \unpack($format, $rawTag);
        $this->clearAllTags();
        if ('TAG' === $tags['marking']) {
            $this->_tags = $tags;
        }
    }

    /**
     * Short way to access tags
     *
     * This method allows a shorter way to access tags.
     * You can access the tags like normal properties,
     * and don't have to call methods.
     *
     * Here an example:
     * <code>
     * <?php
     *     // two ways to do the same
     *     $id3v1->title;
     *     $id3v1->getTitle();
     * ?>
     * </code>
     *
     * @param string $name
     * @return mixed Depends on tag, which will be returned
     * @throws \Exception
     */
    public function __get(
        $name
    ) {
        $validNames = [
            'title',
            'artist',
            'album',
            'year',
            'comment',
            'track',
            'genre',
        ];
        if (\in_array($name, $validNames, true)) {
            return $this->{'get' . \ucfirst($name)}();
        }
        throw new RuntimeException('Property doesn\'t exist');
    }

    /**
     * Short way to assign tags
     *
     * This method allows a shorter way to assign tags.
     * You can assign the tags like normal properties,
     * and don't have to call methods.
     *
     * Here an example:
     * <code>
     * <?php
     *     // two ways to do the same
     *     $id3v1->title = 'Something';
     *     $id3v1->setTitle('Something);
     * ?>
     * </code>
     *
     * @param string $name
     * @param string $value
     * @return mixed Depends on tag
     * @throws \Exception
     */
    public function __set(
        $name,
        $value
    ) {
        $validNames = [
            'title',
            'artist',
            'album',
            'year',
            'comment',
            'track',
            'genre',
        ];
        if (\in_array($name, $validNames, true)) {
            return $this->{'set' . \ucfirst($name)}($value);
        }
        throw new RuntimeException('Property doesn\'t exist');
    }

    /**
     * Magic method, which gets called when casting to string
     *
     * This method will get called when the object will be used
     * in a context, which requires a string. You will get a
     * short overview over all meaningfully tags.
     *
     * Here an example:
     * <code>
     * <?php
     *     // casting to string
     *     echo $id3v1;
     * ?>
     * </code>
     *
     * @return string
     */
    public function __toString()
    {
        $returnedTags = [];
        foreach ($this->_tags as $tagKey => $tagVal) {
            if ('TAG' === $tagVal) {
                continue;
            }
            if (null === $tagVal || !$tagVal) {
                continue;
            }
            if ('genre' === $tagKey) {
                $returnedTags[] = self::getGenreNameById($tagVal);
                continue;
            }
            $returnedTags[] = $tagVal;
        }
        if (\count($returnedTags) > 0) {
            return \implode(', ', $returnedTags);
        }
    }

    /**
     * Gets the title out of the ID3 bytestream
     *
     * @return string
     */
    public function getTitle()
    {
        if (!empty($this->_tags['title'])) {
            return $this->_tags['title'];
        }
        return null;
    }

    /**
     * Gets the artist out of the ID3 bytestream
     *
     * @return string
     */
    public function getArtist()
    {
        if (!empty($this->_tags['artists'])) {
            return $this->_tags['artist'];
        }
        return null;
    }

    /**
     * Gets the album out of the ID3 bytestream
     *
     * @return string
     */
    public function getAlbum()
    {
        if (!empty($this->_tags['album'])) {
            return $this->_tags['album'];
        }
        return null;
    }

    /**
     * Gets the comment out of the ID3 bytestream
     *
     * @return string
     */
    public function getComment()
    {
        if (self::ID3V1_1 === $this->_version) {
            return mb_substr($this->_tags['comment'], 0, 28);
        }
        return $this->_tags['comment'];
    }

    /**
     * Gets the genre name in dependece of the genre id
     *
     * @return string
     * @uses getGenreNameById()
     */
    public function getGenre()
    {
        return self::getGenreNameById($this->_tags['genre']);
    }

    /**
     * Gets the genre id out of the ID3 bytestream
     *
     * @return int
     */
    public function getGenreId()
    {
        return $this->_tags['genre'];
    }

    /**
     * Gets the year out of the ID3 bytestream
     *
     * @return int
     */
    public function getYear()
    {
        if (!empty($this->_tags['year'])) {
            return (int)$this->_tags['year'];
        }
        return null;
    }

    /**
     * Gets the track number out of the ID3 bytestream
     *
     * @return mixed If there is no track false will be returned, else the track
     */
    public function getTrack()
    {
        if (self::ID3V1_0 === $this->_version || !isset($this->_tags['track'])) {
            return false;
        }
        return (int)$this->_tags['track'];
    }

    /**
     * Gets the Id3v1 version, which is used
     *
     * @return string
     * @see self::ID3V1_1
     * @see self::ID3V1_0
     */
    public function getId3v1Version()
    {
        return \constant('self::' . $this->_version);
    }

    /**
     * Sets the Id3v1 version, which will be used
     *
     * @param string $version The version you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see self::ID3V1_1
     * @see self::ID3V1_0
     */
    public function setId3v1Version(
        $version
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        switch ($version) {
            case self::ID3V1_0:
            case self::ID3V1_1:
                break;
            default:
                throw new RuntimeException('Invalid version');
        }
        $this->_version = $version;
        return $this;
    }

    /**
     * Sets the title
     *
     * The maximum length of this property, which will get stored is 30, even if
     * the method itself also accepts longer terms.
     *
     * @param string $title The title you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     */
    public function setTitle(
        $title
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        if (\is_string($title)) {
            $this->_tags['title'] = $title;
        } else {
            throw new RuntimeException('Title has to be a string');
        }
        return $this;
    }

    /**
     * Sets the artist
     *
     * The maximum length of this property, which will get stored is 30, even if
     * the method itself also accepts longer terms.
     *
     * @param string $artist The artist you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     */
    public function setArtist(
        $artist
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        if (\is_string($artist)) {
            $this->_tags['artist'] = $artist;
        } else {
            throw new RuntimeException('Artist has to be a string');
        }
        return $this;
    }

    /**
     * Sets the album
     *
     * The maximum length of this property, which will get stored is 30, even if
     * the method itself also accepts longer terms.
     *
     * @param string $album The album you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     */
    public function setAlbum(
        $album
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        if (\is_string($album)) {
            $this->_tags['album'] = $album;
        } else {
            throw new RuntimeException('Album has to be a string');
        }
        return $this;
    }

    /**
     * Sets the comment
     *
     * The maximum length of this property, which will get stored depends
     * on the used Id3v1 version. Where ID3V1_0 stores 30, ID3V1_1 just
     * stores 28 characters, in order to save place for the track number.
     * The method itselfs takes also longer terms.
     *
     * @param string $comment The comment you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     */
    public function setComment(
        $comment
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        if (\is_string($comment)) {
            $this->_tags['comment'] = $comment;
        } else {
            throw new RuntimeException('Comment has to be a string');
        }
        return $this;
    }

    /**
     * Sets the genre
     *
     * You can either use the genre id, or the genre name.
     *
     * @param string|int $genre The genre you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     */
    public function setGenre(
        $genre
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        if (\is_int($genre)) {
            $this->_tags['genre'] = $genre;
        } elseif (\is_string($genre)) {
            $this->_tags['genre'] = self::getGenreIdByName($genre);
        } else {
            throw new RuntimeException('Genre type invalid');
        }
        return $this;
    }

    /**
     * Sets the year
     *
     * @param int $year The year you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     */
    public function setYear(
        $year
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        if (\is_int($year)) {
            $this->_tags['year'] = $year;
        } else {
            throw new RuntimeException('Year has to be an interger');
        }
        return $this;
    }

    /**
     * Sets the track
     *
     * The Id3v1 version will be set automatically to ID3V1_1, because
     * this property is just defined there. If you want to store explicit
     * ID3V1_0 you have to set it manually after calling this method.
     *
     * @param int $track The tracl you want to set
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     * @see setId3v1Version()
     * @see getId3v1Version()
     */
    public function setTrack(
        $track
    ) {
        if ($this->_readOnly) {
            return $this;
        }
        if (\is_int($track) && 0 !== $track) {
            $this->_tags['track'] = $track;
            $this->_version       = self::ID3V1_1;
        } else {
            throw new RuntimeException('Track type invalid or zero');
        }
        return $this;
    }

    /**
     * Clears all tags
     *
     * This method sets the default value for each tag.
     *
     * @return Id3v1 Implements fluent interface
     * @see $_tags
     */
    public function clearAllTags()
    {
        if ($this->_readOnly) {
            return $this;
        }
        $this->_tags['marking'] = 'TAG';
        $this->_tags['title']   = '';
        $this->_tags['artist']  = '';
        $this->_tags['album']   = '';
        $this->_tags['year']    = null;
        $this->_tags['comment'] = '';
        $this->_tags['track']   = null;
        $this->_tags['genre']   = 255;
        return $this;
    }

    /**
     * Gets the genre id out of a genre name
     *
     * @param $genreName
     * @return int
     * @see $_genres
     */
    public static function getGenreIdByName(
        $genreName
    ) {
        $genres = \array_flip(self::$_genres);
        if (!isset($genres[$genreName])) {
            return 255;
        }
        return (int)$genres[$genreName];
    }

    /**
     * Gets the genre name out of a genre id
     *
     * @param $genreId
     * @return string|bool
     * @see $_genres
     */
    public static function getGenreNameById(
        $genreId
    ) {
        return self::$_genres[$genreId] ?? false;
    }

    /**
     * Returns a array with all defined genres
     *
     * @return array
     * @see $_genres
     */
    public static function getGenreList()
    {
        return self::$_genres;
    }

    /**
     * Saves the set tags to the file
     *
     * This method saves the set tags to the file. Therefore it seeks to
     * the end of the file and writes the Id3v1 bytestream to it.
     *
     * @return Id3v1 Implements fluent interface
     * @throws \Exception
     * @see $_tags
     * @see setTitle()
     * @see setArtist()
     * @see setAlbum()
     * @see setComment()
     * @see setGenre()
     * @see setYear()
     * @see setTrack()
     */
    public function save()
    {
        if ($this->_readOnly) {
            return $this;
        }
        \fseek($this->_stream, -128, \SEEK_END);
        if ('TAG' !== $this->_tags['marking']) {
            \fseek($this->_stream, 0, \SEEK_END);
        }
        $newTag = '';
        if (self::ID3V1_0 === $this->_version) {
            $newTag = \pack(
                'a3a30a30a30a4a30C1',
                'TAG',
                $this->_tags['title'],
                $this->_tags['artist'],
                $this->_tags['album'],
                $this->_tags['year'],
                $this->_tags['comment'],
                $this->_tags['genre']
            );
        } else {
            $newTag = \pack(
                'a3a30a30a30a4a28x1C1C1',
                'TAG',
                $this->_tags['title'],
                $this->_tags['artist'],
                $this->_tags['album'],
                $this->_tags['year'],
                $this->_tags['comment'],
                $this->_tags['track'],
                $this->_tags['genre']
            );
        }
        if (false === \fwrite($this->_stream, $newTag, 128)) {
            throw new RuntimeException('Not possible to write ID3 tags');
        }
        return $this;
    }
}
