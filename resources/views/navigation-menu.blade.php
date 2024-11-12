<nav class="flex items-center justify-between py-3 px-6 border-b border-gray-100">
    <div id="nav-left" class="flex items-center">
        <div class="text-gray-800 font-semibold">
            <a href="/">
                <img src = '/logo.png' class="w-8 h-8">
            </a>
        </div>
        <div class="top-menu ml-10">
            <div class="flex space-x-4">


            </div>
        </div>
    </div>
    <div id="nav-right" class="flex items-center md:space-x-6">
        @auth
            @include('layouts.partials.header-right-auth')
        @endauth
        @guest
            @include('layouts.partials.header-right-guest')
        @endguest
    </div>
</nav>
