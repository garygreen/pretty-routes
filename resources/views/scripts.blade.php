<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify"></script>
<script src="https://cdn.jsdelivr.net/npm/axios"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash"></script>

<script>
    const trans = {
        action: '{{ trans("Action") }}',
        deprecated: '{{ trans("Deprecated") }}',
        domain: '{{ trans("Domain") }}',
        itemsPerPageAllText: '{{ trans("All") }}',
        itemsPerPageText: '{{ trans("Routes per page:") }}',
        loading: '{{ trans("Loading... Please wait...") }}',
        methods: '{{ trans("Methods") }}',
        middlewares: '{{ trans("Middlewares") }}',
        module: '{{ trans("Module") }}',
        name: '{{ trans("Name") }}',
        noDataText: '{{ trans("No data available") }}',
        noResultsText: '{{ trans("No matching records found") }}',
        of: '{{ trans("of") }}',
        only: '{{ trans("Only") }}',
        pageText: '{0}-{1} {{ trans("of") }} {2}',
        path: '{{ trans("Path") }}',
        priority: '{{ trans("Priority") }}',
        search: '{{ trans("Search") }}',
        show: '{{ trans("Show") }}',
        title: '{{ trans("Routes") }}',
        without: '{{ trans("Without") }}'
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
                deprecated: [],
                module: [],
                domain: [],
                value: null
            },

            items: {
                base: [
                    { key: 'without', value: trans.without }
                ],

                deprecated: [
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
                return _.filter(this.routes, item => item.deprecated === true).length > 0;
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

                _.each(this.routes, route => {
                    let name = route[key];

                    if (name !== null && ! this.inArray(result, name, 'key')) {
                        result.push({ key: name, value: name });
                    }
                });

                return result;
            },

            setDomains() {
                this.items.domains = this.getRoutesKey('domain');
            },

            setModules() {
                this.items.modules = this.getRoutesKey('module');
            },

            setFilter(key, value) {
                if (key === 'value') {
                    this.filter.value = value;
                } else {
                    if (! this.inArray(this.filter[key], value)) {
                        this.pushFilter(key, value);
                    }
                }
            },

            allowDeprecated(route) {
                let values = this.filter.deprecated;

                if (this.isEmptyValue(values)) {
                    return true;
                }

                let only = this.inArray(values, 'only') ? route.deprecated === true : false;
                let without = this.inArray(values, 'without') ? route.deprecated === false : false;

                return only || without;
            },

            allow(route, key) {
                let filters = this.filter[key];
                let value = route[key];

                let all = this.isEmptyValue(filters);
                let without = this.inArray(filters, 'without') ? value === null : false;
                let search = this.inArray(filters, value);

                return all || without || search;
            },

            hasHeader(key) {
                return this.has(this.filteredRoutes, key);
            },

            isDirty() {
                return this.isDoesntEmptyValue(this.filter.deprecated)
                    || this.isDoesntEmptyValue(this.filter.domain)
                    || this.isDoesntEmptyValue(this.filter.module)
                    || this.isDoesntEmptyValue(this.filter.value);
            },

            isEmptyValue(value) {
                return _.isEmpty(value);
            },

            isDoesntEmptyValue(value) {
                return ! this.isEmptyValue(value);
            },

            resetFilters() {
                this.filter.deprecated = null;
                this.filter.domain = null;
                this.filter.module = null;
                this.filter.value = null;
            },

            hasRoute(key) {
                return this.has(this.routes, key);
            },

            has(items, key) {
                return _.filter(items, item => item[key] !== null).length > 0;
            },

            inArray(array, value, key = null) {
                return _.filter(array, (val, index) => {
                    if (key !== null) {
                        if (index === key && val === value)
                            return true;
                    } else {
                        if (val === value)
                            return true;
                    }

                    return false;
                }).length > 0;
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

            pushFilter(key, value) {
                this.isEmptyValue(this.filter[key])
                    ? this.filter[key] = [value]
                    : this.filter[key].push(value);
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
