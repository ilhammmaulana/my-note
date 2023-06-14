<x-admin.layout-show-one>
    <x-slot name="css">
        <style>
            .card-user{
                background-color: #fff;
                max-width: 400px
            }
        </style>
    </x-slot>
    <x-slot name="title">{{ $user->name }}</x-slot>
    <x-slot name="html">
        <div id="content">
            <x-admin.header page="{{ $user->name }}"></x-admin.header>
                <a href="{{ url('users') }}" class="btn-primary text-white mb-5 px-3 py-2 rounded-5">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            <div class="row justify-content-center mt-4" id="content-html">
                <div class="col-md-4">
                    <div class="card-user m-auto rounded-1 px-3 py-3">
                        <div class="thumbnial d-flex"  style="background-size: cover;background-image: {{ $user->banner_photo !== null ? 'url('.asset($user->banner_photo).')' : 'url('. asset('assets/images/default-banner.jpg').')' }};">
                            <img  width="150px" src="{{ $user->photo !== null ? url($user->photo) : asset('assets/images/default.jpg') }}" class="rounded-circle mx-auto position-relative" style="bottom: -3rem" alt="">
                        </div>
                        <div class="card-body mt-5">
                            <h3 class="text-center fw-600 ">{{ $user->name }}</h3>
                            <h6 class="text-center fw-bold">{{ $user->school->school_name }}</h6>
                            <div class="row mt-4 justify-content-between">
                                <div class="col-3">
                                    <a class="icon-dark d-flex move-a-decor" href="https://wa.me/{{ $user->phone }}">
                                        <i class="fa-brands fa-whatsapp m-auto"></i>   
                                    </a>
                                </div>
                                <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                                    <i class="fa-solid fa-heart @if($user->total_likes > 0) text-danger @else text-secondary @endif fs-5"></i>
                                    {{ $user->total_likes }}
                                </div>
                                <div class="col-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box-white m-auto w-75">
                        <h3 class="fw-bold text-theme">Get recent who likes this user</h3>
                        @foreach ($likes as $like)
                            <div class="shadow-sm p-3 mb-5 bg-white rounded d-flex align-items-center gap-2">
                                <img src="{{ $like->user->photo !== null ? asset($like->user->photo) : asset('assets/images/default.jpg') }}" width="50" height="50" alt="">
                                <div class="">
                                    <h6 class="fw-bold">{{ $like->user->name }}</h6>
                                    <p>{{ $like->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-admin.layout-show-one>