<header>
  <div class="header-content container">
    <div class="logo"><a href="/">Lift Up</a></div>
    <div class="top-nav-left">
      @if (!(request()->is('checkout') || request()->is('guestCheckout')))
        {{menu('header-left','partials.menus.header-left')}}
      @endif
    </div>
    <div class="top-nav-right">
      @if (!(request()->is('checkout') || request()->is('guestCheckout')))
        @include('partials.menus.header-right')
      @endif
    </div>
  </div>
</header>
