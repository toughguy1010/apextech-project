@if ($errors->any())
<div class="overlay-arlert">

    <div class="alert alert-danger d-flex">
        <i class="fa-solid fa-circle-exclamation me-2 mt-1"></i>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>

@endif


@if (session('error'))
<div class="overlay-arlert">

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
</div>
@endif

@if (session('success'))
    <div class="overlay-arlert">
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    </div>
@endif
