@foreach ($articles2 as $article)
	<div class="rightList col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<a href="{{url("information", ['id'=>$article->id])}}">
		<div class="imgBox col-lg-3 col-md-4 col-sm-4 col-xs-4">
    		
    			<img src="{{ $article->image }}" alt="">
    		
		</div>
		<div class="msgBox col-lg-9 col-md-8 col-sm-8 col-xs-8">
			
				{{ $article->title }}
			
		</div>
		</a>
	</div>
@endforeach