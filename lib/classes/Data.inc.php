<?php
/**
 * This is the Data class.
 *
 * It creates n object of the given records.
 *
 * @author Mark Lösche
 * @mail nenya1337@gmail.com
 * @date: Oct 9, 2022
 */
class Data {
    private $name;
    private $mail;
    private $hashCode;

    public function __construct($name, $mail, $hashcode){
        $this->name = $name;
        $this->mail = $mail;
        $this->hashCode = $hashcode;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getHashCode()
    {
        return $this->hashCode;
    }

    /**
     * @param mixed $hashCode
     */
    public function setHashCode($hashCode): void
    {
        $this->hashCode = $hashCode;
    }
}