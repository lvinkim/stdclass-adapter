<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 4:34 PM
 */

namespace Lvinkim\StdClassAdapter\Tests\Entity;

use Lvinkim\StdClassAdapter\Annotations as Json;

class Address
{
    /**
     * @var string
     * @Json\Json(type="string")
     */
    private $city;

    /**
     * @return string
     */
    public function getCity(): string
    {
        return strval($this->city ?? "");
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}