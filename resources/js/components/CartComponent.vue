<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <h4 style="display: inline">Shopping cart</h4>
          <button class="btn btn-primary" style="float: right" @click="add">
            <i class="fa fa-plus" aria-hidden="true"> Add</i>
          </button>
          <table class="table table-bordered" style="margin-top: 20px">
            <thead class="table-info">
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <td></td>
            </thead>
            <tbody>
              <tr
                is="item-component"
                v-for="(item, index) in cart.items"
                :key="item.id"
                :p_item="item"
                :p_index="index"
                @update-cart-total="updateCartTotal"
                @remove-cart-item="removeCartItem"
              ></tr>
              <tr>
                <td ></td>
                <td ></td>
                <td >Total</td>
                <td ><strong>${{ cart.total }}</strong></td>
                <td ></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card" style="width: 18rem">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <button class="btn btn-success" style="width:100%" @click="pay">
              Pay by <i class="fa fa-cc-stripe" aria-hidden="true"></i>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["p_stripe_api_key", "p_csrf_token", "p_base_url"],
  data: function () {
    return {
      cart: {
        customer: "oscar lira",
        date: "07/11/2020",
        total: 0,
        items: [
          {
            product: "product 1",
            price: 100,
            quantity: 1,
            total: 0,
          },
          {
            product: "product 2",
            price: 50,
            quantity: 1,
            total: 0,
          },
        ],
      },
    };
  },

  mounted() {
    this.updateCartTotal();
  },
  methods: {
    add() {
      this.cart.items.push({
        product: "product" + Math.floor(Math.random() * 100) + 1,
        price: Math.floor(Math.random() * 100) + 50,
        quantity: 1,
        total: this.price * this.quantity,
      });
      this.updateCartTotal();
    },
    updateCartTotal() {
      let sum = 0;
      console.log(this.cart.items)
      this.cart.items.forEach(function (item) {
        sum += item.price*item.quantity;
      });
      this.cart.total = sum;
    },
    removeCartItem(item) {
      let index = this.cart.items.indexOf(item);
      this.cart.items.splice(index, 1);
    },
    pay() {
      var stripe = Stripe(this.p_stripe_api_key);
      // Create a new Checkout Session using the server-side endpoint you
      // created in step 3.
      fetch(this.p_base_url + "/create-checkout-session", {
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json, text-plain, */*",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": this.p_csrf_token,
        },
        method: "POST",
        body: JSON.stringify({
          cart: this.cart,
        }),
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (session) {
          return stripe
            .redirectToCheckout({
              sessionId: session.id,
            })
            .then(function (result) {
              console.log("res", result);
            });
        })
        .then(function (result) {
          // If `redirectToCheckout` fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using `error.message`.
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function (error) {
          console.error("Error:", error);
        });
    },
  },
};
</script>
