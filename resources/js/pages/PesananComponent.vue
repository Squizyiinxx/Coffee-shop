<script>
import Swal from "sweetalert2";
import TotalComponent from "../components/TotalComponent.vue";
import { deletePesanan, putData, putMenu } from '../fetchData';
import { mapActions,mapGetters } from 'vuex';
export default {
  components: { TotalComponent },
  emits: ["emit-delete"],
  computed:{
    read(){
      return this.getListPesanan();
    }
  
  },
  methods: {
    ...mapActions(["fetchPesananList"]),
    ...mapGetters(["getListPesanan"]),
    loadingTime(){
      let timerInterval;
        Swal.fire({
          title: "Proses!",
          html: "Tunggu sedang diproses!.",
          timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading();
          },
          willClose: () => {
            clearInterval(timerInterval);
          },
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
           this.fetchPesananList();
          }
        });
    },
      HandleDelete(payload) {
      const { id, value, isConfirmed, isDenied, jumlah,subtotal,harga } = payload;
      const countDelete = parseInt(value);
      const updateSubtotal = (harga * (jumlah- countDelete));
      if (isConfirmed) {
        if(jumlah > countDelete){
          putData(id,{jumlah:jumlah - countDelete,subtotal:updateSubtotal});
          this.loadingTime();
          putMenu(id,jumlah -countDelete);
        }else{
           Swal.fire("..Oopss", "Sisakan minimal 1", "error");
        }
      } else if (isDenied) {
        deletePesanan(id);
        this.loadingTime();
      }
    },
    deleteItem(id, jumlah,subtotal, harga) {
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
          jumlah,
          subtotal,
          harga
        };
          this.HandleDelete(payload);
      });
    },
    
  },
  created() {
      this.fetchPesananList();
  }

};
</script>
<template>
  <div class="card shadow m-5">
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
        <div class="row" v-for="(item, i) in read?.pesanan" :key="i">
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
              }).format(item?.subtotal)
            }}
          </div>
          <div class="col mb-2">
            <button
              class="btn btn-danger"
              @click="deleteItem(item?.id, item?.jumlah, item?.subtotal, item?.harga)"
            >
              Delete
            </button>
          </div>
          <hr />
        </div>
      </div>
      <total-component :listPesanan="read?.pesanan" />
    </div>
  </div>
</template>
