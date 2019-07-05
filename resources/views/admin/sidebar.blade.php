<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            Sidebar
        </div>
        <div class="panel panel-default">

            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ url('/admin/page') }}">Puslapiai</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url('/admin/order') }}">Užsakymai</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url('/admin/product') }}">Produktai</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url('/admin/blog') }}">Įrašai</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url('/admin/event') }}">Renginiai</a>
                </li>
                @if(Gate::allows('superadmin'))
                <li class="list-group-item">
                    <a href="{{ url('/admin/users') }}">Vartotojai</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url('/register') }}">Sukurti nauja vartotoja</a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url('/admin/settings') }}">Nustatymai</a>
                </li>
                @endif
            </ul>

        </div>
    </div>
</div>
