<template>
  <q-page class="q-px-lg">
    <div style="display: flex;justify-content: space-between;align-items: center;height: 100px;">
      <h4 class="text-weight-bold">Products</h4>
      <q-btn flat
        @click="addProduct = true"
        label="add product"
        class="text-capitalize text-weight-bold"
        style="font-size: 25px;color: #fc6dab;"

      />
    </div>




    <q-markup-table  separator="cell">
      <thead>
        <tr>
          <th >No</th>
          <th >Product Name</th>
          <th >Description</th>
          <th >Price</th>
          <th >Picture</th>
          <th >Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in data" :key="index++">
          <td >{{ index }}</td>
          <td >{{ row.product_name }}</td>
          <td >{{ row.product_desc }}</td>
          <td >{{ row.price }}</td>
          <td >{{ row.picture }}</td>
          <td ></td>
        </tr>
      </tbody>
    </q-markup-table>
</q-page>

    <q-dialog v-model="addProduct">
        <q-card flat style="width: 700px">
        <q-toolbar>
            <q-toolbar-title style="color: #fc6dab" icon="" class="text-weight-bold">Add products</q-toolbar-title>
            <q-space />
            <q-btn round flat icon="cancel" color="grey-7" @click="batal" />
        </q-toolbar>


        <q-card-section>
            <q-form class="q-gutter-sm">
                <p>Product Name</p>
                <q-input  outlined rounded v-model="form.product_name" />

                <p>Product Description</p>

                <q-editor min-height="5rem" v-model="form.product_desc"></q-editor>


                <p>Product Price</p>
                <q-input outlined rounded v-model="form.price" />
                <!-- <tr>
                <td>
                <q-img v-if="row.gambar" :src="/storage/ + row.gambar" />
                </td>

                <td>
                <q-btn>
                    <q-icon round name="expand_more" />
                    <q-menu>
                    <q-list dense>
                        <q-item clickable v-close-popup @click="inUpload(row.id)">
                        <q-item-section side>
                            <q-icon name="upload" />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label> upload </q-item-label>
                        </q-item-section>
                        </q-item>
                    </q-list>
                    </q-menu>
                </q-btn>
                </td>
            </tr> -->

                <div class="q-my-md q-gutter-sm float-right">
                    <q-btn
                    class="text-capitalize"
                    flat
                    rounded
                    label="Save"
                    @click="simpan"
                    style="width: 100px; background-color: #c04cfd; color: white"
                    unelevated
                    dense
                    />
                </div>
            </q-form>
        </q-card-section>
        </q-card>
    </q-dialog>

</template>
<script>
import layout from "../layout/layout.vue";
import { ref, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios"; //memangggil hubungan front end dan back end dan untuk get data

export default {
  layout: layout,
  props: {
    data: Array
  },
  setup() {

    const addProduct = ref(false);
    const data=ref([])
    const form = reactive({
      id: "",
      product_name: "",
      product_desc: "",
      price: "",
    })

    function batal() {
      form.id = ""
      form.product_name = ""
      form.product_desc = ""
      form.price = ""
      addProduct.value = false
    }

    function simpan() {
      router.visit('/product/simpan', {
        method: 'post',
        data: {
          id:form.id,
          product_name:form.product_name,
          product_desc:form.product_desc,
          price:form.price,
        },
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
          batal()
        }
      })
    }
    return {
      simpan,
      batal,
      data,
      form,
      addProduct
    }
  }
}
</script>
