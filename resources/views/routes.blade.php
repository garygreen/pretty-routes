<!DOCTYPE html>
<html>
<head>
    <title>Routes list @if(config('app.name'))| {{ config('app.name') }}@endif</title>
    <link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css"
        integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY"
        crossorigin="anonymous">
    <style type="text/css">
        body {
            padding: 60px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .015);
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

        .strike {
            text-decoration: line-through;
        }

        table.hide-domains .domain {
            display: none;
        }
    </style>

    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
</head>
<body>

<div id="app">
    <v-app>
        <v-main>
            <v-container>
                <h1>
                    Routes (<span v-text="routes.length"></span>)
                </h1>

                <v-data-table
                    :headers="table.headers"
                    :items="table.items"
                    :items-per-page="table.itemsPerPage"
                ></v-data-table>
            </v-container>
        </v-main>
    </v-app>
</div>

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
    <?php $methodColours =
        ['GET' => 'success', 'HEAD' => 'default', 'OPTIONS' => 'default', 'POST' => 'primary', 'PUT' => 'warning', 'PATCH' => 'info', 'DELETE' => 'danger']; ?>
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
            <td class="{{ \PrettyRoutes\Facades\Annotation::isDeprecated($route->getActionName()) ? 'strike' : '' }}">{!! preg_replace('#(@.*)$#', '<span class="text-warning">$1</span>', $route->getActionName()) !!}</td>
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

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

<style>

</style>

<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            title: 'Foo',

            routes: [],

            table: {
                headers: [
                    { text: 'Priority', sortable: true, value: 'priority' },
                    { text: 'Domain', sortable: true, value: 'domain', class: { show: this.isPresentDomain } },
                    { text: 'Methods', sortable: true, value: 'methods' },
                    { text: 'Path', sortable: true, value: 'path' },
                    { text: 'Name', sortable: true, value: 'name' },
                    { text: 'Action', sortable: true, value: 'action' },
                    { text: 'Middlewares', sortable: true, value: 'middlewares' }
                ],

                items: [
                    {
                        priority: 4,
                        domain: 'test.local',
                        methods: ['get', 'head'],
                        path: '/foo/bar',
                        name: 'foo.bar',
                        action: 'FooController@foo',
                        middlewares: ['api', 'auth']
                    },
                    {
                        priority: 3,
                        domain: 'test.local',
                        methods: ['put'],
                        path: '/foo/bar',
                        name: 'foo.bar.update',
                        action: 'FooController@update',
                        middlewares: ['api', 'auth']
                    }
                ],

                itemsPerPage: 20
            },

            badges: {
                get: { text: 'GET', color: 'green' },
                head: { text: 'HEAD', color: 'green' },
                post: { text: 'POST', color: 'navy' },
                put: { text: 'PUT', color: 'orange' },
                patch: { text: 'PATCH', color: 'blue' },
                delete: { text: 'DELETE', color: 'red' },
                options: { text: 'OPTIONS', color: 'gray' }
            }
        },

        computed: {
            isPresentDomain: (value) => {
                return true;
            }
        }
    });
</script>

</body>
</html>
