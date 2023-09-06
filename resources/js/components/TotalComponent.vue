<script>
import Swal from "sweetalert2";

export default {
  props: {
    listPesanan: {
      type: Array,
      default() {
        return [];
      },
    },
  },
  methods: {
    handleSuccess() {
      if (this.listPesanan.length !== 0) {
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
            Swal.fire({
              title: "Terima Kasih Telah Memesan!",
              text:
                "Total Pemabayaran : " +
                new Intl.NumberFormat("id-ID", {
                  style: "currency",
                  currency: "IDR",
                  minimumFractionDigits: 0,
                  maximumFractionDigits: 0,
                }).format(this.totalHarga),
              icon: "success",
              showConfirmButton: true,
              confirmButtonText: "ok!",
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
          }
        });
      } else {
        Swal.fire("..Oopss", "Sepertinya Anda Belum Memesan Apapun!", "error");
      }
    },
  },
  computed: {
    totalHarga() {
      return this.listPesanan.reduce(
        (total, product) => total + product.subtotal,
        0
      );
    },
  },
  mounted() {
    console.log(this.listPesanan);
  },
};
</script>
<template>
  <div class="card shadow-sm">
    <div class="card-body d-flex justify-content-between">
      <a class="btn btn-success" @click="handleSuccess">Check Out</a>
      <h3>
        Total :
        <span>
          {{
            new Intl.NumberFormat("id-ID", {
              style: "currency",
              currency: "IDR",
              minimumFractionDigits: 0,
              maximumFractionDigits: 0,
            }).format(totalHarga)
          }}</span
        >
      </h3>
    </div>
  </div>
</template>
