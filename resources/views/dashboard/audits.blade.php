@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped table-sm" >
            <thead class="thead">
            <tr>
                <th scope="col">Model</th>
                <th scope="col">Aktion</th>
                <th scope="col">Benutzer</th>
                <th scope="col">Zeit</th>
                <th scope="col">Alter Wert</th>
                <th scope="col">Neuer Wert</th>
            </tr>
            </thead>
            <tbody id="audits">
            @foreach($audits as $audit)
                <tr>
                    <td>{{ $audit->auditable_type }} (id: {{ $audit->auditable_id }})</td>
                    <td>{{ $audit->event }}</td>
                    <td>{{ $audit->user ? $audit->user->name :'' }}</td>
                    <td>{{ $audit->created_at }}</td>
                    <td>
                        <table class="table">
                            @foreach($audit->old_values as $attribute => $value)
                                <tr>
                                    <td><b>{{ $attribute }}</b></td>
                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td>
                        <table class="table">
                            @foreach($audit->new_values as $attribute => $value)
                                <tr>
                                    <td><b>{{ $attribute }}</b></td>
                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
