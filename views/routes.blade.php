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
    </style>
</head>
<body>

    <h1 class="display-4">Routes ({{ count($routes) }})</h1>

    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th>Methods</th>
                <th>Path</td>
                <th>Name</th>
                <th>Action</th>
                <th>Middleware</th>
            </tr>
        </thead>
        <tbody>
            <?php $methodColours = ['GET' => 'success', 'HEAD' => 'default', 'POST' => 'primary', 'PUT' => 'warning', 'PATCH' => 'info', 'DELETE' => 'danger']; ?>
            @foreach ($routes as $route)
                <tr>
                    <td>
                        @foreach (array_diff($route->methods(), config('pretty-routes.hide_methods')) as $method)
                            <span class="tag tag-{{ array_get($methodColours, $method) }}">{{ $method }}</span>
                        @endforeach
                    </td>
                    <td>{!! preg_replace('#({[^}]+})#', '<span class="text-warning">$1</span>', $route->uri()) !!}</td>
                    <td>{{ $route->getName() }}</td>
                    <td>{!! preg_replace('#(@.*)$#', '<span class="text-warning">$1</span>', $route->getActionName()) !!}</td>
                    <td>{{ implode(', ', $route->middleware()) }}
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
