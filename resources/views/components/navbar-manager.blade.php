@if (Auth::user()->isManager())
    <li class="nav-item dropdown">
        <a id="ManagerDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Lagerleitende <span class="caret"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ManagerDropdown">
            <ul class="list-unstyled">
                <li>
                    <a class="nav-link" href="{{route('healthforms.index')}}">Gesundheitsblätter</a>
                    <a class="nav-link" href="{{route('dashboard.users.index')}}">Leiter</a>
                    <a class="nav-link" href="{{route('dashboard.questions.index')}}">Fragen</a>
                    <a class="nav-link" href="{{route('dashboard.camps.index')}}">Lager</a>
                </li>
            </ul>
        </div>
    </li>
@endif
