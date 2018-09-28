### 101.设置表主键 ###

     protected $primaryKey='art_id';

### 102.设置默认时间戳 ###

    public $timestamps=false;

### 103.批量赋值保护 ###

     protected $guarded=[];

### 104.为模型指定不同的链接 ###

    protected $connection = 'connection-name';

### 105.取回多个模型 ###

    $flights = Flight::all();

### 106.增加额外限制 ###

    $flights = App\Flight::where('active', 1)
               ->orderBy('name', 'desc')
               ->take(10)
               ->get();

### 107.通过主键取回一个模型 ###

	$data=Navs::find($id);

### 108.取回符合限制条件的第一个模型 ###

	$flight = App\Flight::where('active', 1)->first();

### 109.抛出未找到异常 ###

	$model = App\Flight::findOrFail(1);
	
	$model = App\Flight::where('legs', '>', 100)->firstOrFail();

在找不到模型时抛出一个异常，如果捕捉到异常，则自动送回http 404响应给用户

### 109.取回集合 ###

	$count = App\Flight::where('active', 1)->count();
	
	$max = App\Flight::where('active', 1)->max('price');

### 110.基本添加 ###

	public function store(Request $request)
    {
        // 验证请求...

        $flight = new Flight;

        $flight->name = $request->name;

        $flight->save();
    }

### 111.基本更新 ###

	$flight = App\Flight::find(1);
	
	$flight->name = 'New Flight Name';
	
	$flight->save()

### 112.批量赋值白名单 ###

	protected $fillable = ['name'];

### 113.删除模型 ###

	$flight = App\Flight::find(1);
	
	$flight->delete();

### 114.通过键删除模型 ###

	App\Flight::destroy(1);
	
	App\Flight::destroy([1, 2, 3]);
	
	App\Flight::destroy(1, 2, 3);

### 115.通过查找删除模型 ###

	$re=Navs::where('nav_id',$id)->delete();

### 116.Eloquent集合 ###

	$users = App\User::where('active', 1)->get();

### 117.Eloquent集合所有方法###

- all
- avg
- chunk
- collapse
- combine
- contains
- count
- diff
- diffKeys
- each
- every
- except
- filter
- first
- flatMap
- flatten
- flip
- forget
- forPage
- get
- groupBy
- has
- implode
- intersect
- isEmpty
- keyBy
- keys
- last
- map
- max
- merge
- min
- only
- pluck
- pop
- prepend
- pull
- push
- put
- random
- reduce
- reject
- reverse
- search
- shift
- shuffle
- slice
- sort
- sortBy
- sortByDesc
- splice
- sum
- take
- toArray
- toJson
- transform
- union
- unique
- values
- where
- whereLoose
- whereIn
- whereInLoose
- zip


### 118.集合对象-map ###

	$data=Links::orderBy('link_order','asc')->get();
    $names=$data->map(function($name){
        return $name->link_name;
    });
    dd($names);

输出

	Collection {#245 ▼
	  #items: array:3 [▼
	    0 => "百度"
	    1 => "雅虎"
	    2 => "google"
	  ]
	}

### 119.集合对象-all(所有) ###

	$data=Links::orderBy('link_order','asc')->get();
    $names=$data->all(function($name){
        return $name->link_name;
    });
    dd($names);

