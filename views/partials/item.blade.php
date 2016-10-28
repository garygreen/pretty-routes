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
