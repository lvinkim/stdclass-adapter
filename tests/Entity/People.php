<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 4:30 PM
 */

namespace Lvinkim\StdClassAdapter\Tests\Entity;

use Lvinkim\StdClassAdapter\Annotations as Json;

/**
 * Class People
 * @package Lvinkim\StdClassAdapter\Tests\Entity
 */
class People
{
    /**
     * @var string
     * @Json\Json(type="string")
     */
    private $name;

    /**
     * @var int
     * @Json\Json(type="int")
     */
    private $age;

    /**
     * @var Address
     * @Json\JsonEmbedOne(target="Lvinkim\StdClassAdapter\Tests\Entity\Address")
     */
    private $address;

    /**
     * @var string[]
     * @Json\Json(type="array")
     */
    private $tags;

    /**
     * @return string
     */
    public function getName(): string
    {
        return strval($this->name ?? "");
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return intval($this->age ?? 0);
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        if (!($this->address instanceof Address)) {
            $this->address = new Address();
        }
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return (array)($this->tags ?? []);
    }

    /**
     * @param string[] $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }


}