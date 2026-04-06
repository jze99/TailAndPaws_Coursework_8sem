<div class="megamenu">
    <div class="megamenu-grid">
        @foreach($menuCategories as $category)
        <div class="category-column">
            <h5 class="tw-text-orange border-bottom pb-2 d-flex gap-2">
                <img src="{{ $category->iconUrl }}" alt="{{ $category->name }}" class="object-fit-scale" height="20" width="20">
                <a href="{{ $category->url }}" class="text-decoration-none tw-text-orange">
                    {{ $category->name }}
                </a>
            </h5>
            <ul>
                {{-- Подкатегории 1 уровня --}}
                @foreach($category->children as $child)
                @if($child->children->count() > 0)
                {{-- Категория с подкатегориями --}}
                <li class="fw-bold mt-2">
                    <a href="{{ $child->url }}" class="tw-text-orange text-decoration-none">
                        {{ $child->name }}
                    </a>
                </li>
                @foreach($child->children as $subChild)
                <li>
                    <a href="{{ $subChild->url }}" class="text-decoration-none">
                        — {{ $subChild->name }}
                    </a>
                </li>
                @endforeach
                @else
                {{-- Обычная категория --}}
                <li>
                    <a href="{{ $child->url }}" class="text-decoration-none">
                        {{ $child->name }}
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    {{-- Популярные бренды --}}
    @if(isset($menuBrands) && $menuBrands->count() > 0)
    <div class="row mt-4 pt-3 border-top">
        <div class="col-12">
            <p class="mb-2 fw-bold tw-text-light-gray">Популярные бренды:</p>
            <div class="d-flex flex-wrap gap-3">
                @foreach($menuBrands as $brand)
                <a href=""
                    class="tw-text-light-gray text-decoration-none hover:text-orange">
                    {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>