@extends('admin::base')

@section('view')
    <section class="fullpage">
        <h2>Since {{ Visitors::firstVisitor()->created_at->isoFormat('dddd D MMMM YYYY') }}</h2>
        <table>
            @foreach (Visitors::monthlyVisitors() as $month)
                <tr>
                    <td>{{ ucfirst($month->created_at->isoFormat('MMMM YYYY')) }}</td>
                    <td>{{ $month->visitors }}</td>
                </tr>
            @endforeach
        </table>
    </section>
@endsection
