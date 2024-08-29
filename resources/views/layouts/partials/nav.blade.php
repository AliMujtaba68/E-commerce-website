<nav class="menu">
    <img src="{{asset('img/logo.svg')}}" alt="logo" class="logo">
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
                <span class="cart-amount">$0.00</span>
            </div>
        </a></li>
    </ul>
</nav>