输出

	array:3 [▼
	  0 => Links {#258 ▶}
	  1 => Links {#259 ▶}
	  2 => Links {#260 ▶}
	]

### 120.集合对象-avg(平均值) ###

	$data=Links::orderBy('link_order','asc')->get();
    $names=$data->avg(function($name){
        return $name->link_order;
    });
    dd($names);

### 121.集合对象-chunk(将集合拆成多个指定大小的较小集合) ###

	$names=$data->chunk(3);
    dd($names->toArray());

输出

	array:5 [▼
	  0 => array:3 [▶]
	  1 => array:3 [▶]
	  2 => array:3 [▶]
	  3 => array:3 [▶]
	  4 => array:1 [▶]
	]

这个方法适用于网格系统如Bootstrap的视图

	@foreach ($products->chunk(3) as $chunk)
	    <div class="row">
	        @foreach ($chunk as $product)
	            <div class="col-xs-4">{{ $product->name }}</div>
	        @endforeach
	    </div>
	@endforeach

### 122.集合对象-collapse(将多个数组组成的集合合成单个数组集合) ###

	$collection = collect([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);

    $collapsed = $collection->collapse();

    dd($collapsed->all());

输出

	array:9 [▼
	  0 => 1
	  1 => 2
	  2 => 3
	  3 => 4
	  4 => 5
	  5 => 6
	  6 => 7
	  7 => 8
	  8 => 9
	]

### 123.集合对象-combine(将集合的值作为键，合并另一个数组或者集合作为键对应的值) ###

对应英文：The combine method combines the keys of the collection with the values of another array or collection:

	$collection = collect(['name', 'age']);
	
	$combined = $collection->combine(['George', 29]);
	
	$combined->all();

输出

	array:2 [▼
	  "name" => "George"
	  "age" => 29
	]

### 124.集合对象-contains(判断集合是否含有指定项目) ###

	$collection = collect(['name' => 'Desk', 'price' => 100]);
	
	$collection->contains('Desk');

输出

	true

### 125.集合对象count(项目总数) ###

	$data=Links::orderBy('link_order','asc')->get();
    $contains=$data->count();

    dd($contains);

### 126.集合对象-diff(将集合与其他集合或者php数组比较) ###



	$collection = collect([1, 2, 3, 4, 5]);
	
	$diff = $collection->diff([2, 4, 6, 8]);
	
	$diff->all();


### 127.集合对象-each(遍历集合中的项目，并将之传入回调函数) ###

	$collection = $collection->each(function ($item, $key) {
	    //
	});

### 128.集合对象-every(创建每包含第n个元素的新集合) ###

	$collection = collect(['a', 'b', 'c', 'd', 'e', 'f']);
	
	$collection->every(4);

输出

	Collection {#245 ▼
	  #items: array:2 [▼
	    0 => "a"
	    1 => "e"
	  ]
	}

### 129.集合对象-except(返回集合中除了指定键的所有项目) ###

	$collection = collect(['product_id' => 1, 'name' => 'Desk', 'price' => 100, 'discount' => false]);
	
	$filtered = $collection->except(['price', 'discount']);
	
	$filtered->all();

输出

	['product_id' => 1, 'name' => 'Desk']

### 130.集合对象-filter(使用回调函数筛选集合，只留下通过判断测试的项目) ###

	$collection = collect([1, 2, 3, 4]);
	
	$filtered = $collection->filter(function ($item) {
	    return $item > 2;
	});
	
	$filtered->all();

### 131.集合对象first(返回集合第一个通过制定测试的元素) ###

	$data=Links::orderBy('link_order','asc')->first();
    dd($data);

输出
	
    Links {#256 ▼
	  #table: "links"
	  #primaryKey: "link_id"
	  +timestamps: false
	  #guarded: []
	  #connection: null
	  #keyType: "int"
	  #perPage: 15
	  +incrementing: true
	  #attributes: array:5 [▶]
	  #original: array:5 [▶]
	  #relations: []
	  #hidden: []
	  #visible: []
	  #appends: []
	  #fillable: []
	  #dates: []
	  #dateFormat: null
	  #casts: []
	  #touches: []
	  #observables: []
	  #with: []
	  #morphClass: null
	  +exists: true
	  +wasRecentlyCreated: false
	}

### 132.集合对象-flatten（将多维集合转为一维集合） ###

	$collection = collect(['name' => 'taylor', 'languages' => ['php', 'javascript']]);
	
	$flattened = $collection->flatten();
	
	$flattened->all();

### 133.集合对象-flip（将集合中的键和对应的值进行互换) ###

	$collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
	
	$flipped = $collection->flip();
	
	dd($flipped->all());

输出

	array:2 [▼
	  "taylor" => "name"
	  "laravel" => "framework"
	]

### 134.通过集合的键来移除集合中的一个项目 ###

	$collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
	
	$collection->forget('name');
	
	$collection->all();

输出

	[framework' => 'laravel']


> 注意：与大多数其它集合的方法不同，forget 不会返回修改过后的新集合；它会直接修改调用它的集合。

### 135.集合对象-has(检查集合中是否含有指定的键) ###

	$collection = collect(['account_id' => 1, 'product' => 'Desk']);
	
	$collection->has('email');

### 136.集合对象-implode(合并集合中的项目) ###

	$collection = collect([
	    ['account_id' => 1, 'product' => 'Desk'],
	    ['account_id' => 2, 'product' => 'Chair'],
	]);
	
	$collection->implode('product', ', ');

输出

	Desk, Chair

或者

	collect([1, 2, 3, 4, 5])->implode('-');

输出

	'1-2-3-4-5'

### 137.集合对象-intersect(移除任何指定数组或者集合内没有的数值) ###

	$collection = collect(['Desk', 'Sofa', 'Chair']);
	
	$intersect = $collection->intersect(['Desk', 'Chair', 'Bookcase']);
	
	$intersect->all();

输出

	[0 => 'Desk', 2 => 'Chair']

相当于去交集

### 138.集合对象-last(返回集合中，最后一个通过指定测试的元素) ###

	$data=Links::orderBy('link_order','asc')->get();
	$keys=$data->last(function($key,$value){
	    return $key<4;
	});
	dd($keys);

### 139.集合对象-max(计算指定键的最大值) ###

	$data=Links::orderBy('link_order','asc')->get();
	$max=$data->max();
	dd($max);

输出最大键对应的结果

### 140.集合对象-only(返回集合中指定键的所有项目) ###

	$collection = collect(['product_id' => 1, 'name' => 'Desk', 'price' => 100, 'discount' => false]);
	
	$filtered = $collection->only(['product_id', 'name']);
	
	$filtered->all();

输出

	['product_id' => 1, 'name' => 'Desk']

### 141.集合对象-pluck(获取所有集合中指定键对应的值) ###

	$data=Links::orderBy('link_order','asc')->get();
	$max=$data->pluck('link_name','link_id');
	dd($max);

输出

	Collection {#245 ▼
	  #items: array:13 [▼
	    6 => "百度"
	    8 => "百度1"
	    10 => "百度2"
	    12 => "百度3"
	    14 => "百度4"
	    1 => "百度"
	    4 => "雅虎"
	    7 => "google"
	    9 => "google1"
	    11 => "google2"
	    13 => "google3"
	    15 => "google4"
	    2 => "google"
	  ]
	}

### 142.集合对象-pop(移除并返回集合最后一个项目) ###

	$collection = collect([1, 2, 3, 4, 5]);
	
	$collection->pop();

	$collection->all();

输出
	
 	[1, 2, 3, 4]
### 143.集合对象-prepend(集合前面添加一个项目) ###

	$data=Links::orderBy('link_order','asc')->get();
    $max=$data->prepend(0);
    dd($data);

输出

	Collection {#267 ▼
	  #items: array:14 [▼
	    0 => 0
	    1 => Links {#268 ▶}
	    2 => Links {#269 ▶}
	    3 => Links {#270 ▶}
	    4 => Links {#271 ▶}
	    5 => Links {#272 ▶}
	    6 => Links {#273 ▶}
	    7 => Links {#274 ▶}
	    8 => Links {#275 ▶}
	    9 => Links {#276 ▶}
	    10 => Links {#277 ▶}
	    11 => Links {#278 ▶}
	    12 => Links {#279 ▶}
	    13 => Links {#280 ▶}
	  ]
	}

也可以传递第二个参数，指定这个值对应的键

	$data=Links::orderBy('link_order','asc')->get();
    $max=$data->prepend(0,'aaa');
    dd($data);

输出

	Collection {#267 ▼
	  #items: array:14 [▼
	    "aaa" => 0
	    0 => Links {#268 ▶}
	    1 => Links {#269 ▶}
	    2 => Links {#270 ▶}
	    3 => Links {#271 ▶}
	    4 => Links {#272 ▶}
	    5 => Links {#273 ▶}
	    6 => Links {#274 ▶}
	    7 => Links {#275 ▶}
	    8 => Links {#276 ▶}
	    9 => Links {#277 ▶}
	    10 => Links {#278 ▶}
	    11 => Links {#279 ▶}
	    12 => Links {#280 ▶}
	  ]
	}

### 144.集合对象-pull(把键对应的值从集合中移除并返回) ###

	$data=Links::orderBy('link_order','asc')->get();
    $max=$data->pull(5);
    dd($data);

输出

	Collection {#267 ▼
	  #items: array:12 [▼
	    0 => Links {#268 ▶}
	    1 => Links {#269 ▶}
	    2 => Links {#270 ▶}
	    3 => Links {#271 ▶}
	    4 => Links {#272 ▶}
	    6 => Links {#274 ▶}
	    7 => Links {#275 ▶}
	    8 => Links {#276 ▶}
	    9 => Links {#277 ▶}
	    10 => Links {#278 ▶}
	    11 => Links {#279 ▶}
	    12 => Links {#280 ▶}
	  ]
	}

### 145.集合对象push(在集合后面添加一个元素) ###

	$data=Links::orderBy('link_order','asc')->get();
    $max=$data->push(5);
    dd($data);

输出

	Collection {#267 ▼
	  #items: array:14 [▼
	    0 => Links {#268 ▶}
	    1 => Links {#269 ▶}
	    2 => Links {#270 ▶}
	    3 => Links {#271 ▶}
	    4 => Links {#272 ▶}
	    5 => Links {#273 ▶}
	    6 => Links {#274 ▶}
	    7 => Links {#275 ▶}
	    8 => Links {#276 ▶}
	    9 => Links {#277 ▶}
	    10 => Links {#278 ▶}
	    11 => Links {#279 ▶}
	    12 => Links {#280 ▶}
	    13 => 5
	  ]
	}

### 146.集合对象-put(在集合内设置一个键值) ###

	$data=Links::orderBy('link_order','asc')->get();
    $max=$data->put('aa','bbb');
    dd($data);
输出

	Collection {#267 ▼
	  #items: array:14 [▼
	    0 => Links {#268 ▶}
	    1 => Links {#269 ▶}
	    2 => Links {#270 ▶}
	    3 => Links {#271 ▶}
	    4 => Links {#272 ▶}
	    5 => Links {#273 ▶}
	    6 => Links {#274 ▶}
	    7 => Links {#275 ▶}
	    8 => Links {#276 ▶}
	    9 => Links {#277 ▶}
	    10 => Links {#278 ▶}
	    11 => Links {#279 ▶}
	    12 => Links {#280 ▶}
	    "aa" => "bbb"
	  ]
	}

也可以更换已有键的值

	$data=Links::orderBy('link_order','asc')->get();
    $max=$data->put(5,'bbb');
    dd($data);

输出

	Collection {#267 ▼
	  #items: array:13 [▼
	    0 => Links {#268 ▶}
	    1 => Links {#269 ▶}
	    2 => Links {#270 ▶}
	    3 => Links {#271 ▶}
	    4 => Links {#272 ▶}
	    5 => "bbb"
	    6 => Links {#274 ▶}
	    7 => Links {#275 ▶}
	    8 => Links {#276 ▶}
	    9 => Links {#277 ▶}
	    10 => Links {#278 ▶}
	    11 => Links {#279 ▶}
	    12 => Links {#280 ▶}
	  ]
	}

### 147.集合对象-random(从集合中随机取出一个项目) ###

	$data=Links::orderBy('link_order','asc')->get();
    $max=$data->random();
    dd($max);

输出

	Links {#275 ▼
	  #table: "links"
	  #primaryKey: "link_id"
	  +timestamps: false
	  #guarded: []
	  #connection: null
	  #keyType: "int"
	  #perPage: 15
	  +incrementing: true
	  #attributes: array:5 [▶]
	  #original: array:5 [▶]
	  #relations: []
	  #hidden: []
	  #visible: []
	  #appends: []
	  #fillable: []
	  #dates: []
	  #dateFormat: null
	  #casts: []
	  #touches: []
	  #observables: []
	  #with: []
	  #morphClass: null
	  +exists: true
	  +wasRecentlyCreated: false
	}

### 147.集合对象-reduce(将集合缩缩减到单个数值，该方法将每次迭代的结果传入到下一次迭代) ###

	$collection = collect([1, 2, 3]);
	
	$total = $collection->reduce(function ($carry, $item) {
	    return $carry + $item;
	});

输出

	6

### 148.集合对象-reject(以指定的回调函数筛选集合，该回调函数应该对希望从最终集合移除掉的项目返回true) ###

	$collection = collect([1, 2, 3, 4]);
	
	$filtered = $collection->reject(function ($item) {
	    return $item > 2;
	});
	
	$filtered->all();

输出

	[1, 2]

### 148.集合对象-reverse(倒转集合内项目的顺序) ###

	$collection = collect([1, 2, 3, 4, 5]);
	
	$reversed = $collection->reverse();
	
	$reversed->all();

输出

	[5, 4, 3, 2, 1]

### 149.集合对象-shift(移除并返回集合的第一个项目) ###

	$data=Links::orderBy('link_order','asc')->get();
    $total = $data->shift();
    dd($data);

输出

	Collection {#267 ▼
	  #items: array:12 [▼
	    0 => Links {#269 ▶}
	    1 => Links {#270 ▶}
	    2 => Links {#271 ▶}
	    3 => Links {#272 ▶}
	    4 => Links {#273 ▶}
	    5 => Links {#274 ▶}
	    6 => Links {#275 ▶}
	    7 => Links {#276 ▶}
	    8 => Links {#277 ▶}
	    9 => Links {#278 ▶}
	    10 => Links {#279 ▶}
	    11 => Links {#280 ▶}
	  ]
	}


### 150.集合对象-slice(返回集合从指定索引开始的一部分切片) ###

	$data=Links::orderBy('link_order','asc')->get();
    $total = $data->slice(4);
    dd($total);

输出

	Collection {#252 ▼
	  #items: array:9 [▼
	    4 => Links {#272 ▶}
	    5 => Links {#273 ▶}
	    6 => Links {#274 ▶}
	    7 => Links {#275 ▶}
	    8 => Links {#276 ▶}
	    9 => Links {#277 ▶}
	    10 => Links {#278 ▶}
	    11 => Links {#279 ▶}
	    12 => Links {#280 ▶}
	  ]
	}

### 151.集合对象-splice(返回指定的索引开始的一小切片项目，原本的集合也会被删除) ###

	$collection = collect([1, 2, 3, 4, 5]);
	
	$chunk = $collection->splice(2);
	
	$chunk->all();

输出

	// [3, 4, 5]

原来的集合被切除

	$collection = collect([1, 2, 3, 4, 5]);
	
	$chunk = $collection->splice(2);
	
	$collection->all();

输出

	// [1, 2]

### 152.集合对象-sum(返回集合内所有项目的总和) ###

	collect([1, 2, 3, 4, 5])->sum();

输出

	15

### 153.集合对象-take(返回有着指定数量项目的集合) ###

	$collection = collect([0, 1, 2, 3, 4, 5]);
	
	$chunk = $collection->take(3);
	
	$chunk->all();

输出

	[0, 1, 2]

也可以传入负数获取从集合后面来算指定数量的项目

	$collection = collect([0, 1, 2, 3, 4, 5]);
	
	$chunk = $collection->take(-2);
	
	$chunk->all();
	

输出  

	// [4, 5]

### 154.集合对象-toArray(将集合转换成纯php数组) ###

	$data=Links::orderBy('link_order','asc')->get();
    $total = $data->toArray();
    dd($total);

输出

	array:13 [▼
	  0 => array:5 [▼
	    "link_id" => 6
	    "link_name" => "百度"
	    "link_title" => "全球最大的中文搜索引擎"
	    "link_url" => "https://www.baidu.com"
	    "link_order" => 1
	  ]
	  1 => array:5 [▶]
	  2 => array:5 [▶]
	  3 => array:5 [▶]
	  4 => array:5 [▶]
	  5 => array:5 [▶]
	  6 => array:5 [▶]
	  7 => array:5 [▶]
	  8 => array:5 [▶]
	  9 => array:5 [▶]
	  10 => array:5 [▶]
	  11 => array:5 [▶]
	  12 => array:5 [▶]
	]

### 155.集合对象-toJSON（将集合转换成json） ###

	$collection = collect(['name' => 'Desk', 'price' => 200]);
	
	$collection->toJson();

输出

	'{"name":"Desk","price":200}'

### 156.集合对象-zip(将集合与指定数组同样索引的值合并在一起) ###

	$collection = collect(['Chair', 'Desk']);
	
	$zipped = $collection->zip([100, 200]);
	
	$zipped->all();

输出

	[['Chair', 100], ['Desk', 200]]

### 157.设置session函数 ###

	session(['user'=>$user]);

### 158.销毁这个session ###

	session(['user'=>'']);

### 159.模板引入css和js ###

	<script type="text/javascript" src="{{asset('resources/views/admin/lib/html5.js')}}"></script>

### 160.模板页面书写url ###

	{{url('admin/code')}}

