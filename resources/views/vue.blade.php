<v-app>
    <v-app-bar app>
        <v-toolbar-title>
            <span
                v-text="trans('title')"
                :class="{link: isDirty()}"
                @click="resetFilters"
            ></span> (<span v-text="countRoutes"></span>)
        </v-toolbar-title>

        <v-spacer v-if="hasDomains"></v-spacer>
        <v-select
            v-if="hasDomains"
            v-model="filter.domain"
            :label="trans('domain')"
            :items="items.domains"
            item-value="key"
            item-text="value"
            hide-details="true"
        ></v-select>

        <v-spacer v-if="hasModules"></v-spacer>
        <v-select
            v-if="hasModules"
            v-model="filter.module"
            :label="trans('module')"
            :items="items.modules"
            item-value="key"
            item-text="value"
            hide-details="true"
        ></v-select>

        <v-spacer v-if="hasDeprecated"></v-spacer>
        <v-select
            v-if="hasDeprecated"
            v-model="filter.deprecated"
            :label="trans('deprecated')"
            :items="items.deprecated"
            item-value="key"
            item-text="value"
            hide-details="true"
        ></v-select>

        <v-spacer></v-spacer>
        <v-text-field
            v-model="filter.value"
            :label="trans('search')"
            append-icon="mdi-magnify"
            hide-details
            clearable
        ></v-text-field>

        <v-spacer></v-spacer>
        <v-btn icon @click="openGitHubRepository">
            <v-avatar size="36">
                <img
                    :src="repository.icon"
                    alt="Github Project Page"
                >
            </v-avatar>
        </v-btn>
    </v-app-bar>

    <v-main>
        <v-data-table
            :headers="filteredHeaders"
            :items="filteredRoutes"
            :items-per-page="itemsPerPage"
            :search="filter.value"
            :loading="loading"
            :loading-text="trans('loading')"
            :no-data-text="trans('noDataText')"
            :no-results-text="trans('noResultsText')"
            :footer-props="{
                itemsPerPageAllText: trans('itemsPerPageAllText'),
                itemsPerPageText: trans('itemsPerPageText'),
                pageText: trans('pageText')
            }"
            ref="routes"
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
                    @click="setFilter('value', badge)"
                ></v-chip>
            </template>

            <template v-slot:item.path="{ item }">
                <span v-html="highlightParameters(item.path)"></span>
            </template>

            <template v-slot:item.domain="{ item }">
                <v-chip
                    v-if="item.domain !== null"
                    v-text="item.domain"
                    label
                    small
                    class="spaced"
                    @click="setFilter('domain', item.domain)"
                ></v-chip>
            </template>

            <template v-slot:item.module="{ item }">
                <v-chip
                    v-if="item.module !== null"
                    v-text="item.module"
                    label
                    small
                    class="spaced"
                    @click="setFilter('module', item.module)"
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
                    @click="setFilter('value', middleware)"
                    class="link"
                ></span>
            </template>
        </v-data-table>
    </v-main>
</v-app>
