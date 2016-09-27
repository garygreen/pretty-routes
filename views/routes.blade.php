<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.3.2/css/colReorder.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>    

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

    <script>
        $(document).ready(function() {
             $(document).ready(function () {
                 var table = $('.table').DataTable( {
                           "pageLength": 5,
                            "pagingType": "full_numbers",
                            colReorder: true,
                            fixedHeader: true
                      });
                    $('.table').removeClass( 'display' ).addClass('table table-striped table-bordered');
                });
        } );
    </script>
</body>
</html>