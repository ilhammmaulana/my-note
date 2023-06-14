@if (session('success'))
<div class="alert alert-success alert alert-custom alert-dismissible fade show d-none" id="alert" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
</div>
@endif
@if(session('failed'))
<div class="alert alert-custom alert-slide-down alert-danger alert-dismissible fade show position-fixed alert-custom d-none" role="alert" id="alert">
    <i class="fa-solid fa-triangle-exclamation"></i>
    {!! session('failed') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
</div>  
@endif
@if ($errors->any())
        <div class="alert alert-warning alert-custom alert-dismissible fade show d-none" role="alert" id="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"  aria-label="Close">
            </button>
        </div>
@endif