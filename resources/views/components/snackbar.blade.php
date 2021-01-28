<template>
    <div class="text-center">
        <v-snackbar v-model="snackbar.isOpen" :timeout="snackbar.timeout">
            <span v-text="snackbar.message"></span>

            <template v-slot:action="{ attrs }">
                <v-btn color="blue" text v-bind="attrs" @click="snackbar.isOpen = false">
                    <v-icon dense="true" style="margin-right: 10px;">mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>
