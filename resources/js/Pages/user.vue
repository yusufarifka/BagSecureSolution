<template>
    <q-page class="q-px-lg">
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100px; ">
            <h4 class="text-weight-bold">User</h4>
            <q-btn flat @click="dialogUser = true" label="add user"
            class="text-capitalize text-weight-bold"
            style="font-size: 25px;color: #fc6dab;"  />
        </div>

        <q-markup-table separator="cell"  >
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in data" :key="index++">
                    <td>{{ index }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.username }}</td>
                    <td>
                        <q-btn @click="konfirmasi(row.id)" unelevated label="Delete" color="grey" style="border-radius: 30px;"/>
                        <q-btn @click="edit(row.id)" unelevated label="Edit" color="purple" class="q-mx-xs" style="border-radius: 30px;"/>
                    </td>
                </tr>
            </tbody>
        </q-markup-table>
    </q-page>

    <q-dialog v-model="dialogUser">
        <q-card flat style="width: 700px">
            <q-toolbar>
                <q-toolbar-title>user</q-toolbar-title>
                <q-space />
                <q-btn round flat icon="cancel" color="pink" @click="batal" />
            </q-toolbar>
            <q-card-section>
                <q-form class="q-gutter-sm">
                    <q-input label="nama" v-model="form.name" />
                    <q-input label="username" v-model="form.username" />
                    <q-input label="password" v-model="form.password" />
                    <q-input label="email" v-model="form.email" />
                    <div>
                        <q-btn @click="simpan" class="q-mr-sm" label="simpan" icon="save" color="primary" />
                        <q-btn @click="batal" label="batal" icon="cancel" color="grey-2" text-color="dark" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </q-dialog>

    <q-dialog v-model="dialogKonfirm">
        <q-card style="width=500px">
            <q-card-section>
                <p>Yakin mau hapus data ini?</p>
                <div>
                    <q-btn label="Ya, hapus" @click="hapus" color="red" />
                    <q-btn label="Jangan dong" @click="dialogKonfirm = false" class="q-mx-xs" />
                </div>
            </q-card-section>
        </q-card>
    </q-dialog>



</template>
<script>
import Layout from '../layout/layout.vue'
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'  //memangggil hubungan front end dan back end dan untuk get data

export default {
    layout: Layout,
    props: {
        data: Array
    },
    setup() {
        const dialogUser = ref(false)
        const dialogKonfirm = ref(false)
        const form = reactive({
            id: "",
            name: "",
            username: "",
            password: "",
            email: "",
        })
        function batal() {
            form.id = ""
            form.name = ""
            form.username = ""
            form.password = ""
            form.email = ""
            dialogUser.value = false
        }
        function simpan() {
            router.visit('/user/simpan', {
                method: 'post',
                data: {
                    id: form.id,
                    name: form.name,
                    username: form.username,
                    password: form.password,
                    email: form.email,
                },
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    dialogUser.value = false
                }
            })
        }
        function edit(id) {
            axios.get('/user/edit/' + id).then((res) => {
                form.id = res.data.id
                form.name = res.data.name
                form.username = res.data.username
                form.email = res.data.email
                dialogUser.value = true
            })
        }
        function konfirmasi(id) {
            form.id = id
            dialogKonfirm.value = true
        }
        function hapus() {
            router.visit('/user/hapus/' + form.id, {
                method: 'delete',
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    dialogKonfirm.value = false
                }
            })
        }
        return {
            hapus,
            konfirmasi,
            edit,
            simpan,
            batal,
            form,
            dialogUser,
            dialogKonfirm

        }
    }

}
</script>
