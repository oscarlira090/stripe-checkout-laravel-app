<template>
  <tr >
    <td class="col-sm-3"><input v-model="p_item.product"  /></td>
    <td class="col-sm-3"><input style="width:100px" type="number" v-model="p_item.price"  /></td>
    <td class="col-sm-3"><input style="width:50px" type="number" min="1" v-model="p_item.quantity"  /></td>
    <td class="col-sm-3"><strong>${{total}}</strong></td>
    <td><button  class="btn btn-danger" @click="remove"><i class="fa fa-times" aria-hidden="true"></i></button></td> 
  </tr>
</template>

<script>
export default {
  props: ["p_item","p_index"],
  data: function () {
    return {
    };
  },
  computed: {
    total() {
      return this.p_item.price * this.p_item.quantity;
    }
  },
  watch: {
    total: function (newVal,oldVal) {
      this.p_item.total = newVal;
      this.$emit('update-cart-total',null)
    },
  },
  mounted() {
  },
  methods:{
    remove() {
      this.$emit('remove-cart-item', this.p_item)
    },
  }
};
</script>
