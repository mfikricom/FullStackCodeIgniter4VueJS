<template>
  <div>
    <h1 class="title">Update Product</h1>
    <form @submit.prevent="updateProduct">
      <div class="field">
        <label class="label">Title</label>
        <div class="control">
          <input
            type="text"
            v-model="title"
            class="input"
            placeholder="Title"
          />
        </div>
      </div>
      <div class="field">
        <label class="label">Price</label>
        <div class="control">
          <input
            type="text"
            v-model="price"
            class="input"
            placeholder="Price"
          />
        </div>
      </div>
      <div class="field">
        <div class="control">
          <button class="button is-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "EditForm",
  data() {
    return {
      title: "",
      price: "",
    };
  },
  created() {
    this.getProductById();
  },
  methods: {
    async getProductById() {
      try {
        const response = await axios.get(`product/${this.$route.params.id}`);
        (this.title = response.data.title), (this.price = response.data.price);
      } catch (error) {
        console.log(error);
      }
    },
    async updateProduct() {
      try {
        await axios.put(`product/${this.$route.params.id}`, {
          title: this.title,
          price: this.price,
        });
        (this.title = ""), (this.price = ""), this.$router.push("/");
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style>
</style>