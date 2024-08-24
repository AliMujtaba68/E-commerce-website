<nav class="menu">
    <img src="{{asset('img/logo.svg')}}" alt="logo" class="logo">
    <div class="contact-search">
        <span class="phone-number">(123) 456-7890</span>
        <input type="text" placeholder="Search..." class="search-bar">
    </div>
    <ul>
        <li><a href="{{route('home')}}" class="nav-icon home-icon"></a></li>
        <li><a href="{{route('account')}}" class="nav-icon account-icon"></a></li>
        <li>
            <a href="{{route('cart')}}" class="nav-icon cart-icon">
                <span class="info-count">3</span>
                <div class="cart-info">
                    <span>Your Cart</span>
                    <span class="cart-amount">$0.00</span>
                </div>
            </a>
        </li>
    </ul>
</nav>
