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
        onlyDeprecated: '{{ trans("Only Deprecated") }}',
        withoutDeprecated: '{{ trans("Without Deprecated") }}',
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
                modules: 'all',
                value: null
            },

            items: {
                deprecated: [
                    { key: 'all', value: trans.all },
                    { key: 'onlyDeprecated', value: trans.onlyDeprecated },
                    { key: 'withoutDeprecated', value: trans.withoutDeprecated }
                ],

                modules: [
                    { key: 'all', value: trans.all },
                    { key: 'without', value: trans.without }
                ]
            }
        },

        computed: {
            filteredRoutes() {
                return this.routes.filter(route => {
                    return this.allowDeprecated(route) && this.allowModule(route);
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

            getModules() {
                let modules = this.items.modules;

                for (let i = 0; i < this.routes.length; i++) {
                    let name = this.routes[i].module;

                    if (name !== null && ! this.inArray(modules, 'key', name)) {
                        modules.push({ key: name, value: name });
                    }
                }

                return modules;
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
            }
        },

        mounted() {
            this.getRoutes();
        },

        methods: {
            getRoutes() {
                axios.get(this.url)
                    .then(response => this.routes = response.data)
                    .catch(error => console.error(error))
                    .finally(() => this.loading = false);
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

            allowDeprecated(route) {
                switch (this.filter.deprecated) {
                    case 'onlyDeprecated':
                        return route.deprecated === true;
                    case 'withoutDeprecated':
                        return route.deprecated === false;
                    default:
                        return true;
                }
            },

            allowModule(route) {
                return this.filter.modules !== 'without'
                    ? this.filter.modules === 'all' || route.module === this.filter.modules
                    : route.module === null;
            },

            hasHeader(key) {
                return this.has(this.filteredRoutes, key);
            },

            inArray(array, key, value) {
                for (let i = 0; i < array.length; i++) {
                    if (array[key] === value) {
                        return true;
                    }
                }

                return false;
            },

            isFiltered() {
                return this.filter.deprecated !== 'all'
                    || this.filter.modules !== 'all'
                    || this.filter.value !== null;
            },

            setSearch(value) {
                this.filter.value = value;
            },

            setModule(value) {
                this.filter.modules = value;
            },

            resetFilters() {
                this.filter.deprecated = 'all';
                this.filter.modules = 'all';
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

            trans(key) {
                return trans[key];
            },

            openGitHubRepository() {
                window.open(this.repository.url);
            }
        }
    });
</script>
