<div class="row g-2 justify-content-center categories-block">
    @foreach ($categories as $category)
    <div class="col-6 col-md-4 col-lg-3">
        <a class="text-decoration-none" href="{{ $category->url }}">
            <div class="card category-card"
                style="background-image: url('{{ $category->image_url }}'); background-size: cover; background-position: center; height: 200px;">
                <div class="card-body">
                    <h2>{{ $category->name }}</h2>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>