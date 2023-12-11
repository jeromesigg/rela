@if (Auth::user()->isHelper())
    <li class="nav-item dropdown">
        <a id="ActionDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Aktion <span class="caret"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ActionDropdown">
            <ul class="list-unstyled">
                <li>
                    <a class="nav-link" href="{{route('healthinformation.index')}}">Teilnehmerübersicht</a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('interventions.index')}}">Alle Interventionen</a>
                </li>
            </ul>
        </div>
    </li>
@endif
