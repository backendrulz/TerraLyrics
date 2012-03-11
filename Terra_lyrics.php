<?php
ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');

/**
 * Terra_lyrics class
 * @author Cristian Ferreyra
 * @copyright Copyright (c) 2012, Cristian Ferrerya
 * @desc Get song lyrics from Terra.com.br
 */
class Terra_lyrics
{

    private $url = 'http://letras.terra.com.br/winamp.php?t=';
    private $lyrics;

    function __toString()
    {
        return $this->getLyrics();
    }

    /**
     * Search the song a retrieve the lyrics
     * @param type $songName
     * @return boolean
     */
    public function search($songName)
    {
        $lyrics = $this->fetch($songName);

        if (!$lyrics) {
            $newName = implode(' - ', array_reverse(explode(' - ', $songName)));
            $lyrics = $this->fetch($newName);
        }

        if ($lyrics) {
            $this->lyrics = $lyrics;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Fetch the raw data from Terra
     * @param type $songName
     * @return boolean|array
     */
    private function fetch($songName)
    {
        $ctx = stream_context_create(array('http' => array('timeout' => 50)));
        $raw = file_get_contents($this->url . rawurlencode($songName), 0, $ctx);

        $out = array();
        preg_match_all('#<p>(.*)</p>#Us', $raw, $out, PREG_SET_ORDER);

        if (!isset($out[0][1])) {
            return false;
        }

        $lyrics = $out[0][1];

        if (strpos($lyrics, 'contribuicoes/') === FALSE && strpos($lyrics, 'banco de dados') === FALSE && strpos($lyrics, 'entre as letras de ') == FALSE) {
            return $lyrics;
        } else {
            return FALSE;
        }
    }

    /**
     * Return the lyrics
     * @return type
     */
    public function getLyrics()
    {
        return (string) $this->lyrics;
    }

}