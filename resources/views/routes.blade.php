<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <title>{{ trans('Routes list') }} | {{ config('app.name') }}</title>

    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

    <style>
        .spaced { margin: 2px; }

        .deprecated { text-decoration: line-through; }

        .link:hover { text-decoration: underline; cursor: pointer; }
    </style>
</head>
<body>

<div id="app">
    <v-app>
        <v-main>
            <v-container>

                <v-hover>
                    <template v-slot="{ hover }">
                        <v-card
                                :class="`elevation-${hover ? 24 : 6}`"
                                class="transition-swing"
                        >
                            <v-card-title>
                                <h1 class="display-1">
                                    <span v-text="trans('title')"></span> (<span v-text="countRoutes"></span>)
                                </h1>

                                <v-spacer v-if="allowDeprecatedFilter"></v-spacer>

                                <v-select
                                        v-if="allowDeprecatedFilter"
                                        v-model="filter.selected"
                                        :label="trans('show')"
                                        :items="filter.items"
                                        item-value="key"
                                        item-text="value"
                                ></v-select>

                                <v-spacer v-if="hasModules"></v-spacer>

                                <v-select
                                        v-if="hasModules"
                                        v-model="modules.selected"
                                        :label="trans('module')"
                                        :items="filteredModules"
                                        item-value="key"
                                        item-text="value"
                                ></v-select>

                                <v-spacer></v-spacer>

                                <v-text-field
                                        v-model="search"
                                        :label="trans('search')"
                                        append-icon="mdi-magnify"
                                        single-line
                                        hide-details
                                ></v-text-field>
                            </v-card-title>

                            <v-data-table
                                    :headers="filteredHeaders"
                                    :items="filteredRoutes"
                                    :items-per-page="itemsPerPage"
                                    :search="search"
                                    :loading="loading"
                                    :loading-text="trans('loading')"
                                    :no-data-text="trans('noDataText')"
                                    :no-results-text="trans('noResultsText')"
                                    :footer-props="{
                                        itemsPerPageAllText: trans('itemsPerPageAllText'),
                                        itemsPerPageText: trans('itemsPerPageText'),
                                        pageText: trans('pageText')
                                    }"
                                    multi-sort
                            >
                                <template v-slot:item.methods="{ item }">
                                    <v-chip
                                            v-for="badge in item.methods"
                                            v-text="badge.toUpperCase()"
                                            :color="badges[badge]"
                                            text-color="white"
                                            label
                                            small
                                            class="spaced"
                                            @click="setSearch(badge)"
                                    ></v-chip>
                                </template>

                                <template v-slot:item.path="{ item }">
                                    <span v-html="highlightParameters(item.path)"></span>
                                </template>

                                <template v-slot:item.module="{ item }">
                                    <v-chip
                                            v-if="item.module !== null"
                                            v-text="item.module"
                                            label
                                            small
                                            class="spaced"
                                            @click="setModule(item.module)"
                                    ></v-chip>
                                </template>

                                <template v-slot:item.action="{ item }">
                                    <v-tooltip top v-if="item.deprecated">
                                        <template v-slot:activator="{ on }">
                                <span
                                        v-on="on"
                                        v-html="highlightMethod(item.action)"
                                        class="deprecated"
                                ></span>
                                        </template>
                                        <span v-text="trans('deprecated')"></span>
                                    </v-tooltip>

                                    <span v-else v-html="highlightMethod(item.action)"></span>
                                </template>

                                <template v-slot:item.middlewares="{ item }">
                                    <span
                                            v-for="(middleware, key) in item.middlewares"
                                            v-text="`${middleware}${key !== item.middlewares.length - 1 ? ', ' : ''}`"
                                            @click="setSearch(middleware)"
                                            class="link"
                                    ></span>
                                </template>
                            </v-data-table>
                        </v-card>
                    </template>
                </v-hover>
            </v-container>
        </v-main>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
        switch ({!! json_encode(config('pretty-routes.color_scheme', 'auto')) !!}) {
            case 'dark':
                return true;
            case 'light':
                return false;
            default:
                return (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
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
            search: null,
            loading: true,

            url: '{{ route("pretty-routes.list") }}',

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
                selected: 'all',

                items: [
                    { key: 'all', value: trans.all },
                    { key: 'onlyDeprecated', value: trans.onlyDeprecated },
                    { key: 'withoutDeprecated', value: trans.withoutDeprecated }
                ]
            },

            modules: {
                selected: 'all'
            }
        },

        computed: {
            filteredRoutes() {
                return this.routes.filter(route => {
                    return this.allowFilter(route) && this.allowModule(route);
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

            filteredModules() {
                let modules = [
                    { key: 'all', value: trans.all },
                    { key: 'without', value: trans.without }
                ];

                for (let i = 0; i < this.routes.length; i++) {
                    let name = this.routes[i].module;

                    if (name !== null && ! this.inArray(modules, 'key', name)) {
                        modules.push({
                            key: this.routes[i].module,
                            value: this.routes[i].module
                        });
                    }
                }

                return modules;
            },

            countRoutes() {
                let all = this.routes.length;
                let filtered = this.filteredRoutes.length;

                return all === filtered
                    ? all
                    : filtered + ' ' + this.trans('of') + ' ' + all;
            },

            allowDeprecatedFilter() {
                for (let i = 0; i < this.routes.length; i++) {
                    if (this.routes[i].deprecated === true) {
                        return true;
                    }
                }

                return false;
            },

            hasModules() {
                for (let i = 0; i < this.routes.length; i++) {
                    if (this.routes[i].module !== null) {
                        return true;
                    }
                }

                return false;
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

            trans(key) {
                return trans[key];
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

            allowFilter(route) {
                switch (this.filter.selected) {
                    case 'onlyDeprecated':
                        return route.deprecated === true;
                    case 'withoutDeprecated':
                        return route.deprecated === false;
                    default:
                        return true;
                }
            },

            allowModule(route) {
                if (this.modules.selected === 'without') {
                    return route.module === null;
                }

                return route.module === this.modules.selected || this.modules.selected === 'all';
            },

            hasHeader(key) {
                for (let i = 0; i < this.filteredRoutes.length; i++) {
                    if (this.filteredRoutes[i][key] !== null) {
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

            setSearch(value) {
                this.search = value;
            },

            setModule(value) {
                this.modules.selected = value;
            }
        }
    });
</script>

</body>
</html>
