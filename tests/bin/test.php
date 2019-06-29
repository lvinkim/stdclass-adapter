<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 4:16 PM
 */

use Lvinkim\StdClassAdapter\StdClassAdapter;
use Lvinkim\StdClassAdapter\Tests\Entity\People;

require_once dirname(__DIR__) . "/../vendor/autoload.php";

$object = json_decode(file_get_contents(dirname(__DIR__) . "/var/test.json"));

try {
    /** @var People $people */
    $people = (new StdClassAdapter())->adaptToEntity($object, People::class);
} catch (\Lvinkim\JsonClassSetter\Exception\AdaptException $e) {
    var_dump($e->getMessage());
}


var_dump($people->getAddress()->getCity());
