<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <title>@lang('Routes list') | {{ config('app.name') }}</title>

    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

    <style>
        .spaced { margin: 2px; }

        .deprecated { text-decoration: line-through; }
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
                                    <span v-text="trans('title')"></span> (<span v-text="routes.length"></span>)
                                </h1>

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
                                    :items="routes"
                                    :items-per-page="itemsPerPage"
                                    :search="search"
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
                                    ></v-chip>
                                </template>

                                <template v-slot:item.path="{ item }">
                                    <span v-html="highlightParameters(item.path)"></span>
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

                                <template
                                        v-slot:item.middlewares="{ item }"
                                >
                                    @{{ item.middlewares.join(', ') }}
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

<script>
    const trans = {
        title: '@lang("Routes")',
        search: '@lang("Search")',
        priority: '@lang("Priority")',
        methods: '@lang("Methods")',
        domain: '@lang("Domain")',
        path: '@lang("Path")',
        name: '@lang("Name")',
        action: '@lang("Action")',
        middlewares: '@lang("Middlewares")',
        deprecated: '@lang("Deprecated")'
    };

    const colorScheme = () => {
        switch (@json(config('pretty-routes.color_scheme', 'auto'))) {
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

            routes: @json($routes),

            headers: [
                { text: trans.priority, sortable: true, value: 'priority' },
                { text: trans.methods, sortable: true, value: 'methods' },
                { text: trans.domain, sortable: true, value: 'domain' },
                { text: trans.path, sortable: true, value: 'path' },
                { text: trans.name, sortable: true, value: 'name' },
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
            }
        },

        computed: {
            existDomains() {
                for (let i = 0; i < this.routes.length; i++) {
                    if (this.routes[i].domain !== null) {
                        return true;
                    }
                }

                return false;
            },

            filteredHeaders() {
                return this.headers.filter(item => {
                    let exist = this.existDomains;

                    return exist || (! exist && item.value !== 'domain');
                });
            }
        },

        methods: {
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
            }
        }
    });
</script>

</body>
</html>
