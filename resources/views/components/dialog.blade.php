<template>
    <v-row justify="center">
        <v-dialog v-model="dialog.isOpen" persistent scrollable max-width="750px">
            <v-card>
                <v-card-title class="headline" v-text="dialog.title"></v-card-title>

                <v-card-text>
                    <p v-html="dialog.message" v-if="dialog.messageVisible"></p>
                    <pre v-html="dialog.dataDump" v-if="dialog.dataDumpVisible"></pre>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="light-blue darken-3" text @click="showDialogData" v-if="dialog.dataDump">
                        <v-icon dense="true" style="margin-right: 10px;">mdi-database-search</v-icon>
                        <span v-text="dialog.printDataButton"></span>
                    </v-btn>
                    <v-btn color="teal darken-1" text @click="getRoutes">
                        <v-icon dense="true" style="margin-right: 10px;">mdi-refresh</v-icon>
                        <span v-text="dialog.refreshButton"></span>
                    </v-btn>
                    <v-btn color="red lighten-1" text @click="dialog.isOpen = false">
                        <v-icon dense="true" style="margin-right: 10px;">mdi-close</v-icon>
                        <span v-text="dialog.dismissButton"></span>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
