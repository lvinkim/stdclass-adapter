<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 4:56 PM
 */

namespace Lvinkim\StdClassAdapter;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Lvinkim\StdClassAdapter\Annotations\Json;

class AnnotationParser
{
    /** @var AnnotationReader */
    private $annotationReader;

    private static $registered = false;

    /**
     * EntityConverter constructor.
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct()
    {
        if (!self::$registered) {
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/Json.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonArray.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonBool.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonEmbedMany.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonEmbedOne.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonFloat.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonInt.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonRaw.php');
            AnnotationRegistry::registerFile(__DIR__ . '/Annotations/JsonString.php');

            self::$registered = true;
        }

        $this->annotationReader = new AnnotationReader();
    }

    /**
     * 获取属性的 Field 声明
     * @param $property
     * @return null|Json
     */
    public function getPropertyAnnotation($property): ?Json
    {
        return $this->annotationReader->getPropertyAnnotation($property, Json::class);
    }
}