<template>
  <v-app>
    <v-container>
      <v-row justify="center">
        <v-col cols="12" sm="8" md="6">
          <v-card class="mx-auto" max-width="400">
            <v-card-title class="d-flex justify-center">
              <h2>TodoApp</h2>
            </v-card-title>
            <v-card-text>
              <v-row justify="center">
                <v-col class="d-flex justify-center" v-if="canLogin">
                  <div>
                    <v-btn
                      v-if="$page.props.auth.user"
                      :href="route('dashboard')"
                      class="mx-2"
                      color="primary"
                      outlined
                    >
                      Dashboard
                    </v-btn>

                    <template v-else>
                      <v-btn
                        :href="route('login')"
                        class="mx-2"
                        color="primary"
                        outlined
                      >
                        Log in
                      </v-btn>

                      <v-btn
                        v-if="canRegister"
                        :href="route('register')"
                        class="mx-2"
                        color="primary"
                        outlined
                      >
                        Register
                      </v-btn>
                    </template>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
	document.getElementById('screenshot-container')?.classList.add('!hidden');
	document.getElementById('docs-card')?.classList.add('!row-span-1');
	document.getElementById('docs-card-content')?.classList.add('!flex-row');
	document.getElementById('background')?.classList.add('!hidden');
}
</script>
