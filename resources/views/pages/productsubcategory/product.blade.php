<a href="{{route('products.index', ['product_subcategory_id'=>$id])}}">{{$products_count }} {{Str::plural('Product', $products_count )}}</a> /
<a href="{{route('products.create', ['product_subcategory_id'=>$id])}}">Add New</a>
