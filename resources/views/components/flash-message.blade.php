@if(session()->has('message'))
    <div class="fixed top-0 transform -translate-x-1/2 bg-laravel text-white px-48 py-3 left-1/2">
        <p>
            {{session('message')}}
        </p>
    </div>
@endif
