<script>
export default {};
</script>

<template>
  <div class="container">
    <div
      id="carouselExampleInterval"
      class="carousel mx-auto shadow-lg rounded-4 slide w-75"
      data-bs-ride="carousel"
    >
      <div class="carousel-inner rounded-4 w-100">
        <div class="carousel-item active" data-bs-interval="4000">
          <img
            src="/assets/img/g1.jpg"
            class="d-block w-100 overflow-hidden"
            alt="gambar1"
          />
        </div>
        <div class="carousel-item" data-bs-interval="4000">
          <img
            src="/assets/img/g2.jpg"
            class="d-block w-100 overflow-hidden"
            alt="gambar2"
          />
        </div>
        <div class="carousel-item">
          <img
            src="/assets/img/g3.jpg"
            class="d-block w-100 overflow-hidden"
            alt="gambar3"
          />
        </div>
      </div>
      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExampleInterval"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselExampleInterval"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</template>