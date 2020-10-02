<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <title>Routes list | {{ config('app.name') }}</title>

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
                <h1>
                    <span v-text="trans('title')"></span> (<span v-text="routes.length"></span>)
                </h1>

                <v-data-table
                        :headers="headers"
                        :items="routes"
                        :items-per-page="itemsPerPage"
                        :search="search"
                >
                    <template v-slot:top>
                        <v-text-field
                                v-model="search"
                                :label="trans('search')"
                                class="mx-4"
                        ></v-text-field>
                    </template>

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
            </v-container>
        </v-main>
    </v-app>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

<script>
    const trans = {
        title: 'Routes',
        search: 'Search',
        priority: 'Priority',
        methods: 'Methods',
        domain: 'Domain',
        path: 'Path',
        name: 'Name',
        action: 'Action',
        middlewares: 'Middlewares',
        deprecated: 'Deprecated'
    };

    new Vue({
        el: '#app',
        vuetify: new Vuetify(),

        data: {
            itemsPerPage: 20,
            search: null,

            routes: [
                {
                    priority: 4,
                    domain: 'test.local',
                    methods: ['get', 'head'],
                    path: '/foo/{bar}',
                    name: 'foo.bar',
                    action: 'FooController@foo',
                    middlewares: ['api', 'auth'],
                    deprecated: false
                },
                {
                    priority: 3,
                    domain: 'test.local',
                    methods: ['put'],
                    path: '/foo/{bar}/{baz}',
                    name: 'foo.bar.update',
                    action: 'FooController@update',
                    middlewares: ['api', 'auth'],
                    deprecated: true
                }
            ],

            headers: [
                { text: trans.priority, sortable: true, value: 'priority' },
                { text: trans.methods, sortable: true, value: 'methods' },
                { text: trans.domain, sortable: true, value: 'domain', class: { show: this.isPresentDomain } },
                { text: trans.path, sortable: true, value: 'path' },
                { text: trans.name, sortable: true, value: 'name' },
                { text: trans.action, sortable: true, value: 'action' },
                { text: trans.middlewares, sortable: true, value: 'middlewares' }
            ],

            badges: {
                get: 'green darken-1',
                head: 'grey darken-1',
                post: 'blue darken-1',
                put: 'orange darken-1',
                patch: 'cyan lighten-1',
                delete: 'red darken-1',
                options: 'lime darken-1'
            }
        },

        computed: {
            isPresentDomain: (value) => {
                return false;
            }
        },

        methods: {
            trans(key) {
                return trans[key];
            },

            highlightParameters(value) {
                let splitted = value.split('/');
                let regex = /^(\{.*\})$/i;

                for (let i = 0; i < splitted.length; i++) {
                    if (splitted[i].match(regex)) {
                        splitted[i] = this.highlighting(splitted[i]);
                    }
                }

                return splitted.join('/');
            },

            highlightMethod(value) {
                let splitted = value.split('@');

                return splitted[0] + this.highlighting(splitted[1], '@');
            },

            highlighting(value, prefix = '') {
                return `<span class="orange--text text--darken-2">${ prefix }${ value }</span>`;
            }
        }
    });
</script>

</body>
</html>
