<div class="topNav" id="mainNav">

  <a class='logo' href="{{URL::asset('pictures')}}">
    <img src="{{URL::asset('css/img/logo.png')}}" alt="Image Soft" />
  </a>
  <a class='menuOption' href="{{URL::asset('pictures')}}">Pictures</a>
  <a class='menuOption' href="{{URL::asset('albums')}}">Albums</a>
  <a class='menuOption' href="{{URL::asset('contact')}}">Contact</a>
  <a class='menuOption ' href="{{URL::asset('about')}}">About</a>
  @if (Auth::user()!=null) @if (Auth::user()->isAdmin())
  <a class="menuOption">
    <ol>
      <li>
        <a class="menuOption admin-div" href="admin_panel">admin panel</a>
        <ul class='menuOl'>
          <li>
            <a href="{{URL::asset('users_list')}}">Users</a>
          </li>
          <li>
            <a href="{{URL::asset('pictures_list')}}">Pictures</a>
          </li>
          <li class='z'>
            <a href="{{URL::asset('albums_list_a')}}">Albums</a>
            <ul class='x'>
              <li>
                <a href="{{URL::asset('album_comments_list')}}">Albums comments</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="{{URL::asset('comments_list')}}">Comments</a>
          </li>
          <li>
            <a href="{{URL::asset('albums_ratings_list')}}">Albums ratings</a>
          </li>
          <li>
            <a href="{{URL::asset('pictures_ratings_list')}}">Pictures ratings</a>
          </li>
        </ul>
      </li>
    </ol>
  </a>
  @endif

  <a class="menuOption">
    <ol>
      <li>
        <a class="menuOption admin-div" href="{{URL::asset('user/'.Auth::id())}}">user panel</a>
        <ul class='menuOl'>
          <li>
            <a href="{{URL::asset('user/'.Auth::id())}}">Profile</a>
          </li>
          <li>
            <a href="{{URL::asset('user_panel')}}">Pictures</a>
          </li>
          <li class='z'>
            <a href="{{URL::asset('albums/user/'.Auth::id())}}">Albums</a>

          </li>
          <li>
            <a href="{{URL::asset('pictures/create')}}">Add pictures</a>
          </li>
          <li class='z'>
            <a href="{{URL::asset('albums/create')}}">Add albums</a>

          </li>
        </ul>
      </li>
    </ol>
  </a>



  @endif @if (Auth::user()) @php $src =explode("@",Auth::user()->id); @endphp

  <a class='menuOptionRight' href="{{URL::asset('logout')}}">
    Logout</a>
  <a class='menuOptionRight' href="{{URL::asset('user/'.Auth::user()->id)}}">
    <img class="small-img" src="{{ URL::asset('css/img/avatars/'.$src[0]." .jpg ")}}">
  </a>
  @else
  <a class='menuOptionRight' href="{{URL::route('login')}}">Login</a>
  @endif

  <a class='menuOptionRight' href="{{URL::route('register')}}">Sign in</a>

  <a href="javascript:void(0);" style="font-size:15px;" class="icon">&#9776;</a>



</div>