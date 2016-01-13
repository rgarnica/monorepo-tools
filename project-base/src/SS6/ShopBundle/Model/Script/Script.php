<?php

namespace SS6\ShopBundle\Model\Script;

use Doctrine\ORM\Mapping as ORM;
use SS6\ShopBundle\Model\Script\ScriptData;

/**
 * @ORM\Table(name="scripts")
 * @ORM\Entity
 */
class Script {

	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	private $code;

	/**
	 * @param \SS6\ShopBundle\Model\Script\ScriptData $scriptData
	 */
	public function __construct(ScriptData $scriptData) {
		$this->name = $scriptData->name;
		$this->code = $scriptData->code;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
}
