<nav class="menu">
    <a href="{{route('home')}}"><img src="{{asset('img/logo.svg')}}" alt="logo" class="logo"></a>
    <ul>
        <li><a href="{{route('home')}}" class="nav-icon home-icon"></a></li>
        <li><a href="{{route('account')}}" class="nav-icon account-icon"></a></li>
        <li><a href="{{route('wishlist')}}" class="nav-icon wishlist-icon">
            @auth
            <span class="info-count">{{count(auth()->user()->wishlist)}}</span>
            @endauth
        </a></li>
        <li><a href="{{route('cart')}}" class="nav-icon cart-icon">
            <span class="info-count">{{session()->has('cart') ? count(session('cart')): 0}}</span>
            <div class="cart-info">
                <span>Your Cart</span>
            </div>
        </a></li>
    </ul>
</nav>
