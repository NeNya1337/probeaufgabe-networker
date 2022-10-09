<?php
/**
 * This is the hash class.
 *
 * It creates a cryptographically secure hash with given length.
 *
 * @author Mark Lösche
 * @mail nenya1337@gmail.com
 * @date: Oct 9, 2022
 */

class Hash {
    /**
     * @var string
     */
    private $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    /**
     * @param int $length
     * @return string
     */
    public function getHash(int $length): string
    {
        $token = "";
        for($i = 0; $i < $length; $i++){
            $token .=  $this->codeAlphabet[$this->getRandomNumber()-1];
        }
        return $token;
    }

    /**
     * @return int
     */
    private function getRandomNumber(): int
    {
        $range = strlen($this->codeAlphabet);
        $log = ceil(log($range, 2));
        $bytes = (int) ($log/8)+1;
        $bits = (int) $log+1;
        $filter = (int) (1 << $bits) -1;
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $rnd;
    }
}