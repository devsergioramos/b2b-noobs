<template>

  <v-row
    no-gutters
    align="center"
    justify="center"
  >
    <v-col cols="auto">
      <v-card
        width="290"
        color="#909091"
      >

      <v-img
        width="290"
        height="auto"
        :src="require('assets/images/logo.jpg')"
      ></v-img>

        <v-alert v-if="this.msgError"
          type="error"
        >{{this.msgError}}</v-alert>

        <v-card-title>
          <h2>Entrar</h2>
        </v-card-title>
        <v-card-text>
          <v-form
            ref="form"
            v-model="isValid"
            lazy-validation
            @submit.prevent="submit"
          >

            <v-text-field
              label="Email"
              v-model="user.email"
              :rules="emailRules"
            ></v-text-field>

            <v-text-field
              label="Senha"
              :type="'password'"
              v-model="user.password"
              :rules="passwordRules"
            ></v-text-field>

            <v-btn
              :disabled="!isValid"
              color="primary"
              class="mt-3"
              type="submit"
            >
              Entrar
            </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>

</template>

<script>

import { mapState, mapMutations, mapActions, mapGetters } from "vuex";

export default {
  name: "Home",
  layout: "login",
  auth: false,
  components: {
  
  },
  middleware({ $auth, redirect }) {
    
    if($auth.loggedIn){
 
      redirect('/dashboard');
    }
  },
  data: () => ({
    isValid: true,
    user: { 
      name:'',
      password: '12345678',
      email: 'admin@admin.com',
      is_admin: '',
    },
    msgError: '',
    emailRules: [ 
        v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Deve ser um email válido'
    ],
    passwordRules: [
      v => !!v || "Digite a senha"
    ]
  }),
  computed: {
    ...mapGetters(['isAuthenticated', 'loggedInUser']),
  },
  mounted() {

  },
  created() {
  
  },
  methods: {

    submit() {
      if (this.$refs.form.validate()) {  

          this.$auth.loginWith('local',
           {
            data: {
              email: this.user.email,
              password: this.user.password
            },
         
            }).then(() => {

              this.user.name = this.$auth.user.name;
              this.user.is_admin = this.$auth.user.is_admin;

              this.$router.push("/dashboard");

            }).catch(err => {
                this.msgError = 'Usuário ou senha inválidos!';
            })
      }
    },

  },

};
</script>