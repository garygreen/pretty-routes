<!DOCTYPE html>
<html>
<head>
    <title>Routes list</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @switch (config('sweet-routes.mode'))
            @case('light')
                body {
                    background-color: var(--light);
                    color: var(--dark);
                    padding: 60px;
                }
            @break
            @default
                body {
                    background-color: var(--{{ config('sweet-routes.background-color') ?? 'dark' }});
                    color: var(--{{ config('sweet-routes.color') ?? 'light' }});
                    padding: 60px;
                }
            @break
        @endswitch

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.015);
        }

        .table td, .table th {
            border-top: none;
            font-size: 14px;
        }

        .table thead th {
            @if (config('sweet-routes.datatables'))
                border-bottom: 1px solid var(--primary);
            @else
                border-bottom: 1px solid var(--{{ config('sweet-routes.strip') }});
            @endif
        }

        .badge {
            padding: 0.30em 0.8em;
        }

    </style>
    @if (config('sweet-routes.datatables'))
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    @endif
</head>
<body>
<div class="container-fluid">

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
                @switch(config('sweet-routes.mode'))
                    @case('dark')
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
                            @foreach (array_diff($route->methods(), config('sweet-routes.hide_methods')) as $method)
                                <span class="badge badge-{{ Arr::get($methodColours, $method) }}">{{ $method }}</span>
                            @endforeach
                        </td>
                        <td class="domain{{ strlen($route->domain()) === 0 ? ' domain-empty' : '' }}">{{ $route->domain() }}</td>
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
    </div>
</div>
    @if (config('sweet-routes.datatables'))
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    @endif
    <script type="text/javascript">
        function hideEmptyDomainColumn() {
            let table = document.querySelector('.table');
            let domains = table.querySelectorAll('tbody .domain');
            let emptyDomains = table.querySelectorAll('tbody .domain-empty');
            if (domains.length === emptyDomains.length) {
                table.className += ' hide-domains';
            }

            table.style.visibility = 'visible';
        }

        hideEmptyDomainColumn();
        @if (config('sweet-routes.datatables'))
            document.addEventListener("DOMContentLoaded", function() {
              $('.table').DataTable({
                responsive: true
              });
            });
        @endif
    </script>

</body>
</html>
