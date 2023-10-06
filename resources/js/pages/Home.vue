<script>
import MenuComponent from "../components/MenuComponent.vue";
import NavbarComponent from "../components/NavbarComponent.vue";
import CarouselComponent from "../components/CarouselComponent.vue";
import Swal from "sweetalert2";
import FooterComponent from "../components/FooterComponent.vue";
import { v4 as uuidv4 } from "uuid";
import { postData } from "../fetchData";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    NavbarComponent,
    MenuComponent,
    CarouselComponent,
    FooterComponent,
  },
  
  computed:{
    dataMenu () {
      return this.getMenuList();
    }
  },
  data() {
    return {
      title: "Coffe Shop",
      listPesanan: [],
      id: uuidv4(),
    };
  },
  
  methods: {
    ...mapActions(['fetchMenuList','fetchPesananList']),
    ...mapGetters([ 'getMenuList']),
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
    async handleClick(id, pesanan) {
      const dataPesanan = {
        idPesanan: id,
        pesanan: pesanan,
      };
      postData(dataPesanan);
    },

    handlePesanan() {
      if (this.listPesanan.length !== 0) {
        this.fetchPesananList();
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
            this.$router.push({
              path: "/pesanan",
              query: {
                item: this.id,
              },
            });
          }
        });
      } else {
        Swal.fire("..Oopss", "Sepertinya Anda Belum Memesan Apapun!", "error");
      }
    },
  
  },
   created(){
    this.fetchMenuList();
  },
};
</script>
<template>
  <navbarComponent :title="title" />
  <div class="container mt-5">
    <h1 class="my-5 text-center fw-regular">Selamat Datang di {{ title }}</h1>
    <CarouselComponent />
    <p class="mt-5">Silahkan pilih menu dibawah ini</p>
    <MenuComponent @emit-add="addCart" :listMenu="dataMenu.data" />
    <button
      type="button"
      class="btn btn-success mt-5"
      @click="
        handleClick(id, listPesanan);
        handlePesanan();
      "
    >
      To Cart
    </button>
    <FooterComponent />
  </div>
</template>
