<!DOCTYPE html>
<html>
<head>
    <title>Routes list</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        @switch(config('pretty-routes.mode'))
            @case("dark")
                :root {
                    --main-bg-color: #2B2B2B;
                    --color: #A9B7C6;
                    --warning-color: #CC7832;
                }
                @break
            @default
                :root {
                    --main-bg-color: #FFF;
                    --warning-color: #ff5722;
                }
                @break
        @endswitch

        body {
            background-color: var(--main-bg-color);
            color: var(--color);
            padding: 60px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.015);
        }

        .table td, .table th {
            border-top: none;
            font-size: 14px;
        }

        .table thead th {
            border-bottom: 1px solid var(--warning-color);
        }

        .text-warning {
            color: var(--warning-color) !important;
        }

        .badge {
            padding: 0.30em 0.8em;
        }

        table.hide-domains .domain {
            display: none;
        }
    </style>
</head>
<body>

    <h1 class="display-4">Routes ({{ count($routes) }})</h1>

    <table class="table table-sm table-hover" style="visibility: hidden;">
        <thead>
            <tr>
                <th>Methods</th>
                <th class="domain">Domain</th>
                <th>Path</th>
                <th>Name</th>
                <th>Action</th>
                <th>Middleware</th>
            </tr>
        </thead>
        <tbody>
            @switch(config('pretty-routes.mode'))
                @case("dark")
                    @php
                        $methodColours = ['GET' => 'secondary', 'HEAD' => 'info', 'POST' => 'dark', 'PUT' => 'primary', 'PATCH' => 'info', 'DELETE' => 'danger']
                    @endphp
                @break
                @default
                    @php
                        $methodColours = ['GET' => 'success', 'HEAD' => 'default', 'POST' => 'primary', 'PUT' => 'warning', 'PATCH' => 'info', 'DELETE' => 'danger']
                    @endphp
                    @break
            @endswitch
            @foreach ($routes as $route)
                <tr>
                    <td>
                        @foreach (array_diff($route->methods(), config('pretty-routes.hide_methods')) as $method)
                            <span class="badge badge-{{ array_get($methodColours, $method) }}">{{ $method }}</span>
                        @endforeach
                    </td>
                    <td class="domain{{ strlen($route->domain()) == 0 ? ' domain-empty' : '' }}">{{ $route->domain() }}</td>
                    <td>{!! preg_replace('#({[^}]+})#', '<span class="text-warning">$1</span>', $route->uri()) !!}</td>
                    <td>{{ $route->getName() }}</td>
                    <td>{!! preg_replace('#(@.*)$#', '<span class="text-warning">$1</span>', $route->getActionName()) !!}</td>
                    <td>
                      @if (is_callable([$route, 'controllerMiddleware']))
                        {{ implode(', ', array_map($middlewareClosure, array_merge($route->middleware(), $route->controllerMiddleware()))) }}
                      @else
                        {{ implode(', ', $route->middleware()) }}
                      @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script type="text/javascript">
        function hideEmptyDomainColumn() {
            var table = document.querySelector('.table');
            var domains = table.querySelectorAll('tbody .domain');
            var emptyDomains = table.querySelectorAll('tbody .domain-empty');
            if (domains.length == emptyDomains.length) {
                table.className += ' hide-domains';
            }

            table.style.visibility = 'visible';
        }

        hideEmptyDomainColumn();
    </script>

</body>
</html>
