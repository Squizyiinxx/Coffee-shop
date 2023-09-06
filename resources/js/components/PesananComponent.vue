<script>
import Swal from "sweetalert2";
import TotalComponent from "./TotalComponent.vue";
export default {
  components: { TotalComponent },
  emits: ["emit-delete"],
  props: {
    dataPesanan: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  methods: {
    deleteItem(id, jumlah) {
      Swal.fire({
        title: "Yakin ingin menghapus?!",
        input: "number",
        inputPlaceholder: "Masukan Jumlah yang ingin dihapus",
        inputAttributes: {
          autocapitalize: "off",
        },
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Kembali",
        confirmButtonColor: "#ffc107",
        denyButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        denyButtonText: "Hapus Semua!",
        showLoaderOnConfirm: true,
      }).then((result) => {
        const payload = {
          id: id,
          value: result.value,
          isConfirmed: result.isConfirmed,
          isDenied: result.isDenied,
          jumlah: jumlah,
        };
        console.log(jumlah);
        this.$emit("emit-delete", payload);
      });
    },
  },
};
</script>
<template>
  <div class="card shadow mt-5 mb-3">
    <div class="p-3 border-bottom rounded-top text-white fw-bold fs-5 bg-nav">
      Cart
    </div>
    <div class="card-body">
      <h5 class="card-title">Pesanan :</h5>
      <div class="container my-5">
        <div class="row fw-bold">
          <div class="col md-3 lg-5">
            <p>Product</p>
          </div>
          <div class="col">Harga</div>
          <div class="col">Jumlah</div>
          <div class="col">Subtotal</div>
          <div class="col">Action</div>
        </div>
        <div class="row" v-for="(item, i) in dataPesanan" :key="i">
          <div class="col md-3 lg-5">
            <p>{{ item.product }}</p>
          </div>
          <div class="col">
            {{
              new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
              }).format(item.harga)
            }}
          </div>
          <div class="col">x {{ item.jumlah }}</div>
          <div class="col">
            {{
              new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
              }).format(item.harga * item.jumlah)
            }}
          </div>
          <div class="col mb-2">
            <button
              class="btn btn-danger"
              @click="deleteItem(item.id, item.jumlah)"
            >
              Delete
            </button>
          </div>
          <hr />
        </div>
      </div>
      <total-component :listPesanan="dataPesanan" />
    </div>
  </div>
</template>
