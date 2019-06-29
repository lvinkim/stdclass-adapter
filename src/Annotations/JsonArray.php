<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 5:06 PM
 */

namespace Lvinkim\StdClassAdapter\Annotations;


/**
 * Class JsonArray
 * @package Lvinkim\StdClassAdapter\Annotations
 * @Annotation
 */
final class JsonArray extends Json
{
    public $type = 'array';
}