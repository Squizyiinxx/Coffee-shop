<script>
import MenuComponent from "../components/MenuComponent.vue";
import NavbarComponent from "../components/NavbarComponent.vue";
import PesananComponent from "../components/PesananComponent.vue";
import { menuList } from "../data/MenuData";
import CarouselComponent from "../components/CarouselComponent.vue";
import Swal from "sweetalert2";
import FooterComponent from '../components/FooterComponent.vue';

export default {
  components: {
    NavbarComponent,
    MenuComponent,
    PesananComponent,
    CarouselComponent,
    FooterComponent
  },
  data() {
    return {
      title: "Coffe Shop",
      listPesanan: [],
      menuList: menuList,
    };
  },
  methods: {
    addCart(pesanan) {
      const existingIndex = this.listPesanan.findIndex(
        (item) => item.id === pesanan.id
      );
      if (existingIndex === -1) {
        this.listPesanan.push(pesanan);
      } else {
        this.listPesanan
          .filter((item) => item.id === pesanan.id)
          .map((item) => {
            if (item.id === pesanan.id) {
              item.jumlah += pesanan.jumlah;
              item.subtotal = item.harga * item.jumlah;
            }
          });
      }
    },
    HandleDelete(payload) {
      const { id, value, isConfirmed, isDenied, jumlah } = payload;
      const countDelete = parseInt(value);
      if (isConfirmed) {
        this.listPesanan
          .filter((item) => item.id === id)
          .map((item) => {
            if (countDelete < item.jumlah) {
              item.jumlah -= countDelete;
              item.subtotal = item.harga * item.jumlah;
              this.menuList
                .filter((item) => item.id === id)
                .map((item) => (item.stok += parseInt(value)));
            } else if (countDelete === item.jumlah) {
              this.menuList
                .filter((item) => item.id === id)
                .map((item) => (item.stok += parseInt(value)));
              this.listPesanan = this.listPesanan.filter(
                (item) => item.id !== id
              );
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Kamu memasukan lebih dari jumlah / Belum mengisi Jumlah",
              });
            }
          });
      } else if (isDenied) {
        this.menuList
          .filter((item) => item.id === id)
          .map((item) => (item.stok += parseInt(jumlah)));

        this.listPesanan = this.listPesanan.filter((item) => item.id !== id);
      }
    },
  },
};
</script>
<template>
  <navbarComponent :title="title" />
  <div class="container mt-5">
    <h1 class="my-5 text-center fw-regular">Selamat Datang di {{ title }}</h1>
    <CarouselComponent />
    <p class="mt-5">Silahkan pilih menu dibawah ini</p>
    <MenuComponent @emit-add="addCart" :listMenu="menuList" />
    <PesananComponent :dataPesanan="listPesanan" @emit-delete="HandleDelete" />
    <FooterComponent/>
  </div>
</template>
