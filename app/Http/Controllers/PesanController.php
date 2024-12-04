<?php
namespace App\Http\Controllers;

use App\Product;
use App\Order;
use App\User;
use App\OrderDetail;
use Auth;
use Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $product = Product::where('id', $id)->first();

        return view('pesan.index', compact('product'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        $currentDate = Carbon::now();

        // Validasi apakah jumlah yang dipesan melebihi stok
        if ($request->quantity > $product->stock) {
            return redirect('pesan/'.$id);
        }

        // Cek apakah pengguna sudah memiliki pesanan yang belum selesai
        $existingOrder = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // Jika tidak ada pesanan yang belum selesai, buat pesanan baru
        if (empty($existingOrder)) {
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->number = mt_rand(100000, 999999);
            $order->total_price = 0;
            $order->status = 0; // 0 = belum selesai
            $order->save();
        }

        // Ambil pesanan yang baru saja dibuat
        $newOrder = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // Cek apakah produk sudah ada di dalam pesanan detail
        $existingOrderDetail = OrderDetail::where('product_id', $product->id)->where('order_id', $newOrder->id)->first();

        if (empty($existingOrderDetail)) {
            // Jika produk belum ada, tambahkan produk ke pesanan detail
            $orderDetail = new OrderDetail;
            $orderDetail->product_id = $product->id;
            $orderDetail->order_id = $newOrder->id;
            $orderDetail->quantity = $request->quantity;
            $orderDetail->total_price = $product->price * $request->quantity;
            $orderDetail->save();
        } else {
            // Jika produk sudah ada, update jumlah dan harga
            $existingOrderDetail->quantity += $request->quantity;
            $existingOrderDetail->total_price += $product->price * $request->quantity;
            $existingOrderDetail->update();
        }

        // Update total harga pesanan
        $newOrder->total_price += $product->price * $request->quantity;
        $newOrder->update();

        Alert::success('Product added to cart successfully', 'Success');
        return redirect('pesan');
    }

    public function viewCart()
    {
        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $orderDetails = [];

        if ($order) {
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
        }

        return view('pesan.cart', compact('order', 'orderDetails'));
    }

    public function deleteFromCart($id)
    {
        $orderDetail = OrderDetail::where('id', $id)->first();
        $order = Order::where('id', $orderDetail->order_id)->first();

        // Update total harga pesanan setelah penghapusan
        $order->total_price -= $orderDetail->total_price;
        $order->update();

        // Hapus item dari pesanan detail
        $orderDetail->delete();

        Alert::error('Item removed from cart', 'Deleted');
        return redirect('pesan');
    }

    public function confirmOrder(Request $request)
    {
        $user = Auth::user();

        // Validasi data alamat
        if (empty($user->address) || empty($user->city)) {
            Alert::error('Please complete your address information.', 'Error');
            return redirect('profile');
        }

        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();
        if ($order) {
            $order->status = 1; // Status 1 = pesanan dikonfirmasi
            $order->province_id = $request->province_id;
            $order->city = $request->city;
            $order->address = $request->address;
            $order->shipping_price = $request->shipping_price;
            $order->notes = $request->notes;
            $order->update();

            // Update stok produk
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            foreach ($orderDetails as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                $product->stock -= $orderDetail->quantity;
                $product->update();
            }

            Alert::success('Order confirmed, please proceed to payment.', 'Success');
        }

        return redirect('order/history/'.$order->id);
    }
}
