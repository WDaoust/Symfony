<?php
// src/WD/PlatformBundle/Antispam/WDAntispam.php

namespace WD\PlatformBundle\Antispam;

class WDAntispam
{
	private $mailer;
	private $locale;
	private $minLength;
	
	public function __construct(\Swift_Mailer $mailer, $locale, $minLength)
	{
		$this->mailer 	=$mailer;
		$this->locale	=$locale;
		$this->minLength=(int) $minLength;
	}
  /**
   * V�rifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpam($text)
  {
    return strlen($text) < $this->minLength;
  }
}