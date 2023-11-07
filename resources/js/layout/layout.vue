<template>
  <q-layout view="hHh LpR fFf">
    <!-- HEADER -->
    <q-header class="shadow-4" style="background-color: #fc6dab;">
      <q-toolbar class="q-px-lg">
        <q-btn
          v-if="$page.props.auth.user"
          dense
          flat
          round
          icon="menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title
          style="font-style: italic; color: #ffffff; font-weight: bold; font-size: 28px"
        >
          SticBag
        </q-toolbar-title >
        <q-space />
        <q-tabs inline-label class="text-dark ">
          <!-- TOOLS LINK -->
          <Link href="/" as="q-tab" style="color: #ffffff; font-size: 18;">
            <q-tab name="home" class="text-capitalize q-mx-md" label="Home" />
          </Link>
          <Link href="/products" as="q-tab" style="color: #ffffff; font-size: 18">
            <q-tab name="products"  class="text-capitalize q-mx-md" label="Products" />
          </Link>
          <Link href="/" as="q-tab"  class="text-capitalize" style="color: #ffffff; font-size: 18">
            <q-tab name="more"  class="text-capitalize q-mx-md" label="More" />
          </Link>
          <Link href="/" as="q-tab" style="color: #ffffff; font-size: 18">
            <q-tab name="about us"  class="text-capitalize q-mx-md" label="About us" />
          </Link>
          <!-- <Link href="/Profile" as="q-tab" style="color: #FC6DAB; font-size: 18;">
          <q-tab name="profile" label="Profile" icon="account_circle" />
          </Link> -->

          <q-btn
          flat
            rounded
            outlined
            v-if="$page.props.auth.user"
            style="width:100px;color: #fc6dab; background-color:#ffffff; font-size: 18"
            name="logout"
            label="Log out"
            @click="logout"
            class="text-capitalize q-ml-md"
          />
          <q-btn
            rounded
            outline
            v-else
            name="login"
            style="color: #ffffff; font-size: 18"
            label="Login"
            @click="dialogLogin = true"
          />
        </q-tabs>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-if="$page.props.auth.user"
      show-if-above
      v-model="leftDrawerOpen"
      side="left"
      bordered
      class="tlbc"
      style="width: 100px;background-color: #FEE2EE;"
    >
      <!-- drawer content -->
      <q-list class="q-mt-md">
        <Link href="/dashboard" as="q-item" style="color: black">
          <q-item clickable v-ripple>
            <q-item-section avatar> </q-item-section>

            <q-item-section style="font-size: 18px" class="text-weight-regular">Dashboard</q-item-section>
          </q-item>
        </Link>
      </q-list>

      <q-list class="q-mt-md">
        <Link href="/user" as="q-item" style="color: black">
          <q-item clickable v-ripple>
            <q-item-section avatar> </q-item-section>

            <q-item-section style="font-size: 18px" class="text-weight-regular">User</q-item-section>
          </q-item>
        </Link>
      </q-list>

      <q-list class="q-mt-md">
        <Link href="/products" as="q-item" style="color: black">
          <q-item clickable v-ripple>
            <q-item-section avatar> </q-item-section>

            <q-item-section style="font-size: 18px" class="text-weight-regular">Products</q-item-section>
          </q-item>
        </Link>
      </q-list>

    </q-drawer>

    <q-page-container>
      <slot />
    </q-page-container>

    <!-- DIALOG -->
    <q-dialog persistent v-model="dialogLogin">
      <q-card style="width: 700px">
        <q-toolbar>
          <q-toolbar-title v-if="!reg" style="color: #fc6dab" class="text-weight-bold"
            >Log In to Your Account</q-toolbar-title
          >
          <q-toolbar-title v-else style="color: #fc6dab" class="text-weight-bold"
            >Create Account</q-toolbar-title
          >
          <q-space />
          <span v-if="status.length" class="text-gray q-ml-lg"> {{ status }} </span>
          <q-btn
            round
            icon="cancel"
            @click="dialogLogin = false"
            color="grey-2"
            text-color="dark"
            unelevated
            dense
          />
        </q-toolbar>

        <q-card-section>
          <!-- LOGIN -->
          <q-form v-if="!reg" class="q-gutter-sm">
            <p>Username</p>
            <q-input outlined rounded v-model="form.username" style="border-color: black">
            </q-input>
            <p>Password</p>
            <q-input outlined rounded type="password" v-model="form.password"> </q-input>

            <div class="q-my-md q-gutter-sm float-right">
              <q-btn
                class="text-capitalize"
                flat
                rounded
                @click="ubah"
                label="Register"
                style="width: 100px; background-color: #aeaeae; color: white"
              />
              <q-btn
                class="text-capitalize"
                flat
                rounded
                @click="login"
                label="Log In"
                style="width: 100px; background-color: #c04cfd; color: white"
              />
            </div>
          </q-form>

          <!-- REGISTER -->
          <q-form v-if="reg" class="q-gutter-sm">
            <p>Name</p>
            <q-input :hint="errors.name" outlined rounded v-model="register.name">
            </q-input>

            <p>Username</p>
            <q-input :hint="errors.username" outlined rounded v-model="register.username">
            </q-input>

            <p>Password</p>
            <q-input
              :hint="errors.password"
              outlined
              rounded
              type="password"
              v-model="register.password"
            >
            </q-input>

            <p>Email</p>
            <q-input :hint="errors.email" outlined rounded v-model="register.email">
            </q-input>

            <div class="q-my-md q-gutter-sm float-right">
              <q-btn
                class="text-capitalize"
                flat
                rounded
                @click="reg = false"
                label="Log In"
                style="width: 100px; background-color: #aeaeae; color: white"
              />
              <q-btn
                class="text-capitalize"
                flat
                rounded
                @click="registerSave"
                label="Register"
                style="width: 100px; background-color: #c04cfd; color: white"
              />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-layout>
</template>

<script>
import { ref, reactive } from "vue";
import { router } from "@inertiajs/vue3";

export default {
  props: {
    errors: Object,
  },
  setup() {
    const leftDrawerOpen = ref(false);
    const dialogLogin = ref(false);
    const status = ref("");
    const form = reactive({
      username: "",
      password: "",
    });
    const register = reactive({
      name: "",
      username: "",
      password: "",
      email: "",
    });
    const reg = ref(false);
    function ubah() {
      reg.value = true;
    }
    function registerSave() {
      router.visit("/register", {
        method: "post",
        data: {
          name: register.name,
          username: register.username,
          password: register.password,
          email: register.email,
        },
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
          register.name = "";
          register.username = "";
          register.password = "";
          register.email = "";
          status.value = "berhasil disimpan";
        },
      });
    }
    function login() {
      router.post("/login", form);

      //menghilangkan popup setelah login
      dialogLogin.value = false;
    }
    function logout() {
      router.get("/logout");
    }

    return {
      logout,
      login,
      status,
      registerSave,
      register,
      ubah,
      reg,
      form,
      dialogLogin,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
    };
  },
};
</script>

<style>
/* .gradient-header {
  height: 77px;
  background: linear-gradient(#C04CFD, #FC6DAB, #FCFBE8);
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
  display: flex;
  justify-content: center;
  align-items: center;

} */

/* .tlbc {
  background-color: rgba(255, 109, 171, 20%);
  color: white;
} */
</style>
