<!DOCTYPE html>
<html>
<head>
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
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th>Group</th>
                <th>Methods</th>
                <th class="hide-domain">Domain</th>
                <th>Path</th>
                <th>Name</th>
                <th>Action</th>
                <th>Middleware</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($x as $item => $data)
                <tr>
                    <th>{{ empty($item) ? '/' : $item }}</th>
                    @for ($i = 0; $i < count($data) ; $i++)
                        <tr>
                            <td></td>
                            <td>
                                @foreach (array_diff($data[$i]->methods(), config('pretty-routes.hide_methods')) as $method)
                                    <span class="tag tag-{{ array_get($methodColours, $method) }}">{{ $method }}</span>
                                @endforeach
                            </td>
                            <td class="domain">
                                {{ $data[$i]->domain() }}
                            </td>
                            <td>
                                {{ $data[$i]->uri() }}
                            </td>
                            <td>
                                {{ $data[$i]->getName() }}
                            </td>
                            <td>
                                {{ $data[$i]->getActionName() }}
                            </td>
                            <td>
                                @if (is_callable([$data[$i], 'controllerMiddleware']))
                                    {{ implode(', ', array_map($middlewareClosure, array_merge($data[$i]->middleware(), $data[$i]->controllerMiddleware()))) }}
                                @else
                                    {{ implode(', ', $data[$i]->middleware()) }}
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(function() {
            if (!$('.domain').val()) {
                $('.domain').hide();
                $('.hide-domain').hide()
            }
        })
    </script>
</body>
</html>
