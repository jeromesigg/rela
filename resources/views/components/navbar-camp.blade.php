<li class="nav-item dropdown">
    <a id="navbarCampDropdown" class="nav-link dropdown-toggle" href="#" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        @if(Auth::user()->camp && !Auth::user()->camp['global_camp'] )
            {{Auth::user()->camp['name']}}
        @else
            Meine Lager
        @endif <span class="caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarCampDropdown">
        <a class="nav-link" href="{{ route('camps.create') }}">
            Lager erstellen
        </a>
        @foreach (Auth::user()->camp_users as $camp_user)
            @if(!$camp_user->camp['global_camp'] && $camp_user['active'])
                <a class="nav-link" href="{{route('camps.update',$camp_user->camp['id'])  }}"
                   onclick="event.preventDefault();
                                                document.getElementById('camps-update-form-{{$camp_user->camp['id']}}').submit();">
                    {{$camp_user->camp['name']}}
                </a>

                <form id="camps-update-form-{{$camp_user->camp['id']}}"
                      action="{{route('camps.update',$camp_user->camp['id'])  }}" method="POST"
                      style="display: none;">
                    {{ method_field('PUT') }}
                    @csrf
                </form>
            @endif
        @endforeach
    </div>
</li>
