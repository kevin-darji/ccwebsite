const express = require('express');
const mongoose = require('mongoose');

const app = express();
const port = 80;

// Connect to MongoDB (Make sure you have MongoDB running)
mongoose.connect('mongodb://localhost:27017/ccwebsite', { useNewUrlParser: true, useUnifiedTopology: true });

// Define a mongoose schema for orders
const orderSchema = new mongoose.Schema({
  customerId: String,
  productId: String,
  orderPrice: Number,
  isPaid: Boolean
});

// Create a mongoose model for orders
const Order = mongoose.model('Order', orderSchema);

app.use(express.json());

// Endpoint to get all orders
app.get('/api/orders', async (req, res) => {
  try {
    const orders = await Order.find();
    res.json(orders);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
