<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@v0.21"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4"></script>

<script src="https://cdn.jsdelivr.net/npm/vue-clipboard2@0.3.1/dist/vue-clipboard.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/idle-js@1.2.0"></script>

<script>
    const trans = {!! json_encode(\PrettyRoutes\Facades\Trans::all(), JSON_UNESCAPED_UNICODE) !!};
    const isEnabledCleanup = {{ config('app.env') !== 'production' && (bool) config('app.debug') === true ? 'true' : 'false' }};
    const dummyVariablePrefix = '{{ config('pretty-routes.dummy_variable_prefix') }}';
    const themeIdleTime = {{ config('pretty-routes.color_scheme_idle_time', 1000) }};
    const tableIdleTime = {{ config('pretty-routes.table_reload_idle_time', 0) }};
    const colorScheme = '{{ config('pretty-routes.color_scheme', 'auto') }}';
    const showPathLink = {{ (bool) config('pretty-routes.show_path_link', false) === true ? 'true' : 'false'}};
    const clickAndCopy = {{ (bool) config('pretty-routes.click_and_copy', false) === true ? 'true' : 'false'}};
    const doubleClickAndCopy = {{ (bool) config('pretty-routes.double_click_and_copy', false) === true ? 'true' : 'false'}};

    const isDarkTheme = () => {
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
                dark: isDarkTheme()
            }
        }),

        data: {
            dialog: {
                isOpen: false,
                title: '',
                message: '',
                messageVisible: true,
                dataDump: null,
                dataDumpVisible: false,
                printDataButton: trans.printData,
                dismissButton: trans.dismiss,
                refreshButton: trans.reload
            },

            snackbar: {
                isOpen: false,
                message: '',
                timeout: 3000
            },

            itemsPerPage: 15,
            loading: false,

            url: {
                routes: '{{ route("pretty-routes.list") }}',
                clean: '{{ route("pretty-routes.clear") }}'
            },

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
                types: 'all',
                module: [],
                domain: [],
                value: null
            },

            items: {
                base: [
                    { key: 'without', value: trans.without, color: 'grey lighten-2' }
                ],

                deprecated: [
                    { key: 'only', value: trans.only },
                    { key: 'without', value: trans.without, color: 'grey lighten-2' }
                ],

                types: [
                    { key: 'all', value: trans.all },
                    { key: 'api', value: trans.api },
                    { key: 'web', value: trans.web }
                ],

                domains: [],
                modules: []
            },

            colors: [
                'white--text amber darken-4',
                'white--text blue darken-2',
                'white--text deep-orange darken-3',
                'white--text deep-purple darken-1',
                'white--text green darken-2',
                'white--text indigo darken-1',
                'white--text light-blue darken-1',
                'white--text light-green darken-3',
                'white--text lime darken-4',
                'white--text orange darken-4',
                'white--text pink darken-4',
                'white--text purple darken-3',
                'white--text teal darken-1',
                'white--text yellow darken-3'
            ],

            idleThemeManager: null,

            idleRouteManager: null
        },

        computed: {
            filteredRoutes() {
                return this.routes.filter(route => {
                    return this.allowDeprecated(route)
                        && this.allowTypes(route)
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
                if (this.loading === true || this.$refs.routes === undefined) {
                    return '...';
                }

                let all = this.routes.length;
                let filtered = this.$refs.routes.$children[0].filteredItems.length;
                let particle = this.trans('of');

                return all === filtered ? all : `${ filtered } ${ particle } ${ all }`;
            },

            hasModules() {
                return this.hasRoute('module');
            },

            hasDomains() {
                return this.hasRoute('domain');
            },

            hasDeprecated() {
                return _.filter(this.routes, item => item.deprecated === true).length > 0;
            },

            hasTypes() {
                return _.filter(this.routes, item => item.is_api === true || item.is_web === true).length > 0;
            },

            sortedDomains: {
                get: function () {
                    return this.filter.domain;
                },

                set: function (items) {
                    this.filter.domain = this.sortFilter('domain', items);
                }
            },

            sortedModules: {
                get: function () {
                    return this.filter.module;
                },

                set: function (items) {
                    this.filter.module = this.sortFilter('module', items);
                }
            },

            sortedDeprecated: {
                get: function () {
                    return this.filter.deprecated;
                },

                set: function (items) {
                    this.filter.deprecated = this.sortFilter('deprecated', items);
                }
            },

            sortedTypes: {
                get: function () {
                    return this.filter.types;
                },

                set: function (value) {
                    this.filter.types = value;
                }
            }
        },

        mounted() {
            this.getRoutes();
            
            if (colorScheme === 'auto') {
                this.idleThemeManager = new IdleJs({
                    idle: themeIdleTime,
                    events: ['mousemove', 'keydown', 'mousedown', 'touchstart'],
                    onIdle: () => this.applyTheme(),
                    onActive: () => this.applyTheme(),
                    onHide: () => {},
                    onShow: () => {},
                    keepTracking: true,
                    startAtIdle: false
                });

                this.idleThemeManager.start();
            }

            if (tableIdleTime > 0){
                this.idleRouteManager = new IdleJs({
                    idle: tableIdleTime,
                    events: ['mousemove', 'keydown', 'mousedown', 'touchstart'],
                    onIdle: () => {},
                    onActive: () => {
                        this.getRoutes();

                        this.snackbar.isOpen = true;
                        this.snackbar.message = trans.loadedOnActive;
                    },
                    onHide: () => {},
                    onShow: () => {},
                    keepTracking: true,
                    startAtIdle: false
                });

                this.idleRouteManager.start();
            }
        },

        methods: {
            setDialog(dialogContent, isDump = false){
                if (! dialogContent){
                    dialogContent = {
                        isOpen: false
                    };
                } else {
                    dialogContent = Object.assign(dialogContent, {
                        isOpen: true,
                        messageVisible: ! isDump,
                        dataDumpVisible: isDump,
                        printDataButton: isDump ? trans.showMessage : trans.printData
                    });
                }

                this.dialog = Object.assign(this.dialog, dialogContent);
            },

            getRoutes(force = false) {
                if (this.loading === true && force === false) {
                    return;
                }

                this.loading = true;

                axios.get(this.url.routes)
                    .then(response => {
                        this.routes = response.data;

                        this.setDomains();
                        this.setModules();

                        this.setDialog(false);
                    })
                    .catch(error => {
                        console.error(error);

                        let data = error.response.data;

                        this.setDialog({
                            title: error.message || trans.error,
                            message: data.message || data,
                            messageVisible: true,
                            dataDump: data.message ? data : null,
                            dataDumpVisible: false
                        });
                    })
                    .finally(() => this.loading = false);
            },

            clearRoutes() {
                if (this.loading === true) {
                    return;
                }

                this.loading = true;

                axios.post(this.url.clean)
                    .then(response => this.getRoutes(true))
                    .catch(error => {
                        console.error(error);

                        this.loading = false;
                    });
            },

            getRoutesKey(key) {
                let result = [...this.items.base];

                _.each(this.routes, route => {
                    let name = route[key];

                    if (name !== null && ! this.inArray(result, name, 'key')) {
                        result.push({ key: name, value: name });
                    }
                });

                return _.map(result, (item, index) => {
                    if (item.color !== undefined) {
                        return item;
                    }

                    let color = this.getColor(index);

                    _.set(item, 'color', color);

                    return item;
                });
            },

            getColor(index) {
                return this.colors[index] === undefined
                    ? this.colors[0]
                    : this.colors[index];
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

            unselectFilter(key, value) {
                this.filter[key] = _.filter(this.filter[key], val => val.toLowerCase() !== value.toLowerCase());
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

            allowTypes(route) {
                switch (this.filter.types) {
                    case 'api':
                        return route.is_api === true;
                    case 'web':
                        return route.is_web === true;
                    default:
                        return true;
                }
            },

            allow(route, key) {
                let filters = this.filter[key];
                let value = route[key];

                let all = this.isEmptyValue(filters);
                let without = this.inArray(filters, 'without') ? value === null : false;
                let search = this.inArray(filters, value);

                return all || without || search;
            },

            isDirty() {
                return this.isDoesntEmptyValue(this.filter.deprecated)
                    || this.isDoesntEmptyValue(this.filter.types)
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
                this.filter.types = null;
                this.filter.domain = null;
                this.filter.module = null;
                this.filter.value = null;
            },

            sortFilter(key, items) {
                return this.filter[key] = items.sort();
            },

            hasHeader(key) {
                return this.has(this.filteredRoutes, key);
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

            isEnabledCleanup() {
                return window.isEnabledCleanup;
            },

            trans(key) {
                return trans[key];
            },

            openGitHubRepository() {
                window.open(this.repository.url);
            },

            showDialogData() {
                let isShow = this.dialog.dataDump && ! this.dialog.dataDumpVisible;

                this.setDialog({}, isShow);
            },

            getDummyPath(path){
                if (path && dummyVariablePrefix.length){
                    return path.replace(/{([^}]+)}/gi, `${dummyVariablePrefix}_$1`);
                }

                return path;
            },

            copyText(text){
                this.$copyText(text).then(e => {
                    this.snackbar.isOpen = true;
                    this.snackbar.message = trans.textCopied + ' : ' + (text.length >= 30 ? text.substring(0, 30) + '...' : text);

                    console.log(e);
                },
                e => {
                    this.snackbar.isOpen = true;
                    this.snackbar.message = trans.textNotCopy;

                    console.log(e);
                });
            },
            
            applyTheme(){
                this.$vuetify.theme.dark = isDarkTheme();
            }
        }
    });
</script>
