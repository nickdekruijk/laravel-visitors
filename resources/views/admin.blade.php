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

        TD.right {
            text-align: right;
        }

        TD.center {
            text-align: center;
        }
    </style>
    <section class="fullpage">
        <div class="visitors">
            <table>
                <tr>
                    <th colspan="2">Jaarlijks</th>
                </tr>
                @foreach (NickDeKruijk\LaravelVisitors\Controllers\VisitorController::yearlyVisitors() as $year)
                    <tr>
                        <td>{{ $year->year }}</td>
                        <td class="right">{{ $year->visitors }}</td>
                    </tr>
                @endforeach
            </table>
            <table>
                <tr>
                    <th colspan="2">Maandelijks</th>
                </tr>
                @foreach (NickDeKruijk\LaravelVisitors\Controllers\VisitorController::monthlyVisitors() as $month)
                    <tr>
                        <td>{{ ucfirst($month->created_at->isoFormat('MMMM YYYY')) }}</td>
                        <td class="right">{{ $month->visitors }}</td>
                    </tr>
                @endforeach
            </table>
            <table>
                <tr>
                    <th colspan="2">Dagelijks</th>
                </tr>
                @foreach (NickDeKruijk\LaravelVisitors\Controllers\VisitorController::dailyVisitors() as $month)
                    <tr>
                        <td>{{ ucfirst($month->created_at->isoFormat('dd D MMMM YYYY')) }}</td>
                        <td class="right">{{ $month->visitors }}</td>
                    </tr>
                @endforeach
            </table>
            <table>
                <tr>
                    <th>Laatste 25</th>
                    <th>IP adres</th>
                    <th>Hardware</th>
                    <th>OS</th>
                    <th>Browser</th>
                    <th>Method</th>
                    <th>Screen</th>
                    <th>Viewport</th>
                    <th>Pagina's</th>
                </tr>
                @foreach (NickDeKruijk\LaravelVisitors\Controllers\VisitorController::latestVisitors(25) as $visitor)
                    <tr>
                        <td>{{ $visitor->created_at->isoFormat('dd D MMM YYYY HH:mm') }}</td>
                        <td class="right">{{ trim($visitor->ip, '.0') }}.?</td>
                        <td>{{ $visitor->hardware }}</td>
                        <td>{{ $visitor->platform }}</td>
                        <td title="{{ $visitor->user_agent }}">{{ $visitor->browser }} {{ explode('.', $visitor->browser_version)[0] }}</td>
                        <td class="center">{{ $visitor->javascript ? 'Js' : '' }} {{ $visitor->pixel ? 'Px' : '' }}</td>
                        <td class="center">{{ $visitor->screen_width }} x {{ $visitor->screen_height }}{{ $visitor->screen_pixel_ratio ? ' @' . $visitor->screen_pixel_ratio . 'x' : '' }}</td>
                        <td class="center">{{ $visitor->viewport_width }} x {{ $visitor->viewport_height }}</td>
                        <td class="right">{{ $visitor->pageviews }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
@endsection
