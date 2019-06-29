<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 4:42 PM
 */

namespace Lvinkim\StdClassAdapter;

use Doctrine\Common\Annotations\AnnotationException;
use Lvinkim\JsonClassSetter\Exception\AdaptException;
use Lvinkim\StdClassAdapter\Annotations\Json;

/**
 * 负责 Entity 对象与 stdClass 对象之间转换
 * Class StdClassAdapter
 * @package Lvinkim\StdClassAdapter
 */
class StdClassAdapter
{
    /** @var AnnotationParser */
    private $annotationParser;

    /**
     * EntityConverter constructor.
     * @throws AdaptException
     */
    public function __construct()
    {
        try {
            $this->annotationParser = new AnnotationParser();
        } catch (AnnotationException $e) {
            throw new AdaptException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param \stdClass $object
     * @param string $entityClassName
     * @return mixed
     * @throws AdaptException
     */
    public function adaptToEntity(\stdClass $object, string $entityClassName)
    {
        if (!class_exists($entityClassName)) {
            throw new AdaptException("class {$entityClassName} not exist");
        }

        try {
            $reflectClass = new \ReflectionClass($entityClassName);
        } catch (\Throwable $exception) {
            throw new AdaptException($exception->getMessage(), $exception->getCode());
        }

        $entity = new $entityClassName();

        foreach ($reflectClass->getProperties() as $documentProperty) {
            $this->setPropertyValueToEntity($entity, $object, $documentProperty);
        }

        return $entity;
    }

    /**
     * 将 $object 的 $property 值赋值到 entity 对应的字段
     * @param $entity
     * @param \stdClass $object
     * @param \ReflectionProperty $property
     * @throws AdaptException
     */
    private function setPropertyValueToEntity($entity, \stdClass $object, \ReflectionProperty $property)
    {
        if ($property->isStatic()) {
            return;
        }

        $annotation = $this->annotationParser->getPropertyAnnotation($property);
        if (!($annotation instanceof Json)) {
            return;
        }

        $propertyName = strval($annotation->name ?? $property->getName());
        $propertyValue = $object->{$propertyName} ?? null;
        $propertyValue = $this->propertyToField($propertyValue, $annotation);

        $property->setAccessible(true);
        $property->setValue($entity, $propertyValue);
    }

    /**
     * 由 stdClass 属性 property 设置成对应的 Entity 字段 Field 属性
     * @param $propertyValue
     * @param Json $annotation
     * @return mixed
     * @throws AdaptException
     */
    private function propertyToField($propertyValue, Json $annotation)
    {
        $fieldType = $annotation->type;
        switch ($fieldType) {
            case 'string':
                $fieldValue = strval($propertyValue);
                break;
            case 'bool':
                $fieldValue = boolval($propertyValue);
                break;
            case 'int':
                $fieldValue = intval($propertyValue);
                break;
            case 'float':
                $fieldValue = floatval($propertyValue);
                break;
            case 'array':
                $fieldValue = is_array($propertyValue) ? $propertyValue : (array)($propertyValue);
                break;
            case 'embedOne':
                $fieldValue = $this->propertyToEmbedOne($propertyValue, $annotation);
                break;
            case 'embedMany':
                $fieldValue = $this->propertyToEmbedMany((array)$propertyValue, $annotation);
                break;
            case 'raw':
                $fieldValue = $propertyValue;
                break;
            default:
                $fieldValue = $propertyValue;
                break;
        }
        return $fieldValue;
    }

    /**
     * 由 stdClass 字段设置成对应的 Entity EmbedOne 对象
     * @param $document
     * @param Json $annotation
     * @return mixed
     * @throws AdaptException
     */
    private function propertyToEmbedOne(\stdClass $document, Json $annotation)
    {
        $className = $annotation->target;

        try {
            $reflectClass = new \ReflectionClass($className);
        } catch (\Throwable $exception) {
            throw new AdaptException($exception->getMessage(), $exception->getCode());
        }

        $embed = new $className;

        foreach ($reflectClass->getProperties() as $property) {
            $this->setPropertyValueToEntity($embed, $document, $property);
        }

        return $embed;
    }

    /**
     * 由 stdClass 字段设置成对应的 Entity EmbedMany 对象
     * @param array $properties
     * @param Json $annotation
     * @return array
     * @throws AdaptException
     */
    private function propertyToEmbedMany(array $properties, Json $annotation)
    {
        $embeds = [];
        foreach ($properties as $property) {
            $embeds[] = $this->propertyToEmbedOne($property, $annotation);
        }

        return $embeds;
    }

}