<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 5:01 PM
 */

namespace Lvinkim\StdClassAdapter\Annotations;


use Doctrine\Common\Annotations\Annotation;

/**
 * Class Json
 * @package Lvinkim\StdClassAdapter\Annotations
 * @Annotation
 */
class Json extends Annotation
{
    const TYPES = [
        'string',
        'bool',
        'int',
        'float',
        'array',
        'raw',
        'embedMany',
        'embedOne',
    ];

    public $name;
    public $type = "string";
    public $target = "";
    public $options = [];
}