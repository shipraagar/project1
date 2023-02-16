<div class="tagArea">
    <div class="small-tittle mb-40">
        <h3 class="tittle lineStyleOne">{{__('Categories')}}</h3>
    </div>
    <ul class="selectTag">
        @foreach($categories as $cat)
            <a href="{{ route('tenant.frontend.event.category',['id'=> $cat->id,'any'=> Str::slug($cat->getTranslation('title',get_user_lang()))]) }}">
                <li class="listItem {{$loop->index == 0 ? 'active' : ''}}">{{ $cat->getTranslation('title',get_user_lang()) }}</li>
            </a>
        @endforeach
    </ul>
</div>
