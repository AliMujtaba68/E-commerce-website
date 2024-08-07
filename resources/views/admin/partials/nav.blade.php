<aside class="side-nav">

    <div class="logo">
        <img src="{{asset('img/logo.svg')}}" alt="logo" class="logo">
        AdminPanel
    </div>

    <ul>
        <li>
            <a href="">Dashboard</a>
        </li>
        <li>
            <a href="{{route('adminpanel.products')}}">Products</a>
        </li>
        <li>
            <a href="{{route('adminpanel.categories')}}">Categories</a>
        </li>
        <li>
            <a href="{{route('adminpanel.colors')}}">Colors</a>
        </li>
        <li>
            <a href="">Orders</a>
        </li>

        <div class="logout">
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit">
                <svg width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7v2H5v14h7v2zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5z"/></svg>    
                &nbsp; Logout</button>
        </div>


</aside>
