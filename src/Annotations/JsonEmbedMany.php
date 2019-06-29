<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 2019/6/29
 * Time: 5:06 PM
 */

namespace Lvinkim\StdClassAdapter\Annotations;

/**
 * Class JsonEmbedMany
 * @package Lvinkim\StdClassAdapter\Annotations
 * @Annotation
 */
final class JsonEmbedMany extends Json
{
    public $type = 'embedMany';
}