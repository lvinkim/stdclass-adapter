# stdclass-adapter

将一个标准类 stdClass 对象适配成自定义的 class 类对象

#### 安装

```
$ composer require lvinkim/stdclass-adapter 
```

#### 应用场景

假设有 json 数据

```json

{
  "name": "lvinkim",
  "age": 18,
  "address": {
    "city": "guang zhou"
  },
  "tags": [
    "programmer"
  ]
}

```

通过 `json_decode` 方法能够获得一个 stdClass 类型的对像 `$object`

```
$json = '{
  "name": "lvinkim",
  "age": 18,
  "address": {
    "city": "guang zhou"
  },
  "tags": [
    "programmer"
  ]
}';
$object = json_decode($json);

```

假如，有一个类 People 定义如下：

```
use Lvinkim\StdClassAdapter\Annotations as Json;

class People
{
    /**
     * @var string
     * @Json\Json(type="string")
     */
    public $name;

    /**
     * @var int
     * @Json\Json(type="int")
     */
    public $age;

    /**
     * @var Address
     * @Json\JsonEmbedOne(target="Address")
     */
    public $address;

    /**
     * @var string[]
     * @Json\Json(type="array")
     */
    public $tags;
}

class Address
{
    /**
     * @var string
     * @Json\Json(type="string")
     */
    public $city;
}
```

可以通过 `StdClassAdapter` 可完成由 `$object` 适配成 `People` 类型的对象 `$people`

```
use Lvinkim\StdClassAdapter\StdClassAdapter;

$people = (new StdClassAdapter())->adaptToEntity($object, People::class);
```

#### 备注说明
支持的 Json 注释有

* JsonArray，表示适配为基础类型的数组
* JsonBool，表示适配为 bool 类型
* JsonEmbedMany，表示适配为对象数组，需要指定 target 为要适配的类名
* JsonEmbedOne，表示适配为对象，需要指定 target 为要适配的类名
* JsonFloat，表示适配为 float 类型
* JsonInt，表示适配为 int 类型
* JsonRaw，表示适配为保持原来的类型
* JsonString，表示适配为 string 类型
