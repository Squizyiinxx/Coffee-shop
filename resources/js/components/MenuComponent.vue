<script>
import Swal from "sweetalert2";
export default {
  emits: ["emit-add"],
  props: {
    listMenu: {
      default() {
        return [];
      },
    },
  },
  data() {
    return {
      menuList: this.listMenu,
    };
  },
  methods: {

    noStokAlert() {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Stok tidak ada",
      });
    },
    addAlert() {
      Swal.fire({
        icon: "success",
        title: "Ditambahkan!",
        text: "Berhasil ditambahkan",
      });
    },
    addCart(id, product, harga, i) {
      const jumlah = parseInt(this.menuList[i].inputJumlah);
      const pesanan = {
        id: id,
        product: product,
        jumlah: jumlah,
        subtotal: jumlah * harga,
        harga: harga,
      };
      if (this.menuList[i].inputJumlah > this.menuList[i].stok) {
        this.noStokAlert();
      } else {
        this.$emit("emit-add", pesanan);
        this.menuList[i].stok -= this.menuList[i].inputJumlah;
        this.addAlert();
      }
      this.menuList[i].inputJumlah = 1;
    },
    validateInput(e) {
      if (e.charCode < 48 || e.charCode > 57) {
        e.preventDefault();
      }
    },
  },
};
</script>
<template>
  <table class="table table-striped table-hover">
    <thead>
      <tr class="text-center">
        <th scope="col" class="text-start">No</th>
        <th scope="col">Nama</th>
        <th scope="col">Stok</th>
        <th scope="col">Harga</th>
        <th scope="col">Action</th>
        <th scope="col">Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(menu, i) in menuList"
        :key="i"
        class="text-center"
        scope="row"
      >
        <td class="text-start">{{ menu.id }}</td>
        <td>{{ menu.product }}</td>
        <td>{{ menu.stok }}</td>
        <td>
          {{
            new Intl.NumberFormat("id-ID", {
              style: "currency",
              currency: "IDR",
              minimumFractionDigits: 0,
              maximumFractionDigits: 0,
            }).format(menu.harga)
          }}
        </td>
        <td>
          <button
            class="btn btn-success"
            @click="addCart(menu.id, menu.product, menu.harga, i)"
          >
            add Cart
          </button>
        </td>
        <td>
          <input
            type="text"
            @keypress="validateInput"
            :id="menu.id"
            class="jumlahInput text-center shadow"
            min="1"
            v-model="menu.inputJumlah"
            required
          />
        </td>
      </tr>
    </tbody>
  </table>
</template>
