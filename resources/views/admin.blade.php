@extends('admin::base')

@section('view')
    <style>
        .visitors {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: start;
        }

        table {
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, .25);
        }

        TH,
        TD {
            border: 1px solid #bbb;
            padding: 5px 10px;
        }
    </style>
    <section class="fullpage">
        <div class="visitors">
            <table>
                <tr>
                    <th colspan="2">Jaarlijks</th>
                </tr>
                @foreach (Visitors::yearlyVisitors() as $year)
                    <tr>
                        <td>{{ $year->year }}</td>
                        <td>{{ $year->visitors }}</td>
                    </tr>
                @endforeach
            </table>
            <table>
                <tr>
                    <th colspan="2">Maandelijks</th>
                </tr>
                @foreach (Visitors::monthlyVisitors() as $month)
                    <tr>
                        <td>{{ ucfirst($month->created_at->isoFormat('MMMM YYYY')) }}</td>
                        <td>{{ $month->visitors }}</td>
                    </tr>
                @endforeach
            </table>
            <table>
                <tr>
                    <th colspan="2">Dagelijks</th>
                </tr>
                @foreach (Visitors::dailyVisitors() as $month)
                    <tr>
                        <td>{{ ucfirst($month->created_at->isoFormat('dd D MMMM YYYY')) }}</td>
                        <td>{{ $month->visitors }}</td>
                    </tr>
                @endforeach
            </table>
            <table>
                <tr>
                    <th>Laatste 10</th>
                    <th>IP adres</th>
                    <th>Hardware</th>
                    <th>OS</th>
                    <th>Browser</th>
                </tr>
                @foreach (Visitors::latestVisitors(10) as $visitor)
                    <tr>
                        <td>{{ $visitor->created_at->isoFormat('dd D MMM YYYY HH:mm') }}</td>
                        <td>{{ trim($visitor->ip, '.0') }}.?</td>
                        <td>{{ $visitor->hardware }}</td>
                        <td>{{ $visitor->platform }}</td>
                        <td>{{ $visitor->browser }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
@endsection
