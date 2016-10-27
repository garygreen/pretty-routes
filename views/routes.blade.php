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

        ul.routePrefixLinks {
            list-style: none;
        }

        ul.routePrefixLinks li {
            background-color: #3B5998;
            float: left;
            margin-right:5px;
            margin-top: 5px;
            padding: 0 5px;
        }

        ul.routePrefixLinks li a {
            color: #FFF;
        }

        td.routePrefixName h5 {
            background-color: #edeff0;
            padding-left:10px;
        }

        td.routePrefixName:hover {
            background-color: #edeff0;
        }

    </style>
</head>
<body>

<h1 class="display-4">Routes ({{ count($routes) }})</h1>

<?php
    $routePrefixLinks = collect($routes)->reduce(function ($arr,$item) {
        $arr[] = $item->getPrefix();
        return $arr;
    },collect([]))->filter(function ($value, $key) {
        return $value != null;
    })->unique()->map(function ($value, $key) {
        return sprintf('<li><a href="#%s">%s</a></li>', $value, $value);
    })->implode("");
?>

@if ($routePrefixLinks)
    <ul class="routePrefixLinks">{!! $routePrefixLinks !!}</ul>
@endif

<table class="table table-sm table-hover" style="visibility: hidden;">
    <thead>
    <tr>
        <th>Methods</th>
        <th class="domain">Domain</td>
        <th>Path</td>
        <th>Name</th>
        <th>Action</th>
        <th>Middleware</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $methodColours = ['GET' => 'success', 'HEAD' => 'default', 'POST' => 'primary', 'PUT' => 'warning', 'PATCH' => 'info', 'DELETE' => 'danger'];
    $lastRoutePrefix = '';
    ?>

    @foreach ($routes as $route)

        @if ($lastRoutePrefix != $route->getPrefix())
            <tr>
                <td colspan="6" id="{{ $route->getPrefix() }}" class="routePrefixName"><h5>{{ $route->getPrefix() }}</h5></td>
            </tr>
            <?php $lastRoutePrefix =  $route->getPrefix(); ?>
        @endif

        <tr>
            <td>
                @foreach (array_diff($route->methods(), config('pretty-routes.hide_methods')) as $method)
                    <span class="tag tag-{{ array_get($methodColours, $method) }}">{{ $method }}</span>
                @endforeach
            </td>
            <td class="domain{{ strlen($route->domain()) == 0 ? ' domain-empty' : '' }}">{{ $route->domain() }}</td>
            <td>{!! preg_replace('#({[^}]+})#', '<span class="text-warning">$1</span>', $route->uri()) !!}</td>
            <td>{{ $route->getName() }}</td>
            <td>{!! preg_replace('#(@.*)$#', '<span class="text-warning">$1</span>', $route->getActionName()) !!}</td>
            <td>
                @if (method_exists($route, 'controllerMiddleware'))
                    {{ implode(', ', array_merge($route->middleware(), $route->controllerMiddleware())) }}
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
