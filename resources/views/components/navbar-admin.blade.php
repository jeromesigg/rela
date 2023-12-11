@if (Auth::user()->isAdmin())
    <li class="nav-item dropdown">
        <a id="AdminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Admin <span class="caret"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="AdminDropdown">
            <ul class="list-unstyled">
                <li>
                    <a class="nav-link" href="{{route('dashboard.audits')}}">Audit-Trail</a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('interventionclasses.index')}}">Kategorien</a>
                </li>
                <li>
                    <a class="nav-link" href="{{route('helps.index')}}">Hilfe-Artikel</a>
                </li>
            </ul>
        </div>
    </li>
@endif
