<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify"></script>
<script src="https://cdn.jsdelivr.net/npm/axios"></script>

<script>
    const trans = {
        title: '{{ trans("Routes") }}',
        search: '{{ trans("Search") }}',
        priority: '{{ trans("Priority") }}',
        methods: '{{ trans("Methods") }}',
        domain: '{{ trans("Domain") }}',
        path: '{{ trans("Path") }}',
        name: '{{ trans("Name") }}',
        module: '{{ trans("Module") }}',
        action: '{{ trans("Action") }}',
        middlewares: '{{ trans("Middlewares") }}',
        deprecated: '{{ trans("Deprecated") }}',
        itemsPerPageAllText: '{{ trans("All") }}',
        itemsPerPageText: '{{ trans("Routes per page:") }}',
        pageText: '{0}-{1} {{ trans("of") }} {2}',
        noDataText: '{{ trans("No data available") }}',
        noResultsText: '{{ trans("No matching records found") }}',
        show: '{{ trans("Show") }}',
        all: '{{ trans("All") }}',
        only: '{{ trans("Only") }}',
        without: '{{ trans("Without") }}',
        of: '{{ trans("of") }}',
        loading: '{{ trans("Loading... Please wait...") }}'
    };

    const colorScheme = () => {
        switch ('{{ config('pretty-routes.color_scheme', 'auto') }}') {
            case 'dark':
                return true;
            case 'light':
                return false;
            default:
                return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
    };

    new Vue({
        el: '#app',
        vuetify: new Vuetify({
            theme: {
                dark: colorScheme()
            }
        }),

        data: {
            itemsPerPage: 15,
            loading: true,

            url: '{{ route("pretty-routes.list") }}',

            repository: {
                url: 'https://github.com/andrey-helldar/pretty-routes',
                icon: 'https://github.com/fluidicon.png'
            },

            routes: [],

            headers: [
                { text: trans.priority, sortable: true, value: 'priority' },
                { text: trans.methods, sortable: true, value: 'methods' },
                { text: trans.domain, sortable: true, value: 'domain' },
                { text: trans.path, sortable: true, value: 'path' },
                { text: trans.name, sortable: true, value: 'name' },
                { text: trans.module, sortable: true, value: 'module' },
                { text: trans.action, sortable: true, value: 'action' },
                { text: trans.middlewares, sortable: true, value: 'middlewares' }
            ],

            badges: {
                GET: 'green darken-1',
                HEAD: 'grey darken-1',
                POST: 'blue darken-1',
                PUT: 'orange darken-1',
                PATCH: 'cyan lighten-1',
                DELETE: 'red darken-1',
                OPTIONS: 'lime darken-1'
            },

            filter: {
                deprecated: 'all',
                module: 'all',
                domain: 'all',
                value: null
            },

            items: {
                base: [
                    { key: 'all', value: trans.all },
                    { key: 'without', value: trans.without }
                ],

                deprecated: [
                    { key: 'all', value: trans.all },
                    { key: 'only', value: trans.only },
                    { key: 'without', value: trans.without }
                ],

                domains: [],
                modules: []
            }
        },

        computed: {
            filteredRoutes() {
                return this.routes.filter(route => {
                    return this.allowDeprecated(route)
                        && this.allow(route, 'domain')
                        && this.allow(route, 'module');
                });
            },

            filteredHeaders() {
                return this.headers.filter(item => {
                    switch (item.value) {
                        case 'domain':
                            return this.hasHeader('domain');
                        case 'module':
                            return this.hasHeader('module');
                        default:
                            return true;
                    }
                });
            },

            countRoutes() {
                if (this.loading === true) {
                    return '...';
                }

                let all = this.routes.length;
                let filtered = this.$refs.routes.$children[0].filteredItems.length;
                let particle = this.trans('of');

                return all === filtered ? all : `${ filtered } ${ particle } ${ all }`;
            },

            hasDeprecated() {
                return this.hasRoute('deprecated');
            },

            hasModules() {
                return this.hasRoute('module');
            },

            hasDomains() {
                return this.hasRoute('domain');
            }
        },

        mounted() {
            this.getRoutes();
        },

        methods: {
            getRoutes() {
                axios.get(this.url)
                    .then(response => {
                        this.routes = response.data;

                        this.setDomains();
                        this.setModules();
                    })
                    .catch(error => console.error(error))
                    .finally(() => this.loading = false);
            },

            getRoutesKey(key) {
                let result = [...this.items.base];

                for (let i = 0; i < this.routes.length; i++) {
                    let name = this.routes[i][key];

                    if (name !== null && ! this.inArray(result, 'key', name)) {
                        result.push({ key: name, value: name });
                    }
                }

                return result;
            },

            setDomains() {
                this.items.domains = this.getRoutesKey('domain');
            },

            setModules() {
                this.items.modules = this.getRoutesKey('module');
            },

            setFilter(key, value) {
                this.filter[key] = value;
            },

            allowDeprecated(route) {
                switch (this.filter.deprecated) {
                    case 'only':
                        return route.deprecated === true;
                    case 'without':
                        return route.deprecated === false;
                    default:
                        return true;
                }
            },

            allow(route, key) {
                let filterValue = this.filter[key];
                let routeValue = route[key];

                return filterValue !== 'without'
                    ? filterValue === 'all' || routeValue === filterValue
                    : routeValue === null;
            },

            hasHeader(key) {
                return this.has(this.filteredRoutes, key);
            },

            isDirty() {
                return this.filter.deprecated !== 'all'
                    || this.filter.domain !== 'all'
                    || this.filter.module !== 'all'
                    || this.filter.value !== null;
            },

            resetFilters() {
                this.filter.deprecated = 'all';
                this.filter.domain = 'all';
                this.filter.module = 'all';
                this.filter.value = null;
            },

            hasRoute(key) {
                return this.has(this.routes, key);
            },

            has(items, key) {
                for (let i = 0; i < items.length; i++) {
                    if (items[i][key] !== null) {
                        return true;
                    }
                }

                return false;
            },

            inArray(array, key, value) {
                for (let i = 0; i < array.length; i++) {
                    if (array[key] === value) {
                        return true;
                    }
                }

                return false;
            },

            highlight(value, regex, modifier) {
                return value.replace(regex, `<span class="orange--text text--darken-2">${ modifier }</span>`);
            },

            highlightParameters(value) {
                return this.highlight(value, /({[^}]+})/gi, '$1');
            },

            highlightMethod(value) {
                return this.highlight(value, /(@.*)$/gi, '$&');
            },

            trans(key) {
                return trans[key];
            },

            openGitHubRepository() {
                window.open(this.repository.url);
            }
        }
    });
</script>
