<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <style type="text/css">
        body {
            padding: 60px;
        }

        .table {
            margin-left: 100px;
            width: calc(100% - 100px);
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
    @php
        $methodColours = ['GET' => 'success', 'HEAD' => 'default', 'POST' => 'primary', 'PUT' => 'warning', 'PATCH' => 'info', 'DELETE' => 'danger'];
        $x=[];

        foreach ($routes as $route) {
            if (str_contains($route->uri(), '/')) {
                $o = strstr($route->uri(), '/', true);

                if (preg_match('/^'.$o.'/', $route->uri())) {
                    $x[$o][]=$route;
                }
            } else {
                $x[$route->uri()][]=$route;
            }
        }

        if (!empty(config('pretty-routes.ignore_uri'))) {
            $y = preg_grep(config('pretty-routes.ignore_uri'), array_keys($x));
            foreach ($y as $key) {
                unset($x[$key]);
            }
        }
    @endphp

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
            <tr>
                @foreach ($x as $item => $data)
                    <th style="transform: translateX(-100px);">{{ empty($item) ? '/' : $item }}</th>
                    @foreach ($data as $one)
                        <tr>
                            <td>
                                @foreach (array_diff($one->methods(), config('pretty-routes.hide_methods')) as $method)
                                    <span class="tag tag-{{ array_get($methodColours, $method) }}">{{ $method }}</span>
                                @endforeach
                            </td>
                            <td class="domain{{ strlen($one->domain()) == 0 ? ' domain-empty' : '' }}">{{ $one->domain() }}</td>
                            <td>{!! preg_replace('#({[^}]+})#', '<span class="text-warning">$1</span>', $one->uri()) !!}</td>
                            <td>{{ $one->getName() }}</td>
                            <td>{!! preg_replace('#(@.*)$#', '<span class="text-warning">$1</span>', $one->getActionName()) !!}</td>
                            <td>
                                @if (is_callable([$one, 'controllerMiddleware']))
                                    {{ implode(', ', array_map($middlewareClosure, array_merge($one->middleware(), $one->controllerMiddleware()))) }}
                                @else
                                    {{ implode(', ', $one->middleware()) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tr>
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
