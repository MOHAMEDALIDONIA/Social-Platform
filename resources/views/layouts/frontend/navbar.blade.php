<nav class="navbar navbar-light bg-white">
    <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
      <a href="{{route('suggest.connections')}}" class="nav-link"  type="button" >People you  know</a>
      <a href="{{route('friend.requests')}}" class="nav-link"  type="button" >Friend Requests</a>
      <a href="{{route('profile.view',auth()->user()->id)}}" class="nav-link"  type="button" >My Profile</a>
      <a href="{{route('home.page')}}" class="nav-link"  type="button" >Home</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
            <a href="route('logout')"
                    onclick="event.preventDefault();
                        this.closest('form').submit();"          
                    class="nav-link"  type="button" >Logout</a>


      </form>
     

    </div>
    <form class="form-inline mt-2">
        <div class="input-group">
            <input type="text" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" id="button-addon2">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</nav>