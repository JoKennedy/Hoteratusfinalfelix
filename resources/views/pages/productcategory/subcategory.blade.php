<a href="{{route('productsubcategories.index', ['product_category_id'=>$id])}}">{{$subcategories_count }} {{Str::plural('Subcategory', $subcategories_count )}}</a> /
<a href="{{route('productsubcategories.create', ['product_category_id'=>$id])}}">Add New</a>
