<!DOCTYPE html>
<html>
<head>
    <title>Routes list @if(config('app.name'))| {{ config('app.name') }}@endif</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <style type="text/css">
        body {
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
            border-bottom: 1px solid #ff5722;
        }

        .text-warning {
            color: #ff5722 !important;
        }

        .tag {
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
            <?php $methodColours = ['GET' => 'success', 'HEAD' => 'default', 'OPTIONS' => 'default', 'POST' => 'primary', 'PUT' => 'warning', 'PATCH' => 'info', 'DELETE' => 'danger']; ?>
            @foreach ($routes as $route)
                <tr>
                    <td>
                        @foreach (array_diff($route->methods(), config('pretty-routes.hide_methods')) as $method)
                            <span class="tag tag-{{ $methodColours[$method] }}">{{ $method }}</span>
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
