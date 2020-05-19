<ul>
    @guest
        <li><a href="{{route('register')}}">Registruotis</a></li>
        <li><a href="{{route('login')}}">Prisijungti</a></li>
    @else
    <li>
        @if(Auth::check() && Auth::user()->role['name'] == "admin")
            <a href="/admin">Mano profilis</a>
        @else
            <a href="{{route('users.edit')}}">Mano profilis</a>
        @endif
    </li>
    <li>
        <a href="{{route('logout')}}"
            onclick="event.preventDefault()
            document.getElementById('logout-form').submit()">
            Atsijungti
        </a>
    </li>
    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
        {{csrf_field()}}
    </form>
    @endguest
    <li><a href="{{route('cart.index')}}"><i class="fa fa-shopping-cart" style="font-size:24px;"></i>
        @if(Cart::instance('default')->count() > 0)
            <span class="cart-count"><span>{{Cart::instance('default')->count()}}</span></span>
        @endif
    </a></li>
</ul>